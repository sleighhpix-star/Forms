@php
  $employmentStatuses = ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'];

  // ── Standard signatory defaults ──────────────────────────────────────────
  $signatories = [
    [
      'role'           => 'Requested by',
      'name_field'     => 'sig_requested_name',
      'position_field' => 'sig_requested_position',
      'default_name'   => 'Dr. Bryan John A. Magoling',
      'default_pos'    => 'Director, Research Management Services',
    ],
    [
      'role'           => 'Reviewed by',
      'name_field'     => 'sig_reviewed_name',
      'position_field' => 'sig_reviewed_position',
      'default_name'   => 'Engr. Albertson D. Amante',
      'default_pos'    => 'VP for Research, Development and Extension Services',
    ],
    [
      'role'           => 'Recommending Approval',
      'name_field'     => 'sig_recommending_name',
      'position_field' => 'sig_recommending_position',
      'default_name'   => 'Atty. Noel Alberto S. Omandap',
      'default_pos'    => 'VP for Administration and Finance',
    ],
    [
      'role'           => 'Approved by',
      'name_field'     => 'sig_approved_name',
      'position_field' => 'sig_approved_position',
      'default_name'   => 'Dr. Tirso A. Ronquillo',
      'default_pos'    => 'University President',
    ],
  ];
  $types    = ['Seminar', 'Convention', 'Conference', 'Training', 'Symposium', 'Workshop', 'Immersion'];
  $levels   = ['Local', 'Regional', 'National', 'International'];
  $natures  = ['Learner', 'Presenter', 'Officer', 'Speaker', 'Facilitator', 'Organizer'];
  $coverage = [
    'registration'   => 'Registration',
    'accommodation'  => 'Accommodation',
    'materials'      => 'Materials/ Kit',
    'speaker_fee'    => "Speaker's Fee",
    'meals'          => 'Meals/ Snacks',
    'transportation' => 'Transportation',
  ];
@endphp

<form action="{{ route('ld.update', $record) }}" method="POST" id="edit-form">
  @method('PUT')
  @csrf

  {{-- PARTICIPANT INFORMATION --}}
  <div class="card-section">
    <div class="section-label">Participant Information</div>
    <div class="field-grid cols-2">

      <div class="field span-2 {{ $errors->has('tracking_number') ? 'has-error' : '' }}">
        <label for="tracking_number">Tracking Number <span class="hint">(optional — leave empty to auto-generate)</span></label>
        <input type="text" id="tracking_number" name="tracking_number"
               value="{{ old('tracking_number', $record?->tracking_number) }}"
               placeholder="e.g. LD-20260312-XXXXXX">
        @error('tracking_number') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field span-2 {{ $errors->has('participant_name') ? 'has-error' : '' }}">
        <label>Name of Participant <span class="req">*</span></label>
        <input type="text" name="participant_name" value="{{ $record->participant_name }}" placeholder="Last Name, First Name, Middle Name">
        @error('participant_name') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('campus') ? 'has-error' : '' }}">
        <label>Campus / Operating Unit <span class="req">*</span></label>
        <input type="text" name="campus" value="{{ $record->campus }}" placeholder="e.g. Alangilan Campus">
        @error('campus') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('employment_status') ? 'has-error' : '' }}">
        <label>Employment Status <span class="req">*</span></label>
        <select name="employment_status">
          <option value="">— Select —</option>
          @foreach($employmentStatuses as $status)
            <option value="{{ $status }}" {{ $record->employment_status === $status ? 'selected' : '' }}>{{ $status }}</option>
          @endforeach
        </select>
        @error('employment_status') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('college_office') ? 'has-error' : '' }}">
        <label>College / Office <span class="req">*</span></label>
        <input type="text" name="college_office" value="{{ $record->college_office }}" placeholder="e.g. College of Engineering">
        @error('college_office') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('position') ? 'has-error' : '' }}">
        <label>Academic Rank / Position / Designation <span class="req">*</span></label>
        <input type="text" name="position" value="{{ $record->position }}" placeholder="e.g. Assistant Professor II">
        @error('position') <span class="field-error">{{ $message }}</span> @enderror
      </div>

    </div>
  </div>

  {{-- INTERVENTION DETAILS --}}
  <div class="card-section">
    <div class="section-label">Intervention Details</div>
    <div class="field-grid">

      <div class="field {{ $errors->has('title') ? 'has-error' : '' }}">
        <label>Title of Intervention <span class="req">*</span></label>
        <input type="text" name="title" value="{{ $record->title }}" placeholder="Full title of the training / seminar / conference">
        @error('title') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('types') ? 'has-error' : '' }}">
        <label>Type of Intervention <span class="req">*</span></label>
        <div class="check-group">
          @foreach($types as $type)
            <label class="check-item">
              <input type="checkbox" name="types[]" value="{{ $type }}" {{ in_array($type, $record->types ?? []) ? 'checked' : '' }}>
              <span>{{ $type }}</span>
            </label>
          @endforeach
          <label class="check-item">
            <input type="checkbox" id="e_type_others_chk" {{ $record->type_others ? 'checked' : '' }}>
            <span>Others:</span>
          </label>
          <input type="text" class="others-input" name="type_others" id="e_type_others_txt"
                 value="{{ $record->type_others }}" placeholder="specify..." {{ $record->type_others ? '' : 'disabled' }}>
        </div>
        @error('types') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('level') ? 'has-error' : '' }}">
        <label>Level <span class="req">*</span></label>
        <div class="check-group">
          @foreach($levels as $level)
            <label class="check-item">
              <input type="radio" name="level" value="{{ $level }}" {{ $record->level === $level ? 'checked' : '' }}>
              <span>{{ $level }}</span>
            </label>
          @endforeach
        </div>
        @error('level') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field {{ $errors->has('natures') ? 'has-error' : '' }}">
        <label>Nature of Participation <span class="req">*</span></label>
        <div class="check-group">
          @foreach($natures as $nature)
            <label class="check-item">
              <input type="checkbox" name="natures[]" value="{{ $nature }}" {{ in_array($nature, $record->natures ?? []) ? 'checked' : '' }}>
              <span>{{ $nature }}</span>
            </label>
          @endforeach
          <label class="check-item">
            <input type="checkbox" id="e_nature_others_chk" {{ $record->nature_others ? 'checked' : '' }}>
            <span>Others:</span>
          </label>
          <input type="text" class="others-input" name="nature_others" id="e_nature_others_txt"
                 value="{{ $record->nature_others }}" placeholder="specify..." {{ $record->nature_others ? '' : 'disabled' }}>
        </div>
        @error('natures') <span class="field-error">{{ $message }}</span> @enderror
      </div>

      <div class="field">
        <label>Competency/ies to be Developed / Enhanced <span class="hint">(if participating as a learner)</span></label>
        <textarea name="competency" placeholder="Describe the competencies...">{{ $record->competency }}</textarea>
      </div>

      <div class="field-grid cols-2">
        <div class="field {{ $errors->has('intervention_date') ? 'has-error' : '' }}">
          <label>Date <span class="req">*</span></label>
          <input type="text" name="intervention_date" class="date-picker-range" value="{{ $record->intervention_date }}" placeholder="e.g. March 5–7, 2026">
          @error('intervention_date') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="field">
          <label>Actual No. of Hours</label>
          <input type="number" name="hours" min="1" value="{{ $record->hours }}" placeholder="e.g. 24">
        </div>
        <div class="field {{ $errors->has('venue') ? 'has-error' : '' }}">
          <label>Venue <span class="req">*</span></label>
          <input type="text" name="venue" value="{{ $record->venue }}" placeholder="City, Venue name">
          @error('venue') <span class="field-error">{{ $message }}</span> @enderror
        </div>
        <div class="field {{ $errors->has('organizer') ? 'has-error' : '' }}">
          <label>Sponsor Agency / Organizer <span class="req">*</span></label>
          <input type="text" name="organizer" value="{{ $record->organizer }}" placeholder="Name of organizing body">
          @error('organizer') <span class="field-error">{{ $message }}</span> @enderror
        </div>
      </div>

    </div>
  </div>

  {{-- ASSESSMENT QUESTIONS --}}
  <div class="card-section">
    <div class="section-label">Assessment Questions</div>

    @php
      $yesNoFields = [
        ['name' => 'endorsed_by_org',  'label' => 'Endorsed by a recognized or registered professional organization?'],
        ['name' => 'related_to_field', 'label' => "Related to the participant's current field/workload?"],
        ['name' => 'has_pending_ldap', 'label' => 'Has pending implementation of Learning and Development Application Plan?'],
        ['name' => 'has_cash_advance', 'label' => 'Has any unliquidated cash advance?'],
      ];
    @endphp

    @foreach($yesNoFields as $field)
      <div class="yn-row">
        <div>{{ $field['label'] }}</div>
        <div class="yn-opts">
          <label><input type="radio" name="{{ $field['name'] }}" value="1" {{ $record->{$field['name']} ? 'checked' : '' }}> Yes</label>
          <label><input type="radio" name="{{ $field['name'] }}" value="0" {{ !$record->{$field['name']} ? 'checked' : '' }}> No</label>
        </div>
      </div>
    @endforeach

    <div class="yn-row">
      <div>Is financial assistance requested from the University?</div>
      <div class="yn-opts">
        <label><input type="radio" name="financial_requested" value="1" {{ $record->financial_requested ? 'checked' : '' }} onchange="editToggleFinance(true)"> Yes</label>
        <label><input type="radio" name="financial_requested" value="0" {{ !$record->financial_requested ? 'checked' : '' }} onchange="editToggleFinance(false)"> No</label>
      </div>
    </div>

    <div class="fin-box" id="edit_fin_section" style="{{ $record->financial_requested ? '' : 'display:none' }}">
      <div class="field-grid cols-2" style="margin-bottom:.85rem">
        <div class="field">
          <label>Total Amount Requested (₱)</label>
          <input type="number" name="amount_requested" min="0" step="0.01" value="{{ $record->amount_requested }}" placeholder="0.00">
        </div>
      </div>
      <div class="field">
        <label>Coverage</label>
        <div class="check-group">
          @foreach($coverage as $key => $lbl)
            <label class="check-item">
              <input type="checkbox" name="coverage[]" value="{{ $key }}" {{ in_array($key, $record->coverage ?? []) ? 'checked' : '' }}>
              <span>{{ $lbl }}</span>
            </label>
          @endforeach
          <label class="check-item">
            <input type="checkbox" id="e_cov_others_chk" {{ $record->coverage_others ? 'checked' : '' }}>
            <span>Others:</span>
          </label>
          <input type="text" class="others-input" name="coverage_others" id="e_cov_others_txt"
                 value="{{ $record->coverage_others }}" placeholder="specify..." {{ $record->coverage_others ? 'required' : 'disabled' }}>
          {{-- Hidden: keeps coverage[] non-empty when only Others is chosen --}}
          @if($record->coverage_others)<input type="hidden" name="coverage[]" value="Others" id="hidden_e_cov_others_txt">@endif
        </div>
      </div>
    </div>
  </div>

  {{-- SIGNATORIES --}}
  <div class="card-section">
    <div class="section-label">
      Signatories
      <span style="font-size:.68rem;font-weight:400;color:#9ca3af;margin-left:.5rem;">
        — pre-filled with standard names, click any field to edit
      </span>
    </div>

    <div class="sig-grid">
      @foreach($signatories as $sig)
      <div class="sig-box">
        <div class="sig-role">{{ $sig['role'] }}</div>

        <div class="sig-field-wrap">
          <input
            type="text"
            class="sig-name-input"
            name="{{ $sig['name_field'] }}"
            value="{{ old($sig['name_field'], $record->{$sig['name_field']} ?? $sig['default_name']) }}"
            placeholder="{{ $sig['default_name'] }}"
            data-default="{{ $sig['default_name'] }}"
          >
          <span class="sig-edit-icon">✎</span>
        </div>

        <div class="sig-field-wrap">
          <input
            type="text"
            class="sig-pos-input"
            name="{{ $sig['position_field'] }}"
            value="{{ old($sig['position_field'], $record->{$sig['position_field']} ?? $sig['default_pos']) }}"
            placeholder="{{ $sig['default_pos'] }}"
            data-default="{{ $sig['default_pos'] }}"
          >
          <span class="sig-edit-icon" style="font-size:.55rem;">✎</span>
        </div>

        <button
          type="button"
          class="sig-reset-btn"
          onclick="resetEditSignatory(this)"
          title="Reset to default"
        >↺ Reset to default</button>
      </div>
      @endforeach
    </div>
  </div>

  {{-- ACTIONS --}}
  <div class="form-actions">
    <button type="button" onclick="closeModal('editModal')" class="btn btn-ghost">Cancel</button>
    <button type="submit" class="btn btn-primary">💾 Update Request</button>
  </div>

<script>
// Signatory reset for edit form
function resetEditSignatory(btn) {
  const box = btn.closest('.sig-box');
  const nameInput = box.querySelector('.sig-name-input');
  const posInput  = box.querySelector('.sig-pos-input');
  if (nameInput) nameInput.value = nameInput.dataset.default || '';
  if (posInput)  posInput.value  = posInput.dataset.default  || '';
}

// "Others" checkbox toggles for edit form — injects hidden array value so required|array|min:1 passes
function _editToggleOthers(chk, txtId, arrayName, hiddenId) {
  const txt = document.getElementById(txtId);
  if (chk.checked) {
    txt.disabled = false; txt.required = true; txt.focus();
    if (!document.getElementById(hiddenId)) {
      const h = document.createElement('input');
      h.type = 'hidden'; h.name = arrayName; h.value = 'Others'; h.id = hiddenId;
      txt.parentNode.appendChild(h);
    }
  } else {
    txt.disabled = true; txt.required = false; txt.value = '';
    const h = document.getElementById(hiddenId);
    if (h) h.remove();
  }
}
document.getElementById('e_type_others_chk')?.addEventListener('change', function() {
  _editToggleOthers(this, 'e_type_others_txt', 'types[]', 'hidden_e_type_others_txt');
});
document.getElementById('e_nature_others_chk')?.addEventListener('change', function() {
  _editToggleOthers(this, 'e_nature_others_txt', 'natures[]', 'hidden_e_nature_others_txt');
});
document.getElementById('e_cov_others_chk')?.addEventListener('change', function() {
  _editToggleOthers(this, 'e_cov_others_txt', 'coverage[]', 'hidden_e_cov_others_txt');
});
</script>
</form>