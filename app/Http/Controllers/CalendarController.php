<?php

namespace App\Http\Controllers;

use App\Models\Booking;
use App\Models\Room;
use Illuminate\Http\Request;
use Carbon\Carbon;

class CalendarController extends Controller
{
    public function index()
    {
        $rooms = Room::where('is_active', true)->get();
        
        // Get today's schedule data
        $today = Carbon::today('Asia/Jakarta');
        $scheduleData = $this->getTodaySchedule($rooms, $today);
        
        return view('home', compact('rooms', 'scheduleData'));
    }

    public function room($roomId)
    {
        $room = Room::where('is_active', true)->findOrFail($roomId);
        
        return view('calendar.room', compact('room'));
    }

    private function getTodaySchedule($rooms, $date)
    {
        $timeSlots = [
            '08:00' => ['start' => '08:00', 'end' => '09:00'],
            '09:00' => ['start' => '09:00', 'end' => '10:00'],
            '10:00' => ['start' => '10:00', 'end' => '11:00'],
            '11:00' => ['start' => '11:00', 'end' => '12:00'],
            '12:00' => ['start' => '12:00', 'end' => '13:00'],
            '13:00' => ['start' => '13:00', 'end' => '14:00'],
            '14:00' => ['start' => '14:00', 'end' => '15:00'],
            '15:00' => ['start' => '15:00', 'end' => '16:00'],
            '16:00' => ['start' => '16:00', 'end' => '17:00'],
            '17:00' => ['start' => '17:00', 'end' => '18:00'],
            '18:00' => ['start' => '18:00', 'end' => '19:00'],
            '19:00' => ['start' => '19:00', 'end' => '20:00'],
            '20:00' => ['start' => '20:00', 'end' => '21:00'],
            '21:00' => ['start' => '21:00', 'end' => '22:00'],
            '22:00' => ['start' => '22:00', 'end' => '23:00'],
            '23:00' => ['start' => '23:00', 'end' => '24:00'],
        ];

        $schedule = [];
        
        foreach ($timeSlots as $time => $slot) {
            $schedule[$time] = [];
            
            foreach ($rooms as $room) {
                $startDateTime = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $slot['start'], 'Asia/Jakarta');
                $endDateTime = Carbon::createFromFormat('Y-m-d H:i', $date->format('Y-m-d') . ' ' . $slot['end'], 'Asia/Jakarta');
                
                // Check if there's a booking for this room at this time
                $booking = Booking::where('room_id', $room->id)
                    ->whereIn('status', ['approved', 'pending'])
                    ->where(function($query) use ($startDateTime, $endDateTime) {
                        $query->where(function($q) use ($startDateTime, $endDateTime) {
                            // Booking starts within this time slot
                            $q->whereBetween('start_time', [$startDateTime, $endDateTime->subSecond()]);
                        })->orWhere(function($q) use ($startDateTime, $endDateTime) {
                            // Booking ends within this time slot
                            $q->whereBetween('end_time', [$startDateTime->addSecond(), $endDateTime]);
                        })->orWhere(function($q) use ($startDateTime, $endDateTime) {
                            // Booking spans across this time slot
                            $q->where('start_time', '<=', $startDateTime)
                              ->where('end_time', '>=', $endDateTime);
                        });
                    })
                    ->first();

                if ($booking) {
                    $schedule[$time][$room->id] = [
                        'status' => $booking->status,
                        'booking' => $booking,
                        'user' => $booking->user->name ?? 'Unknown'
                    ];
                } else {
                    $schedule[$time][$room->id] = [
                        'status' => 'available',
                        'booking' => null,
                        'user' => null
                    ];
                }
            }
        }

        return $schedule;
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
                // Pastikan timezone yang benar - gunakan format yang tidak mengubah timezone
                $startTime = $booking->start_time->setTimezone('Asia/Jakarta');
                $endTime = $booking->end_time->setTimezone('Asia/Jakarta');
                
                return [
                    'id' => $booking->id,
                    'title' => "{$startTime->format('H:i')}-{$endTime->format('H:i')} {$booking->booker_name}",
                    'start' => $startTime->format('Y-m-d H:i:s'),
                    'end' => $endTime->format('Y-m-d H:i:s'),
                    'backgroundColor' => $this->getStatusColor($booking->status),
                    'borderColor' => $this->getStatusColor($booking->status),
                    'textColor' => '#ffffff',
                    'displayEventTime' => false, // Nonaktifkan tampilan waktu default FullCalendar
                    'extendedProps' => [
                        'booking_id' => $booking->id,
                        'booking_title' => $booking->title,
                        'room' => $booking->room->name,
                        'user' => $booking->user->name,
                        'booker_name' => $booking->booker_name,
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

    public function getScheduleData()
    {
        $rooms = Room::where('is_active', true)->get();
        $today = Carbon::today('Asia/Jakarta');
        $scheduleData = $this->getTodaySchedule($rooms, $today);
        
        return response()->json([
            'success' => true,
            'data' => $scheduleData,
            'rooms' => $rooms->map(function($room) {
                return [
                    'id' => $room->id,
                    'name' => $room->name
                ];
            }),
            'updated_at' => Carbon::now('Asia/Jakarta')->format('H:i:s')
        ]);
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