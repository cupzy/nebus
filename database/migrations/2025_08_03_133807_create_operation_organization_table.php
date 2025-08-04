<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('operation_organization', function (Blueprint $table) {
            $table->foreignId('organization_id')->constrained('organizations')->cascadeOnDelete();
            $table->foreignId('operation_id')->constrained('operations')->cascadeOnDelete();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('operation_organization');
    }
};
