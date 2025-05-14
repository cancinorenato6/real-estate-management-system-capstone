<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up()
    {
        // Create broadcast_properties table
        Schema::create('broadcast_properties', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('client_id');
            $table->text('description');
            $table->string('status')->default('open'); // open, claimed, closed
            $table->unsignedBigInteger('claimed_by_agent_id')->nullable();
            $table->timestamp('claimed_at')->nullable();
            $table->timestamps();
            
            $table->foreign('client_id')->references('id')->on('clients')->onDelete('cascade');
            $table->foreign('claimed_by_agent_id')->references('id')->on('agents')->onDelete('set null');
        });
        
        // Add is_broadcast field to messages table
        Schema::table('messages', function (Blueprint $table) {
            $table->boolean('is_broadcast')->default(false);
            $table->unsignedBigInteger('broadcast_id')->nullable();
            $table->foreign('broadcast_id')->references('id')->on('broadcast_properties')->onDelete('cascade');
        });
    }

    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            $table->dropForeign(['broadcast_id']);
            $table->dropColumn(['is_broadcast', 'broadcast_id']);
        });
        
        Schema::dropIfExists('broadcast_properties');
    }
};