<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateDealersTable extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::create('dealers', function(Blueprint $table){
            $table->id();
            $table->string('name');
            $table->string('email');
            $table->string('country_code');
            $table->string('mobile_no');
            $table->string('business_name');
            $table->string('password')->nullable();
            $table->string('address')->nullable();
            $table->string('latitude')->nullable();
            $table->string('longitude')->nullable();
            $table->unsignedBigInteger('vehicle_type_id')->nullable();
            $table->unsignedBigInteger('emergency_service_id')->nullable();
            $table->unsignedBigInteger('quick_service_id')->nullable();
            $table->enum('status', ['active', 'inActive'])->default('active');
            $table->enum('register_status', ['approved', 'pending', 'rejected'])->default('approved');
            $table->timestamps();

            $table->foreign('vehicle_type_id')
                ->references('id')
                ->on('vehicle_types')
                ->onDelete('cascade');

            $table->foreign('emergency_service_id')
                ->references('id')
                ->on('emergency_services')
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
        Schema::dropIfExists('dealers');
    }
}
