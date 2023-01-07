<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateQuickServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('quick_services', function(Blueprint $table){
            $table->id();
            $table->string('image');
            $table->timestamps();
        });
        Schema::create('quick_service_translations', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('quick_service_id')->unsigned();
            $table->string('name');
            $table->string('locale')->index();

            $table->foreign('quick_service_id')
                ->references('id')
                ->on('quick_services')
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
        Schema::dropIfExists('quick_services');
    }
}
