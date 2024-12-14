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
        Schema::create('task_activities', function (Blueprint $table) {
            $table->id();
            $table->foreignId('task_id')->constrained()->cascadeOnDelete()->cascadeOnUpdate();
            $table->foreignId('member_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->foreignId('admin_id')->nullable()->constrained()->nullOnDelete()->cascadeOnUpdate();
            $table->enum('type', ['created', 'updated', 'commented', 'status changed']);
            $table->text('description');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('task_activities');
    }
};
