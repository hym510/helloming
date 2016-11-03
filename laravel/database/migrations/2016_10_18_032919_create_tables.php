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
            $table->unsignedTinyInteger('level')->default(0);
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
            $table->unsignedSmallInteger('action')->default(0);
            $table->unsignedSmallInteger('gold')->default(0);
            $table->unsignedSmallInteger('shoe')->default(0);
            $table->unsignedSmallInteger('diamond')->default(0);
            $table->unsignedSmallInteger('equipment1_level')->default(1);
            $table->unsignedSmallInteger('equipment2_level')->default(1);
            $table->unsignedSmallInteger('equipment3_level')->default(1);
            $table->boolean('activate')->default(true);
            $table->string('auth_token', 64)->nullable();
            $table->string('wechat_id', 64)->nullable();
            $table->timestamp('created_at');

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
            $table->unsignedSmallInteger('quantity')->default(1);
        });

        Schema::create('events', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('type', ['mine', 'monster', 'fortune']);
            $table->unsignedTinyInteger('level');
            $table->unsignedInteger('mine_id')->nullable();
            $table->foreign('mine_id')
                ->references('id')->on('mines')
                ->onDelete('cascade');
            $table->unsignedInteger('monster_id')->nullable();
            $table->foreign('monster_id')
                ->references('id')->on('monsters')
                ->onDelete('cascade');
            $table->unsignedInteger('fortune_id')->nullable();
            $table->foreign('fortune_id')
                ->references('id')->on('fortunes')
                ->onDelete('cascade');
            $table->unsignedSmallInteger('exp');
            $table->unsignedTinyInteger('unlock_level');
            $table->json('prize')->nullable();
            $table->string('info');
        });

        Schema::create('monsters', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->enum('type', ['normal', 'boss']);
            $table->unsignedSmallInteger('level');
            $table->unsignedSmallInteger('hp');
            $table->boolean('kill_limit');
            $table->unsignedSmallInteger('kill_limit_time');
            $table->string('icon');
        });

        Schema::create('mines', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name');
            $table->unsignedSmallInteger('time');
            $table->string('icon');
            $table->unsignedSmallInteger('consume_diamond');
        });

        Schema::create('fortunes', function (Blueprint $table) {
            $table->increments('id');
            $table->enum('cost_type', ['item', 'gold', 'diamond', 'none']);
            $table->unsignedInteger('item_id')->nullable();
            $table->foreign('item_id')
                ->references('id')->on('items')
                ->onDelete('cascade');
            $table->unsignedTinyInteger('cost');
            $table->json('prize');
        });

        Schema::create('host_mining', function (Blueprint $table) {
            $table->increments('id');
            $table->unsignedInteger('user_id');
            $table->foreign('user_id')
                ->references('id')->on('users')
                ->onDelete('cascade');
            $table->unsignedInteger('event_id');
            $table->foreign('event_id')
                ->references('id')->on('events')
                ->onDelete('cascade');
            $table->unsignedInteger('mine_id');
            $table->foreign('mine_id')
                ->references('id')->on('mines')
                ->onDelete('cascade');
            $table->timestamp('created_at');
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

        Schema::create('notifications', function (Blueprint $table) {
            $table->increments('id');
            $table->string('message');
            $table->timestamp('created_at');
        });
    }
}
