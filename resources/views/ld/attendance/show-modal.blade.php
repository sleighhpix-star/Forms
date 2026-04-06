{{-- attendance/show-modal.blade.php --}}
@php
  $actTypes = is_array($record->activity_types ?? null) ? $record->activity_types : (json_decode($record->activity_types ?? '[]', true) ?: []);
  $natures  = is_array($record->natures  ?? null) ? $record->natures  : (json_decode($record->natures  ?? '[]', true) ?: []);
  $covSel   = is_array($record->coverage ?? null) ? $record->coverage : (json_decode($record->coverage ?? '[]', true) ?: []);
  $covMap   = ['registration'=>'Registration','accommodation'=>'Accommodation','materials'=>'Materials / Kit','speaker_fee'=>"Speaker's Fee",'meals'=>'Meals / Snacks','transportation'=>'Transportation'];
@endphp

{{-- Hero --}}
<div style="background:var(--c-dk);padding:1.1rem 1.75rem 1rem;position:relative;flex-shrink:0">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.6"></div>
  <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.9);margin-bottom:.5rem;font-size:.64rem">📅 Attendance Request</div>
  <h2 style="font-family:var(--f-display);color:#fff;font-size:1rem;font-weight:400;line-height:1.3">Request to Attend Official Activity</h2>
  <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.3rem">
    <span style="font-size:.7rem;color:rgba(255,255,255,.6)">🗓 <strong style="color:rgba(255,255,255,.85)">{{ optional($record->created_at)->format('F j, Y') }}</strong></span>
    @if($record->tracking_number)<span style="font-size:.7rem;color:rgba(255,255,255,.6)">🔖 <strong style="color:rgba(255,255,255,.85)">{{ $record->tracking_number }}</strong></span>@endif
  </div>
</div>

{{-- Scrollable body --}}
<div style="overflow-y:auto;max-height:65vh">

  <div class="card-section">
    <div class="section-label">Attendee Information</div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Name</div><div class="dval" style="font-weight:600">{{ $record->attendee_name ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Position / Designation</div><div class="dval">{{ $record->position ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Campus</div><div class="dval">{{ $record->campus ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">College / Office</div><div class="dval">{{ $record->college_office ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Employment Status</div><div class="dval">{{ $record->employment_status ?? '—' }}</div></div>
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Activity Details</div>
    <div class="detail-field mb-2">
      <div class="dlabel">Purpose / Title</div>
      <div class="dval" style="font-weight:600;font-size:.95rem">{{ $record->purpose ?? '—' }}</div>
    </div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Type of Activity</div>
        <div class="dval">
          @forelse($actTypes as $t)<span class="badge badge-crimson" style="font-size:.65rem">{{ $t }}</span> @empty <span class="text-muted text-sm">—</span> @endforelse
          @if(!empty($record->activity_type_others))<span class="badge badge-neutral" style="font-size:.65rem">{{ $record->activity_type_others }}</span>@endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Nature</div>
        <div class="dval">
          @forelse($natures as $n)<span class="badge badge-neutral" style="font-size:.65rem">{{ $n }}</span> @empty <span class="text-muted text-sm">—</span> @endforelse
        </div>
      </div>
      <div class="detail-field"><div class="dlabel">Level</div><div class="dval">@if($record->level)<span class="badge badge-gold">{{ $record->level }}</span>@else —@endif</div></div>
      <div class="detail-field"><div class="dlabel">Date</div><div class="dval">{{ $record->activity_date ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">No. of Hours</div><div class="dval">{{ $record->hours ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Venue</div><div class="dval">{{ $record->venue ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Organizer / Sponsor</div><div class="dval">{{ $record->organizer ?? '—' }}</div></div>
    </div>
  </div>

  @if($record->financial_requested)
  <div class="card-section">
    <div class="section-label">Financial Assistance</div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Amount Requested</div><div class="dval" style="font-weight:600;color:var(--c)">₱{{ number_format((float)($record->amount_requested ?? 0), 2) }}</div></div>
      @if(count($covSel))
      <div class="detail-field">
        <div class="dlabel">Coverage</div>
        <div class="dval">@foreach($covSel as $c)<span class="badge badge-gold" style="font-size:.65rem">{{ $covMap[$c] ?? $c }}</span> @endforeach</div>
      </div>
      @endif
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
  <button type="button" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
  <button type="button" onclick="openPrintModal('{{ route('ld.attendance.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>