<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateDimensionTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dimension', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('mapinfo_id')->unsigned();
            $table->foreign('mapinfo_id')->references('id')->on('mapinfo')->onDelete('cascade');
            $table->float('offsetY');
            $table->float('offsetX');
            $table->float('height');
            $table->float('width');
            $table->float('length');   
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('dimension');
    }
}
