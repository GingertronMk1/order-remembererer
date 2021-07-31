<?php

use App\Models\User;
use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Schema;

class AddVendorUserId extends Migration
{
    /**
     * Run the migrations.
     */
    public function up()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable()->after('phone');
        });
        DB::table('vendors')->update(['user_id' => User::get()->firstWhere('admin', true)->id]);

        Schema::table('vendors', function (Blueprint $table) {
            $table->foreignId('user_id')->nullable(false)->change();
            $table->foreign('user_id')->references('id')->on('users');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down()
    {
        Schema::table('vendors', function (Blueprint $table) {
            $table->dropForeign(['user_id']);
            $table->dropColumn('user_id');
        });
    }
}
