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
        Schema::table('citizen_stages', function (Blueprint $table) {
            $table->unsignedBigInteger('stage')->nullable()->change();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::table('citizen_stages', function (Blueprint $table) {
            $table->unsignedBigInteger('stage')->nullable(false)->change();
        });
    }
};
