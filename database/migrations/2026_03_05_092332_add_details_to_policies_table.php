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
        Schema::table('policies', function (Blueprint $table) {
            $table->date('effective_date')->nullable()->after('title');
            $table->enum('status', ['berlaku', 'tidak_berlaku'])->default('berlaku')->after('effective_date');
            $table->enum('category', ['cs', 'teller', 'back', 'front'])->default('back')->after('status');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('policies', function (Blueprint $table) {
            $table->dropColumn(['effective_date', 'status', 'category']);
        });
    }
};
