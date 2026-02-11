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
        Schema::create('income_categories', function (Blueprint $table) {
            $table->bigIncrements('incate_id');
            $table->string('incate_name', 255)->unique();
            $table->string('incate_remarks', 255)->nullable();
            $table->string('incate_creator')->nullable();
            $table->string('incate_editor')->nullable();
            $table->string('incate_slug', 255)->nullable();
            $table->integer('incate_status')->default(1);
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('income_categories');
    }
};
