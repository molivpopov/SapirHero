<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateAlleopTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('alleop', function (Blueprint $table) {
            $table->id();
            $table->unsignedInteger('game');
            $table->unsignedInteger('turn');
            $table->unsignedBigInteger('hero_id');
            $table->float('health_hero');
            $table->string('used_skills')->nullable();
            $table->unsignedBigInteger('monster_id');
            $table->float('health_monster');
            $table->enum('status', ['play', 'finished']);
            $table->timestamps();
            $table->foreign('hero_id')
                ->references('id')->on('creatures')
                ->onDelete('cascade');
            $table->foreign('monster_id')
                ->references('id')->on('creatures')
                ->onDelete('cascade');
            $table->engine = "InnoDB";
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('alleop');
    }
}
