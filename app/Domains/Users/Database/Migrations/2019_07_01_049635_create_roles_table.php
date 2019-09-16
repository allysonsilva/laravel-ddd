<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\Artisan;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateRolesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');

            $table->string('name');
            $table->string('code')->unique();
            $table->string('description')->nullable();
            $table->unsignedSmallInteger('level')->unique();

            $table->timestamps();
        });

        Artisan::call('db:seed', [
            '--class' => 'RolesTableSeeder',
            '--domain' => 'Users',
        ]);
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('roles');
    }
}
