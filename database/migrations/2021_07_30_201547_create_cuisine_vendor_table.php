<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateCuisineVendorTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::create('cuisine_vendor', function (Blueprint $table) {
            $table->id();
            $table->foreignId('cuisine_id');
            $table->foreignId('vendor_id');

            $table->foreign('cuisine_id')->references('id')->on('cuisines');
            $table->foreign('vendor_id')->references('id')->on('vendors');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::dropIfExists('cuisine_vendor');
    }
}
