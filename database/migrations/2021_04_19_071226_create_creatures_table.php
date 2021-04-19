<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCreaturesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('creatures', function (Blueprint $table) {
            $table->id();
            $table->string('name')->unique();
            $table->enum('type', ['hero', 'monster']);
            $table->string('health')->default('70-100');
            $table->string('strength')->default('70-80');
            $table->string('speed')->default('40-50');
            $table->string('defence')->default('40-50');
            $table->string('luck')->default('10-30');
            $table->timestamps();
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
        Schema::dropIfExists('creatures');
    }
}
