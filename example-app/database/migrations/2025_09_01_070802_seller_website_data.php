<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    /**
     * Run the migrations.
     */
    public function up(): void
    {
        //
        Schema::create('seller_website_data', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->constrained()->onDelete('cascade');
            $table->string('website_name');
            $table->integer('da_score');
            $table->integer('publishing_time');
            $table->string('example_website_name');
            $table->json('category');
            $table->integer('normal_guest_price')->nullable();
            $table->integer('normal_link_price')->nullable();
            $table->integer('fc_guest_price')->nullable();
            $table->integer('fc_link_price')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        //
        Schema::dropIfExists('seller_website_data');
    }
};
