<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('settings', function (Blueprint $table) {
            $table->string('key')->primary();
            $table->text('value')->nullable();
            $table->timestamps();
        });

        // Seed default signatory values
        $now = now();
        DB::table('settings')->insert([
            ['key' => 'sig_requested_name',        'value' => 'Dr. Bryan John A. Magoling',    'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_requested_position',    'value' => 'Director, Research Management Services', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_reviewed_name',         'value' => 'Engr. Albertson D. Amante',     'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_reviewed_position',     'value' => 'VP for Research, Development and Extension Services', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_recommending_name',     'value' => 'Atty. Noel Alberto S. Omandap', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_recommending_position', 'value' => 'VP for Administration and Finance', 'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_approved_name',         'value' => 'Dr. Tirso A. Ronquillo',        'created_at' => $now, 'updated_at' => $now],
            ['key' => 'sig_approved_position',     'value' => 'University President',           'created_at' => $now, 'updated_at' => $now],
        ]);
    }

    public function down(): void
    {
        Schema::dropIfExists('settings');
    }
};
