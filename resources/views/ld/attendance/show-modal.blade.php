{{-- resources/views/ld/attendance/show-modal.blade.php --}}

@php
  /**
   * Make sure list-like fields are ALWAYS arrays (handles null + JSON strings).
   */
  $types = $record->types ?? [];
  $natures = $record->natures ?? [];
  $coverageSelected = $record->coverage ?? [];

  if (is_string($types)) $types = json_decode($types, true) ?: [];
  if (is_string($natures)) $natures = json_decode($natures, true) ?: [];
  if (is_string($coverageSelected)) $coverageSelected = json_decode($coverageSelected, true) ?: [];

  // Coverage labels (key => label)
  $coverage = [
    'registration'   => 'Registration',
    'accommodation'  => 'Accommodation',
    'materials'      => 'Materials/ Kit',
    'speaker_fee'    => "Speaker's Fee",
    'meals'          => 'Meals/ Snacks',
    'transportation' => 'Transportation',
  ];
@endphp

<div class="card" style="box-shadow:none;border-radius:0 0 14px 14px;width:100%;">
  <div class="card-section" style="background:var(--maroon);">
    <div class="ref-badge" style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:white;margin-bottom:.75rem;">
      BatStateU-FO-HRD-31 &middot; Rev. 00
    </div>

    <h1 style="font-family:'DM Serif Display',serif;color:white;font-size:1.15rem;line-height:1.35;">
      Request for Participation in External Learning and Development Interventions
    </h1>

    <p class="text-sm" style="color:rgba(255,255,255,.65);margin-top:.4rem;">
      Submitted {{ optional($record->created_at)->format('F j, Y') }}
    </p>
  </div>

  <div class="card-section">
    <div class="section-label">Attendee Information</div>
    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Name of Attendee</div>
        <div class="dval">{{ $record->attendee_name ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Employment Status</div>
        <div class="dval">{{ $record->employment_status ?? '—' }}</div>
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
        <div class="dlabel">Position / Designation</div>
        <div class="dval">{{ $record->position ?? '—' }}</div>
      </div>
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Activity Details</div>

    <div class="detail-field mb-2">
      <div class="dlabel">Title of Activity</div>
      <div class="dval" style="font-size:1rem;font-weight:600;">{{ $record->title ?? '—' }}</div>
    </div>

    <div class="detail-grid">
      <div class="detail-field">
        <div class="dlabel">Type of Activity</div>
        <div class="dval">
          @forelse($types as $t)
            <span class="badge badge-maroon">{{ $t }}</span>
          @empty
            <span class="text-muted text-sm">—</span>
          @endforelse

          @if(!empty($record->type_others))
            <span class="badge badge-maroon">Others: {{ $record->type_others }}</span>
          @endif
        </div>
      </div>

      <div class="detail-field">
        <div class="dlabel">Level</div>
        <div class="dval">
          @if(!empty($record->level))
            <span class="badge badge-gold">{{ $record->level }}</span>
          @else
            <span class="text-muted text-sm">—</span>
          @endif
        </div>
      </div>

      <div class="detail-field">
        <div class="dlabel">Nature of Participation</div>
        <div class="dval">
          @forelse($natures as $n)
            <span class="badge badge-maroon">{{ $n }}</span>
          @empty
            <span class="text-muted text-sm">—</span>
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
  </div>

  <div class="card-section">
    <div class="section-label">Assessment Questions</div>

    @php
      $questions = [
        ['label' => 'Is financial assistance requested from the University?', 'val' => (bool) ($record->financial_requested ?? false)],
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

    @if(!empty($record->financial_requested))
      <div class="fin-box mt-2">
        <div class="detail-grid">
          <div class="detail-field">
            <div class="dlabel">Amount Requested</div>
            <div class="dval" style="font-size:1.05rem;font-weight:600;color:var(--maroon);">
              ₱ {{ number_format((float) ($record->amount_requested ?? 0), 2) }}
            </div>
          </div>

          <div class="detail-field">
            <div class="dlabel">Coverage</div>
            <div class="dval">
              @forelse($coverageSelected as $cov)
                <span class="badge badge-maroon">{{ $coverage[$cov] ?? $cov }}</span>
              @empty
                <span class="text-muted text-sm">—</span>
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

  <div class="card-section">
    <div class="section-label">Signatories</div>
    <div class="sig-grid">
      @foreach([
        ['role' => 'Requested by',          'name' => 'Dr. Bryan John A. Magoling',     'position' => 'Director, Research Management Services'],
        ['role' => 'Reviewed by',          'name' => 'Engr. Albertson D. Amante',      'position' => 'VP for Research, Development and Extension Services'],
        ['role' => 'Recommending Approval','name' => 'Atty. Noel Alberto S. Omandap',  'position' => 'VP for Administration and Finance'],
        ['role' => 'Approved by',          'name' => 'Dr. Tirso A. Ronquillo',         'position' => 'University President'],
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
     <button type="button" onclick="closeModal('genericViewModal')" class="btn btn-ghost">Close</button>
     <button type="button" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $record->id }})" class="btn btn-outline">✏️ Edit</button>
     <button type="button" onclick="openPrintModal('{{ route('ld.attendance.print', $record) }}')" class="btn btn-gold">🖨 Print</button>
  </div>
</div>