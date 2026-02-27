<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdPublication extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ld_publications';

    protected $fillable = [
        'faculty_name', 'campus', 'employment_status', 'college_office', 'position',
        'paper_title', 'co_authors',
        'journal_title', 'vol_issue', 'issn_isbn', 'publisher', 'editors',
        'website', 'email_address',
        'pub_scope', 'pub_format', 'nature',
        'amount_requested',
        'has_previous_claim', 'previous_claim_amount',
        'prev_paper_title', 'prev_co_authors',
        'prev_journal_title', 'prev_vol_issue', 'prev_issn_isbn',
        'prev_doi', 'prev_publisher', 'prev_editors', 'prev_pub_scope',
        'sig_requested_name',    'sig_requested_position',
        'sig_reviewed_name',     'sig_reviewed_position',
        'sig_recommending_name', 'sig_recommending_position',
        'sig_approved_name',     'sig_approved_position',
        'mov_original_name', 'mov_path', 'mov_size', 'mov_mime',
    ];

    protected $casts = [
        'amount_requested'      => 'decimal:2',
        'has_previous_claim'    => 'boolean',
        'previous_claim_amount' => 'decimal:2',
    ];
}