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
        Schema::create('themes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('company_id')->constrained()->onDelete('cascade');
            $table->string('name')->default('Default Theme');
            $table->string('description')->nullable();
            $table->string('primary_color')->default('#000000');
            $table->string('secondary_color')->default('#FFFFFF');
            $table->string('background_color')->default('#F0F0F0');
            $table->string('text_color')->default('#000000');
            $table->string('font_family')->default('Arial, sans-serif');
            $table->string('font_size')->default('16px');
            $table->string('logo_path')->nullable();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('themes');
    }
};
