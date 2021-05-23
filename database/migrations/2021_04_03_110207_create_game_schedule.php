<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateGameSchedule extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('game_schedule', function (Blueprint $table) {
            $table->id();
            $table->integer('player_1');
            $table->integer('player_2');
            $table->string('time');
            $table->string('date');
            $table->string('string_time');
            $table->boolean('is_approve');
            $table->boolean('is_upcoming');
            $table->boolean('is_in_progress');
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
        Schema::dropIfExists('game_schedule');
    }
}
