<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        // Add each column only if it does not exist (prevents duplicate column error)
        Schema::table('ld_requests', function (Blueprint $table) {

            if (!Schema::hasColumn('ld_requests', 'mov_original_name')) {
                $table->string('mov_original_name')->nullable();
            }

            if (!Schema::hasColumn('ld_requests', 'mov_path')) {
                $table->string('mov_path')->nullable();
            }

            if (!Schema::hasColumn('ld_requests', 'mov_size')) {
                $table->unsignedBigInteger('mov_size')->nullable();
            }

            if (!Schema::hasColumn('ld_requests', 'mov_mime')) {
                $table->string('mov_mime')->nullable();
            }
        });
    }

    public function down(): void
    {
        Schema::table('ld_requests', function (Blueprint $table) {

            if (Schema::hasColumn('ld_requests', 'mov_mime')) {
                $table->dropColumn('mov_mime');
            }

            if (Schema::hasColumn('ld_requests', 'mov_size')) {
                $table->dropColumn('mov_size');
            }

            if (Schema::hasColumn('ld_requests', 'mov_path')) {
                $table->dropColumn('mov_path');
            }

            if (Schema::hasColumn('ld_requests', 'mov_original_name')) {
                $table->dropColumn('mov_original_name');
            }
        });
    }
};