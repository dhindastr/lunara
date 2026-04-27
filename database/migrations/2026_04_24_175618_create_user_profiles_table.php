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
        Schema::create('user_profiles', function (Blueprint $table) {
    $table->id();
    $table->foreignId('user_id')->constrained()->onDelete('cascade');
    $table->integer('age')->nullable();
    $table->string('profile_photo')->nullable();
    $table->integer('average_cycle_length')->default(28);
    $table->integer('average_period_length')->default(5);
    $table->date('last_period_start')->nullable();
    $table->string('language')->default('id');
    $table->enum('theme_mode', ['light', 'dark', 'system'])->default('system');
    $table->boolean('notification_enabled')->default(true);
    $table->timestamps();
});
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('user_profiles');
    }
};
