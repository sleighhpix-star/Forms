@php
  $coverage = [
    'registration'   => 'Registration',
    'accommodation'  => 'Accommodation',
    'materials'      => 'Materials/ Kit',
    'speaker_fee'    => "Speaker's Fee",
    'meals'          => 'Meals/ Snacks',
    'transportation' => 'Transportation',
  ];
@endphp

<div class="card" style="box-shadow:none;border-radius:0 0 14px 14px;">

  {{-- Header --}}
  <div class="card-section" style="background:var(--maroon);">
    <div class="ref-badge" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:white;margin-bottom:.75rem;">
      BatStateU-FO-HRD-28 &middot; Rev. 03
    </div>
    <h1 style="font-family:'DM Serif Display',serif;color:white;font-size:1.15rem;line-height:1.35;">
      Request for Participation in External Learning and Development Interventions
    </h1>
    <p class="text-sm" style="color:rgba(255,255,255,.65);margin-top:.4rem;">
      Submitted {{ $record->created_at->format('F j, Y') }}
    </p>
  </div>

  {{-- Participant Info --}}
  <div class="card-section">
    <div class="section-label">Participant Information</div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Name of Participant</div>
        <div class="dval">{{ $record->participant_name }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Employment Status</div>
        <div class="dval">{{ $record->employment_status }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Campus / Operating Unit</div>
        <div class="dval">{{ $record->campus }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">College / Office</div>
        <div class="dval">{{ $record->college_office }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Position / Designation</div>
        <div class="dval">{{ $record->position }}</div>
      </div>
    </div>
  </div>

  {{-- Intervention Details --}}
  <div class="card-section">
    <div class="section-label">Intervention Details</div>
    <div class="detail-field mb-2">
      <div class="dlabel">Title of Intervention</div>
      <div class="dval" style="font-size:1rem;font-weight:600;">{{ $record->title }}</div>
    </div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Type of Intervention</div>
        <div class="dval">
          @foreach($record->types as $t)
            <span class="badge badge-maroon">{{ $t }}</span>
          @endforeach
          @if($record->type_others)
            <span class="badge badge-maroon">Others: {{ $record->type_others }}</span>
          @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Level</div>
        <div class="dval"><span class="badge badge-gold">{{ $record->level }}</span></div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Nature of Participation</div>
        <div class="dval">
          @foreach($record->natures as $n)
            <span class="badge badge-maroon">{{ $n }}</span>
          @endforeach
          @if($record->nature_others)
            <span class="badge badge-maroon">Others: {{ $record->nature_others }}</span>
          @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Date</div>
        <div class="dval">{{ $record->intervention_date }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Actual No. of Hours</div>
        <div class="dval">{{ $record->hours ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Venue</div>
        <div class="dval">{{ $record->venue }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Sponsor / Organizer</div>
        <div class="dval">{{ $record->organizer }}</div>
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
    <div class="section-label">Assessment Questions</div>
    @php
      $questions = [
        ['label' => 'Endorsed by a recognized or registered professional organization?', 'val' => $record->endorsed_by_org],
        ['label' => "Related to the participant's current field/workload?",               'val' => $record->related_to_field],
        ['label' => 'Has pending implementation of L&D Application Plan?',               'val' => $record->has_pending_ldap],
        ['label' => 'Has any unliquidated cash advance?',                                'val' => $record->has_cash_advance],
        ['label' => 'Financial assistance requested?',                                   'val' => $record->financial_requested],
      ];
    @endphp
    @foreach($questions as $q)
      <div class="yn-row">
        <div>{{ $q['label'] }}</div>
        <div>
          @if($q['val'])
            <span class="badge badge-green">Yes</span>
          @else
            <span class="text-muted text-sm">No</span>
          @endif
        </div>
      </div>
    @endforeach

    @if($record->financial_requested)
      <div class="fin-box mt-2">
        <div class="detail-grid">
          <div class="detail-field">
            <div class="dlabel">Amount Requested</div>
            <div class="dval" style="font-size:1.05rem;font-weight:600;color:var(--maroon);">
              ₱ {{ number_format($record->amount_requested, 2) }}
            </div>
          </div>
          <div class="detail-field">
            <div class="dlabel">Coverage</div>
            <div class="dval">
              @foreach($record->coverage ?? [] as $cov)
                <span class="badge badge-maroon">{{ $coverage[$cov] ?? $cov }}</span>
              @endforeach
              @if($record->coverage_others)
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
        ['role' => 'Requested by',         'name' => 'Dr. Bryan John A. Magoling',     'position' => 'Director, Research Management Services'],
        ['role' => 'Reviewed by',           'name' => 'Engr. Albertson D. Amante',     'position' => 'VP for Research, Development and Extension Services'],
        ['role' => 'Recommending Approval', 'name' => 'Atty. Noel Alberto S. Omandap', 'position' => 'VP for Administration and Finance'],
        ['role' => 'Approved by',           'name' => 'Dr. Tirso A. Ronquillo',        'position' => 'University President'],
      ] as $sig)
        <div class="sig-box">
          <div class="sig-role">{{ $sig['role'] }}</div>
          <div class="sig-name">{{ $sig['name'] }}</div>
          <div class="sig-position">{{ $sig['position'] }}</div>
        </div>
      @endforeach
    </div>
  </div>

  {{-- Modal Actions --}}
  <div class="form-actions">
    <button type="button" onclick="closeViewModal()" class="btn btn-ghost">Close</button>
    <button type="button" onclick="openViewEditModal()" class="btn btn-outline">✏️ Edit</button>
    <button type="button" onclick="openViewPrintModal('{{ route('ld.print', $record) }}')" class="btn btn-gold">🖨 Print</button>
  </div>

</div>