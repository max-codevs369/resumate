<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('resumes', function (Blueprint $table) {
            $table->id();
            $table->foreignId('user_id')->nullable()->constrained('users')->cascadeOnDelete();
            $table->foreignId('cv_template_id')->constrained('cv_templates')->cascadeOnDelete();
            
            $table->string('title')->nullable(); 
            
            $table->json('layout_schema')->nullable(); 
            $table->json('global_settings')->nullable(); 
            
            $table->string('photo')->nullable(); 

            $table->enum('status', ['draft', 'completed'])->default('draft');
            $table->integer('downloads')->default(0);
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('resumes');
    }
};