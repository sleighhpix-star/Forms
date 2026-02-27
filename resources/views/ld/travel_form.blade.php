@php
  $record ??= null;
  $isEdit = isset($record) && $record?->id;
  $action = $isEdit
    ? route('ld.travel.update', $record->id)
    : route('ld.travel.store');
@endphp

<style>
.sig-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1rem; margin-top:.5rem; }
.sig-box { border:1px solid #e5e7eb; border-radius:10px; padding:.75rem 1rem; background:#fafafa; transition:border-color .15s,background .15s; }
.sig-box:focus-within { border-color:var(--maroon); background:#fff; }
.sig-role { font-size:.68rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.5pt; margin-bottom:.45rem; }
.sig-field-wrap { position:relative; }
.sig-name-input { width:100%; border:none; border-bottom:1.5px dashed #d1d5db; background:transparent; font-size:.85rem; font-weight:700; color:#111827; padding:.15rem 1.4rem .15rem 0; outline:none; font-family:inherit; transition:border-color .15s; }
.sig-name-input:focus { border-bottom-color:var(--maroon); border-bottom-style:solid; }
.sig-pos-input { width:100%; border:none; border-bottom:1px dashed #e5e7eb; background:transparent; font-size:.72rem; color:#6b7280; padding:.15rem 1.4rem .15rem 0; outline:none; font-family:inherit; margin-top:.3rem; transition:border-color .15s; }
.sig-pos-input:focus { border-bottom-color:var(--maroon); border-bottom-style:solid; }
.sig-edit-icon { position:absolute; right:0; top:50%; transform:translateY(-50%); font-size:.65rem; color:#d1d5db; pointer-events:none; }
.sig-box:focus-within .sig-edit-icon { color:var(--maroon); }
.sig-reset-btn { margin-top:.5rem; font-size:.65rem; color:#9ca3af; background:none; border:none; cursor:pointer; padding:0; text-decoration:underline; }
.sig-reset-btn:hover { color:var(--maroon); }

.emp-table { width:100%; border-collapse:collapse; font-size:.82rem; }
.emp-table th { background:#f3f4f6; padding:.4rem .6rem; text-align:left; font-size:.7rem; font-weight:700; color:#6b7280; text-transform:uppercase; border-bottom:2px solid #e5e7eb; }
.emp-table td { padding:.3rem .4rem; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
.emp-table input, .emp-table textarea { width:100%; border:1.5px solid #e5e7eb; border-radius:6px; padding:.3rem .5rem; font-size:.8rem; font-family:inherit; outline:none; background:#fff; resize:none; }
.emp-table input:focus, .emp-table textarea:focus { border-color:var(--maroon); }
.emp-del-btn { background:none; border:none; color:#ef4444; cursor:pointer; font-size:.9rem; padding:.2rem .4rem; border-radius:5px; }
.emp-del-btn:hover { background:#fef2f2; }
.btn-add-emp { display:inline-flex; align-items:center; gap:.35rem; margin-top:.6rem;
  background:#fff; border:1.5px dashed #d1d5db; border-radius:7px;
  padding:.35rem .85rem; font-size:.78rem; font-weight:600; color:#6b7280; cursor:pointer; }
.btn-add-emp:hover { border-color:var(--maroon); color:var(--maroon); background:#fdf2f2; }
</style>

<div class="page" style="max-width:880px">
  <form action="{{ $action }}" method="POST" id="travel-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="card">

      {{-- ══ EMPLOYEES ══ --}}
      <div class="card-section">
        <div class="section-label">Employee/s Information</div>
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
            <input type="text" name="travel_dates"
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