{{-- resources/views/ld/show-modal.blade.php (Attendance / Participation view) --}}
@php
  $actTypes = $record->activity_types ?? [];
  $natures  = $record->natures ?? [];
  $covSel   = $record->coverage ?? [];
  if (is_string($actTypes)) $actTypes = json_decode($actTypes, true) ?: [];
  if (is_string($natures))  $natures  = json_decode($natures,  true) ?: [];
  if (is_string($covSel))   $covSel   = json_decode($covSel,   true) ?: [];
  $coverageMap = [
    'registration'  => 'Registration',   'accommodation' => 'Accommodation',
    'materials'     => 'Materials / Kit','speaker_fee'   => "Speaker's Fee",
    'meals'         => 'Meals / Snacks', 'transportation'=> 'Transportation',
  ];
@endphp

<div class="card" style="box-shadow:none;border-radius:0 0 var(--radius-lg) var(--radius-lg);border:none;">

  {{-- ── Hero ── --}}
  <div style="background:linear-gradient(135deg,var(--crimson-deep) 0%,var(--crimson) 60%,var(--crimson-mid) 100%);padding:1.25rem 1.75rem 1.1rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold),var(--gold-light),transparent);opacity:.55;"></div>
    <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.88);margin-bottom:.55rem;">
      📅 Attendance Request
    </div>
    <h2 style="font-family:var(--font-display);color:#fff;font-size:1.05rem;font-weight:600;line-height:1.3;margin-bottom:.35rem;">
      Request to Attend Official Activity
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

  {{-- ── Attendee Info ── --}}
  <div class="card-section">
    <div class="section-label">Attendee Information</div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Name</div>
        <div class="dval" style="font-weight:600;">{{ $record->attendee_name ?? '—' }}</div>
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

  {{-- ── Activity Details ── --}}
  <div class="card-section">
    <div class="section-label">Activity Details</div>

    <div class="detail-field mb-2" style="background:var(--ivory-warm);border:1px solid var(--gold-pale);border-radius:var(--radius-md);padding:.65rem .9rem;">
      <div class="dlabel">Purpose / Title</div>
      <div class="dval" style="font-size:.95rem;font-weight:600;color:var(--crimson-deep);">{{ $record->purpose ?? '—' }}</div>
    </div>

    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Type of Activity</div>
        <div class="dval" style="display:flex;flex-wrap:wrap;gap:.25rem;">
          @forelse($actTypes as $t)
            <span class="badge badge-maroon">{{ $t }}</span>
          @empty <span class="text-muted text-sm">—</span>
          @endforelse
          @if(!empty($record->activity_type_others))
            <span class="badge badge-maroon">Others: {{ $record->activity_type_others }}</span>
          @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Nature</div>
        <div class="dval" style="display:flex;flex-wrap:wrap;gap:.25rem;">
          @forelse($natures as $n)
            <span class="badge badge-maroon">{{ $n }}</span>
          @empty <span class="text-muted text-sm">—</span>
          @endforelse
          @if(!empty($record->nature_others))
            <span class="badge badge-maroon">Others: {{ $record->nature_others }}</span>
          @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Level</div>
        <div class="dval">
          @if($record->level) <span class="badge badge-gold">{{ $record->level }}</span>
          @else <span class="text-muted text-sm">—</span> @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Date</div>
        <div class="dval">{{ $record->activity_date ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">No. of Hours</div>
        <div class="dval">{{ $record->hours ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Venue</div>
        <div class="dval">{{ $record->venue ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Organizer / Sponsor</div>
        <div class="dval">{{ $record->organizer ?? '—' }}</div>
      </div>
    </div>
  </div>

  {{-- ── Financial ── --}}
  <div class="card-section">
    <div class="section-label">Financial</div>
    <div class="yn-row">
      <div>Financial assistance requested from the University?</div>
      <div>
        @if($record->financial_requested)
          <span class="badge badge-green">Yes</span>
        @else
          <span class="text-muted text-sm">No</span>
        @endif
      </div>
    </div>
    @if($record->financial_requested)
      <div class="fin-box">
        <div class="detail-grid">
          <div class="detail-field">
            <div class="dlabel">Amount Requested</div>
            <div class="dval" style="font-family:var(--font-display);font-size:1.1rem;font-weight:700;color:var(--crimson);">
              ₱ {{ number_format((float)($record->amount_requested ?? 0), 2) }}
            </div>
          </div>
          <div class="detail-field">
            <div class="dlabel">Coverage</div>
            <div class="dval" style="display:flex;flex-wrap:wrap;gap:.25rem;">
              @forelse($covSel as $c)
                <span class="badge badge-maroon">{{ $coverageMap[$c] ?? $c }}</span>
              @empty <span class="text-muted text-sm">—</span>
              @endforelse
              @if(!empty($record->coverage_others))
                <span class="badge badge-maroon">Others: {{ $record->coverage_others }}</span>
              @endif
            </div>
          </div>
        </div>
      </div>
    @endif
  </div>

  {{-- ── Signatories ── --}}
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
    <button type="button" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
    <button type="button" onclick="openPrintModal('{{ route('ld.attendance.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  </div>
</div>