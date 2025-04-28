<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
{
    Schema::create('agents', function (Blueprint $table) {
        $table->id();
        $table->string('prc_id', 55)->unique();
        $table->string('name', 55);
        $table->integer('age');
        $table->date('birthday');
        $table->string('contactno', 15);
        $table->string('address', 255);
        $table->string('email')->unique();
        $table->string('username', 55)->unique();
        $table->string('password');
        $table->string('profile_pic')->nullable();
        $table->rememberToken();
        $table->timestamps();
    });
}
    public function down(): void
    {
        Schema::dropIfExists('agents');
    }
};
