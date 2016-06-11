<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Albums extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Albums', function(Blueprint $tabla) 
        {
            $tabla->increments('id');
            $tabla->string('Name', 100);
            $tabla->string('Activo', 1)->default('1');
            $tabla->string('Type', 1);

            $tabla->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::drop('Albums');
    }
}
