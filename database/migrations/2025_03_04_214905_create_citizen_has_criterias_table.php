<?php

use App\Models\Citizen;
use App\Models\Criteria;
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
        Schema::create('citizen_has_criterias', function (Blueprint $table) {
            $table->string('citizen_code');
            $table->string('sub_criteria_code');

            $table->foreign('citizen_code')->references('code')->on('citizens')->cascadeOnDelete();
            $table->foreign('sub_criteria_code')->references('code')->on('sub_criterias')->cascadeOnDelete();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('citizen_has_criterias');
    }
};
