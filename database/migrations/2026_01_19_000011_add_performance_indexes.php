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
        Schema::table('transactions', function (Blueprint $table) {
            $table->index(['user_id', 'date']);
            $table->index(['user_id', 'type']);
            $table->index(['user_id', 'category_id']);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->index(['user_id', 'type']);
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->index(['user_id', 'end_date']);
        });

        Schema::table('goals', function (Blueprint $table) {
            $table->index(['user_id', 'deadline']);
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('transactions', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'date']);
            $table->dropIndex(['user_id', 'type']);
            $table->dropIndex(['user_id', 'category_id']);
        });

        Schema::table('accounts', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'type']);
        });

        Schema::table('budgets', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'end_date']);
        });

        Schema::table('goals', function (Blueprint $table) {
            $table->dropIndex(['user_id', 'deadline']);
        });
    }
};
