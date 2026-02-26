<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;

class LdRequest extends Model
{
    use HasFactory, SoftDeletes;

    protected $table = 'ld_requests';

    protected $fillable = [
        'participant_name',
        'campus',
        'employment_status',
        'college_office',
        'position',
        'title',
        'types',
        'type_others',
        'level',
        'natures',
        'nature_others',
        'competency',
        'intervention_date',
        'hours',
        'venue',
        'organizer',
        'endorsed_by_org',
        'related_to_field',
        'has_pending_ldap',
        'has_cash_advance',
        'financial_requested',
        'amount_requested',
        'coverage',
        'coverage_others',
        'sig_requested_date',
        'sig_reviewed_date',
        'sig_recommending_date',
        'sig_approved_date',
        'mov_original_name',
        'mov_path',
        'mov_size',
        'mov_mime',
    ];

    protected $casts = [
        'types'              => 'array',
        'natures'            => 'array',
        'coverage'           => 'array',
        'endorsed_by_org'    => 'boolean',
        'related_to_field'   => 'boolean',
        'has_pending_ldap'   => 'boolean',
        'has_cash_advance'   => 'boolean',
        'financial_requested'=> 'boolean',
        'amount_requested'   => 'decimal:2',
        'sig_requested_date' => 'date',
        'sig_reviewed_date'  => 'date',
        'sig_recommending_date' => 'date',
        'sig_approved_date'  => 'date',
    ];

    // ── Scopes ────────────────────────────────────────────────────────────────

    public function scopeSearch($query, $term)
    {
        if (blank($term)) {
            return $query;
        }

        // PostgreSQL full-text search via the generated tsvector column.
        // plainto_tsquery handles multi-word phrases gracefully (no special chars needed).
        return $query->whereRaw(
            "fts_vector @@ plainto_tsquery('english', ?)",
            [$term]
        );
    }

    public function scopeOfType($query, $type)
    {
        // JSONB containment: types array must contain this value
        return $type
            ? $query->whereRaw('types @> ?::jsonb', [json_encode([$type])])
            : $query;
    }

    public function scopeOfLevel($query, $level)
    {
        return $level ? $query->where('level', $level) : $query;
    }

    public function scopeOfStatus($query, $status)
    {
        return $status ? $query->where('status', $status) : $query;
    }

    // ── Helpers ───────────────────────────────────────────────────────────────

    public function getTypesListAttribute(): string
    {
        $types = $this->types ?? [];
        if ($this->type_others) {
            $types[] = 'Others: ' . $this->type_others;
        }
        return implode(', ', $types);
    }

    public function getNaturesListAttribute(): string
    {
        $natures = $this->natures ?? [];
        if ($this->nature_others) {
            $natures[] = 'Others: ' . $this->nature_others;
        }
        return implode(', ', $natures);
    }

    public function getCoverageListAttribute(): string
    {
        $coverage = $this->coverage ?? [];
        if ($this->coverage_others) {
            $coverage[] = 'Others: ' . $this->coverage_others;
        }
        return implode(', ', $coverage);
    }

    public function getFormattedAmountAttribute(): string
    {
        return $this->amount_requested
            ? '₱ ' . number_format($this->amount_requested, 2)
            : '—';
    }
   
}
