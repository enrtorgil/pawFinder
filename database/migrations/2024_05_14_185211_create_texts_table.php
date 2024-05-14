<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateTextsTable extends Migration
{
    public function up()
    {
        Schema::create('texts', function (Blueprint $table) {
            $table->unsignedBigInteger('emitter_id');
            $table->unsignedBigInteger('receiver_id');
            $table->string('subject');
            $table->text('short_description');
            $table->timestamps();

            $table->primary(['emitter_id', 'receiver_id', 'created_at']);
            $table->foreign('emitter_id')->references('id')->on('users')->onDelete('cascade');
            $table->foreign('receiver_id')->references('id')->on('users')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::dropIfExists('texts');
    }
}
