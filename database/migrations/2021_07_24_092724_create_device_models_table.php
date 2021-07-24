<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDeviceModelsTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('device_models', function (Blueprint $table) {
            $table->id();
            $table->boolean("isDevice");
            $table->string("brand");
            $table->string("manufacturer");
            $table->string("modelName");
            $table->string("modelId");
            $table->string("designName");
            $table->string("productName");
            $table->string("deviceYearClass");
            $table->string("totalMemory");
            $table->string("supportedCpuArchitectures");
            $table->string("osName");
            $table->string("osVersion");
            $table->string("osBuildId");
            $table->string("osInternalBuildId");
            $table->string("osBuildFingerprint");
            $table->string("platformApiLevel");
            $table->string("deviceName");            
            $table->unsignedBigInteger('record_id')->nullable();
            $table->foreign('record_id')->references('id')->on('records')->onDelete('cascade');

            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::dropIfExists('device_models');
    }
}