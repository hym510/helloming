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
            $table->string('gender', 16)->default('male');
            $table->unsignedMediumInteger('online_time')->default(0);
            $table->unsignedSmallInteger('job_id');
            $table->string('zodiac', 16)->nullable();
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

        Schema::connection('admin')->create('admins', function (Blueprint $table) {
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

        Schema::connection('log')->create('log', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('type', 16);
            $table->timestamp('time');
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
            $table->unsignedTinyInteger('position');
            $table->json('upgrade');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
        });

        Schema::create('user_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
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
            $table->string('type', 32);
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
            $table->unsignedInteger('event_id');
            $table->string('longitude', 64);
            $table->string('latitude', 64);
            $table->timestamp('created_at');
        });

        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id')->nullable();
            $table->unsignedSmallInteger('type');
            $table->unsignedSmallInteger('price');
            $table->unsignedSmallInteger('quantity');
        });

        Schema::create('orders', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->unsignedTinyInteger('quantity');
            $table->string('product_id', 64);
            $table->string('transaction_id');
            $table->timestamp('purchase_date');

            $table->unique('transaction_id');
        });

        Schema::create('diamonds', function (Blueprint $table) {
            $table->increments('id');
            $table->string('icon');
            $table->string('product_id');
            $table->unsignedSmallInteger('price');
            $table->unsignedSmallInteger('quantity');
        });

        Schema::create('xml_managements', function (Blueprint $table) {
            $table->increments('id');
            $table->string('xmlname');
            $table->string('version');
            $table->boolean('mark')->default(true);
            $table->timestamp('created_at')
                ->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')
                ->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('xml_urls', function (Blueprint $table) {
            $table->increments('id');
            $table->string('urlname');
            $table->string('flag')->default(true);
            $table->timestamp('created_at')
                ->default(\DB::raw('CURRENT_TIMESTAMP'));
            $table->timestamp('updated_at')
                ->default(\DB::raw('CURRENT_TIMESTAMP ON UPDATE CURRENT_TIMESTAMP'));
        });

        Schema::create('configure', function (Blueprint $table) {
            $table->increments('id');
            $table->string('key', 64);
            $table->json('value');
        });

        Schema::create('consumes', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->string('content');
            $table->unsignedSmallInteger('quantity');
            $table->timestamp('consume_date');
        });
    }
}
