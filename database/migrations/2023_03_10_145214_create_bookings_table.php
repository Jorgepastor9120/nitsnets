<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        Schema::create('bookings', function (Blueprint $table) {
            $table->id();

            $table->unsignedBigInteger('member_id')
                ->nullable();
            $table->foreign('member_id')
                ->references('id')
                ->on('members')
                ->onDelete('set null');
            $table->unsignedBigInteger('court_id')
                ->nullable();
            $table->foreign('court_id')
                ->references('id')
                ->on('courts')
                ->onDelete('set null');
            $table->date('date');
            $table->string('hour_reserve_id', 5);

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('bookings');
    }
};
