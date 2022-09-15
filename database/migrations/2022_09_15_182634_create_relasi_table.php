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
        Schema::create('relasi', function (Blueprint $table) {
            $table->id();
            $table->foreignId('id_penyakit');
            $table->foreignId('id_gejala');
            $table->timestamps();

            $table->foreign('id_penyakit')->references('id')->on('penyakit')
            ->onUpdate('cascade')
            ->onDelete('cascade');

            $table->foreign('id_gejala')->references('id')->on('gejala')
            ->onUpdate('cascade')
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
        Schema::dropIfExists('relasi');
    }
};
