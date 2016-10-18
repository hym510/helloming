<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTables extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('users', function (Blueprint $table) {
            $table->increments('id');
            $table->string('phone', 11);
            $table->string('name', 32);
            $table->string('avatar')->nullable();
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->unsignedInteger('job_id');
            $table->string('token', 64);
            $table->string('wechat_id', 64)->nullable();
            $table->timestamp('created_at');

            $table->unique('phone');
            $table->unique('token');
            $table->unique('wechat_id');
        });
    }
}
