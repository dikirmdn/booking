<?php

namespace Database\Seeders;

use App\Models\Room;
use Illuminate\Database\Seeder;

class RoomSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $rooms = [
            [
                'name' => 'Ruang Meeting A',
                'description' => 'Ruang meeting dengan kapasitas kecil, cocok untuk diskusi tim kecil',
                'capacity' => 10,
                'facilities' => ['Projector', 'Whiteboard', 'WiFi', 'AC'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Meeting B',
                'description' => 'Ruang meeting dengan kapasitas sedang',
                'capacity' => 20,
                'facilities' => ['Projector', 'Whiteboard', 'WiFi', 'AC', 'Sound System'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Meeting C',
                'description' => 'Ruang meeting besar untuk presentasi dan acara besar',
                'capacity' => 50,
                'facilities' => ['Projector', 'Whiteboard', 'WiFi', 'AC', 'Sound System', 'Microphone'],
                'is_active' => true,
            ],
            [
                'name' => 'Ruang Diskusi',
                'description' => 'Ruang diskusi informal dengan suasana santai',
                'capacity' => 8,
                'facilities' => ['Whiteboard', 'WiFi', 'AC'],
                'is_active' => true,
            ],
        ];

        foreach ($rooms as $room) {
            Room::create($room);
        }
    }
}
