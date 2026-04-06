{{-- show-modal.blade.php — Participation detail inside a modal --}}
@php
  $types   = is_array($record->types   ?? null) ? $record->types   : (json_decode($record->types   ?? '[]', true) ?: []);
  $natures = is_array($record->natures ?? null) ? $record->natures : (json_decode($record->natures ?? '[]', true) ?: []);
  $covSel  = is_array($record->coverage ?? null) ? $record->coverage : (json_decode($record->coverage ?? '[]', true) ?: []);
  $covMap  = [
    'registration'  => 'Registration',   'accommodation' => 'Accommodation',
    'materials'     => 'Materials / Kit', 'speaker_fee'   => "Speaker's Fee",
    'meals'         => 'Meals / Snacks',  'transportation' => 'Transportation',
  ];
@endphp

{{-- Hero header --}}
<div style="background:var(--c-dk);padding:1.1rem 1.75rem 1rem;position:relative;flex-shrink:0">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.55"></div>
  <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.88);margin-bottom:.5rem;font-size:.64rem">
    📋 Participation &middot; BatStateU-FO-HRD-28
  </div>
  <h2 style="font-family:var(--f-display);color:#fff;font-size:1rem;font-weight:400;line-height:1.3">
    Request for Participation in External L&amp;D Interventions
  </h2>
  <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.3rem">
    <span style="font-size:.7rem;color:rgba(255,255,255,.6)">🗓 <strong style="color:rgba(255,255,255,.85)">{{ optional($record->created_at)->format('F j, Y') }}</strong></span>
    @if($record->tracking_number)
      <span style="font-size:.7rem;color:rgba(255,255,255,.6)">🔖 <strong style="color:rgba(255,255,255,.85)">{{ $record->tracking_number }}</strong></span>
    @endif
  </div>
</div>

{{-- Scrollable body --}}
<div style="overflow-y:auto;max-height:65vh">

  {{-- Participant Info --}}
  <div class="card-section">
    <div class="section-label">Participant Information</div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Name</div><div class="dval" style="font-weight:600">{{ $record->participant_name ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Position</div><div class="dval">{{ $record->position ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Campus</div><div class="dval">{{ $record->campus ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">College / Office</div><div class="dval">{{ $record->college_office ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Employment Status</div><div class="dval">{{ $record->employment_status ?? '—' }}</div></div>
    </div>
  </div>

  {{-- Intervention Details --}}
  <div class="card-section">
    <div class="section-label">Intervention Details</div>
    <div class="detail-field mb-2">
      <div class="dlabel">Title</div>
      <div class="dval" style="font-weight:600">{{ $record->title ?? '—' }}</div>
    </div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Type</div>
        <div class="dval">
          @foreach($types as $t)<span class="badge badge-crimson" style="font-size:.65rem">{{ $t }}</span> @endforeach
          @if($record->type_others)<span class="badge badge-neutral" style="font-size:.65rem">{{ $record->type_others }}</span>@endif
        </div>
      </div>
      <div class="detail-field"><div class="dlabel">Level</div><div class="dval"><span class="badge badge-gold">{{ $record->level ?? '—' }}</span></div></div>
      <div class="detail-field">
        <div class="dlabel">Nature</div>
        <div class="dval">@foreach($natures as $n)<span class="badge badge-neutral" style="font-size:.65rem">{{ $n }}</span> @endforeach</div>
      </div>
      <div class="detail-field"><div class="dlabel">Date</div><div class="dval">{{ $record->intervention_date ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Hours</div><div class="dval">{{ $record->hours ? $record->hours.' hrs' : '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Venue</div><div class="dval">{{ $record->venue ?? '—' }}</div></div>
      <div class="detail-field"><div class="dlabel">Organizer</div><div class="dval">{{ $record->organizer ?? '—' }}</div></div>
      @if($record->competency)
        <div class="detail-field" style="grid-column:span 2">
          <div class="dlabel">Competencies</div>
          <div class="dval">{{ $record->competency }}</div>
        </div>
      @endif
    </div>
  </div>

  {{-- Assessment --}}
  <div class="card-section">
    <div class="section-label">Assessment</div>
    <div class="detail-grid">
      <div class="detail-field"><div class="dlabel">Endorsed by org?</div><div class="dval"><span class="badge {{ $record->endorsed_by_org ? 'badge-green' : 'badge-neutral' }}">{{ $record->endorsed_by_org ? 'Yes' : 'No' }}</span></div></div>
      <div class="detail-field"><div class="dlabel">Related to field?</div><div class="dval"><span class="badge {{ $record->related_to_field ? 'badge-green' : 'badge-neutral' }}">{{ $record->related_to_field ? 'Yes' : 'No' }}</span></div></div>
      <div class="detail-field"><div class="dlabel">Pending LDAP?</div><div class="dval"><span class="badge {{ $record->has_pending_ldap ? 'badge-amber' : 'badge-neutral' }}">{{ $record->has_pending_ldap ? 'Yes' : 'No' }}</span></div></div>
      <div class="detail-field"><div class="dlabel">Cash advance?</div><div class="dval"><span class="badge {{ $record->has_cash_advance ? 'badge-amber' : 'badge-neutral' }}">{{ $record->has_cash_advance ? 'Yes' : 'No' }}</span></div></div>
      <div class="detail-field"><div class="dlabel">Financial requested?</div><div class="dval"><span class="badge {{ $record->financial_requested ? 'badge-green' : 'badge-neutral' }}">{{ $record->financial_requested ? 'Yes' : 'No' }}</span></div></div>
      @if($record->financial_requested)
        <div class="detail-field"><div class="dlabel">Amount</div><div class="dval" style="font-weight:600;color:var(--c)">₱{{ number_format($record->amount_requested ?? 0, 2) }}</div></div>
      @endif
    </div>
    @if($record->financial_requested && count($covSel))
      <div class="detail-field" style="margin-top:.75rem">
        <div class="dlabel">Coverage Items</div>
        <div class="dval">
          @foreach($covSel as $cov)
            <span class="badge badge-gold" style="font-size:.65rem">{{ $covMap[$cov] ?? ucwords(str_replace('_', ' ', $cov)) }}</span>
          @endforeach
        </div>
      </div>
    @endif
  </div>

</div>

{{-- Footer actions --}}
<div style="padding:12px 20px;background:var(--bg);border-top:1px solid var(--border-sm);display:flex;justify-content:space-between;align-items:center;gap:8px;flex-shrink:0">
  <a href="{{ route('ld.show', $record) }}" target="_blank" class="btn btn-ghost btn-sm">🔗 Full View</a>
  <div style="display:flex;gap:6px">
    <a href="{{ route('ld.print', $record) }}" target="_blank" class="btn btn-gold btn-sm">🖨 Print</a>
    <button onclick="closeModal('viewModal')" class="btn btn-primary btn-sm">✓ Close</button>
  </div>
</div>