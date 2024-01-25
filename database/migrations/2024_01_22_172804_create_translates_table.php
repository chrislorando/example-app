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
        Schema::create('translates', function (Blueprint $table) {
            $table->id();
            $table->uuid('uuid')->unique();
            $table->string('locale');
            $table->string('group');
            $table->string('parent')->nullable();
            $table->string('code');
            $table->string('value');
            $table->enum('is_deleted', [0, 1])->default(0)->comment('0 = nonactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('translates');
    }
};
