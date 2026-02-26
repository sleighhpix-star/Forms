<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;
use Illuminate\Support\Facades\DB;

return new class extends Migration
{
    public function up(): void
    {
        Schema::create('ld_requests', function (Blueprint $table) {
            $table->id();                                    // BIGSERIAL PRIMARY KEY

            // ── Participant Information ──────────────────────────────────────
            $table->string('participant_name', 255);
            $table->string('campus', 255);
            $table->string('employment_status', 50);
            $table->string('college_office', 255);
            $table->string('position', 255);

            // ── Intervention Details ─────────────────────────────────────────
            $table->string('title', 500);
            $table->jsonb('types');                          // PostgreSQL JSONB (indexed)
            $table->string('type_others', 255)->nullable();
            $table->string('level', 20);                    // Local / Regional / National / International
            $table->jsonb('natures');                        // PostgreSQL JSONB
            $table->string('nature_others', 255)->nullable();
            $table->text('competency')->nullable();
            $table->string('intervention_date', 100);        // stored as text (e.g. "March 5–7, 2026")
            $table->smallInteger('hours')->unsigned()->nullable();
            $table->string('venue', 255);
            $table->string('organizer', 255);

            // ── Yes/No Questions ─────────────────────────────────────────────
            $table->boolean('endorsed_by_org')->default(false);
            $table->boolean('related_to_field')->default(false);
            $table->boolean('has_pending_ldap')->default(false);
            $table->boolean('has_cash_advance')->default(false);
            $table->boolean('financial_requested')->default(false);

            // ── Financial (nullable unless financial_requested = true) ────────
            $table->decimal('amount_requested', 12, 2)->nullable();
            $table->jsonb('coverage')->nullable();           // PostgreSQL JSONB
            $table->string('coverage_others', 255)->nullable();

            // ── Signatory Dates ──────────────────────────────────────────────
            $table->date('sig_requested_date')->nullable();
            $table->date('sig_reviewed_date')->nullable();
            $table->date('sig_recommending_date')->nullable();
            $table->date('sig_approved_date')->nullable();

            // ── Status ───────────────────────────────────────────────────────
            // status/remarks removed — single admin, no approval workflow needed

            $table->timestamps();                            // TIMESTAMP WITH TIME ZONE
            $table->softDeletes();                           // deleted_at
        });

        // ── PostgreSQL JSONB indexes (GIN — fast for @> containment queries) ──
        DB::statement('CREATE INDEX idx_ld_types    ON ld_requests USING GIN (types)');
        DB::statement('CREATE INDEX idx_ld_natures  ON ld_requests USING GIN (natures)');
        DB::statement('CREATE INDEX idx_ld_coverage ON ld_requests USING GIN (coverage)');

        // ── Regular B-tree indexes on filter columns ─────────────────────────
        // no status index needed
        DB::statement('CREATE INDEX idx_ld_level      ON ld_requests (level)');
        DB::statement('CREATE INDEX idx_ld_deleted_at ON ld_requests (deleted_at)');
        DB::statement('CREATE INDEX idx_ld_created_at ON ld_requests (created_at DESC)');

        // ── Generated tsvector column for full-text search ────────────────────
        DB::statement("
            ALTER TABLE ld_requests
            ADD COLUMN fts_vector tsvector
            GENERATED ALWAYS AS (
                to_tsvector('english',
                    coalesce(participant_name, '') || ' ' ||
                    coalesce(campus, '')           || ' ' ||
                    coalesce(title, '')            || ' ' ||
                    coalesce(college_office, '')   || ' ' ||
                    coalesce(organizer, '')        || ' ' ||
                    coalesce(venue, '')
                )
            ) STORED
        ");
        DB::statement('CREATE INDEX idx_ld_fts ON ld_requests USING GIN (fts_vector)');
    }

    public function down(): void
    {
        Schema::dropIfExists('ld_requests');
    }
};
