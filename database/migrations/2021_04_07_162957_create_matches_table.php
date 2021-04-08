<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateMatchesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('matches', function (Blueprint $table) {
            $table->id();
            $table->foreignId('season_id')->constrained()->onDelete('cascade');
            $table->date('date_played');
            $table->foreignId('team_id', 'team_A')->constrained()->onDelete('cascade');
            $table->unsignedInteger('team_A_score');
            $table->foreignId('team_id', 'team_B')->constrained()->onDelete('cascade');
            $table->unsignedInteger('team_B_score');;
            $table->string('referee');
            $table->string('venue');
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
        Schema::dropIfExists('matches');
    }
}
