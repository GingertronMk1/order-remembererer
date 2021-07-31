<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class UpdateOrdersTable extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('orders', function (Blueprint $table) {
            $table->text('food')->nullable()->change();
            $table->text('drink')->nullable()->change();
            $table->text('other')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
    }
}
