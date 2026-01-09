<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;

class BookingController extends Controller
{
    public function index()
    {
        $bookings = Booking::with(['room', 'user'])
            ->latest()
            ->paginate(15);

        return view('admin.bookings.index', compact('bookings'));
    }

    public function show(Booking $booking)
    {
        $booking->load(['room', 'user']);
        return view('admin.bookings.show', compact('booking'));
    }

    public function approve(Booking $booking)
    {
        // Check for conflicts - hanya cek booking yang sudah approved
        // Admin bisa approve booking meskipun ada booking pending lain di waktu yang sama
        // Overlap terjadi jika:
        // 1. start_time baru berada di antara start_time dan end_time booking yang ada
        // 2. end_time baru berada di antara start_time dan end_time booking yang ada
        // 3. Booking baru mencakup seluruh waktu booking yang ada
        // 4. Booking yang ada mencakup seluruh waktu booking baru
        $conflictingBooking = Booking::where('room_id', $booking->room_id)
            ->where('status', 'approved') // Hanya cek yang sudah approved
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($booking) {
                // Case 1: start_time baru overlap dengan booking yang ada
                $query->where(function ($q) use ($booking) {
                    $q->where('start_time', '<=', $booking->start_time)
                      ->where('end_time', '>', $booking->start_time);
                })
                // Case 2: end_time baru overlap dengan booking yang ada
                ->orWhere(function ($q) use ($booking) {
                    $q->where('start_time', '<', $booking->end_time)
                      ->where('end_time', '>=', $booking->end_time);
                })
                // Case 3: Booking baru mencakup seluruh waktu booking yang ada
                ->orWhere(function ($q) use ($booking) {
                    $q->where('start_time', '>=', $booking->start_time)
                      ->where('end_time', '<=', $booking->end_time);
                })
                // Case 4: Booking yang ada mencakup seluruh waktu booking baru
                ->orWhere(function ($q) use ($booking) {
                    $q->where('start_time', '<=', $booking->start_time)
                      ->where('end_time', '>=', $booking->end_time);
                });
            })
            ->first();

        if ($conflictingBooking) {
            $startTime = Carbon::parse($conflictingBooking->start_time)->format('d F Y H:i');
            $endTime = Carbon::parse($conflictingBooking->end_time)->format('H:i');
            
            return back()->with('toast_error', "Ruangan sudah disetujui pada waktu tersebut. Booking disetujui pada tanggal {$startTime} - {$endTime}.");
        }

        $booking->update([
            'status' => 'approved',
            'rejection_reason' => null,
        ]);

        // Tolak booking pending lain yang bertabrakan dengan booking yang baru diapprove
        $conflictingPendingBookings = Booking::where('room_id', $booking->room_id)
            ->where('status', 'pending')
            ->where('id', '!=', $booking->id)
            ->where(function ($query) use ($booking) {
                // Case 1: start_time booking pending overlap dengan booking yang diapprove
                $query->where(function ($q) use ($booking) {
                    $q->where('start_time', '<=', $booking->start_time)
                      ->where('end_time', '>', $booking->start_time);
                })
                // Case 2: end_time booking pending overlap dengan booking yang diapprove
                ->orWhere(function ($q) use ($booking) {
                    $q->where('start_time', '<', $booking->end_time)
                      ->where('end_time', '>=', $booking->end_time);
                })
                // Case 3: Booking pending mencakup seluruh waktu booking yang diapprove
                ->orWhere(function ($q) use ($booking) {
                    $q->where('start_time', '>=', $booking->start_time)
                      ->where('end_time', '<=', $booking->end_time);
                })
                // Case 4: Booking yang diapprove mencakup seluruh waktu booking pending
                ->orWhere(function ($q) use ($booking) {
                    $q->where('start_time', '<=', $booking->start_time)
                      ->where('end_time', '>=', $booking->end_time);
                });
            })
            ->get();

        // Auto-reject conflicting pending bookings
        foreach ($conflictingPendingBookings as $conflictingBooking) {
            $conflictingBooking->update([
                'status' => 'rejected',
                'rejection_reason' => 'Booking ditolak otomatis karena bertabrakan dengan booking yang telah disetujui.',
            ]);
        }

        $rejectedCount = $conflictingPendingBookings->count();
        $message = 'Booking berhasil disetujui.';
        if ($rejectedCount > 0) {
            $message .= " {$rejectedCount} booking pending lain yang bertabrakan telah ditolak otomatis.";
        }

        return back()->with('toast_success', $message);
    }

    public function reject(Request $request, Booking $booking)
    {
        $validated = $request->validate([
            'rejection_reason' => 'required|string|max:500',
        ]);

        $booking->update([
            'status' => 'rejected',
            'rejection_reason' => $validated['rejection_reason'],
        ]);

        return back()->with('toast_success', 'Booking berhasil ditolak.');
    }

    public function destroy(Booking $booking)
    {
        $booking->delete();

        return redirect()->route('admin.bookings.index')
            ->with('toast_success', 'Booking berhasil dihapus.');
    }
}
