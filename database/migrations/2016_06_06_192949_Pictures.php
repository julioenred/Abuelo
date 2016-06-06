<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class Pictures extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('Pictures', function(Blueprint $tabla) 
        {
            $tabla->increments('id');
            $tabla->string('Title', 100);
            $tabla->string('Description', 300);
            $tabla->string('Url', 300);

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
        Schema::drop('Pictures');
    }
}
