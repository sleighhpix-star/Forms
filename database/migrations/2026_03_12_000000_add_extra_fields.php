<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::table('ld_publications', function (Blueprint $table) {
            $table->string('prev_pub_format')->nullable()->after('prev_pub_scope');
            $table->string('prev_website')->nullable()->after('prev_pub_format');
            $table->string('prev_email_address')->nullable()->after('prev_website');
        });
    }

    public function down(): void
    {
        Schema::table('ld_publications', function (Blueprint $table) {
            $table->dropColumn(['prev_pub_format', 'prev_website', 'prev_email_address']);
        });
    }
};