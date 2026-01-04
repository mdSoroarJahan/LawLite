<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up()
    {
        // Update existing 'scheduled' appointments to 'pending'
        DB::table('appointments')
            ->where('status', 'scheduled')
            ->update(['status' => 'pending']);
    }

    public function down()
    {
        // Revert 'pending' to 'scheduled' (optional, but tricky if we have mixed data)
        // For this fix, we can assume we want to keep them as pending or confirmed.
    }
};
