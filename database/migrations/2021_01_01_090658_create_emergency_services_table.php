<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateEmergencyServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('emergency_services', function(Blueprint $table){
            $table->id();
            $table->string('image');
            $table->timestamps();
        });
        Schema::create('emergency_service_translations', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('emergency_service_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();

            $table->foreign('emergency_service_id')
                ->references('id')
                ->on('emergency_services')
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
        Schema::dropIfExists('emergency_services');
    }
}
