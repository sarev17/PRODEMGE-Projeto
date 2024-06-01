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
        Schema::create('contacts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('people_id');
            $table->text('phone_number');
            $table->enum('type',['business','whatsapp','residential']);
            $table->timestamps();
            $table->foreign('people_id')
                ->references('id')
                ->on('peoples')
                ->onDelete('cascade');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('contacts', function (Blueprint $table) {
            $table->dropForeign(['people_id']);
        });
        Schema::dropIfExists('contacts');
    }
};
