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
        Schema::create('citizens', function (Blueprint $table) {
            $table->string('code')->primary()->unique();
            $table->unsignedBigInteger('nik')->unique();
            $table->string('name');
            $table->unsignedInteger('rt');
            $table->unsignedInteger('rw');
            $table->string('province');
            $table->string('district');
            $table->string('subdistrict');
            $table->string('village');
            $table->string('address');
            $table->timestamps();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizens');
    }
};
