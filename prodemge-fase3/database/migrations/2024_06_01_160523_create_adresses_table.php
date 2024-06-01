<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('adresses', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');
            $table->enum('type',['residential','business']);
            $table->text('postal_code');
            $table->text('number');
            $table->text('complement');
            $table->text('neighborhood');
            $table->text('uf');
            $table->text('city');
            $table->timestamps();
            $table->foreign('people_id')->references('id')->on('peoples');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('adresses', function (Blueprint $table) {
            $table->dropForeign(['people_id']);
        });
        Schema::dropIfExists('adresses');
    }
};
