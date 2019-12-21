<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserMinistriesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user_ministries', function (Blueprint $table) {
            $table->integer('id_user');
            $table->integer('id_ministry');
            $table->boolean('leader');
            $table->boolean('vice_leader');
            $table->boolean('member');
            $table->boolean('status');
            $table->timestamps();

            $table->foreign('id_user')->references('id')->on('users');
            $table->foreign('id_ministry')->references('id')->on('ministries');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('user_ministries');
    }
}
