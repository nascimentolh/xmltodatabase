<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;

class CreateTableItems extends Migration
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
            $table->string('weapon_type')->nullable();
            $table->string('crystal_type')->nullable();
            $table->string('material')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });

        Schema::create('armor_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idItem');
            $table->string('type');
            $table->string('name');
            $table->string('reference');
            $table->string('armor_type')->nullable();
            $table->string('crystal_type')->nullable();
            $table->string('bodypart')->nullable();
            $table->string('material')->nullable();
            $table->integer('price')->nullable();
            $table->timestamps();
        });

        Schema::create('etc_items', function (Blueprint $table) {
            $table->increments('id');
            $table->integer('idItem');
            $table->string('type');
            $table->string('name');
            $table->string('reference');
            $table->string('material')->nullable();
            $table->integer('price')->nullable();
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
        Schema::dropIfExists('table_items');
    }
}
