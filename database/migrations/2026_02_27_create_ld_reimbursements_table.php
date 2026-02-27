<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

return new class extends Migration {
    public function up(): void
    {
        Schema::create('ld_reimbursements', function (Blueprint $table) {
            $table->id();
            $table->string('department');
            $table->jsonb('activity_types')->nullable();
            $table->string('activity_type_others')->nullable();
            $table->string('venue')->nullable();
            $table->string('activity_date')->nullable();
            $table->text('reason')->nullable();
            $table->text('remarks')->nullable();
            // Expense items stored as JSON array:
            // [{ payee, description, quantity, unit_cost, amount }, ...]
            $table->jsonb('expense_items')->nullable();
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
        Schema::dropIfExists('ld_reimbursements');
    }
};