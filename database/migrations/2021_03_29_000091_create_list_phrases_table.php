<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateListPhrasesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('list_phrases', function (Blueprint $table) {
            $table->id();
            $table->string('phrase');
            $table->timestamps();
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->foreign('treatment_id')->references('id')->on('treatments')->onDelete('cascade');
            
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('list_phrases');
    }
}
