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
        Schema::create('expenses', function (Blueprint $table) {
        $table->bigIncrements('expense_id');
        $table->string('expense_name', 255)->nullable();   // খরচের নাম (Rent, Internet)
        $table->integer('expencate_id')->nullable();         // Expense category
        $table->string('expense_amount', 255)->nullable(); // কত টাকা খরচ
        $table->date('expense_date')->nullable();          // খরচের তারিখ
        $table->text('expense_note')->nullable();          // Optional note
        $table->integer('expense_creator')->nullable();
        $table->string('expense_slug', 255)->nullable();
        $table->integer('expense_editor')->nullable();
        $table->integer('expense_status')->default(1);
        $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('expenses');
    }
};
