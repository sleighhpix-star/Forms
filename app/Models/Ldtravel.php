<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdTravel extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ld_travels';

    protected $fillable = [
        'employee_names', 'positions',
        'travel_dates', 'travel_time',
        'places_visited', 'purpose',
        'chargeable_against',
        'sig_requested_name',    'sig_requested_position',
        'sig_reviewed_name',     'sig_reviewed_position',
        'sig_recommending_name', 'sig_recommending_position',
        'sig_approved_name',     'sig_approved_position',
        'mov_original_name', 'mov_path', 'mov_size', 'mov_mime',
    ];
}