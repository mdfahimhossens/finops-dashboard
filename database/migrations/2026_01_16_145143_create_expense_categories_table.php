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
        Schema::create('expense_categories', function (Blueprint $table) {
            $table->bigIncrements('expencate_id');
            $table->string('expencate_name', 255)->unique();
            $table->string('expencate_remarks', 255)->nullable();
            $table->string('expencate_creator')->nullable();
            $table->string('expencate_editor')->nullable();
            $table->string('expencate_slug', 255)->nullable();
            $table->integer('expencate_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expense_categories');
    }
};
