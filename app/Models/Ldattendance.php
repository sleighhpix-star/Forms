<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdAttendance extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ld_attendances';

    protected $fillable = [
        'attendee_name', 'campus', 'employment_status', 'college_office', 'position',
        'activity_types', 'activity_type_others',
        'natures', 'nature_others',
        'purpose', 'level',
        'activity_date', 'hours', 'venue', 'organizer',
        'financial_requested', 'amount_requested', 'coverage', 'coverage_others',
        'sig_requested_name',    'sig_requested_position',
        'sig_reviewed_name',     'sig_reviewed_position',
        'sig_recommending_name', 'sig_recommending_position',
        'sig_approved_name',     'sig_approved_position',
        'mov_original_name', 'mov_path', 'mov_size', 'mov_mime',
    ];

    protected $casts = [
        'activity_types'      => 'array',
        'natures'             => 'array',
        'coverage'            => 'array',
        'financial_requested' => 'boolean',
        'amount_requested'    => 'decimal:2',
    ];
}