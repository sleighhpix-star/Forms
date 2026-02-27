@php
  $record ??= null;
  $activityTypes = ['Seminar/Training', 'Meeting', 'Seminar/Conference', 'Accreditation', 'Program'];
  $isEdit = isset($record) && $record?->id;
  $action = $isEdit
    ? route('ld.reimbursement.update', $record->id)
    : route('ld.reimbursement.store');
  $existingItems = old('payees')
    ? collect(old('payees'))->map(fn($p,$i) => [
        'payee'       => $p,
        'description' => old('descriptions')[$i] ?? '',
        'quantity'    => old('quantities')[$i] ?? '',
        'unit_cost'   => old('unit_costs')[$i] ?? '',
        'amount'      => old('amounts')[$i] ?? '',
      ])->values()->all()
    : ($record?->expense_items ?? [['payee'=>'','description'=>'','quantity'=>'','unit_cost'=>'','amount'=>'']]);
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

/* Expense table */
.expense-table { width:100%; border-collapse:collapse; font-size:.82rem; }
.expense-table th { background:#f3f4f6; padding:.4rem .6rem; text-align:left; font-size:.7rem; font-weight:700; color:#6b7280; text-transform:uppercase; border-bottom:2px solid #e5e7eb; white-space:nowrap; }
.expense-table td { padding:.3rem .4rem; border-bottom:1px solid #f3f4f6; vertical-align:middle; }
.expense-table input { width:100%; border:1.5px solid #e5e7eb; border-radius:6px; padding:.3rem .5rem; font-size:.8rem; font-family:inherit; outline:none; background:#fff; }
.expense-table input:focus { border-color:var(--maroon); }
.expense-table input[type=number] { text-align:right; }
.expense-table .amt-cell { font-weight:600; color:#111827; text-align:right; min-width:90px; }
.expense-table .del-btn { background:none; border:none; color:#ef4444; cursor:pointer; font-size:.9rem; padding:.2rem .4rem; border-radius:5px; }
.expense-table .del-btn:hover { background:#fef2f2; }
.expense-total-row td { padding:.5rem .6rem; font-weight:700; border-top:2px solid #e5e7eb; background:#f9fafb; }
.btn-add-row { display:inline-flex; align-items:center; gap:.35rem; margin-top:.6rem;
  background:#fff; border:1.5px dashed #d1d5db; border-radius:7px;
  padding:.35rem .85rem; font-size:.78rem; font-weight:600; color:#6b7280; cursor:pointer; }
.btn-add-row:hover { border-color:var(--maroon); color:var(--maroon); background:#fdf2f2; }
</style>

<div class="page" style="max-width:960px">
  <form action="{{ $action }}" method="POST" id="reimbursement-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="card">

      {{-- ══ REQUEST DETAILS ══ --}}
      <div class="card-section">
        <div class="section-label">Request Details</div>
        <div class="field-grid cols-2">

          <div class="field span-2">
            <label>Department / Office <span class="req">*</span></label>
            <input type="text" name="department"
                   value="{{ old('department', $record?->department) }}"
                   placeholder="e.g. Research Management Services" required>
          </div>

          <div class="field span-2">
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
                <input type="checkbox" id="rei_type_others_chk" {{ old('activity_type_others', $record?->activity_type_others) ? 'checked' : '' }}>
                <span>Others:</span>
              </label>
              <input type="text" class="others-input" name="activity_type_others" id="rei_type_others_txt"
                     value="{{ old('activity_type_others', $record?->activity_type_others) }}" placeholder="specify..."
                     {{ old('activity_type_others', $record?->activity_type_others) ? '' : 'disabled' }}>
            </div>
          </div>

          <div class="field">
            <label>Venue</label>
            <input type="text" name="venue"
                   value="{{ old('venue', $record?->venue) }}" placeholder="Venue of activity">
          </div>

          <div class="field">
            <label>Date of Activity</label>
            <input type="text" name="activity_date"
                   value="{{ old('activity_date', $record?->activity_date) }}" placeholder="e.g. March 5, 2026">
          </div>

          <div class="field span-2">
            <label>Reason for Reimbursement</label>
            <textarea name="reason" placeholder="Explain why reimbursement is being requested...">{{ old('reason', $record?->reason) }}</textarea>
          </div>

          <div class="field span-2">
            <label>Remarks</label>
            <textarea name="remarks" placeholder="Additional remarks (optional)..." style="min-height:2.5rem;">{{ old('remarks', $record?->remarks) }}</textarea>
          </div>

        </div>
      </div>

      {{-- ══ EXPENSE ITEMS ══ --}}
      <div class="card-section">
        <div class="section-label">Expense Items</div>

        <div style="overflow-x:auto;">
          <table class="expense-table" id="expense-table">
            <thead>
              <tr>
                <th style="min-width:130px;">Payee</th>
                <th style="min-width:180px;">Description / Particulars</th>
                <th style="min-width:60px;">Qty</th>
                <th style="min-width:100px;">Unit Cost (₱)</th>
                <th style="min-width:110px;">Amount (₱)</th>
                <th style="width:36px;"></th>
              </tr>
            </thead>
            <tbody id="expense-body">
              @foreach($existingItems as $idx => $item)
              <tr class="expense-row">
                <td><input type="text" name="payees[]" value="{{ $item['payee'] ?? '' }}" placeholder="Payee name"></td>
                <td><input type="text" name="descriptions[]" value="{{ $item['description'] ?? '' }}" placeholder="Description"></td>
                <td><input type="number" name="quantities[]" value="{{ $item['quantity'] ?? '' }}" min="0" step="any" placeholder="0" oninput="calcRow(this)"></td>
                <td><input type="number" name="unit_costs[]" value="{{ $item['unit_cost'] ?? '' }}" min="0" step="0.01" placeholder="0.00" oninput="calcRow(this)"></td>
                <td><input type="number" name="amounts[]" value="{{ $item['amount'] ?? '' }}" min="0" step="0.01" placeholder="0.00" class="row-amount" oninput="updateTotal()"></td>
                <td><button type="button" class="del-btn" onclick="removeExpenseRow(this)" title="Remove row">✕</button></td>
              </tr>
              @endforeach
            </tbody>
            <tfoot>
              <tr class="expense-total-row">
                <td colspan="4" style="text-align:right;color:#6b7280;">Total Amount:</td>
                <td class="amt-cell" id="expense-total">₱ 0.00</td>
                <td></td>
              </tr>
            </tfoot>
          </table>
        </div>

        <button type="button" class="btn-add-row" onclick="addExpenseRow()">＋ Add Row</button>
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
        <button type="reset" class="btn btn-outline" onclick="document.querySelectorAll('#reimbursement-form [data-default]').forEach(i=>i.value=i.dataset.default)">Clear</button>
        <button type="submit" class="btn btn-primary">💾 {{ $isEdit ? 'Update' : 'Save' }} Request</button>
      </div>

    </div>
  </form>
</div>

<script>
// ── "Others" checkbox toggles
document.getElementById('rei_type_others_chk')?.addEventListener('change', function() {
  const t = document.getElementById('rei_type_others_txt');
  t.disabled = !this.checked; if (!this.checked) t.value = '';
});

// ── Expense row auto-calculate
function calcRow(input) {
  const row = input.closest('tr');
  const qty  = parseFloat(row.querySelector('[name="quantities[]"]').value) || 0;
  const uc   = parseFloat(row.querySelector('[name="unit_costs[]"]').value) || 0;
  if (qty > 0 && uc > 0) {
    row.querySelector('[name="amounts[]"]').value = (qty * uc).toFixed(2);
  }
  updateTotal();
}

function updateTotal() {
  let total = 0;
  document.querySelectorAll('#expense-body [name="amounts[]"]').forEach(inp => {
    total += parseFloat(inp.value) || 0;
  });
  document.getElementById('expense-total').textContent = '₱ ' + total.toLocaleString('en-PH', { minimumFractionDigits: 2 });
}

function addExpenseRow() {
  const tbody = document.getElementById('expense-body');
  const row = document.createElement('tr');
  row.className = 'expense-row';
  row.innerHTML = `
    <td><input type="text" name="payees[]" placeholder="Payee name"></td>
    <td><input type="text" name="descriptions[]" placeholder="Description"></td>
    <td><input type="number" name="quantities[]" min="0" step="any" placeholder="0" oninput="calcRow(this)"></td>
    <td><input type="number" name="unit_costs[]" min="0" step="0.01" placeholder="0.00" oninput="calcRow(this)"></td>
    <td><input type="number" name="amounts[]" min="0" step="0.01" placeholder="0.00" class="row-amount" oninput="updateTotal()"></td>
    <td><button type="button" class="del-btn" onclick="removeExpenseRow(this)" title="Remove row">✕</button></td>
  `;
  tbody.appendChild(row);
  row.querySelector('input').focus();
}

function removeExpenseRow(btn) {
  const rows = document.querySelectorAll('#expense-body .expense-row');
  if (rows.length <= 1) { btn.closest('tr').querySelectorAll('input').forEach(i => i.value = ''); updateTotal(); return; }
  btn.closest('tr').remove();
  updateTotal();
}

function resetSignatory(btn) {
  btn.closest('.sig-box').querySelectorAll('[data-default]').forEach(i => i.value = i.dataset.default);
}

// Init total on load
document.addEventListener('DOMContentLoaded', updateTotal);
</script>