<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreatePhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('phrases', function (Blueprint $table) {
            $table->id();
            $table->string('phrase');
            $table->boolean('status')->default(false);
            $table->boolean('current')->default(false);
            $table->timestamps();
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
            $table->unsignedBigInteger('patient_id')->nullable();
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('phrases');
    }
}
