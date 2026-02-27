<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdReimbursement extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ld_reimbursements';

    protected $fillable = [
        'department',
        'activity_types', 'activity_type_others',
        'venue', 'activity_date',
        'reason', 'remarks',
        'expense_items',
        'sig_requested_name',    'sig_requested_position',
        'sig_reviewed_name',     'sig_reviewed_position',
        'sig_recommending_name', 'sig_recommending_position',
        'sig_approved_name',     'sig_approved_position',
        'mov_original_name', 'mov_path', 'mov_size', 'mov_mime',
    ];

    protected $casts = [
        'activity_types' => 'array',
        'expense_items'  => 'array',
    ];

    public function getTotalAmountAttribute(): float
    {
        return collect($this->expense_items ?? [])
            ->sum(fn($item) => (float) ($item['amount'] ?? 0));
    }
}