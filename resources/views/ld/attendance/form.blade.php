@php
  $record ??= null;
  $activityTypes = ['Meeting', 'Planning Session', 'Benchmarking', 'Project/Product Launch', 'Ceremonial/Representational'];
  $levels        = ['Local', 'Regional', 'National', 'International'];
  $natures       = ['Learner', 'Presenter', 'Officer', 'Speaker', 'Facilitator', 'Organizer'];
  $employmentStatuses = ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'];
  $coverage = [
    'registration'   => 'Registration',
    'accommodation'  => 'Accommodation',
    'materials'      => 'Materials/ Kit',
    'speaker_fee'    => "Speaker's Fee",
    'meals'          => 'Meals/ Snacks',
    'transportation' => 'Transportation',
  ];
  $isEdit  = isset($record) && $record?->id;
  $action  = $isEdit
    ? route('ld.attendance.update', $record->id)
    : route('ld.attendance.store');

  $hasTypeOthers   = !empty(old('activity_type_others', $record?->activity_type_others));
  $hasNatureOthers = !empty(old('nature_others',        $record?->nature_others));
  $hasCovOthers    = !empty(old('coverage_others',      $record?->coverage_others));
@endphp

<script>
function attToggleOthers(chk, txtId) {
  const t = document.getElementById(txtId);
  if (!t) return;

  // Each "Others" text input belongs to a group array (activity_types[], natures[], coverage[]).
  // When checked we inject a hidden input with value "Others" into that array so the
  // server-side `required|array|min:1` rule is satisfied even when no regular option is chosen.
  const arrayMap = {
    'att_type_others_txt':  'activity_types[]',
    'att_nature_others_txt': 'natures[]',
    'att_cov_others_txt':   'coverage[]',
  };
  const arrayName = arrayMap[txtId];

  if (chk.checked) {
    t.removeAttribute('disabled');
    t.required = true;
    t.focus();
    // Inject hidden "Others" value into the corresponding array if not already present
    if (arrayName && !document.getElementById('hidden_' + txtId)) {
      const h = document.createElement('input');
      h.type  = 'hidden';
      h.name  = arrayName;
      h.value = 'Others';
      h.id    = 'hidden_' + txtId;
      t.parentNode.appendChild(h);
    }
  } else {
    t.setAttribute('disabled', 'disabled');
    t.required = false;
    t.value = '';
    // Remove the injected hidden input
    const h = document.getElementById('hidden_' + txtId);
    if (h) h.remove();
  }
}

function resetSignatory(btn) {
  btn.closest('.sig-box').querySelectorAll('[data-default]').forEach(function(i) {
    i.value = i.dataset.default;
  });
}
</script>



<div class="page" style="max-width:100%;">
  <form action="{{ $action }}" method="POST" id="attendance-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="card">

      {{-- ATTENDEE INFORMATION --}}
      <div class="card-section">
        <div class="section-label">Attendee Information</div>
        <div class="field-grid cols-2">

          <div class="field {{ $errors->has('tracking_number') ? 'has-error' : '' }}">
            <label for="att_tracking_number">Tracking Number <span class="hint">(optional)</span></label>
            <input type="text" id="att_tracking_number" name="tracking_number"
                   value="{{ old('tracking_number', $record?->tracking_number) }}"
                   placeholder="Auto-generated if empty"
                   style="max-width:260px;">
            @error('tracking_number') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          <div class="field" style="visibility:hidden;pointer-events:none;" aria-hidden="true"></div>

          <div class="field span-2">
            <label>Name of Attendee <span class="req">*</span></label>
            <input type="text" name="attendee_name"
                   value="{{ old('attendee_name', $record?->attendee_name) }}"
                   placeholder="Last Name, First Name, Middle Name" required>
          </div>

          <div class="field">
            <label>Campus / Operating Unit <span class="req">*</span></label>
            <input type="text" name="campus"
                   value="{{ old('campus', $record?->campus) }}"
                   placeholder="e.g. Alangilan Campus" required>
          </div>

          <div class="field">
            <label>Employment Status <span class="req">*</span></label>
            <select name="employment_status" required>
              <option value="">— Select —</option>
              @foreach($employmentStatuses as $s)
                <option value="{{ $s }}" {{ old('employment_status', $record?->employment_status) === $s ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>College / Office <span class="req">*</span></label>
            <input type="text" name="college_office"
                   value="{{ old('college_office', $record?->college_office) }}"
                   placeholder="e.g. Office of the VP for Research" required>
          </div>

          <div class="field">
            <label>Academic Rank / Position <span class="req">*</span></label>
            <input type="text" name="position"
                   value="{{ old('position', $record?->position) }}"
                   placeholder="e.g. Assistant Professor II" required>
          </div>

        </div>
      </div>

      {{-- ACTIVITY DETAILS --}}
      <div class="card-section">
        <div class="section-label">Activity Details</div>
        <div class="field-grid">

          {{-- Type of Activity --}}
          <div class="field">
            <label>Type of Activity <span class="req">*</span></label>
            <div class="check-group">
              @foreach($activityTypes as $t)
                <label class="check-item">
                  <input type="checkbox" name="activity_types[]" value="{{ $t }}"
                    {{ in_array($t, old('activity_types', $record?->activity_types ?? [])) ? 'checked' : '' }}>
                  <span>{{ $t }}</span>
                </label>
              @endforeach
              <label class="check-item">
                <input type="checkbox" id="att_type_others_chk"
                       onchange="attToggleOthers(this, 'att_type_others_txt')"
                       {{ $hasTypeOthers ? 'checked' : '' }}>
                <span>Others:</span>
              </label>
              <input type="text" class="others-input" name="activity_type_others" id="att_type_others_txt"
                     value="{{ old('activity_type_others', $record?->activity_type_others) }}"
                     placeholder="specify..."
                     @if(!$hasTypeOthers) disabled @else required @endif>
              {{-- Hidden: keeps activity_types[] non-empty when only Others is chosen --}}
              @if($hasTypeOthers)<input type="hidden" name="activity_types[]" value="Others" id="hidden_att_type_others_txt">@endif
            </div>
          </div>

          {{-- Nature of Participation --}}
          <div class="field">
            <label>Nature of Participation <span class="req">*</span></label>
            <div class="check-group">
              @foreach($natures as $n)
                <label class="check-item">
                  <input type="checkbox" name="natures[]" value="{{ $n }}"
                    {{ in_array($n, old('natures', $record?->natures ?? [])) ? 'checked' : '' }}>
                  <span>{{ $n }}</span>
                </label>
              @endforeach
              <label class="check-item">
                <input type="checkbox" id="att_nature_others_chk"
                       onchange="attToggleOthers(this, 'att_nature_others_txt')"
                       {{ $hasNatureOthers ? 'checked' : '' }}>
                <span>Others:</span>
              </label>
              <input type="text" class="others-input" name="nature_others" id="att_nature_others_txt"
                     value="{{ old('nature_others', $record?->nature_others) }}"
                     placeholder="specify..."
                     @if(!$hasNatureOthers) disabled @else required @endif>
              {{-- Hidden: keeps natures[] non-empty when only Others is chosen --}}
              @if($hasNatureOthers)<input type="hidden" name="natures[]" value="Others" id="hidden_att_nature_others_txt">@endif
            </div>
          </div>

          {{-- Purpose --}}
          <div class="field">
            <label>Purpose of Activity <span class="req">*</span></label>
            <textarea name="purpose" placeholder="Describe the purpose of this activity..." required>{{ old('purpose', $record?->purpose) }}</textarea>
          </div>

          {{-- Level --}}
          <div class="field">
            <label>Level <span class="req">*</span></label>
            <div class="check-group">
              @foreach($levels as $l)
                <label class="check-item">
                  <input type="radio" name="level" value="{{ $l }}"
                    {{ old('level', $record?->level) === $l ? 'checked' : '' }}>
                  <span>{{ $l }}</span>
                </label>
              @endforeach
            </div>
          </div>

          <div class="field-grid cols-2">
            <div class="field">
              <label>Date <span class="req">*</span></label>
              <input type="text" name="activity_date" class="date-picker-range"
                     value="{{ old('activity_date', $record?->activity_date) }}"
                     placeholder="e.g. March 5-7, 2026" required>
            </div>
            <div class="field">
              <label>Actual No. of Hours</label>
              <input type="number" name="hours" min="1"
                     value="{{ old('hours', $record?->hours) }}" placeholder="e.g. 8">
            </div>
            <div class="field">
              <label>Venue <span class="req">*</span></label>
              <input type="text" name="venue"
                     value="{{ old('venue', $record?->venue) }}"
                     placeholder="City, Venue name" required>
            </div>
            <div class="field">
              <label>Sponsor Agency / Organizer <span class="req">*</span></label>
              <input type="text" name="organizer"
                     value="{{ old('organizer', $record?->organizer) }}"
                     placeholder="Name of organizing body" required>
            </div>
          </div>

        </div>
      </div>

      {{-- FINANCIAL --}}
      <div class="card-section">
        <div class="section-label">Financial Assistance</div>

        <div class="yn-row">
          <div>Is financial assistance requested from the University?</div>
          <div class="yn-opts">
            <label>
              <input type="radio" name="financial_requested" value="1"
                {{ old('financial_requested', $record?->financial_requested) == '1' ? 'checked' : '' }}
                onchange="document.getElementById('att_fin_section').style.display=''"> Yes
            </label>
            <label>
              <input type="radio" name="financial_requested" value="0"
                {{ old('financial_requested', $record?->financial_requested ?? '0') == '0' ? 'checked' : '' }}
                onchange="document.getElementById('att_fin_section').style.display='none'"> No
            </label>
          </div>
        </div>

        <div id="att_fin_section" style="{{ old('financial_requested', $record?->financial_requested) == '1' ? '' : 'display:none' }}">
          <div class="fin-box">
            <div class="field-grid cols-2" style="margin-bottom:.85rem">
              <div class="field">
                <label>Total Amount Requested (Philippine Peso)</label>
                <input type="number" name="amount_requested" min="0" step="0.01"
                       value="{{ old('amount_requested', $record?->amount_requested) }}" placeholder="0.00">
              </div>
            </div>
            <div class="field">
              <label>Coverage</label>
              <div class="check-group">
                @foreach($coverage as $key => $label)
                  <label class="check-item">
                    <input type="checkbox" name="coverage[]" value="{{ $key }}"
                      {{ in_array($key, old('coverage', $record?->coverage ?? [])) ? 'checked' : '' }}>
                    <span>{{ $label }}</span>
                  </label>
                @endforeach
                <label class="check-item">
                  <input type="checkbox" id="att_cov_others_chk"
                         onchange="attToggleOthers(this, 'att_cov_others_txt')"
                         {{ $hasCovOthers ? 'checked' : '' }}>
                  <span>Others:</span>
                </label>
                <input type="text" class="others-input" name="coverage_others" id="att_cov_others_txt"
                       value="{{ old('coverage_others', $record?->coverage_others) }}"
                       placeholder="specify..."
                       @if(!$hasCovOthers) disabled @else required @endif>
                {{-- Hidden: keeps coverage[] non-empty when only Others is chosen --}}
                @if($hasCovOthers)<input type="hidden" name="coverage[]" value="Others" id="hidden_att_cov_others_txt">@endif
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- SIGNATORIES --}}
      @php
        $signatories = [
          ['role'=>'Requested by',         'name_field'=>'sig_requested_name',    'position_field'=>'sig_requested_position',    'default_name'=>'Dr. Bryan John A. Magoling',    'default_pos'=>'Director, Research Management Services'],
          ['role'=>'Reviewed by',          'name_field'=>'sig_reviewed_name',     'position_field'=>'sig_reviewed_position',     'default_name'=>'Engr. Albertson D. Amante',     'default_pos'=>'Vice President for Research, Development and Extension Services'],
          ['role'=>'Recommending Approval','name_field'=>'sig_recommending_name', 'position_field'=>'sig_recommending_position', 'default_name'=>'Atty. Noel Alberto S. Omandap', 'default_pos'=>'Vice President for Administration and Finance'],
          ['role'=>'Approved by',          'name_field'=>'sig_approved_name',     'position_field'=>'sig_approved_position',     'default_name'=>'Dr. Tirso A. Ronquillo',        'default_pos'=>'University President'],
        ];
      @endphp
      <div class="card-section">
        <div class="section-label">Signatories <span style="font-size:.68rem;font-weight:400;color:#9ca3af;margin-left:.5rem;">— pre-filled with standard names, click any field to edit</span></div>
        <div class="sig-grid">
          @foreach($signatories as $sig)
          <div class="sig-box">
            <div class="sig-role">{{ $sig['role'] }}</div>
            <div class="sig-field-wrap">
              <input type="text" class="sig-name-input" name="{{ $sig['name_field'] }}"
                     value="{{ old($sig['name_field'], $record?->{$sig['name_field']} ?? $sig['default_name']) }}"
                     data-default="{{ $sig['default_name'] }}">
              <span class="sig-edit-icon">✎</span>
            </div>
            <div class="sig-field-wrap">
              <input type="text" class="sig-pos-input" name="{{ $sig['position_field'] }}"
                     value="{{ old($sig['position_field'], $record?->{$sig['position_field']} ?? $sig['default_pos']) }}"
                     data-default="{{ $sig['default_pos'] }}">
              <span class="sig-edit-icon" style="font-size:.55rem;">✎</span>
            </div>
            <button type="button" class="sig-reset-btn" onclick="resetSignatory(this)">Reset to default</button>
          </div>
          @endforeach
        </div>
      </div>

      {{-- Actions --}}
      <div class="form-actions">
        <button type="button" onclick="closeModal('gFormModal')" class="btn btn-ghost">Cancel</button>
        <button type="reset" class="btn btn-outline" onclick="document.querySelectorAll('#attendance-form [data-default]').forEach(i=>i.value=i.dataset.default)">Clear</button>
        <button type="submit" class="btn btn-primary">{{ $isEdit ? '💾 Update' : '💾 Save' }} Request</button>
      </div>

    </div>
  </form>
</div>