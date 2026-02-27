@php
  // Normalize potentially JSON-stored fields
  $types = $record->types ?? [];
  $natures = $record->natures ?? [];
  $coverageSelected = $record->coverage ?? [];

  if (is_string($types)) $types = json_decode($types, true) ?: [];
  if (is_string($natures)) $natures = json_decode($natures, true) ?: [];
  if (is_string($coverageSelected)) $coverageSelected = json_decode($coverageSelected, true) ?: [];

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
    <div class="ref-badge"
         style="background:rgba(255,255,255,.15);border-color:rgba(255,255,255,.3);color:white;margin-bottom:.75rem;">
      BatStateU-FO-HRD-31 &middot; Rev. 00
    </div>

    <h1 style="font-family:'DM Serif Display',serif;color:white;font-size:1.15rem;line-height:1.35;">
      Request for Participation in External Learning and Development Interventions
    </h1>

    <p class="text-sm" style="color:rgba(255,255,255,.65);margin-top:.4rem;">
      Submitted {{ optional($record->created_at)->format('F j, Y') }}
    </p>
  </div>

  {{-- Attendee Information --}}
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

  {{-- Activity Details --}}
  <div class="card-section">
    <div class="section-label">Activity Details</div>

    <div class="detail-field mb-2">
      <div class="dlabel">Title of Activity</div>
      <div class="dval" style="font-size:1rem;font-weight:600;">
        {{ $record->title ?? '—' }}
      </div>
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

    {{-- Optional extra details block (same style as fin-box in HRD-28). Remove if not needed. --}}
    @if(!empty($record->competency))
      <div class="fin-box mt-2">
        <div class="detail-field">
          <div class="dlabel">Competency/ies to be Developed</div>
          <div class="dval" style="white-space:pre-line;">{{ $record->competency }}</div>
        </div>
      </div>
    @endif
  </div>

  {{-- Modal Actions (same as earlier design) --}}
  <div class="form-actions">
    <button type="button" onclick="closeViewModal()" class="btn btn-ghost">Close</button>
    <button type="button" onclick="openViewEditModal()" class="btn btn-outline">✏️ Edit</button>
    <button type="button" onclick="openViewPrintModal('{{ route('ld.print', $record) }}')" class="btn btn-gold">🖨 Print</button>
  </div>

</div>