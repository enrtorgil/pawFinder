<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextsTable extends Migration
{
    public function up()
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('emitter_id');
            $table->unsignedBigInteger('receiver_id');
            $table->string('subject');
            $table->text('short_description');
            $table->boolean('is_read')->default(false);
            $table->timestamps();

            $table->foreign('emitter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('texts');
    }
}
