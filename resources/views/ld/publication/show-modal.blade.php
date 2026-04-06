{{-- publication/show-modal.blade.php --}}

{{-- Hero --}}
<div style="background:var(--c-dk);padding:1.1rem 1.75rem 1rem;position:relative;flex-shrink:0">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.6"></div>
  <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.9);margin-bottom:.5rem;font-size:.64rem">📰 Publication Incentive</div>
  <h2 style="font-family:var(--f-display);color:#fff;font-size:1rem;font-weight:400;line-height:1.3">Request for Publication Incentive</h2>
  <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.3rem">
    <span style="font-size:.7rem;color:rgba(255,255,255,.6)">🗓 <strong style="color:rgba(255,255,255,.85)">{{ optional($record->created_at)->format('F j, Y') }}</strong></span>
    @if($record->tracking_number)<span style="font-size:.7rem;color:rgba(255,255,255,.6)">🔖 <strong style="color:rgba(255,255,255,.85)">{{ $record->tracking_number }}</strong></span>@endif
  </div>
</div>

{{-- Scrollable body --}}
<div style="overflow-y:auto;max-height:65vh">

  <div class="card-section">
    <div class="section-label">Faculty / Employee Information</div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Name</div><div class="dval" style="font-weight:600">{{ $record->faculty_name ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Position</div><div class="dval">{{ $record->position ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Campus</div><div class="dval">{{ $record->campus ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">College / Office</div><div class="dval">{{ $record->college_office ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Employment Status</div><div class="dval">{{ $record->employment_status ?? '—' }}</div></div>
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Publication Details</div>
    <div class="detail-field mb-2"><div class="dlabel">Title of Paper</div><div class="dval" style="font-weight:600;font-size:.95rem">{{ $record->paper_title ?? '—' }}</div></div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Co-author/s</div><div class="dval">{{ $record->co_authors ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Journal Title</div><div class="dval">{{ $record->journal_title ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Vol. / Issue / No.</div><div class="dval">{{ $record->vol_issue ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">ISSN / ISBN</div><div class="dval">{{ $record->issn_isbn ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Publisher</div><div class="dval">{{ $record->publisher ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Editor/s</div><div class="dval">{{ $record->editors ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Scope</div><div class="dval">@if($record->pub_scope)<span class="badge badge-gold">{{ $record->pub_scope }}</span>@else —@endif</div></div>
      <div class="detail-field"><div class="dlabel">Format</div><div class="dval">{{ $record->pub_format ?? '—' }}</div></div>
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Nature</div><div class="dval">{{ $record->nature ?? '—' }}</div></div>
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Incentive</div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Amount Requested</div><div class="dval" style="font-weight:600;color:var(--c);font-size:1rem">@if($record->amount_requested)₱{{ number_format((float)$record->amount_requested, 2) }}@else —@endif</div></div>
      <div class="detail-field"><div class="dlabel">Has Previous Claim?</div><div class="dval"><span class="badge {{ $record->has_previous_claim ? 'badge-amber' : 'badge-neutral' }}">{{ $record->has_previous_claim ? 'Yes' : 'No' }}</span></div></div>
      @if($record->has_previous_claim && $record->previous_claim_amount)
        <div class="detail-field"><div class="dlabel">Previous Claim Amount</div><div class="dval" style="font-weight:600">₱{{ number_format((float)$record->previous_claim_amount, 2) }}</div></div>
      @endif
    </div>
  </div>

  @if($record->has_previous_claim)
  <div class="card-section">
    <div class="section-label">Previous Publication</div>
    <div class="detail-grid">
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Title</div><div class="dval">{{ $record->prev_paper_title ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Co-authors</div><div class="dval">{{ $record->prev_co_authors ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Journal</div><div class="dval">{{ $record->prev_journal_title ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">ISSN / ISBN</div><div class="dval">{{ $record->prev_issn_isbn ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Scope</div><div class="dval">@if($record->prev_pub_scope)<span class="badge badge-gold">{{ $record->prev_pub_scope }}</span>@else —@endif</div></div>
    </div>
  </div>
  @endif

  <div class="card-section">
    <div class="section-label">Signatories</div>
    <div class="sig-grid" style="pointer-events:none">
      @foreach([['role'=>'Requested by','name'=>$record->sig_requested_name,'pos'=>$record->sig_requested_position],['role'=>'Reviewed by','name'=>$record->sig_reviewed_name,'pos'=>$record->sig_reviewed_position],['role'=>'Recommending Approval','name'=>$record->sig_recommending_name,'pos'=>$record->sig_recommending_position],['role'=>'Approved by','name'=>$record->sig_approved_name,'pos'=>$record->sig_approved_position]] as $s)
        <div class="sig-box"><div class="sig-role">{{ $s['role'] }}</div><div style="font-size:.85rem;font-weight:600;color:var(--c)">{{ $s['name'] ?? '—' }}</div><div style="font-size:.72rem;color:var(--ink-3)">{{ $s['pos'] ?? '' }}</div></div>
      @endforeach
    </div>
  </div>

</div>

{{-- Footer --}}
<div style="padding:12px 20px;background:var(--bg);border-top:1px solid var(--border-sm);display:flex;justify-content:flex-end;gap:8px;flex-shrink:0">
  <button type="button" onclick="openFormModal('publication-edit','✏️ Edit Publication',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
  <button type="button" onclick="openPrintModal('{{ route('ld.publication.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>