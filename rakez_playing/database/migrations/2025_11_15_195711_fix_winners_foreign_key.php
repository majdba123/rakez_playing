<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Drop the old table if it exists with wrong schema
        Schema::dropIfExists('winners');

        // Recreate the table with correct schema
        Schema::create('winners', function (Blueprint $table) {
            $table->id();
            $table->string('phone')->index();
            $table->string('name')->nullable();
            $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
            $table->string('project_type');
            $table->timestamps();

            $table->index(['phone', 'project_type']);
            $table->unique(['phone', 'project_id']); // Prevent duplicate wins for same project
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('winners');
    }
};
