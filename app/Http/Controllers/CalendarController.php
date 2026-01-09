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
        
        // Get bookings for this specific room
        $bookings = Booking::where('status', 'approved')
            ->where('room_id', $roomId)
            ->with(['room', 'user'])
            ->get()
            ->map(function ($booking) {
                return [
                    'id' => $booking->id,
                    'title' => $booking->title,
                    'room' => $booking->room->name,
                    'user' => $booking->user->name,
                    'start' => $booking->start_time->toIso8601String(),
                    'end' => $booking->end_time->toIso8601String(),
                    'status' => $booking->status,
                ];
            });

        return view('calendar.room', compact('room', 'bookings'));
    }

    public function api(Request $request)
    {
        $start = $request->input('start');
        $end = $request->input('end');
        $roomId = $request->input('room_id');

        $query = Booking::where('status', 'approved')
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
                return [
                    'id' => $booking->id,
                    'title' => $booking->title . ' - ' . $booking->room->name,
                    'start' => $booking->start_time->toIso8601String(),
                    'end' => $booking->end_time->toIso8601String(),
                    'backgroundColor' => $this->getStatusColor($booking->status),
                    'extendedProps' => [
                        'room' => $booking->room->name,
                        'user' => $booking->user->name,
                        'description' => $booking->description ?? '',
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
