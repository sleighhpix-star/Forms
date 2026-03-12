{{-- resources/views/ld/publication/show-modal.blade.php --}}
<div class="card" style="box-shadow:none;border-radius:0 0 var(--radius-lg) var(--radius-lg);border:none;">

  <div style="background:linear-gradient(135deg,var(--crimson-deep) 0%,var(--crimson) 60%,var(--crimson-mid) 100%);padding:1.25rem 1.75rem 1.1rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold),var(--gold-light),transparent);opacity:.55;"></div>
    <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.88);margin-bottom:.55rem;">
      📰 Publication Incentive
    </div>
    <h2 style="font-family:var(--font-display);color:#fff;font-size:1.05rem;font-weight:600;line-height:1.3;margin-bottom:.35rem;">
      Request for Publication Incentive
    </h2>
    <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
      <span style="font-size:.7rem;color:rgba(255,255,255,.65);">
        🗓 Submitted <strong style="color:rgba(255,255,255,.88);">{{ optional($record->created_at)->format('F j, Y') }}</strong>
      </span>
      @if($record->tracking_number)
        <span style="font-size:.7rem;color:rgba(255,255,255,.65);">
          🔖 <strong style="color:rgba(255,255,255,.88);">{{ $record->tracking_number }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Faculty / Employee Information</div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Name</div>
        <div class="dval" style="font-weight:600;">{{ $record->faculty_name ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Position / Designation</div>
        <div class="dval">{{ $record->position ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Campus</div>
        <div class="dval">{{ $record->campus ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">College / Office</div>
        <div class="dval">{{ $record->college_office ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Employment Status</div>
        <div class="dval">{{ $record->employment_status ?? '—' }}</div>
      </div>
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Publication Details</div>

    <div class="detail-field mb-2" style="background:var(--ivory-warm);border:1px solid var(--gold-pale);border-radius:var(--radius-md);padding:.65rem .9rem;">
      <div class="dlabel">Title of Paper</div>
      <div class="dval" style="font-size:.95rem;font-weight:600;color:var(--crimson-deep);">{{ $record->paper_title ?? '—' }}</div>
    </div>

    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Co-author/s</div>
        <div class="dval">{{ $record->co_authors ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Journal Title</div>
        <div class="dval">{{ $record->journal_title ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Vol. / Issue / No.</div>
        <div class="dval">{{ $record->vol_issue ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">ISSN / ISBN</div>
        <div class="dval">{{ $record->issn_isbn ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Publisher</div>
        <div class="dval">{{ $record->publisher ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Editor/s</div>
        <div class="dval">{{ $record->editors ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Website</div>
        <div class="dval">{{ $record->website ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Email</div>
        <div class="dval">{{ $record->email_address ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Scope</div>
        <div class="dval">
          @if($record->pub_scope) <span class="badge badge-gold">{{ $record->pub_scope }}</span>
          @else <span class="text-muted text-sm">—</span> @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Format</div>
        <div class="dval">{{ $record->pub_format ?? '—' }}</div>
      </div>
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Nature</div>
        <div class="dval">{{ $record->nature ?? '—' }}</div>
      </div>
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Incentive</div>
    <div class="fin-box">
      <div class="detail-grid">
        <div class="detail-field">
          <div class="dlabel">Amount Requested</div>
          <div class="dval" style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--crimson);">
            @if($record->amount_requested) ₱ {{ number_format((float)$record->amount_requested, 2) }}
            @else <span class="text-muted">—</span> @endif
          </div>
        </div>
        <div class="detail-field">
          <div class="dlabel">Has Previous Claim?</div>
          <div class="dval">
            @if($record->has_previous_claim) <span class="badge badge-gold">Yes</span>
            @else <span class="text-muted text-sm">No</span> @endif
          </div>
        </div>
        @if($record->has_previous_claim)
          <div class="detail-field">
            <div class="dlabel">Previous Claim Amount</div>
            <div class="dval" style="font-weight:600;">
              @if($record->previous_claim_amount) ₱ {{ number_format((float)$record->previous_claim_amount, 2) }}
              @else — @endif
            </div>
          </div>
        @endif
      </div>
    </div>
  </div>

  @if($record->has_previous_claim)
  <div class="card-section">
    <div class="section-label">Previous Publication</div>
    <div class="detail-grid">
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Title</div>
        <div class="dval">{{ $record->prev_paper_title ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Co-authors</div>
        <div class="dval">{{ $record->prev_co_authors ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Journal</div>
        <div class="dval">{{ $record->prev_journal_title ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Vol. / Issue</div>
        <div class="dval">{{ $record->prev_vol_issue ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">ISSN / ISBN</div>
        <div class="dval">{{ $record->prev_issn_isbn ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">DOI</div>
        <div class="dval">{{ $record->prev_doi ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Publisher</div>
        <div class="dval">{{ $record->prev_publisher ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Editors</div>
        <div class="dval">{{ $record->prev_editors ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Scope</div>
        <div class="dval">
          @if($record->prev_pub_scope) <span class="badge badge-gold">{{ $record->prev_pub_scope }}</span>
          @else <span class="text-muted text-sm">—</span> @endif
        </div>
      </div>
    </div>
  </div>
  @endif

  <div class="card-section">
    <div class="section-label">Signatories</div>
    <div class="sig-grid">
      @foreach([
        ['role'=>'Requested by',          'name'=>$record->sig_requested_name,     'pos'=>$record->sig_requested_position],
        ['role'=>'Reviewed by',           'name'=>$record->sig_reviewed_name,      'pos'=>$record->sig_reviewed_position],
        ['role'=>'Recommending Approval', 'name'=>$record->sig_recommending_name,  'pos'=>$record->sig_recommending_position],
        ['role'=>'Approved by',           'name'=>$record->sig_approved_name,      'pos'=>$record->sig_approved_position],
      ] as $s)
        <div class="sig-box">
          <div class="sig-role">{{ $s['role'] }}</div>
          <div class="sig-name">{{ $s['name'] ?? '—' }}</div>
          <div class="sig-position">{{ $s['pos'] ?? '' }}</div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="form-actions">
    <button type="button" onclick="openFormModal('publication-edit','✏️ Edit Publication',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
    <button type="button" onclick="openPrintModal('{{ route('ld.publication.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  </div>
</div>