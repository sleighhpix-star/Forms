<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration
{
    public function up(): void
    {
        Schema::table('ld_requests', function (Blueprint $table) {
            $table->string('sig_requested_name')->nullable()->after('sig_requested_date');
            $table->string('sig_requested_position')->nullable()->after('sig_requested_name');

            $table->string('sig_reviewed_name')->nullable()->after('sig_reviewed_date');
            $table->string('sig_reviewed_position')->nullable()->after('sig_reviewed_name');

            $table->string('sig_recommending_name')->nullable()->after('sig_recommending_date');
            $table->string('sig_recommending_position')->nullable()->after('sig_recommending_name');

            $table->string('sig_approved_name')->nullable()->after('sig_approved_date');
            $table->string('sig_approved_position')->nullable()->after('sig_approved_name');
        });
    }

    public function down(): void
    {
        Schema::table('ld_requests', function (Blueprint $table) {
            $table->dropColumn([
                'sig_requested_name',    'sig_requested_position',
                'sig_reviewed_name',     'sig_reviewed_position',
                'sig_recommending_name', 'sig_recommending_position',
                'sig_approved_name',     'sig_approved_position',
            ]);
        });
    }
};