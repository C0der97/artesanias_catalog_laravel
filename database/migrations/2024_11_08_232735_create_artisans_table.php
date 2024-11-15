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
        Schema::create('artisans', function (Blueprint $table) {
            $table->id();
            $table->string('name', 100);
            $table->text('biography')->nullable();  // Agregado campo biography
            $table->string('phone')->nullable();
            $table->string('email')->nullable();
            $table->string('address')->nullable();
            $table->foreignId('municipality_id')
                  ->constrained('municipalities')
                  ->onDelete('cascade');
            $table->boolean('featured')->default(false);  // Agregado campo featured
            $table->enum('status', ['active', 'inactive'])->default('active');  // Agregado campo status
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('artisans');
    }
};