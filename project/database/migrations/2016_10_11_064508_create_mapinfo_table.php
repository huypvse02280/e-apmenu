<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateMapinfoTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('mapinfo', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('wireless_id')->unsigned();
            $table->foreign('wireless_id')->references('id')->on('wireless')->onDelete('cascade');
            $table->double('floorRefId');
            $table->string('mapHierarchyString');
            //$table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('mapinfo');
    }
}
