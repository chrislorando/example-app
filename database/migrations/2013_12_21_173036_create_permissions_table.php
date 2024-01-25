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
        Schema::create('permissions', function (Blueprint $table)  {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->string('guard_name', 50);
            $table->string('name')->comment('Fill with backend routes(controller/action) or with menu code from menus table for android');
            $table->string('controller')->nullable();
            $table->string('action')->nullable();
            $table->string('method')->nullable();
            $table->string('params')->nullable();
            $table->string('alias')->nullable();
            $table->string('class_path')->nullable();
            $table->text('description')->nullable()->comment('Custom content or get description from menus table for android');
            $table->tinyInteger('type')->default(0)->comment('0 = backend, 1 = android, 3 = gis');
            $table->timestamps();

        });

        Schema::create('roles', function (Blueprint $table) {
            $table->bigIncrements('id');
            $table->string('uuid')->unique();
            $table->string('name');
            $table->string('guard_name', 50);
            $table->string('redirect')->nullable();
            $table->string('description')->nullable();
            $table->integer('rating')->default(0);
            $table->tinyInteger('type')->default(0)->comment('0 = backend, 1 = android, 3 = gis');
            $table->tinyInteger('is_public')->default(0)->comment('0 = private, 1 = public');
            $table->tinyInteger('is_deleted')->default(0)->comment('0 = nonactive, 1 = active');
            $table->timestamps();
            $table->softDeletes();
        });

        Schema::create('role_permissions', function (Blueprint $table) {
            $table->unsignedBigInteger('permission_id');
            $table->unsignedBigInteger('role_id');
            $table->string('uuid')->unique();

            $table->foreign('permission_id')
                ->references('id')
                ->on('permissions')
                ->onDelete('cascade');

            $table->foreign('role_id')
                ->references('id')
                ->on('roles')
                ->onDelete('cascade');

            $table->primary(['permission_id', 'role_id'], 'role_permissions_permission_id_role_id_primary');
        });

    }

    /**
     * Reverse the migrations.
     */
    public function down(): void
    {
        Schema::dropIfExists('role_permissions');
        Schema::dropIfExists('roles');
        Schema::dropIfExists('permissions');
    }
};
