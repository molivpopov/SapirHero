<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreatureSkillsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creature_skills', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('creature_id');
            $table->unsignedBigInteger('skill_id');
            $table->foreign('skill_id')
                ->references('id')->on('skills')
                ->onDelete('cascade');
            $table->foreign('creature_id')
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
        Schema::dropIfExists('creature_skills');
    }
}
