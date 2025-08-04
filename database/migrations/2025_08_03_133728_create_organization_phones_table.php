<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('organization_phones', function (Blueprint $table) {
            $table->id();
            $table->string('phone');
            $table->foreignId('organization_id')->constrained('organizations');
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('organization_phones');
    }
};
