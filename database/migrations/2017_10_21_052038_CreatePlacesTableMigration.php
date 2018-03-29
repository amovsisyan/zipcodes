<?php

use Illuminate\Support\Facades\Schema;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Database\Migrations\Migration;
use \App\Http\Controllers\DBColumnsLengthData;

class CreatePlacesTableMigration extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('places', function (Blueprint $table) {
            $table->increments('id');
            $table->string('name', DBColumnsLengthData::PLACES_TABLE['name'])->nullable();
            $table->decimal(
                'long'
                , DBColumnsLengthData::PLACES_TABLE['long']['digits']
                , DBColumnsLengthData::PLACES_TABLE['long']['after']
            )->nullable();
            $table->decimal(
                'lat'
                , DBColumnsLengthData::PLACES_TABLE['lat']['digits']
                , DBColumnsLengthData::PLACES_TABLE['lat']['after']
            )->nullable();
            $table->integer('state_id')->unsigned();
            $table->foreign('state_id')->references('id')->on('states')->onDelete('cascade');
            $table->integer('post_code_id')->unsigned();
            $table->foreign('post_code_id')->references('id')->on('post_codes')->onDelete('cascade');
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
        Schema::dropIfExists('places');
    }
}
