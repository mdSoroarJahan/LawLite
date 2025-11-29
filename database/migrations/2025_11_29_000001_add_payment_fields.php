<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->decimal('hourly_rate', 8, 2)->default(500.00)->after('bio'); // Default 500 BDT
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->string('payment_status')->default('pending')->after('status'); // pending, paid, failed
            $table->decimal('amount', 8, 2)->nullable()->after('payment_status');
            $table->string('payment_method')->nullable()->after('amount'); // bkash, card, cash
            $table->string('transaction_id')->nullable()->after('payment_method');
        });
    }

    public function down()
    {
        Schema::table('lawyers', function (Blueprint $table) {
            $table->dropColumn('hourly_rate');
        });

        Schema::table('appointments', function (Blueprint $table) {
            $table->dropColumn(['payment_status', 'amount', 'payment_method', 'transaction_id']);
        });
    }
};
