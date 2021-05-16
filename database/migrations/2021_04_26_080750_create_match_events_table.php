<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchEventsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('match_events', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->unsignedBigInteger('season_id');
            $table->date('date_played');
            $table->unsignedBigInteger('home_team_id');
            $table->unsignedInteger('home_team_score');
            $table->unsignedInteger('away_team_score');
            $table->unsignedBigInteger('away_team_id');
            $table->unsignedBigInteger('win_team_id')->nullable();
            $table->unsignedBigInteger('loss_team_id')->nullable();
            $table->string('referee')->nullable();
            $table->string('venue');
            $table->timestamps();
            

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('season_id')->references('id')->on('seasons')->onDelete('cascade');
            $table->foreign('home_team_id')->references('id')->on('teams')->onDelete('cascade');
            $table->foreign('away_team_id')->references('id')->on('teams')->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('match_events');
    }
}
