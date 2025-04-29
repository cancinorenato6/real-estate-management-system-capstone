<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('agent_id'); // link to agents table
            $table->enum('offer_type', ['sell', 'rent']);
            $table->enum('property_type', ['condominium', 'commercial_space', 'apartment', 'house', 'land']);
            $table->string('title');
            $table->text('description');
            $table->decimal('price', 15, 2);
            $table->json('images')->nullable(); // will store array of image filenames
            $table->string('province');
            $table->string('city');
            $table->string('barangay');
            $table->timestamps();

            // foreign key constraint
            $table->foreign('agent_id')->references('id')->on('agents')->onDelete('cascade');
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('properties');
    }
};
