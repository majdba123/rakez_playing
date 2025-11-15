<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Check if the winners table exists and has the wrong column
        if (Schema::hasTable('winners')) {
            // Drop foreign key constraints if they exist
            Schema::table('winners', function (Blueprint $table) {
                // Check if the wrong column exists
                if (Schema::hasColumn('winners', 'projects_id')) {
                    // Drop the wrong column
                    $table->dropColumn('projects_id');
                }

                // Make sure project_id exists
                if (!Schema::hasColumn('winners', 'project_id')) {
                    $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
                }
            });
        } else {
            // Create the table if it doesn't exist
            Schema::create('winners', function (Blueprint $table) {
                $table->id();
                $table->string('phone')->index();
                $table->string('name')->nullable();
                $table->foreignId('project_id')->constrained('projects')->onDelete('cascade');
                $table->string('project_type');
                $table->timestamps();

                $table->index(['phone', 'project_type']);
                $table->unique(['phone', 'project_id']);
            });
        }
    }

    public function down(): void
    {
        // You can choose to keep the table or drop it
        // Schema::dropIfExists('winners');
    }
};
