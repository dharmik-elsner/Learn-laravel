<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateVehiclesTable extends Migration
{
    public function up()
    {
        Schema::create('vehicles', function (Blueprint $table) {
            $table->id();  // This will create the 'id' column as the primary key
            $table->string('model');  // Vehicle model (e.g., Corolla, Mustang)
            $table->string('brand');  // Vehicle brand (e.g., Toyota, Ford)
            $table->year('year');  // Year of manufacture (e.g., 2020)
            $table->timestamps();  // Created_at and updated_at timestamps
        });
    }

    public function down()
    {
        Schema::dropIfExists('vehicles');
    }
}
