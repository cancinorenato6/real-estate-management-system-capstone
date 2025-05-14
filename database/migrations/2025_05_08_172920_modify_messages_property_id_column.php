<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class ModifyMessagesPropertyIdColumn extends Migration
{
    /**
     * Run the migrations.
     *
     * @return void
     */
    public function up()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop the existing foreign key constraint
            $table->dropForeign(['property_id']);
            
            // Modify the property_id column to allow NULL values
            $table->unsignedBigInteger('property_id')->nullable()->change();
            
            // Add the foreign key constraint back, but with 'on delete set null'
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('set null');
        });
    }

    /**
     * Reverse the migrations.
     *
     * @return void
     */
    public function down()
    {
        Schema::table('messages', function (Blueprint $table) {
            // Drop the modified foreign key constraint
            $table->dropForeign(['property_id']);
            
            // Change property_id back to non-nullable
            $table->unsignedBigInteger('property_id')->nullable(false)->change();
            
            // Add back the original foreign key constraint
            $table->foreign('property_id')
                  ->references('id')
                  ->on('properties')
                  ->onDelete('cascade');
        });
    }
}