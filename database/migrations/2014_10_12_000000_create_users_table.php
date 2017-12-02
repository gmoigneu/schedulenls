<?php

use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateUsersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function(Blueprint $table){
            
            $table->increments('id');
            $table->string('email');
            $table->string('slug');
            $table->string('first_name');
            $table->string('last_name');
            $table->string('remember_token');
            $table->text('token');
            $table->text('timezone')->default('Europe/Paris');

        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('users');
    }
}