<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ld_travels', function (Blueprint $table) {
            $table->id();
            $table->text('employee_names');
            $table->text('positions')->nullable();
            $table->string('travel_dates');
            $table->string('travel_time')->nullable();
            $table->string('places_visited');
            $table->text('purpose');
            $table->string('chargeable_against')->nullable();
            // Signatories
            $table->string('sig_requested_name')->nullable();
            $table->string('sig_requested_position')->nullable();
            $table->string('sig_reviewed_name')->nullable();
            $table->string('sig_reviewed_position')->nullable();
            $table->string('sig_recommending_name')->nullable();
            $table->string('sig_recommending_position')->nullable();
            $table->string('sig_approved_name')->nullable();
            $table->string('sig_approved_position')->nullable();
            // MOV
            $table->string('mov_original_name')->nullable();
            $table->string('mov_path')->nullable();
            $table->unsignedBigInteger('mov_size')->nullable();
            $table->string('mov_mime')->nullable();

            $table->softDeletes();
            $table->timestamps();
        });
    }

    public function down(): void
    {
        Schema::dropIfExists('ld_travels');
    }
};