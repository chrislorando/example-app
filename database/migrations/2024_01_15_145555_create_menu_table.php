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
        Schema::create('menus', function (Blueprint $table) {
            $table->id();
            $table->unsignedBigInteger('parent_id')->nullable();
            $table->uuid('uuid')->unique();
            $table->integer('sequence');
            $table->string('code')->nullable();
            $table->string('name')->nullable();
            $table->string('translate')->nullable();
            $table->string('description')->nullable();
            $table->string('icon')->nullable();
            $table->string('url')->nullable()->comment('get from permissions');
            $table->enum('position', ['0', '1'])->default('1')->comment('0 = header, 1 = sidebar');
            $table->enum('is_deleted', ['0', '1'])->default('0')->comment('0 = nonactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();

            $table->foreign('parent_id')
            ->references('id')
            ->on('menus')
            ->onUpdate('CASCADE')
            ->onDelete('RESTRICT');
        });
    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('menu');
    }
};
