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
        Schema::create('pks', function (Blueprint $table) {
            $table->id();
            $table->string('title');
            $table->date('effective_date')->nullable();
            $table->enum('status', ['berlaku', 'tidak_berlaku'])->default('berlaku');
            $table->enum('category', ['pks'])->default('pks');
            $table->string('file_path')->nullable();
            $table->integer('views_count')->default(0);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('pks');
    }
};
