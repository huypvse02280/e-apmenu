<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWirelessTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('wireless', function (Blueprint $table) {
            $table->increments('id');
            $table->string('historyLogReason');
            $table->float('confidenceFactor');
            $table->tinyInteger('currentlyTracked');
            $table->string('macAddress');
            $table->tinyInteger('isGuestUser');
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
        Schema::dropIfExists('wireless');
    }
}
