<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateReportsTable extends Migration
{
    public function up()
    {
        Schema::create('reports', function (Blueprint $table) {
            $table->unsignedBigInteger('publication_id');
            $table->unsignedBigInteger('user_id');
            $table->text('additional_info')->nullable();
            $table->enum('reason', ['Contenido inapropiado', 'Información incorrecta', 'Spam', 'Otra razón']);
            $table->timestamps();

            $table->foreign('publication_id')->references('id')->on('publications')->onDelete('cascade');
            $table->foreign('user_id')->references('id')->on('users')->onDelete('cascade');
        });

        Schema::table('reports', function (Blueprint $table) {
            $table->primary(['publication_id', 'user_id', 'created_at']);
        });
    }

    public function down()
    {
        Schema::dropIfExists('reports');
    }
}
