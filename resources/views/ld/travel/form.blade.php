@php
  $record ??= null;
  $isEdit = isset($record) && $record?->id;
  $action = $isEdit
    ? route('ld.travel.update', $record->id)
    : route('ld.travel.store');
@endphp



<div class="page" style="max-width:880px">
  <form action="{{ $action }}" method="POST" id="travel-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="card">

      {{-- ══ EMPLOYEES ══ --}}
      <div class="card-section">
        <div class="section-label">Employee/s Information</div>

        <div class="field-grid cols-2" style="margin-bottom:1.25rem;">
          <div class="field {{ $errors->has('tracking_number') ? 'has-error' : '' }}">
            <label for="tracking_number">Tracking Number <span class="hint">(optional)</span></label>
            <input type="text" id="tracking_number" name="tracking_number"
                   value="{{ old('tracking_number', $record?->tracking_number) }}"
                   placeholder="Auto-generated if empty"
                   style="max-width:260px;">
            @error('tracking_number') <span class="field-error">{{ $message }}</span> @enderror
          </div>
        </div>

        <p class="text-muted text-xs" style="margin-bottom:.75rem;">Add one row per employee. For single traveller, one row is enough.</p>

        @php
          // Parse existing employee_names / positions (newline-delimited) into rows
          $empNames = array_filter(explode("\n", old('employee_names', $record?->employee_names ?? '')));
          $empPositions = array_filter(explode("\n", old('positions', $record?->positions ?? '')));
          if (empty($empNames)) { $empNames = ['']; $empPositions = ['']; }
        @endphp

        <div style="overflow-x:auto;">
          <table class="emp-table">
            <thead>
              <tr>
                <th style="min-width:220px;">Name <span class="req">*</span></th>
                <th style="min-width:200px;">Position / Designation</th>
                <th style="width:36px;"></th>
              </tr>
            </thead>
            <tbody id="emp-body">
              @foreach($empNames as $idx => $name)
              <tr class="emp-row">
                <td><input type="text" name="emp_names[]" value="{{ trim($name) }}" placeholder="Last Name, First Name M.I." required></td>
                <td><input type="text" name="emp_positions[]" value="{{ trim($empPositions[$idx] ?? '') }}" placeholder="e.g. Assistant Professor II"></td>
                <td><button type="button" class="emp-del-btn" onclick="removeEmpRow(this)" title="Remove">✕</button></td>
              </tr>
              @endforeach
            </tbody>
          </table>
        </div>
        <button type="button" class="btn-add-emp" onclick="addEmpRow()">＋ Add Employee</button>

        {{-- Hidden fields that get populated on submit --}}
        <input type="hidden" name="employee_names" id="hidden-emp-names">
        <input type="hidden" name="positions" id="hidden-emp-positions">
      </div>

      {{-- ══ TRAVEL DETAILS ══ --}}
      <div class="card-section">
        <div class="section-label">Travel Details</div>
        <div class="field-grid cols-2">




          <div class="field">
            <label>Date/s of Travel <span class="req">*</span></label>
                 <input type="text" name="travel_dates" class="date-picker-range"
                   value="{{ old('travel_dates', $record?->travel_dates) }}"
                   placeholder="e.g. March 13–15, 2026" required>
          </div>

          <div class="field">
            <label>Time</label>
            <input type="text" name="travel_time"
                   value="{{ old('travel_time', $record?->travel_time) }}"
                   placeholder="e.g. 7:00 AM – 6:00 PM">
          </div>

          <div class="field span-2">
            <label>Place/s to be Visited <span class="req">*</span></label>
            <input type="text" name="places_visited"
                   value="{{ old('places_visited', $record?->places_visited) }}"
                   placeholder="e.g. Manila, Metro Manila" required>
          </div>

          <div class="field span-2">
            <label>Purpose of Travel <span class="req">*</span></label>
            <textarea name="purpose" placeholder="Describe the purpose of travel..." required>{{ old('purpose', $record?->purpose) }}</textarea>
          </div>

          <div class="field span-2">
            <label>Chargeable Against</label>
            <input type="text" name="chargeable_against"
                   value="{{ old('chargeable_against', $record?->chargeable_against) }}"
                   placeholder="e.g. N/A, Research Fund, GAA">
          </div>

        </div>
      </div>

      {{-- ══ SIGNATORIES ══ --}}
      @php
        $signatories = [
          ['role'=>'Requested by',         'name_field'=>'sig_requested_name',        'position_field'=>'sig_requested_position',        'default_name'=>'Dr. Bryan John A. Magoling',       'default_pos'=>'Director, Research Management Services'],
          ['role'=>'Reviewed by',          'name_field'=>'sig_reviewed_name',         'position_field'=>'sig_reviewed_position',         'default_name'=>'Engr. Albertson D. Amante',        'default_pos'=>'VP for Research, Development and Extension Services'],
          ['role'=>'Recommending Approval','name_field'=>'sig_recommending_name',     'position_field'=>'sig_recommending_position',     'default_name'=>'Atty. Noel Alberto S. Omandap',    'default_pos'=>'VP for Administration and Finance'],
          ['role'=>'Approved by',          'name_field'=>'sig_approved_name',         'position_field'=>'sig_approved_position',         'default_name'=>'Dr. Tirso A. Ronquillo',           'default_pos'=>'University President'],
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
            <button type="button" class="sig-reset-btn" onclick="resetSignatory(this)">↺ Reset to default</button>
          </div>
          @endforeach
        </div>
      </div>

      <div class="form-actions">
        <button type="button" onclick="closeModal('genericFormModal')" class="btn btn-ghost">Cancel</button>
        <button type="reset" class="btn btn-outline" onclick="document.querySelectorAll('#travel-form [data-default]').forEach(i=>i.value=i.dataset.default)">Clear</button>
        <button type="submit" class="btn btn-primary">💾 {{ $isEdit ? 'Update' : 'Save' }} Request</button>
      </div>

    </div>
  </form>
</div>

<script>
function addEmpRow() {
  const tbody = document.getElementById('emp-body');
  const row = document.createElement('tr');
  row.className = 'emp-row';
  row.innerHTML = `
    <td><input type="text" name="emp_names[]" placeholder="Last Name, First Name M.I." required></td>
    <td><input type="text" name="emp_positions[]" placeholder="e.g. Assistant Professor II"></td>
    <td><button type="button" class="emp-del-btn" onclick="removeEmpRow(this)" title="Remove">✕</button></td>
  `;
  tbody.appendChild(row);
  row.querySelector('input').focus();
}

function removeEmpRow(btn) {
  const rows = document.querySelectorAll('#emp-body .emp-row');
  if (rows.length <= 1) return; // keep at least one row
  btn.closest('tr').remove();
}

// On submit: flatten employee rows into newline-delimited hidden fields
document.getElementById('travel-form').addEventListener('submit', function() {
  const names     = [...document.querySelectorAll('#emp-body [name="emp_names[]"]')].map(i => i.value.trim()).filter(Boolean);
  const positions = [...document.querySelectorAll('#emp-body [name="emp_positions[]"]')].map(i => i.value.trim());
  document.getElementById('hidden-emp-names').value     = names.join('\n');
  document.getElementById('hidden-emp-positions').value = positions.join('\n');
});

function resetSignatory(btn) {
  btn.closest('.sig-box').querySelectorAll('[data-default]').forEach(i => i.value = i.dataset.default);
}
</script>