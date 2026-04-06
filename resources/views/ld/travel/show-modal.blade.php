{{-- travel/show-modal.blade.php --}}

{{-- Hero --}}
<div style="background:var(--c-dk);padding:1.1rem 1.75rem 1rem;position:relative;flex-shrink:0">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.6"></div>
  <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.9);margin-bottom:.5rem;font-size:.64rem">✈️ Authority to Travel</div>
  <h2 style="font-family:var(--f-display);color:#fff;font-size:1rem;font-weight:400;line-height:1.3">Authority to Travel</h2>
  <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.3rem">
    <span style="font-size:.7rem;color:rgba(255,255,255,.6)">🗓 <strong style="color:rgba(255,255,255,.85)">{{ optional($record->created_at)->format('F j, Y') }}</strong></span>
    @if($record->tracking_number)<span style="font-size:.7rem;color:rgba(255,255,255,.6)">🔖 <strong style="color:rgba(255,255,255,.85)">{{ $record->tracking_number }}</strong></span>@endif
  </div>
</div>

{{-- Scrollable body --}}
<div style="overflow-y:auto;max-height:65vh">

  <div class="card-section">
    <div class="section-label">Travel Details</div>
    <div class="detail-field mb-2">
      <div class="dlabel">Purpose of Travel</div>
      <div class="dval" style="font-weight:600;font-size:.95rem">{{ $record->purpose ?? '—' }}</div>
    </div>
    <div class="detail-grid">
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Employee Name/s</div><div class="dval" style="font-weight:600;white-space:pre-line">{{ $record->employee_names ?? '—' }}</div></div>
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Position/s</div><div class="dval" style="white-space:pre-line">{{ $record->positions ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Date/s of Travel</div><div class="dval">{{ $record->travel_dates ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Time</div><div class="dval">{{ $record->travel_time ?? '—' }}</div></div>
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Place/s to be Visited</div><div class="dval">{{ $record->places_visited ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Chargeable Against</div><div class="dval">{{ $record->chargeable_against ?? '—' }}</div></div>
    </div>
  </div>

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
  <button type="button" onclick="openFormModal('travel-edit','✏️ Edit Travel',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
  <button type="button" onclick="openPrintModal('{{ route('ld.travel.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>