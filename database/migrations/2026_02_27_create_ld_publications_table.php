<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ld_publications', function (Blueprint $table) {
            $table->id();
            // Researcher info
            $table->string('faculty_name');
            $table->string('campus');
            $table->string('employment_status')->nullable();
            $table->string('college_office');
            $table->string('position');
            // Paper details
            $table->string('paper_title');
            $table->string('co_authors')->nullable();
            $table->string('journal_title');
            $table->string('vol_issue')->nullable();
            $table->string('issn_isbn')->nullable();
            $table->string('publisher')->nullable();
            $table->string('editors')->nullable();
            $table->string('website')->nullable();
            $table->string('email_address')->nullable();
            $table->string('pub_scope');
            $table->string('pub_format')->nullable();
            $table->string('nature');
            // Incentive
            $table->decimal('amount_requested', 12, 2)->nullable();
            $table->boolean('has_previous_claim')->default(false);
            $table->decimal('previous_claim_amount', 12, 2)->nullable();
            // Previous paper
            $table->string('prev_paper_title')->nullable();
            $table->string('prev_co_authors')->nullable();
            $table->string('prev_journal_title')->nullable();
            $table->string('prev_vol_issue')->nullable();
            $table->string('prev_issn_isbn')->nullable();
            $table->string('prev_doi')->nullable();
            $table->string('prev_publisher')->nullable();
            $table->string('prev_editors')->nullable();
            $table->string('prev_pub_scope')->nullable();
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
        Schema::dropIfExists('ld_publications');
    }
};