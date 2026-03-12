{{-- resources/views/ld/reimbursement/show-modal.blade.php --}}
@php
  $actTypes     = $record->activity_types ?? [];
  $expenseItems = $record->expense_items  ?? [];
  if (is_string($actTypes))     $actTypes     = json_decode($actTypes, true)     ?: [];
  if (is_string($expenseItems)) $expenseItems = json_decode($expenseItems, true) ?: [];
  $total = collect($expenseItems)->sum(fn($i) => (float)($i['amount'] ?? 0));
@endphp

<div class="card" style="box-shadow:none;border-radius:0 0 var(--radius-lg) var(--radius-lg);border:none;">

  <div style="background:linear-gradient(135deg,var(--crimson-deep) 0%,var(--crimson) 60%,var(--crimson-mid) 100%);padding:1.25rem 1.75rem 1.1rem;position:relative;overflow:hidden;">
    <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--gold-light),var(--gold),var(--gold-light),transparent);opacity:.55;"></div>
    <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.88);margin-bottom:.55rem;">
      💰 Reimbursement
    </div>
    <h2 style="font-family:var(--font-display);color:#fff;font-size:1.05rem;font-weight:600;line-height:1.3;margin-bottom:.35rem;">
      Request for Reimbursement
    </h2>
    <div style="display:flex;gap:.75rem;flex-wrap:wrap;">
      <span style="font-size:.7rem;color:rgba(255,255,255,.65);">
        🗓 Submitted <strong style="color:rgba(255,255,255,.88);">{{ optional($record->created_at)->format('F j, Y') }}</strong>
      </span>
      @if($record->tracking_number)
        <span style="font-size:.7rem;color:rgba(255,255,255,.65);">
          🔖 <strong style="color:rgba(255,255,255,.88);">{{ $record->tracking_number }}</strong>
        </span>
      @endif
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Request Information</div>
    <div class="detail-grid">
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Department / Office</div>
        <div class="dval" style="font-weight:600;">{{ $record->department ?? '—' }}</div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Type of Activity</div>
        <div class="dval" style="display:flex;flex-wrap:wrap;gap:.25rem;">
          @forelse($actTypes as $t)
            <span class="badge badge-maroon">{{ $t }}</span>
          @empty <span class="text-muted text-sm">—</span>
          @endforelse
          @if(!empty($record->activity_type_others))
            <span class="badge badge-maroon">Others: {{ $record->activity_type_others }}</span>
          @endif
        </div>
      </div>
      <div class="detail-field">
        <div class="dlabel">Date of Activity</div>
        <div class="dval">{{ $record->activity_date ?? '—' }}</div>
      </div>
      <div class="detail-field" style="grid-column:span 2;">
        <div class="dlabel">Venue</div>
        <div class="dval">{{ $record->venue ?? '—' }}</div>
      </div>
      @if($record->reason)
        <div class="detail-field" style="grid-column:span 2;">
          <div class="dlabel">Reason for Reimbursement</div>
          <div class="dval">{{ $record->reason }}</div>
        </div>
      @endif
      @if($record->remarks)
        <div class="detail-field" style="grid-column:span 2;">
          <div class="dlabel">Remarks</div>
          <div class="dval">{{ $record->remarks }}</div>
        </div>
      @endif
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Expense Items</div>
    @if(count($expenseItems) > 0)
      <div style="overflow-x:auto;border-radius:var(--radius-md);border:1px solid var(--ivory-deep);overflow:hidden;">
        <table style="width:100%;border-collapse:collapse;font-size:.82rem;">
          <thead>
            <tr style="background:linear-gradient(to right,var(--ivory-warm),var(--ivory-deep));">
              <th style="padding:.55rem .85rem;text-align:left;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-ghost);border-bottom:1px solid var(--ivory-deep);">Payee</th>
              <th style="padding:.55rem .85rem;text-align:left;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-ghost);border-bottom:1px solid var(--ivory-deep);">Description</th>
              <th style="padding:.55rem .85rem;text-align:right;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-ghost);border-bottom:1px solid var(--ivory-deep);">Qty</th>
              <th style="padding:.55rem .85rem;text-align:right;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-ghost);border-bottom:1px solid var(--ivory-deep);">Unit Cost</th>
              <th style="padding:.55rem .85rem;text-align:right;font-size:.62rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-ghost);border-bottom:1px solid var(--ivory-deep);">Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenseItems as $idx => $item)
            <tr style="background:{{ $idx % 2 === 0 ? '#fff' : 'var(--ivory-warm)' }};border-bottom:1px solid var(--ivory-deep);">
              <td style="padding:.5rem .85rem;color:var(--ink-mid);">{{ $item['payee'] ?? '—' }}</td>
              <td style="padding:.5rem .85rem;color:var(--ink-mid);">{{ $item['description'] ?? '—' }}</td>
              <td style="padding:.5rem .85rem;text-align:right;color:var(--ink-faint);">{{ $item['quantity'] ?? '—' }}</td>
              <td style="padding:.5rem .85rem;text-align:right;color:var(--ink-faint);">
                @if(!empty($item['unit_cost'])) ₱ {{ number_format((float)$item['unit_cost'], 2) }} @else — @endif
              </td>
              <td style="padding:.5rem .85rem;text-align:right;font-weight:600;color:var(--ink);">
                @if(!empty($item['amount'])) ₱ {{ number_format((float)$item['amount'], 2) }} @else — @endif
              </td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr style="background:var(--ivory-warm);border-top:2px solid var(--ivory-deep);">
              <td colspan="4" style="padding:.55rem .85rem;text-align:right;font-size:.7rem;font-weight:700;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-ghost);">Total</td>
              <td style="padding:.55rem .85rem;text-align:right;font-family:var(--font-display);font-size:1rem;font-weight:700;color:var(--crimson);">
                ₱ {{ number_format($total, 2) }}
              </td>
            </tr>
          </tfoot>
        </table>
      </div>
    @else
      <p class="text-muted text-sm">No expense items recorded.</p>
    @endif
  </div>

  <div class="card-section">
    <div class="section-label">Signatories</div>
    <div class="sig-grid">
      @foreach([
        ['role'=>'Requested by',          'name'=>$record->sig_requested_name,     'pos'=>$record->sig_requested_position],
        ['role'=>'Reviewed by',           'name'=>$record->sig_reviewed_name,      'pos'=>$record->sig_reviewed_position],
        ['role'=>'Recommending Approval', 'name'=>$record->sig_recommending_name,  'pos'=>$record->sig_recommending_position],
        ['role'=>'Approved by',           'name'=>$record->sig_approved_name,      'pos'=>$record->sig_approved_position],
      ] as $s)
        <div class="sig-box">
          <div class="sig-role">{{ $s['role'] }}</div>
          <div class="sig-name">{{ $s['name'] ?? '—' }}</div>
          <div class="sig-position">{{ $s['pos'] ?? '' }}</div>
        </div>
      @endforeach
    </div>
  </div>

  <div class="form-actions">
    <button type="button" onclick="openFormModal('reimbursement-edit','✏️ Edit Reimbursement',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
    <button type="button" onclick="openPrintModal('{{ route('ld.reimbursement.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  </div>
</div>