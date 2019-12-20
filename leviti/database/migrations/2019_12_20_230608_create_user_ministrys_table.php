<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMinistrysTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ministrys', function (Blueprint $table) {
            $table->integer('id_user');
            $table->integer('id_ministry');
            $table->boolean('leader');
            $table->boolean('vice_leader');
            $table->boolean('member');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_ministry')->references('id')->on('ministrys');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_ministrys');
    }
}
