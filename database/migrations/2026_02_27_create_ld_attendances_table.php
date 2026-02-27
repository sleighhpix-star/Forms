<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ld_attendances', function (Blueprint $table) {
            $table->id();
            // Attendee info
            $table->string('attendee_name');
            $table->string('campus');
            $table->string('employment_status')->nullable();
            $table->string('college_office');
            $table->string('position');
            // Activity
            $table->jsonb('activity_types')->nullable();
            $table->string('activity_type_others')->nullable();
            $table->jsonb('natures')->nullable();
            $table->string('nature_others')->nullable();
            $table->text('purpose');
            $table->string('level')->nullable();
            $table->string('activity_date')->nullable();
            $table->integer('hours')->nullable();
            $table->string('venue')->nullable();
            $table->string('organizer')->nullable();
            // Financial
            $table->boolean('financial_requested')->default(false);
            $table->decimal('amount_requested', 12, 2)->nullable();
            $table->jsonb('coverage')->nullable();
            $table->string('coverage_others')->nullable();
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
        Schema::dropIfExists('ld_attendances');
    }
};