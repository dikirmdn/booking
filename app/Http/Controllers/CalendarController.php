<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;

class CalendarController extends Controller
{
    public function index()
    {
        $rooms = Room::where('is_active', true)->get();
        
        return view('home', compact('rooms'));
    }

    public function room($roomId)
    {
        $room = Room::where('is_active', true)->findOrFail($roomId);
        
        return view('calendar.room', compact('room'));
    }

    public function api(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $roomId = $request->input('room_id');

        $query = Booking::whereIn('status', ['approved', 'pending'])
            ->with(['room', 'user']);

        if ($roomId) {
            $query->where('room_id', $roomId);
        }

        if ($start && $end) {
            $query->where(function($q) use ($start, $end) {
                $q->whereBetween('start_time', [$start, $end])
                    ->orWhereBetween('end_time', [$start, $end])
                    ->orWhere(function($q2) use ($start, $end) {
                        $q2->where('start_time', '<=', $start)
                            ->where('end_time', '>=', $end);
                    });
            });
        }

        $bookings = $query->get()
            ->map(function ($booking) {
                // Pastikan timezone yang benar
                $startTime = $booking->start_time->setTimezone('Asia/Jakarta');
                $endTime = $booking->end_time->setTimezone('Asia/Jakarta');
                
                return [
                    'id' => $booking->id,
                    'title' => "{$startTime->format('H:i')}-{$endTime->format('H:i')} {$booking->user->name}",
                    'start' => $startTime->toISOString(),
                    'end' => $endTime->toISOString(),
                    'backgroundColor' => $this->getStatusColor($booking->status),
                    'borderColor' => $this->getStatusColor($booking->status),
                    'textColor' => '#ffffff',
                    'displayEventTime' => false, // Nonaktifkan tampilan waktu default FullCalendar
                    'extendedProps' => [
                        'booking_id' => $booking->id,
                        'booking_title' => $booking->title,
                        'room' => $booking->room->name,
                        'user' => $booking->user->name,
                        'description' => $booking->description ?? '',
                        'status' => $booking->status,
                        'start_time' => $startTime->format('H:i'),
                        'end_time' => $endTime->format('H:i'),
                        'start_date' => $startTime->format('d M Y'),
                        'created_at' => $booking->created_at->setTimezone('Asia/Jakarta')->format('d M Y H:i'),
                    ],
                ];
            });

        return response()->json($bookings);
    }

    private function getStatusColor($status)
    {
        return match($status) {
            'approved' => '#10b981',
            'pending' => '#f59e0b',
            'rejected' => '#ef4444',
            default => '#6b7280',
        };
    }
}
