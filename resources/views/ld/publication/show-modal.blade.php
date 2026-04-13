{{-- publication/show-modal.blade.php --}}
@php
function smRow($l,$v){return '<div style="display:flex;align-items:baseline;padding:5px 0;border-bottom:1px solid var(--border-sm)"><div style="min-width:130px;font-size:.67rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-4);padding-right:12px;flex-shrink:0">'.$l.'</div><div style="font-size:.84rem;color:var(--ink);flex:1">'.$v.'</div></div>';}
@endphp
<div style="background:var(--c-dk);padding:.75rem 1.25rem;flex-shrink:0;position:relative">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.5"></div>
  <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
    <div>
      <div style="font-size:.62rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--g-lt);margin-bottom:2px">📰 Publication Incentive</div>
      <div style="font-family:var(--f-display);color:#fff;font-size:.95rem;font-weight:400">{{ $record->faculty_name ?? '—' }}</div>
    </div>
    @if($record->tracking_number)
      <span style="font-size:.65rem;background:rgba(255,255,255,.12);color:rgba(255,255,255,.8);padding:3px 8px;border-radius:20px;border:1px solid rgba(255,255,255,.15);white-space:nowrap">🔖 {{ $record->tracking_number }}</span>
    @endif
  </div>
</div>

<div style="padding:.75rem 1.25rem;overflow-y:auto;flex:1">
  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin-bottom:4px">Researcher</div>
  {!! smRow('Position', e($record->position ?? '—')) !!}
  {!! smRow('Campus', e($record->campus ?? '—')) !!}
  {!! smRow('College / Office', e($record->college_office ?? '—')) !!}
  {!! smRow('Status', e($record->employment_status ?? '—')) !!}

  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin:10px 0 4px">Publication</div>
  {!! smRow('Paper Title', '<strong>'.e($record->paper_title ?? '—').'</strong>') !!}
  {!! smRow('Co-author/s', e($record->co_authors ?? '—')) !!}
  {!! smRow('Journal', e($record->journal_title ?? '—')) !!}
  {!! smRow('Vol. / Issue', e($record->vol_issue ?? '—')) !!}
  {!! smRow('ISSN / ISBN', e($record->issn_isbn ?? '—')) !!}
  {!! smRow('Publisher', e($record->publisher ?? '—')) !!}
  {!! smRow('Scope', $record->pub_scope ? '<span class="badge badge-gold" style="font-size:.6rem">'.e($record->pub_scope).'</span>' : '—') !!}
  {!! smRow('Format', e($record->pub_format ?? '—')) !!}
  {!! smRow('Nature', e($record->nature ?? '—')) !!}

  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin:10px 0 4px">Incentive</div>
  {!! smRow('Amount', '<strong style="color:var(--c)">₱'.number_format((float)($record->amount_requested??0),2).'</strong>') !!}
  {!! smRow('Prev. Claim', $record->has_previous_claim ? '<span class="badge badge-amber" style="font-size:.6rem">Yes</span>' : '<span class="badge badge-neutral" style="font-size:.6rem">No</span>') !!}

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
  <button type="button" onclick="openFormModal('publication-edit','✏️ Edit Publication',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
 <button type="button"
    onclick="closeModal('gViewModal'); openPrintModal('{{ route('ld.publication.print', $record) }}')"
    class="btn btn-gold btn-sm">
    🖨 Print
</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>