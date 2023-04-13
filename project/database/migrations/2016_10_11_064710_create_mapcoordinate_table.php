<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapcoordinateTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapcoordinate', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wireless_id')->unsigned();
            $table->foreign('wireless_id')->references('id')->on('wireless')->onDelete('cascade');
            $table->string('unit');
            $table->float('y');
            $table->float('x');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapcoordinate');
    }
}
