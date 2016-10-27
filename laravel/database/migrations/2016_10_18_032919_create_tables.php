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
            $table->unsignedInteger('experience')->default(0);
            $table->unsignedInteger('vip_experience')->default(0);
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
            $table->unsignedSmallInteger('power')->default(0);
            $table->unsignedSmallInteger('action')->default(0);
            $table->unsignedSmallInteger('gold')->default(0);
            $table->unsignedSmallInteger('shoe')->default(0);
            $table->unsignedSmallInteger('diamond')->default(0);
            $table->unsignedSmallInteger('equipment1_level')->default(1);
            $table->unsignedSmallInteger('equipment2_level')->default(1);
            $table->unsignedSmallInteger('equipment3_level')->default(1);
            $table->string('auth_token', 64);
            $table->string('wechat_id', 64)->nullable();
            $table->timestamp('created_at');
            $table->softDeletes();

            $table->unique('phone');
            $table->unique('auth_token');
            $table->unique('wechat_id');
        });

        Schema::create('admins', function (Blueprint $table) {
            $table->increments('id');
            $table->string('email');
            $table->string('password');
            $table->rememberToken();
        });

        Schema::create('jobs', function (Blueprint $table) {
            $table->increments('id');
            $table->string('title');
        });

        Schema::create('equipment', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
        });

        Schema::create('equipment_attr', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedSmallInteger('level');
            $table->boolean('max_level')->default(false);
            $table->unsignedSmallInteger('power');
            $table->unsignedSmallInteger('job_id');
            $table->enum('position', [1, 2, 3]);
            $table->json('upgrade');
            $table->string('icon');
        });

        Schema::create('items', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('priority');
            $table->enum('type', ['currency', 'tool', 'building', 'nei_dan']);
            $table->string('icon');
            $table->string('info')->nullable();
        });

        Schema::create('user_items', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')
                ->references('id')->on('items')
                ->onDelete('cascade');
            $table->unsignedSmallInteger('quantity');
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['monster', 'mine', 'fortune_chest']);
            $table->unsignedInteger('monster_id')->nullable();
            $table->unsignedInteger('mine_id')->nullable();
            $table->unsignedSmallInteger('exp');
            $table->unsignedTinyInteger('unlock_level');
            $table->json('prize');
            $table->string('info');
        });

        Schema::create('monsters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['normal', 'boss']);
            $table->unsignedSmallInteger('level');
            $table->unsignedSmallInteger('hp');
            $table->boolean('kill_limit');
            $table->boolean('kill_limit_time');
            $table->string('rescource');
        });

        Schema::create('mines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('time');
            $table->string('icon');
        });

        Schema::create('fortune_chests', function (Blueprint $table) {
            $table->increments('id');
            $table->boolean('cost');
            $table->enum('cost_type', ['nothing', 'gold', 'diamond']);
            $table->json('prize');
        });

        Schema::create('shops', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('item_id');
            $table->foreign('item_id')
                ->references('id')->on('items')
                ->onDelete('cascade');
            $table->enum('type', ['tool', 'building', 'nei_dan']);
            $table->unsignedSmallInteger('priority');
            $table->unsignedSmallInteger('price');
        });
    }
}
