<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateLocationsXmlTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('locationsXml', function (Blueprint $table) {
            $table->increments('id');
            $table->string('historyLogReason');
            $table->float('confidenceFactor');
            $table->tinyInteger('currentlyTracked');
            $table->string('macAddress');
            $table->tinyInteger('isGuestUser');
            $table->double('floorRefId');
            $table->string('mapHierarchyString');
            $table->string('unit_Dimension');
            $table->float('offsetX');
            $table->float('offsetY');
            $table->float('height');
            $table->float('width');
            $table->float('length');
            $table->string('imageName');
            $table->string('unit_MapCoordinate');
            $table->float('y_MapCoordinate');
            $table->float('x_MapCoordinate');
            $table->datetime('lastLocatedTime');
            $table->datetime('firstLocatedTime');
            $table->datetime('currentServerTime');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('locationsXml');
    }
}
