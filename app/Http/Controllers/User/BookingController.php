<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use App\Models\Room;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = auth()->user()->bookings()
            ->with('room')
            ->latest()
            ->paginate(10);

        return view('user.bookings.index', compact('bookings'));
    }

    public function create(Request $request)
    {
        $rooms = Room::where('is_active', true)->get();
        
        // Hanya ambil room_id dari parameter URL
        $selectedRoomId = $request->get('room_id');
        
        // Tidak mengambil date dan time dari URL, biarkan kosong
        $defaultStartTime = null;
        
        return view('user.bookings.create', compact('rooms', 'selectedRoomId', 'defaultStartTime'));
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booker_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Custom validation untuk start_time - harus di masa depan atau hari ini dengan jam belum terlewat
        $startTime = Carbon::parse($validated['start_time']);
        $now = Carbon::now();
        
        if ($startTime->isPast()) {
            return back()->with('toast_error', 'Waktu mulai tidak boleh di masa lalu.')
                        ->withInput();
        }

        // Check for conflicts - hanya cek booking yang sudah approved
        // User bisa booking di waktu yang sama selama status masih pending
        // Overlap terjadi jika:
        // 1. start_time baru berada di antara start_time dan end_time booking yang ada
        // 2. end_time baru berada di antara start_time dan end_time booking yang ada
        // 3. Booking baru mencakup seluruh waktu booking yang ada
        // 4. Booking yang ada mencakup seluruh waktu booking baru
        $conflictingBooking = Booking::where('room_id', $validated['room_id'])
            ->where('status', 'approved') // Hanya cek yang sudah approved
            ->where(function ($query) use ($validated) {
                // Case 1: start_time baru overlap dengan booking yang ada
                // start_time baru >= start_time booking yang ada AND start_time baru < end_time booking yang ada
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })
                // Case 2: end_time baru overlap dengan booking yang ada
                // end_time baru > start_time booking yang ada AND end_time baru <= end_time booking yang ada
                ->orWhere(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })
                // Case 3: Booking baru mencakup seluruh waktu booking yang ada
                ->orWhere(function ($q) use ($validated) {
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                })
                // Case 4: Booking yang ada mencakup seluruh waktu booking baru
                ->orWhere(function ($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingBooking) {
            $startTime = Carbon::parse($conflictingBooking->start_time)->format('d F Y H:i');
            $endTime = Carbon::parse($conflictingBooking->end_time)->format('H:i');
            
            return back()->with('toast_error', "Ruangan sudah disetujui pada waktu tersebut. Booking disetujui pada tanggal {$startTime} - {$endTime}.")
                        ->withInput();
        }

        $validated['user_id'] = auth()->id();
        Booking::create($validated);

        return redirect()->route('user.bookings.index')
            ->with('toast_success', 'Booking berhasil diajukan dan sedang menunggu persetujuan admin.');
    }

    public function show(Booking $booking)
    {
        if ($booking->user_id !== auth()->id()) {
            abort(403);
        }

        $booking->load('room');
        return view('user.bookings.show', compact('booking'));
    }

    public function edit(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || !$booking->canBeEdited()) {
            abort(403);
        }

        $rooms = Room::where('is_active', true)->get();
        return view('user.bookings.edit', compact('booking', 'rooms'));
    }

    public function update(Request $request, Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || !$booking->canBeEdited()) {
            abort(403);
        }

        $validated = $request->validate([
            'room_id' => 'required|exists:rooms,id',
            'booker_name' => 'required|string|max:255',
            'title' => 'required|string|max:255',
            'description' => 'nullable|string',
            'start_time' => 'required|date',
            'end_time' => 'required|date|after:start_time',
        ]);

        // Custom validation untuk start_time - harus di masa depan atau hari ini dengan jam belum terlewat
        $startTime = Carbon::parse($validated['start_time']);
        $now = Carbon::now();
        
        if ($startTime->isPast()) {
            return back()->with('toast_error', 'Waktu mulai tidak boleh di masa lalu.')
                        ->withInput();
        }

        // Check for conflicts (excluding current booking)
        // Hanya cek booking yang sudah approved, user bisa booking di waktu yang sama selama status masih pending
        // Overlap terjadi jika:
        // 1. start_time baru berada di antara start_time dan end_time booking yang ada
        // 2. end_time baru berada di antara start_time dan end_time booking yang ada
        // 3. Booking baru mencakup seluruh waktu booking yang ada
        // 4. Booking yang ada mencakup seluruh waktu booking baru
        $conflictingBooking = Booking::where('room_id', $validated['room_id'])
            ->where('status', 'approved') // Hanya cek yang sudah approved
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($validated) {
                // Case 1: start_time baru overlap dengan booking yang ada
                $query->where(function ($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>', $validated['start_time']);
                })
                // Case 2: end_time baru overlap dengan booking yang ada
                ->orWhere(function ($q) use ($validated) {
                    $q->where('start_time', '<', $validated['end_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                })
                // Case 3: Booking baru mencakup seluruh waktu booking yang ada
                ->orWhere(function ($q) use ($validated) {
                    $q->where('start_time', '>=', $validated['start_time'])
                      ->where('end_time', '<=', $validated['end_time']);
                })
                // Case 4: Booking yang ada mencakup seluruh waktu booking baru
                ->orWhere(function ($q) use ($validated) {
                    $q->where('start_time', '<=', $validated['start_time'])
                      ->where('end_time', '>=', $validated['end_time']);
                });
            })
            ->first();

        if ($conflictingBooking) {
            $startTime = Carbon::parse($conflictingBooking->start_time)->format('d F Y H:i');
            $endTime = Carbon::parse($conflictingBooking->end_time)->format('H:i');
            
            return back()->with('toast_error', "Ruangan sudah disetujui pada waktu tersebut. Booking disetujui pada tanggal {$startTime} - {$endTime}.")
                        ->withInput();
        }

        $booking->update($validated);

        return redirect()->route('user.bookings.index')
            ->with('toast_success', 'Booking berhasil diperbarui. Status booking akan kembali ke "pending".');
    }

    public function destroy(Booking $booking)
    {
        if ($booking->user_id !== auth()->id() || !$booking->canBeCancelled()) {
            abort(403);
        }

        $booking->delete();

        return redirect()->route('user.bookings.index')
            ->with('toast_success', 'Booking berhasil dibatalkan.');
    }
}
