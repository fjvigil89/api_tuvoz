<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateUserTreatmentsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('user__treatments', function (Blueprint $table) {
            $table->id();
            $table->timestamps();
            $table->boolean('complete')->default(false);
            $table->integer("current_phrase")->default(1);
            $table->unsignedBigInteger('treatment_id')->nullable();
            $table->unsignedBigInteger('patient_id')->nullable();              
            $table->foreign('patient_id')->references('id')->on('users')->onDelete('cascade');           
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
        Schema::dropIfExists('user__treatments');
    }
}