{{-- reimbursement/show-modal.blade.php --}}
@php
  $actTypes     = is_array($record->activity_types ?? null) ? $record->activity_types : (json_decode($record->activity_types ?? '[]', true) ?: []);
  $expenseItems = is_array($record->expense_items  ?? null) ? $record->expense_items  : (json_decode($record->expense_items  ?? '[]', true) ?: []);
  $total        = collect($expenseItems)->sum(fn($i) => (float)($i['amount'] ?? 0));
@endphp
@php
function smRow($l,$v){return '<div style="display:flex;align-items:baseline;padding:5px 0;border-bottom:1px solid var(--border-sm)"><div style="min-width:130px;font-size:.67rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-4);padding-right:12px;flex-shrink:0">'.$l.'</div><div style="font-size:.84rem;color:var(--ink);flex:1">'.$v.'</div></div>';}
@endphp
<div style="background:var(--c-dk);padding:.75rem 1.25rem;flex-shrink:0;position:relative">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.5"></div>
  <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
    <div>
      <div style="font-size:.62rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--g-lt);margin-bottom:2px">💰 Reimbursement</div>
      <div style="font-family:var(--f-display);color:#fff;font-size:.95rem;font-weight:400">{{ $record->department ?? '—' }}</div>
    </div>
    @if($record->tracking_number)
      <span style="font-size:.65rem;background:rgba(255,255,255,.12);color:rgba(255,255,255,.8);padding:3px 8px;border-radius:20px;border:1px solid rgba(255,255,255,.15);white-space:nowrap">🔖 {{ $record->tracking_number }}</span>
    @endif
  </div>
</div>

<div style="padding:.75rem 1.25rem;overflow-y:auto;flex:1">
  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin-bottom:4px">Details</div>
  {!! smRow('Activity', collect($actTypes)->map(fn($t)=>'<span class="badge badge-crimson" style="font-size:.6rem">'.e($t).'</span>')->implode(' ') ?: '—') !!}
  {!! smRow('Date', e($record->activity_date ?? '—')) !!}
  {!! smRow('Venue', e($record->venue ?? '—')) !!}
  {!! smRow('Reason', e($record->reason ?? '—')) !!}

  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin:10px 0 6px">Expenses</div>
  @forelse($expenseItems as $item)
  <div style="display:flex;justify-content:space-between;align-items:center;padding:4px 8px;border-radius:var(--r-sm);background:var(--surface-2);margin-bottom:4px;border:1px solid var(--border-sm)">
    <div>
      <div style="font-size:.8rem;font-weight:500;color:var(--ink)">{{ $item['description'] ?? '—' }}</div>
      <div style="font-size:.68rem;color:var(--ink-4)">{{ $item['payee'] ?? '' }}{{ isset($item['quantity']) && $item['quantity'] ? ' · qty '.($item['quantity']) : '' }}</div>
    </div>
    <div style="font-size:.84rem;font-weight:600;color:var(--ink);white-space:nowrap">₱{{ number_format((float)($item['amount']??0),2) }}</div>
  </div>
  @empty
  <div style="font-size:.82rem;color:var(--ink-4)">No expense items.</div>
  @endforelse
  @if($total > 0)
  <div style="display:flex;justify-content:flex-end;padding:6px 0;border-top:2px solid var(--border);margin-top:4px">
    <span style="font-size:.78rem;font-weight:700;color:var(--c)">Total: ₱{{ number_format($total,2) }}</span>
  </div>
  @endif

  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin:10px 0 6px">Signatories</div>
  <div style="display:grid;grid-template-columns:1fr 1fr;gap:6px">
    @foreach([['role'=>'Requested by','name'=>$record->sig_requested_name,'pos'=>$record->sig_requested_position],['role'=>'Reviewed by','name'=>$record->sig_reviewed_name,'pos'=>$record->sig_reviewed_position],['role'=>'Recommending','name'=>$record->sig_recommending_name,'pos'=>$record->sig_recommending_position],['role'=>'Approved by','name'=>$record->sig_approved_name,'pos'=>$record->sig_approved_position]] as $s)
    <div style="background:var(--surface-2);border:1px solid var(--border-sm);border-radius:var(--r-md);padding:7px 10px">
      <div style="font-size:.58rem;font-weight:700;letter-spacing:.08em;text-transform:uppercase;color:var(--g);margin-bottom:2px">{{ $s['role'] }}</div>
      <div style="font-size:.78rem;font-weight:600;color:var(--c)">{{ $s['name'] ?? '—' }}</div>
      <div style="font-size:.66rem;color:var(--ink-4);line-height:1.3">{{ $s['pos'] ?? '' }}</div>
    </div>
    @endforeach
  </div>
</div>

<div style="padding:10px 16px;background:var(--bg);border-top:1px solid var(--border-sm);display:flex;justify-content:flex-end;gap:6px;flex-shrink:0">
  <button type="button" onclick="openFormModal('reimbursement-edit','✏️ Edit Reimbursement',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
  <button type="button"
    onclick="closeModal('gViewModal'); openPrintModal('{{ route('ld.reimbursement.print', $record) }}')"
    class="btn btn-gold btn-sm">
    🖨 Print
</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>