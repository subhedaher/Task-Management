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
        Schema::create('projects', function (Blueprint $table) {
            $table->id();
            $table->string('name');
            $table->text('description');
            $table->enum('status', ['pending', 'processing', 'completed', 'cancled', 'overdue'])->default('pending');
            $table->enum('priority', ['low', 'medium', 'high']);
            $table->date('start_date');
            $table->date('end_date');
            $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('projects');
    }
};
