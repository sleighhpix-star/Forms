<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ld_requests', function (Blueprint $table) {
            $table->string('tracking_number', 100)->nullable()->after('id');
        });

        Schema::table('ld_attendances', function (Blueprint $table) {
            $table->string('tracking_number', 100)->nullable()->after('id');
        });

        Schema::table('ld_publications', function (Blueprint $table) {
            $table->string('tracking_number', 100)->nullable()->after('id');
        });

        Schema::table('ld_reimbursements', function (Blueprint $table) {
            $table->string('tracking_number', 100)->nullable()->after('id');
        });

        Schema::table('ld_travels', function (Blueprint $table) {
            $table->string('tracking_number', 100)->nullable()->after('id');
        });
    }

    public function down(): void
    {
        Schema::table('ld_requests', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
        Schema::table('ld_attendances', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
        Schema::table('ld_publications', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
        Schema::table('ld_reimbursements', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
        Schema::table('ld_travels', function (Blueprint $table) {
            $table->dropColumn('tracking_number');
        });
    }
};
