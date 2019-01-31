<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateWeaponItems extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('weapon_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idItem');
            $table->string('type');
            $table->string('name');
            $table->string('reference');
            $table->timestamps();
        });

        Schema::create('armor_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idItem');
            $table->string('type');
            $table->string('name');
            $table->string('reference');
            $table->timestamps();
        });

        Schema::create('etc_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idItem');
            $table->string('type');
            $table->string('name');
            $table->string('reference');
            $table->timestamps();
        });        
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('weapon_items');
    }
}
