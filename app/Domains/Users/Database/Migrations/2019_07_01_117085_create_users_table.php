<?php

use Illuminate\Support\Facades\Schema;
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
        Schema::create('users', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->uuid('uuid')->unique();

            $table->unsignedBigInteger('role_id');
            $table->unsignedBigInteger('last_login_id')->nullable();

            $table->string('name');
            $table->string('email')->unique();
            $table->boolean('is_enabled')->default(true);
            $table->timestamp('email_verified_at')->nullable();
            $table->string('password');
            $table->string('api_token', 80)
                        ->unique()
                        ->nullable()
                        ->default(null);

            $table->rememberToken();
            $table->timestamp('last_login_at')->nullable();

            $table->timestamps();

            $table->foreign('role_id')->references('id')->on('roles');
            $table->foreign('last_login_id')->references('id')->on('logins');
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
