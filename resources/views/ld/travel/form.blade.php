@php
  $record ??= null;
  $isEdit = isset($record) && $record?->id;
  $action = $isEdit
    ? route('ld.travel.update', $record->id)
    : route('ld.travel.store');
@endphp

<style>
.rte-wrap {
  border: 1px solid #d1d5db;
  border-radius: 6px;
  overflow: hidden;
}
.rte-toolbar {
  display: flex;
  gap: 2px;
  padding: 4px 6px;
  background: #f9fafb;
  border-bottom: 1px solid #e5e7eb;
}
.rte-btn {
  background: none;
  border: 1px solid transparent;
  border-radius: 4px;
  padding: 2px 8px;
  font-size: .85rem;
  cursor: pointer;
  color: #374151;
  line-height: 1.6;
  transition: background .12s, border-color .12s;
}
.rte-btn:hover {
  background: #e5e7eb;
  border-color: #d1d5db;
}
.rte-btn.active {
  background: #dbeafe;
  border-color: #93c5fd;
  color: #1d4ed8;
}
.rte-editor {
  min-height: 90px;
  padding: 8px 10px;
  font-size: .92rem;
  font-family: inherit;
  outline: none;
  line-height: 1.6;
  color: inherit;
}
.rte-editor:empty::before {
  content: attr(data-placeholder);
  color: #9ca3af;
  pointer-events: none;
}
</style>

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
                   placeholder="e.g. March 13-15, 2026" required>
          </div>

          <div class="field">
            <label>Time</label>
            <input type="text" name="travel_time"
                   value="{{ old('travel_time', $record?->travel_time) }}"
                   placeholder="e.g. 7:00 AM - 6:00 PM">
          </div>

          {{-- ══ PLACES ══ --}}
          <div class="field span-2">
            <label>Place/s to be Visited <span class="req">*</span></label>

            @php
              $places = array_filter(explode("\n", old('places_visited', $record?->places_visited ?? '')));
              if (empty($places)) { $places = ['']; }
            @endphp

            <div style="overflow-x:auto; margin-top:.5rem;">
              <table class="emp-table">
                <thead>
                  <tr>
                    <th>Place / Venue <span class="req">*</span></th>
                    <th style="width:36px;"></th>
                  </tr>
                </thead>
                <tbody id="places-body">
                  @foreach($places as $place)
                  <tr class="place-row">
                    <td><input type="text" name="place_items[]" value="{{ trim($place) }}" placeholder="e.g. Manila, Metro Manila" required></td>
                    <td><button type="button" class="emp-del-btn" onclick="removePlaceRow(this)" title="Remove">✕</button></td>
                  </tr>
                  @endforeach
                </tbody>
              </table>
            </div>
            <button type="button" class="btn-add-emp" onclick="addPlaceRow()">+ Add Place</button>

            <input type="hidden" name="places_visited" id="hidden-places">
          </div>

          {{-- ══ PURPOSE (rich text) ══ --}}
          <div class="field span-2">
            <label>Purpose of Travel <span class="req">*</span></label>
            <div class="rte-wrap">
              <div class="rte-toolbar">
                <button type="button" class="rte-btn" id="rte-bold"
                        onmousedown="event.preventDefault(); rteExec('bold')" title="Bold"><b>B</b></button>
                <button type="button" class="rte-btn" id="rte-italic"
                        onmousedown="event.preventDefault(); rteExec('italic')" title="Italic"><i>I</i></button>
                <button type="button" class="rte-btn" id="rte-underline"
                        onmousedown="event.preventDefault(); rteExec('underline')" title="Underline"><u>U</u></button>
              </div>
              <div id="purpose-editor"
                   class="rte-editor"
                   contenteditable="true"
                   data-placeholder="Describe the purpose of travel...">{!! old('purpose', $record?->purpose) !!}</div>
            </div>
            <input type="hidden" name="purpose" id="hidden-purpose">
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
          ['role'=>'Reviewed by',          'name_field'=>'sig_reviewed_name',         'position_field'=>'sig_reviewed_position',         'default_name'=>'Engr. Albertson D. Amante',        'default_pos'=>'Vice President for Research, Development and Extension Services'],
          ['role'=>'Recommending Approval','name_field'=>'sig_recommending_name',     'position_field'=>'sig_recommending_position',     'default_name'=>'Atty. Noel Alberto S. Omandap',    'default_pos'=>'Vice President for Administration and Finance'],
          ['role'=>'Approved by',          'name_field'=>'sig_approved_name',         'position_field'=>'sig_approved_position',         'default_name'=>'Dr. Tirso A. Ronquillo',           'default_pos'=>'University President'],
        ];
      @endphp
      <div class="card-section">
        <div class="section-label">Signatories <span style="font-size:.68rem;font-weight:400;color:#9ca3af;margin-left:.5rem;">- pre-filled with standard names, click any field to edit</span></div>
        <div class="sig-grid">
          @foreach($signatories as $sig)
          <div class="sig-box">
            <div class="sig-role">{{ $sig['role'] }}</div>
            <div class="sig-field-wrap">
              <input type="text" class="sig-name-input" name="{{ $sig['name_field'] }}"
                     value="{{ old($sig['name_field'], $record?->{$sig['name_field']} ?? $sig['default_name']) }}"
                     data-default="{{ $sig['default_name'] }}">
              <span class="sig-edit-icon">pencil</span>
            </div>
            <div class="sig-field-wrap">
              <input type="text" class="sig-pos-input" name="{{ $sig['position_field'] }}"
                     value="{{ old($sig['position_field'], $record?->{$sig['position_field']} ?? $sig['default_pos']) }}"
                     data-default="{{ $sig['default_pos'] }}">
              <span class="sig-edit-icon" style="font-size:.55rem;">pencil</span>
            </div>
            <button type="button" class="sig-reset-btn" onclick="resetSignatory(this)">Reset to default</button>
          </div>
          @endforeach
        </div>
      </div>

      <div class="form-actions">
        <button type="button" onclick="closeModal('gFormModal')" class="btn btn-ghost">Cancel</button>
        <button type="reset" class="btn btn-outline"
                onclick="document.querySelectorAll('#travel-form [data-default]').forEach(i=>i.value=i.dataset.default); document.getElementById('purpose-editor').innerHTML='';">Clear</button>
        <button type="submit" class="btn btn-primary">{{ $isEdit ? 'Update' : 'Save' }} Request</button>
      </div>

    </div>
  </form>
</div>

<script>
/* ── Employees ── */
function addEmpRow() {
  const tbody = document.getElementById('emp-body');
  const row = document.createElement('tr');
  row.className = 'emp-row';
  row.innerHTML = `
    <td><input type="text" name="emp_names[]" placeholder="Last Name, First Name M.I." required></td>
    <td><input type="text" name="emp_positions[]" placeholder="e.g. Assistant Professor II"></td>
    <td><button type="button" class="emp-del-btn" onclick="removeEmpRow(this)" title="Remove">X</button></td>
  `;
  tbody.appendChild(row);
  row.querySelector('input').focus();
}

function removeEmpRow(btn) {
  const rows = document.querySelectorAll('#emp-body .emp-row');
  if (rows.length <= 1) return;
  btn.closest('tr').remove();
}

/* ── Places ── */
function addPlaceRow() {
  const tbody = document.getElementById('places-body');
  const row = document.createElement('tr');
  row.className = 'place-row';
  row.innerHTML = `
    <td><input type="text" name="place_items[]" placeholder="e.g. Batangas City, Batangas" required></td>
    <td><button type="button" class="emp-del-btn" onclick="removePlaceRow(this)" title="Remove">X</button></td>
  `;
  tbody.appendChild(row);
  row.querySelector('input').focus();
}

function removePlaceRow(btn) {
  const rows = document.querySelectorAll('#places-body .place-row');
  if (rows.length <= 1) return;
  btn.closest('tr').remove();
}

/* ── Rich text editor ── */
function rteExec(cmd) {
  document.execCommand(cmd, false, null);
  updateRteToolbar();
  document.getElementById('purpose-editor').focus();
}

function updateRteToolbar() {
  document.getElementById('rte-bold').classList.toggle('active', document.queryCommandState('bold'));
  document.getElementById('rte-italic').classList.toggle('active', document.queryCommandState('italic'));
  document.getElementById('rte-underline').classList.toggle('active', document.queryCommandState('underline'));
}

const editor = document.getElementById('purpose-editor');
editor.addEventListener('keyup', updateRteToolbar);
editor.addEventListener('mouseup', updateRteToolbar);
document.addEventListener('selectionchange', function() {
  if (document.activeElement === editor) updateRteToolbar();
});

/* ── On submit ── */
document.getElementById('travel-form').addEventListener('submit', function(e) {
  // Validate purpose not empty
  if (!editor.innerText.trim()) {
    e.preventDefault();
    editor.style.outline = '2px solid #ef4444';
    editor.focus();
    return;
  }
  editor.style.outline = '';

  // Employees
  const names     = [...document.querySelectorAll('#emp-body [name="emp_names[]"]')].map(i => i.value.trim()).filter(Boolean);
  const positions = [...document.querySelectorAll('#emp-body [name="emp_positions[]"]')].map(i => i.value.trim());
  document.getElementById('hidden-emp-names').value     = names.join('\n');
  document.getElementById('hidden-emp-positions').value = positions.join('\n');

  // Places
  const places = [...document.querySelectorAll('#places-body [name="place_items[]"]')].map(i => i.value.trim()).filter(Boolean);
  document.getElementById('hidden-places').value = places.join('\n');

  // Purpose HTML (preserves bold/italic/underline tags)
  document.getElementById('hidden-purpose').value = editor.innerHTML;
});

/* ── Signatories ── */
function resetSignatory(btn) {
  btn.closest('.sig-box').querySelectorAll('[data-default]').forEach(i => i.value = i.dataset.default);
}
</script>