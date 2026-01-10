<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Models\Booking;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Barryvdh\DomPDF\Facade\Pdf;

class BookingController extends Controller
{
    public function index(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|min:2020|max:' . (now()->year + 5),
        ]);
        
        $query = Booking::with(['room', 'user']);
        
        // Filter berdasarkan bulan jika ada
        if ($request->filled('month') && $request->filled('year')) {
            $month = $request->month;
            $year = $request->year;
            $query->whereMonth('start_time', $month)
                  ->whereYear('start_time', $year);
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date')) {
            $query->whereDate('start_time', '>=', $request->start_date);
        }
        
        if ($request->filled('end_date')) {
            $query->whereDate('start_time', '<=', $request->end_date);
        }
        
        $bookings = $query->latest()->paginate(15);

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

    public function downloadReport(Request $request)
    {
        // Validasi input tanggal
        $request->validate([
            'start_date' => 'nullable|date',
            'end_date' => 'nullable|date|after_or_equal:start_date',
            'month' => 'nullable|integer|between:1,12',
            'year' => 'nullable|integer|min:2020|max:' . (now()->year + 5),
        ]);
        
        $query = Booking::with(['room', 'user']);
        
        $title = 'Laporan Booking';
        $period = 'Semua Data';
        
        // Filter berdasarkan bulan jika ada
        if ($request->filled('month') && $request->filled('year')) {
            $month = $request->month;
            $year = $request->year;
            $query->whereMonth('start_time', $month)
                  ->whereYear('start_time', $year);
            
            $monthName = Carbon::create($year, $month, 1)->format('F Y');
            $period = $monthName;
            $title = "Laporan Booking - {$monthName}";
        }
        
        // Filter berdasarkan rentang tanggal
        if ($request->filled('start_date') && $request->filled('end_date')) {
            $startDate = Carbon::parse($request->start_date);
            $endDate = Carbon::parse($request->end_date);
            
            $query->whereDate('start_time', '>=', $startDate)
                  ->whereDate('start_time', '<=', $endDate);
            
            $period = $startDate->format('d F Y') . ' - ' . $endDate->format('d F Y');
            $title = "Laporan Booking - {$period}";
        } elseif ($request->filled('start_date')) {
            $startDate = Carbon::parse($request->start_date);
            $query->whereDate('start_time', '>=', $startDate);
            
            $period = 'Mulai ' . $startDate->format('d F Y');
            $title = "Laporan Booking - {$period}";
        } elseif ($request->filled('end_date')) {
            $endDate = Carbon::parse($request->end_date);
            $query->whereDate('start_time', '<=', $endDate);
            
            $period = 'Sampai ' . $endDate->format('d F Y');
            $title = "Laporan Booking - {$period}";
        }
        
        $bookings = $query->orderBy('start_time', 'desc')->get();
        
        // Statistik
        $stats = [
            'total' => $bookings->count(),
            'approved' => $bookings->where('status', 'approved')->count(),
            'pending' => $bookings->where('status', 'pending')->count(),
            'rejected' => $bookings->where('status', 'rejected')->count(),
            'cancelled' => $bookings->where('status', 'cancelled')->count(),
        ];
        
        // Encode logo ke base64 untuk kompatibilitas PDF
        $logoPath = public_path('img/logodsi.png');
        $logoBase64 = '';
        if (file_exists($logoPath)) {
            $logoData = file_get_contents($logoPath);
            $logoBase64 = 'data:image/png;base64,' . base64_encode($logoData);
        }
        
        $pdf = Pdf::loadView('admin.bookings.report-pdf', compact('bookings', 'stats', 'title', 'period', 'logoBase64'));
        
        // Set paper size dan orientasi
        $pdf->setPaper('A4', 'portrait');
        
        // Set options untuk DomPDF
        $pdf->setOptions([
            'isHtml5ParserEnabled' => true,
            'isPhpEnabled' => true,
            'isRemoteEnabled' => true,
        ]);
        
        // Generate filename berdasarkan filter
        $filename = 'laporan-booking-';
        if ($request->filled('month') && $request->filled('year')) {
            $filename .= $request->year . '-' . str_pad($request->month, 2, '0', STR_PAD_LEFT);
        } elseif ($request->filled('start_date') && $request->filled('end_date')) {
            $filename .= Carbon::parse($request->start_date)->format('Y-m-d') . '_' . Carbon::parse($request->end_date)->format('Y-m-d');
        } elseif ($request->filled('start_date')) {
            $filename .= 'dari-' . Carbon::parse($request->start_date)->format('Y-m-d');
        } elseif ($request->filled('end_date')) {
            $filename .= 'sampai-' . Carbon::parse($request->end_date)->format('Y-m-d');
        } else {
            $filename .= 'semua';
        }
        $filename .= '.pdf';
            
        return $pdf->download($filename);
    }
}
