{{-- reimbursement/show-modal.blade.php --}}
@php
  $actTypes     = is_array($record->activity_types ?? null) ? $record->activity_types : (json_decode($record->activity_types ?? '[]', true) ?: []);
  $expenseItems = is_array($record->expense_items  ?? null) ? $record->expense_items  : (json_decode($record->expense_items  ?? '[]', true) ?: []);
  $total        = collect($expenseItems)->sum(fn($i) => (float)($i['amount'] ?? 0));
@endphp

{{-- Hero --}}
<div style="background:var(--c-dk);padding:1.1rem 1.75rem 1rem;position:relative;flex-shrink:0">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.6"></div>
  <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.2);color:rgba(255,255,255,.9);margin-bottom:.5rem;font-size:.64rem">💰 Reimbursement</div>
  <h2 style="font-family:var(--f-display);color:#fff;font-size:1rem;font-weight:400;line-height:1.3">Request for Reimbursement</h2>
  <div style="display:flex;gap:.75rem;flex-wrap:wrap;margin-top:.3rem">
    <span style="font-size:.7rem;color:rgba(255,255,255,.6)">🗓 <strong style="color:rgba(255,255,255,.85)">{{ optional($record->created_at)->format('F j, Y') }}</strong></span>
    @if($record->tracking_number)<span style="font-size:.7rem;color:rgba(255,255,255,.6)">🔖 <strong style="color:rgba(255,255,255,.85)">{{ $record->tracking_number }}</strong></span>@endif
  </div>
</div>

{{-- Scrollable body --}}
<div style="overflow-y:auto;max-height:65vh">

  <div class="card-section">
    <div class="section-label">Request Information</div>
    <div class="detail-grid">
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Department / Office</div><div class="dval" style="font-weight:600">{{ $record->department ?? '—' }}</div></div>
      <div class="detail-field">
        <div class="dlabel">Type of Activity</div>
        <div class="dval">@forelse($actTypes as $t)<span class="badge badge-crimson" style="font-size:.65rem">{{ $t }}</span> @empty <span class="text-muted">—</span>@endforelse</div>
      </div>
      <div class="detail-field"><div class="dlabel">Date</div><div class="dval">{{ $record->activity_date ?? '—' }}</div></div>
      <div class="detail-field" style="grid-column:span 2"><div class="dlabel">Venue</div><div class="dval">{{ $record->venue ?? '—' }}</div></div>
      @if($record->reason)<div class="detail-field" style="grid-column:span 2"><div class="dlabel">Reason</div><div class="dval">{{ $record->reason }}</div></div>@endif
      @if($record->remarks)<div class="detail-field" style="grid-column:span 2"><div class="dlabel">Remarks</div><div class="dval">{{ $record->remarks }}</div></div>@endif
    </div>
  </div>

  <div class="card-section">
    <div class="section-label">Expense Items</div>
    @if(count($expenseItems))
      <div style="overflow-x:auto;border:1px solid var(--border);border-radius:var(--r-md);overflow:hidden">
        <table style="width:100%;border-collapse:collapse;font-size:.82rem">
          <thead>
            <tr style="background:var(--bg)">
              <th style="padding:.5rem .85rem;text-align:left;font-size:.61rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4);border-bottom:1px solid var(--border)">Payee</th>
              <th style="padding:.5rem .85rem;text-align:left;font-size:.61rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4);border-bottom:1px solid var(--border)">Description</th>
              <th style="padding:.5rem .85rem;text-align:right;font-size:.61rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4);border-bottom:1px solid var(--border)">Qty</th>
              <th style="padding:.5rem .85rem;text-align:right;font-size:.61rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4);border-bottom:1px solid var(--border)">Unit Cost</th>
              <th style="padding:.5rem .85rem;text-align:right;font-size:.61rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4);border-bottom:1px solid var(--border)">Amount</th>
            </tr>
          </thead>
          <tbody>
            @foreach($expenseItems as $idx => $item)
            <tr style="border-bottom:1px solid var(--border-sm);{{ $idx%2===1?'background:var(--surface-2)':'' }}">
              <td style="padding:.48rem .85rem;color:var(--ink-2)">{{ $item['payee'] ?? '—' }}</td>
              <td style="padding:.48rem .85rem;color:var(--ink-2)">{{ $item['description'] ?? '—' }}</td>
              <td style="padding:.48rem .85rem;text-align:right;color:var(--ink-4)">{{ $item['quantity'] ?? '—' }}</td>
              <td style="padding:.48rem .85rem;text-align:right;color:var(--ink-4)">@if(!empty($item['unit_cost']))₱{{ number_format((float)$item['unit_cost'],2) }}@else —@endif</td>
              <td style="padding:.48rem .85rem;text-align:right;font-weight:600;color:var(--ink)">@if(!empty($item['amount']))₱{{ number_format((float)$item['amount'],2) }}@else —@endif</td>
            </tr>
            @endforeach
          </tbody>
          <tfoot>
            <tr style="background:var(--bg);border-top:2px solid var(--border)">
              <td colspan="4" style="padding:.5rem .85rem;text-align:right;font-size:.62rem;font-weight:600;letter-spacing:.08em;text-transform:uppercase;color:var(--ink-4)">Total</td>
              <td style="padding:.5rem .85rem;text-align:right;font-weight:600;color:var(--c);font-size:1rem">₱{{ number_format($total, 2) }}</td>
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
    <div class="sig-grid" style="pointer-events:none">
      @foreach([['role'=>'Requested by','name'=>$record->sig_requested_name,'pos'=>$record->sig_requested_position],['role'=>'Reviewed by','name'=>$record->sig_reviewed_name,'pos'=>$record->sig_reviewed_position],['role'=>'Recommending Approval','name'=>$record->sig_recommending_name,'pos'=>$record->sig_recommending_position],['role'=>'Approved by','name'=>$record->sig_approved_name,'pos'=>$record->sig_approved_position]] as $s)
        <div class="sig-box"><div class="sig-role">{{ $s['role'] }}</div><div style="font-size:.85rem;font-weight:600;color:var(--c)">{{ $s['name'] ?? '—' }}</div><div style="font-size:.72rem;color:var(--ink-3)">{{ $s['pos'] ?? '' }}</div></div>
      @endforeach
    </div>
  </div>

</div>

{{-- Footer --}}
<div style="padding:12px 20px;background:var(--bg);border-top:1px solid var(--border-sm);display:flex;justify-content:flex-end;gap:8px;flex-shrink:0">
  <button type="button" onclick="openFormModal('reimbursement-edit','✏️ Edit Reimbursement',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
  <button type="button" onclick="openPrintModal('{{ route('ld.reimbursement.print', $record) }}')" class="btn btn-gold btn-sm">🖨 Print</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>