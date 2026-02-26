@php
  $employmentStatuses = ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'];
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

<div class="page" style="max-width:880px">
  <form action="{{ route('ld.store') }}" method="POST" id="ld-form">
    @csrf

    <div class="card">

      {{-- ══ PARTICIPANT INFORMATION ══ --}}
      <div class="card-section">
        <div class="section-label">Participant Information</div>

        <div class="field-grid cols-2">

          <div class="field span-2 {{ $errors->has('participant_name') ? 'has-error' : '' }}">
            <label for="participant_name">Name of Participant <span class="req">*</span></label>
            <input type="text" id="participant_name" name="participant_name"
                   value="{{ old('participant_name') }}"
                   placeholder="Last Name, First Name, Middle Name">
            @error('participant_name')
              <span class="field-error">{{ $message }}</span>
            @enderror
          </div>

          <div class="field {{ $errors->has('campus') ? 'has-error' : '' }}">
            <label for="campus">Campus / Operating Unit <span class="req">*</span></label>
            <input type="text" id="campus" name="campus"
                   value="{{ old('campus') }}"
                   placeholder="e.g. Alangilan Campus">
            @error('campus') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          <div class="field {{ $errors->has('employment_status') ? 'has-error' : '' }}">
            <label for="employment_status">Employment Status <span class="req">*</span></label>
            <select id="employment_status" name="employment_status">
              <option value="">— Select —</option>
              @foreach($employmentStatuses as $status)
                <option value="{{ $status }}" {{ old('employment_status') === $status ? 'selected' : '' }}>
                  {{ $status }}
                </option>
              @endforeach
            </select>
            @error('employment_status') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          <div class="field {{ $errors->has('college_office') ? 'has-error' : '' }}">
            <label for="college_office">College / Office <span class="req">*</span></label>
            <input type="text" id="college_office" name="college_office"
                   value="{{ old('college_office') }}"
                   placeholder="e.g. College of Engineering">
            @error('college_office') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          <div class="field {{ $errors->has('position') ? 'has-error' : '' }}">
            <label for="position">Academic Rank / Position / Designation <span class="req">*</span></label>
            <input type="text" id="position" name="position"
                   value="{{ old('position') }}"
                   placeholder="e.g. Assistant Professor II">
            @error('position') <span class="field-error">{{ $message }}</span> @enderror
          </div>

        </div>
      </div>

      {{-- ══ INTERVENTION DETAILS ══ --}}
      <div class="card-section">
        <div class="section-label">Intervention Details</div>

        <div class="field-grid">

          <div class="field {{ $errors->has('title') ? 'has-error' : '' }}">
            <label for="title">Title of Intervention <span class="req">*</span></label>
            <input type="text" id="title" name="title"
                   value="{{ old('title') }}"
                   placeholder="Full title of the training / seminar / conference">
            @error('title') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Type of Intervention --}}
          <div class="field {{ $errors->has('types') ? 'has-error' : '' }}">
            <label>Type of Intervention <span class="req">*</span></label>
            <div class="check-group">
              @foreach($types as $type)
                <label class="check-item">
                  <input type="checkbox" name="types[]" value="{{ $type }}"
                    {{ in_array($type, old('types', [])) ? 'checked' : '' }}>
                  <span>{{ $type }}</span>
                </label>
              @endforeach
              <label class="check-item">
                <input type="checkbox" id="type_others_chk"
                  {{ old('type_others') ? 'checked' : '' }}>
                <span>Others:</span>
              </label>
              <input type="text" class="others-input" name="type_others" id="type_others_txt"
                     value="{{ old('type_others') }}" placeholder="specify..."
                     {{ old('type_others') ? '' : 'disabled' }}>
            </div>
            @error('types') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Level --}}
          <div class="field {{ $errors->has('level') ? 'has-error' : '' }}">
            <label>Level <span class="req">*</span></label>
            <div class="check-group">
              @foreach($levels as $level)
                <label class="check-item">
                  <input type="radio" name="level" value="{{ $level }}"
                    {{ old('level') === $level ? 'checked' : '' }}>
                  <span>{{ $level }}</span>
                </label>
              @endforeach
            </div>
            @error('level') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Nature of Participation --}}
          <div class="field {{ $errors->has('natures') ? 'has-error' : '' }}">
            <label>Nature of Participation <span class="req">*</span></label>
            <div class="check-group">
              @foreach($natures as $nature)
                <label class="check-item">
                  <input type="checkbox" name="natures[]" value="{{ $nature }}"
                    {{ in_array($nature, old('natures', [])) ? 'checked' : '' }}>
                  <span>{{ $nature }}</span>
                </label>
              @endforeach
              <label class="check-item">
                <input type="checkbox" id="nature_others_chk"
                  {{ old('nature_others') ? 'checked' : '' }}>
                <span>Others:</span>
              </label>
              <input type="text" class="others-input" name="nature_others" id="nature_others_txt"
                     value="{{ old('nature_others') }}" placeholder="specify..."
                     {{ old('nature_others') ? '' : 'disabled' }}>
            </div>
            @error('natures') <span class="field-error">{{ $message }}</span> @enderror
          </div>

          {{-- Competency --}}
          <div class="field">
            <label for="competency">
              Competency/ies to be Developed / Enhanced
              <span class="hint">(if participating as a learner)</span>
            </label>
            <textarea id="competency" name="competency"
                      placeholder="Describe the competencies to be developed or enhanced...">{{ old('competency') }}</textarea>
          </div>

          {{-- Date / Hours / Venue / Organizer --}}
          <div class="field-grid cols-2">
            <div class="field {{ $errors->has('intervention_date') ? 'has-error' : '' }}">
              <label for="intervention_date">Date <span class="req">*</span></label>
              <input type="text" id="intervention_date" name="intervention_date"
                     value="{{ old('intervention_date') }}"
                     placeholder="e.g. March 5–7, 2026">
              @error('intervention_date') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field {{ $errors->has('hours') ? 'has-error' : '' }}">
              <label for="hours">Actual No. of Hours</label>
              <input type="number" id="hours" name="hours" min="1"
                     value="{{ old('hours') }}" placeholder="e.g. 24">
              @error('hours') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field {{ $errors->has('venue') ? 'has-error' : '' }}">
              <label for="venue">Venue <span class="req">*</span></label>
              <input type="text" id="venue" name="venue"
                     value="{{ old('venue') }}" placeholder="City, Venue name">
              @error('venue') <span class="field-error">{{ $message }}</span> @enderror
            </div>

            <div class="field {{ $errors->has('organizer') ? 'has-error' : '' }}">
              <label for="organizer">Sponsor Agency / Organizer <span class="req">*</span></label>
              <input type="text" id="organizer" name="organizer"
                     value="{{ old('organizer') }}" placeholder="Name of organizing body">
              @error('organizer') <span class="field-error">{{ $message }}</span> @enderror
            </div>
          </div>

        </div>
      </div>

      {{-- ══ ASSESSMENT QUESTIONS ══ --}}
      <div class="card-section">
        <div class="section-label">Assessment Questions</div>

        @php
          $yesNoFields = [
            ['name' => 'endorsed_by_org',    'label' => 'Endorsed by a recognized or registered professional organization?'],
            ['name' => 'related_to_field',   'label' => "Related to the participant's current field/workload?"],
            ['name' => 'has_pending_ldap',   'label' => 'Has pending implementation of Learning and Development Application Plan? <small style="color:var(--gray-500)">(If yes, attach BatStateU-FO-HRD-30)</small>'],
            ['name' => 'has_cash_advance',   'label' => 'Has any unliquidated cash advance?'],
          ];
        @endphp

        @foreach($yesNoFields as $field)
          <div class="yn-row">
            <div>{!! $field['label'] !!}</div>
            <div class="yn-opts">
              <label>
                <input type="radio" name="{{ $field['name'] }}" value="1"
                  {{ old($field['name']) == '1' ? 'checked' : '' }}> Yes
              </label>
              <label>
                <input type="radio" name="{{ $field['name'] }}" value="0"
                  {{ old($field['name'], '0') == '0' ? 'checked' : '' }}> No
              </label>
            </div>
          </div>
        @endforeach

        {{-- Financial question --}}
        <div class="yn-row">
          <div>Is financial assistance requested from the University?</div>
          <div class="yn-opts">
            <label>
              <input type="radio" name="financial_requested" value="1" id="fin_yes"
                {{ old('financial_requested') == '1' ? 'checked' : '' }}
                onchange="toggleFinance(true)"> Yes
            </label>
            <label>
              <input type="radio" name="financial_requested" value="0" id="fin_no"
                {{ old('financial_requested', '0') == '0' ? 'checked' : '' }}
                onchange="toggleFinance(false)"> No
            </label>
          </div>
        </div>

        {{-- Financial details --}}
        <div class="fin-box" id="fin_section"
             style="{{ old('financial_requested') == '1' ? '' : 'display:none' }}">

          <div class="field-grid cols-2" style="margin-bottom:.85rem">
            <div class="field {{ $errors->has('amount_requested') ? 'has-error' : '' }}">
              <label for="amount_requested">Total Amount Requested (₱) <span class="req">*</span></label>
              <input type="number" id="amount_requested" name="amount_requested"
                     min="0" step="0.01"
                     value="{{ old('amount_requested') }}" placeholder="0.00">
              @error('amount_requested') <span class="field-error">{{ $message }}</span> @enderror
            </div>
          </div>

          <div class="field">
            <label>Coverage</label>
            <div class="check-group">
              @foreach($coverage as $key => $label)
                <label class="check-item">
                  <input type="checkbox" name="coverage[]" value="{{ $key }}"
                    {{ in_array($key, old('coverage', [])) ? 'checked' : '' }}>
                  <span>{{ $label }}</span>
                </label>
              @endforeach
              <label class="check-item">
                <input type="checkbox" id="cov_others_chk"
                  {{ old('coverage_others') ? 'checked' : '' }}>
                <span>Others:</span>
              </label>
              <input type="text" class="others-input" name="coverage_others" id="cov_others_txt"
                     value="{{ old('coverage_others') }}" placeholder="specify..."
                     {{ old('coverage_others') ? '' : 'disabled' }}>
            </div>
          </div>

        </div>
      </div>

      {{-- ══ SIGNATORIES ══ --}}
      <div class="card-section">
        <div class="section-label">Signatories</div>

        <div class="sig-grid">
          <div class="sig-box">
            <div class="sig-role">Requested by</div>
            <div class="sig-name">Dr. Bryan John A. Magoling</div>
            <div class="sig-position">Director, Research Management Services</div>
          </div>

          <div class="sig-box">
            <div class="sig-role">Reviewed by</div>
            <div class="sig-name">Engr. Albertson D. Amante</div>
            <div class="sig-position">VP for Research, Development and Extension Services</div>
          </div>

          <div class="sig-box">
            <div class="sig-role">Recommending Approval</div>
            <div class="sig-name">Atty. Noel Alberto S. Omandap</div>
            <div class="sig-position">VP for Administration and Finance</div>
          </div>

          <div class="sig-box">
            <div class="sig-role">Approved by</div>
            <div class="sig-name">Dr. Tirso A. Ronquillo</div>
            <div class="sig-position">University President</div>
          </div>
        </div>

        <p class="text-muted text-xs mt-2" style="line-height:1.7">
          <strong>Required Attachments:</strong>
          (1) Official endorsement/invitation from professional organization;
          (2) Program of activities;
          (3) Signed itinerary of travel, if requesting financial support;
          (4) L&D Application Plan, if attending as learner.
        </p>
      </div>

      {{-- Actions --}}
      <div class="form-actions">
        <button type="button" onclick="closeCreateModal()" class="btn btn-ghost">Cancel</button>
        <button type="reset" class="btn btn-outline">Clear</button>
        <button type="submit" class="btn btn-primary">💾 Save Request</button>
      </div>

    </div>{{-- /card --}}
  </form>
</div>