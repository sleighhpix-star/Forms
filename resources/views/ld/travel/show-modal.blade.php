{{-- resources/views/ld/travel/show-modal.blade.php --}}
<div class="card" style="box-shadow:none;border-radius:0 0 var(--radius-lg) var(--radius-lg);border:none;">

  <div style="background:linear-gradient(135deg,var(--crimson-deep) 0%,var(--crimson) 60%,var(--crimson-mid) 100%);padding:1.25rem 1.75rem 1.1rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold),var(--gold-light),transparent);opacity:.55;"></div>
    <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.88);margin-bottom:.55rem;">
      ✈️ Authority to Travel
    </div>
    <h2 style="font-family:var(--font-display);color:#fff;font-size:1.05rem;font-weight:600;line-height:1.3;margin-bottom:.35rem;">
      Authority to Travel
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
    <div class="section-label">Travel Details</div>

    <div class="detail-field mb-2" style="background:var(--ivory-warm);border:1px solid var(--gold-pale);border-radius:var(--radius-md);padding:.65rem .9rem;">
      <div class="dlabel">Purpose of Travel</div>
      <div class="dval" style="font-size:.95rem;font-weight:600;color:var(--crimson-deep);">{{ $record->purpose ?? '—' }}</div>
    </div>

    <div class="detail-grid">
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Employee Name/s</div>
        <div class="dval" style="font-weight:600;white-space:pre-line;">{{ $record->employee_names ?? '—' }}</div>
      </div>
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Position/s</div>
        <div class="dval" style="white-space:pre-line;">{{ $record->positions ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Date/s of Travel</div>
        <div class="dval">{{ $record->travel_dates ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Time</div>
        <div class="dval">{{ $record->travel_time ?? '—' }}</div>
      </div>
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Place/s to be Visited</div>
        <div class="dval">{{ $record->places_visited ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Chargeable Against</div>
        <div class="dval">{{ $record->chargeable_against ?? '—' }}</div>
      </div>
    </div>
  </div>

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
    <button type="button" onclick="openFormModal('travel-edit','✏️ Edit Travel Authority',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
    <button type="button" onclick="openPrintModal('{{ route('ld.travel.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  </div>
</div>