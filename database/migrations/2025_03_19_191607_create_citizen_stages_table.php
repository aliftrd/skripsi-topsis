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
        Schema::create('citizen_stages', function (Blueprint $table) {
            $table->id();
            $table->string('citizen_code');
            $table->unsignedBigInteger('stage');
            $table->unsignedBigInteger('year');

            $table->foreign('citizen_code')->references('code')->on('citizens')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_stages');
    }
};
