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
            $table->string('avatar')->nullable();
            $table->string('phone', 11);
            $table->unsignedTinyInteger('level')->default(1);
            $table->unsignedMediumInteger('exp')->default(0);
            $table->unsignedMediumInteger('vip_exp')->default(0);
            $table->unsignedTinyInteger('state')->default(0);
            $table->string('name', 32);
            $table->unsignedTinyInteger('height')->default(0);
            $table->unsignedTinyInteger('weight')->default(0);
            $table->unsignedTinyInteger('age')->default(0);
            $table->enum('gender', ['male', 'female'])->default('male');
            $table->unsignedMediumInteger('online_time')->default(0);
            $table->unsignedSmallInteger('job_id');
            $table->enum('zodiac', [
                    'aquarius', 'pisces', 'aries',
                    'taurus', 'gemini', 'cancer', 'leo', 'virgo',
                    'libra', 'scorpio', 'sagittarius', 'capricorn'
                ])->nullable();
            $table->unsignedTinyInteger('space')->default(3);
            $table->unsignedTinyInteger('take_up')->default(0);
            $table->unsignedSmallInteger('power')->default(0);
            $table->unsignedSmallInteger('remain_power')->default(0);
            $table->unsignedSmallInteger('action')->default(0);
            $table->unsignedSmallInteger('remain_action')->default(0);
            $table->unsignedSmallInteger('gold')->default(0);
            $table->unsignedSmallInteger('diamond')->default(0);
            $table->unsignedSmallInteger('equipment1_level')->default(1);
            $table->unsignedSmallInteger('equipment2_level')->default(1);
            $table->unsignedSmallInteger('equipment3_level')->default(1);
            $table->boolean('activate')->default(true);
            $table->string('auth_token', 64)->nullable();
            $table->string('union_id', 64)->nullable();
            $table->string('withdraw_password')->nullable();
            $table->timestamp('created_at');

            $table->unique('phone');
            $table->unique('auth_token');
            $table->unique('union_id');
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
        });

        Schema::create('wechat', function (Blueprint $table) {
            $table->increments('id');
            $table->string('union_id', 64);
            $table->string('open_id', 64);

            $table->unique('union_id');
        });

        Schema::create('state_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('level');
            $table->unsignedSmallInteger('power');

            $table->unique('level');
        });

        Schema::create('level_attributes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedTinyInteger('level');
            $table->unsignedMediumInteger('exp');
            $table->unsignedSmallInteger('power');
            $table->unsignedSmallInteger('action');

            $table->unique('level');
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('level');
            $table->boolean('max_level')->default(false);
            $table->unsignedSmallInteger('power');
            $table->unsignedSmallInteger('job_id');
            $table->enum('position', [1, 2, 3]);
            $table->json('upgrade');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('user_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('item_id');
            $table->unsignedSmallInteger('quantity')->default(1);
        });

        Schema::create('monsters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('level');
            $table->unsignedSmallInteger('hp');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['monster', 'mine', 'chest']);
            $table->unsignedTinyInteger('level');
            $table->unsignedInteger('type_id');
            $table->unsignedSmallInteger('exp');
            $table->unsignedTinyInteger('unlock_level');
            $table->unsignedTinyInteger('weight');
            $table->json('prize');
            $table->string('info');
            $table->boolean('time_limit')->default(false);
            $table->unsignedSmallInteger('time')->default(0);
            $table->unsignedInteger('finish_item_id');
            $table->unsignedSmallInteger('item_quantity');
        });

        Schema::create('host_events', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('event_id');
            $table->unsignedInteger('mine_id');
            $table->foreign('mine_id')
                ->references('id')->on('mines')
                ->onDelete('cascade');
            $table->timestamp('created_at');
        });

        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedSmallInteger('type');
            $table->unsignedSmallInteger('price');
            $table->unsignedSmallInteger('quantity');
        });

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->timestamp('created_at');
        });
    }
}
