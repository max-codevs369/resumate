<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('cv_templates', function (Blueprint $table) {
            $table->id();
            $table->string('name'); 
            $table->string('slug')->unique(); 
            
            $table->string('thumbnail')->nullable(); 
            
            $table->text('description')->nullable(); 
            $table->string('category')->index(); 
            $table->json('tags')->nullable(); 
            
            $table->enum('type', ['free', 'pro'])->default('free'); 
            $table->unsignedBigInteger('price')->default(0);
            
            $table->json('layout_schema')->nullable(); 
            $table->json('global_settings')->nullable();
            
            $table->boolean('is_active')->default(true); 
            $table->boolean('is_new')->default(true);
            
            $table->unsignedInteger('total_downloads')->default(0); 
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('cv_templates');
    }
};