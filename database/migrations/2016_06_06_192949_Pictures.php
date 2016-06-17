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
            $tabla->increments('Id_Picture');
            $tabla->string('Title', 100);
            $tabla->string('Description', 300);
            $tabla->string('Url', 500);
            $tabla->string('Url_Croped', 500);
            $tabla->string('Mime', 5);
            $tabla->integer('Id_Album')->unsigned();
            $tabla->timestamps();

            $tabla->foreign('Id_Album')->references('Id_Album')->on('Albums');

            
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
