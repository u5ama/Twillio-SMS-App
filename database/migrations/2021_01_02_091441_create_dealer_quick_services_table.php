<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealerQuickServicesTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealer_quick_services', function(Blueprint $table){
            $table->id();
            $table->unsignedBigInteger('dealer_id');
            $table->unsignedBigInteger('quick_service_id');
            $table->timestamps();

            $table->foreign('dealer_id')
                ->references('id')
                ->on('dealers')
                ->onDelete('cascade');

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
        Schema::dropIfExists('dealer_quick_services');
    }
}
