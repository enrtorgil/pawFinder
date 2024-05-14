<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePublicationsTable extends Migration
{
    public function up()
    {
        Schema::create('publications', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('user_id');
            $table->string('name');
            $table->enum('type', ['se busca', 'se adopta']);
            $table->enum('type_animal', ['perro', 'gato', 'otro']);
            $table->enum('size', ['Grande', 'Mediano', 'Pequeño']);
            $table->string('image');
            $table->dateTime('date');
            $table->text('description')->nullable();
            $table->string('street')->nullable();
            $table->string('city')->nullable();
            $table->string('country')->nullable();
            $table->integer('zip')->nullable();
            $table->float('latitude');
            $table->float('longitude');
            $table->timestamps();

            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('publications');
    }
}
