{{-- resources/views/ld/show-modal.blade.php — Participation view --}}
@php
  $types   = $record->types   ?? [];
  $natures = $record->natures ?? [];
  $covSel  = $record->coverage ?? [];
  if (is_string($types))   $types   = json_decode($types,   true) ?: [];
  if (is_string($natures)) $natures = json_decode($natures, true) ?: [];
  if (is_string($covSel))  $covSel  = json_decode($covSel,  true) ?: [];
  $coverageMap = [
    'registration'  => 'Registration',   'accommodation' => 'Accommodation',
    'materials'     => 'Materials / Kit','speaker_fee'   => "Speaker's Fee",
    'meals'         => 'Meals / Snacks', 'transportation'=> 'Transportation',
  ];
@endphp

<div class="card" style="box-shadow:none;border-radius:0 0 var(--radius-lg) var(--radius-lg);border:none;">

  {{-- Hero --}}
  <div style="background:linear-gradient(135deg,var(--crimson-deep) 0%,var(--crimson) 60%,var(--crimson-mid) 100%);padding:1.25rem 1.75rem 1.1rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold),var(--gold-light),transparent);opacity:.55;"></div>
    <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.88);margin-bottom:.55rem;">
      📋 Participation Request · BatStateU-FO-HRD-28
    </div>
    <h2 style="font-family:var(--font-display);color:#fff;font-size:1.05rem;font-weight:600;line-height:1.3;margin-bottom:.35rem;">
      Request for Participation in External L&D Interventions
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

  {{-- Participant Info --}}
  <div class="card-section">
    <div class="section-label">Participant Information</div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Name of Participant</div>
        <div class="dval" style="font-weight:600;">{{ $record->participant_name ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Position / Designation</div>
        <div class="dval">{{ $record->position ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Campus / Operating Unit</div>
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

  {{-- Intervention Details --}}
  <div class="card-section">
    <div class="section-label">Intervention Details</div>

    <div class="detail-field mb-2" style="background:var(--ivory-warm);border:1px solid var(--gold-pale);border-radius:var(--radius-md);padding:.65rem .9rem;">
      <div class="dlabel">Title of Intervention</div>
      <div class="dval" style="font-size:.95rem;font-weight:600;color:var(--crimson-deep);">{{ $record->title ?? '—' }}</div>
    </div>

    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Type of Intervention</div>
        <div class="dval" style="display:flex;flex-wrap:wrap;gap:.25rem;">
          @forelse($types as $t)
            <span class="badge badge-maroon">{{ $t }}</span>
          @empty <span class="text-muted text-sm">—</span>
          @endforelse
          @if(!empty($record->type_others))
            <span class="badge badge-maroon">Others: {{ $record->type_others }}</span>
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
        <div class="dlabel">Nature of Participation</div>
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
        <div class="dlabel">Date</div>
        <div class="dval">{{ $record->intervention_date ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Actual No. of Hours</div>
        <div class="dval">{{ $record->hours ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Venue</div>
        <div class="dval">{{ $record->venue ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Sponsor / Organizer</div>
        <div class="dval">{{ $record->organizer ?? '—' }}</div>
      </div>
    </div>

    @if($record->competency)
      <div class="detail-field mt-2">
        <div class="dlabel">Competency/ies to be Developed</div>
        <div class="dval" style="white-space:pre-line;">{{ $record->competency }}</div>
      </div>
    @endif
  </div>

  {{-- Assessment Questions --}}
  <div class="card-section">
    <div class="section-label">Assessment</div>
    @foreach([
      ['label' => 'Endorsed by a recognized or registered professional organization?', 'val' => $record->endorsed_by_org],
      ['label' => "Related to the participant's current field / workload?",             'val' => $record->related_to_field],
      ['label' => 'Has pending implementation of L&D Application Plan?',               'val' => $record->has_pending_ldap],
      ['label' => 'Has any unliquidated cash advance?',                                'val' => $record->has_cash_advance],
      ['label' => 'Financial assistance requested from the University?',               'val' => $record->financial_requested],
    ] as $q)
      <div class="yn-row">
        <div>{{ $q['label'] }}</div>
        <div>
          @if($q['val']) <span class="badge badge-green">Yes</span>
          @else <span class="text-muted text-sm">No</span> @endif
        </div>
      </div>
    @endforeach

    @if($record->financial_requested)
      <div class="fin-box mt-2">
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

  {{-- Signatories --}}
  <div class="card-section">
    <div class="section-label">Signatories</div>
    <div class="sig-grid">
      @foreach([
        ['role'=>'Requested by',          'name'=>$record->sig_requested_name     ?? 'Dr. Bryan John A. Magoling',    'pos'=>$record->sig_requested_position     ?? 'Director, Research Management Services'],
        ['role'=>'Reviewed by',           'name'=>$record->sig_reviewed_name      ?? 'Engr. Albertson D. Amante',    'pos'=>$record->sig_reviewed_position      ?? 'VP for Research, Development and Extension Services'],
        ['role'=>'Recommending Approval', 'name'=>$record->sig_recommending_name  ?? 'Atty. Noel Alberto S. Omandap','pos'=>$record->sig_recommending_position  ?? 'VP for Administration and Finance'],
        ['role'=>'Approved by',           'name'=>$record->sig_approved_name      ?? 'Dr. Tirso A. Ronquillo',       'pos'=>$record->sig_approved_position      ?? 'University President'],
      ] as $s)
        <div class="sig-box">
          <div class="sig-role">{{ $s['role'] }}</div>
          <div class="sig-name">{{ $s['name'] }}</div>
          <div class="sig-position">{{ $s['pos'] }}</div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="form-actions">
    <button type="button" onclick="openEditModal({{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
    <button type="button" onclick="openPrintModal('{{ route('ld.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  </div>
</div>