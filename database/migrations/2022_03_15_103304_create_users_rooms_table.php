<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users_rooms', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id');
            $table->string('room_id');
            $table->foreign('room_id')->references('id')->on('rooms')->cascadeOnDelete();
            $table->boolean('online');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users_rooms');
    }
};
