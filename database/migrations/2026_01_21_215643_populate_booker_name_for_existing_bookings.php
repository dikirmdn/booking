<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        // Populate booker_name for existing bookings with user's name
        DB::table('bookings')
            ->join('users', 'bookings.user_id', '=', 'users.id')
            ->whereNull('bookings.booker_name')
            ->orWhere('bookings.booker_name', '')
            ->update(['bookings.booker_name' => DB::raw('users.name')]);
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        // Set booker_name to null for rollback
        DB::table('bookings')->update(['booker_name' => null]);
    }
};
