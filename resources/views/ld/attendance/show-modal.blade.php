{{-- attendance/show-modal.blade.php --}}
@php
  $actTypes = is_array($record->activity_types ?? null) ? $record->activity_types : (json_decode($record->activity_types ?? '[]', true) ?: []);
  $natures  = is_array($record->natures  ?? null) ? $record->natures  : (json_decode($record->natures  ?? '[]', true) ?: []);
  $covSel   = is_array($record->coverage ?? null) ? $record->coverage : (json_decode($record->coverage ?? '[]', true) ?: []);
  $covMap   = ['registration'=>'Registration','accommodation'=>'Accommodation','materials'=>'Materials / Kit','speaker_fee'=>"Speaker's Fee",'meals'=>'Meals / Snacks','transportation'=>'Transportation'];
@endphp
@php
function smRow($l,$v){return '<div style="display:flex;align-items:baseline;padding:5px 0;border-bottom:1px solid var(--border-sm)"><div style="min-width:130px;font-size:.67rem;font-weight:600;letter-spacing:.06em;text-transform:uppercase;color:var(--ink-4);padding-right:12px;flex-shrink:0">'.$l.'</div><div style="font-size:.84rem;color:var(--ink);flex:1">'.$v.'</div></div>';}
@endphp
<div style="background:var(--c-dk);padding:.75rem 1.25rem;flex-shrink:0;position:relative">
  <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.5"></div>
  <div style="display:flex;align-items:center;justify-content:space-between;gap:8px">
    <div>
      <div style="font-size:.62rem;font-weight:600;letter-spacing:.1em;text-transform:uppercase;color:var(--g-lt);margin-bottom:2px">📅 Attendance</div>
      <div style="font-family:var(--f-display);color:#fff;font-size:.95rem;font-weight:400">{{ $record->attendee_name ?? '—' }}</div>
    </div>
    @if($record->tracking_number)
      <span style="font-size:.65rem;background:rgba(255,255,255,.12);color:rgba(255,255,255,.8);padding:3px 8px;border-radius:20px;border:1px solid rgba(255,255,255,.15);white-space:nowrap">🔖 {{ $record->tracking_number }}</span>
    @endif
  </div>
</div>

<div style="padding:.75rem 1.25rem;overflow-y:auto;flex:1">
  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin-bottom:4px">Person</div>
  {!! smRow('Position', e($record->position ?? '—')) !!}
  {!! smRow('Campus', e($record->campus ?? '—')) !!}
  {!! smRow('College / Office', e($record->college_office ?? '—')) !!}
  {!! smRow('Status', e($record->employment_status ?? '—')) !!}

  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin:10px 0 4px">Activity</div>
  {!! smRow('Purpose', '<strong>'.e($record->purpose ?? '—').'</strong>') !!}
  {!! smRow('Type', collect($actTypes)->map(fn($t)=>'<span class="badge badge-crimson" style="font-size:.6rem">'.e($t).'</span>')->implode(' ') ?: '—') !!}
  {!! smRow('Nature', collect($natures)->map(fn($n)=>'<span class="badge badge-neutral" style="font-size:.6rem">'.e($n).'</span>')->implode(' ') ?: '—') !!}
  {!! smRow('Level', $record->level ? '<span class="badge badge-gold" style="font-size:.6rem">'.e($record->level).'</span>' : '—') !!}
  {!! smRow('Date', e($record->activity_date ?? '—')) !!}
  {!! smRow('Hours', $record->hours ? $record->hours.' hrs' : '—') !!}
  {!! smRow('Venue', e($record->venue ?? '—')) !!}
  {!! smRow('Organizer', e($record->organizer ?? '—')) !!}

  @if($record->financial_requested)
  <div style="font-size:.6rem;font-weight:700;letter-spacing:.12em;text-transform:uppercase;color:var(--c);margin:10px 0 4px">Financial</div>
  {!! smRow('Amount', '<strong style="color:var(--c)">₱'.number_format((float)($record->amount_requested??0),2).'</strong>') !!}
  @if(count($covSel))
  {!! smRow('Coverage', collect($covSel)->map(fn($c)=>'<span class="badge badge-gold" style="font-size:.6rem">'.e($covMap[$c]??$c).'</span>')->implode(' ')) !!}
  @endif
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
  <button type="button" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $record->id }})" class="btn btn-outline btn-sm">✏️ Edit</button>
  <button type="button"
    onclick="closeModal('gViewModal'); openPrintModal('{{ route('ld.attendance.print', $record) }}')"
    class="btn btn-gold btn-sm">
    🖨 Print
</button>
  <button type="button" onclick="closeModal('gViewModal')" class="btn btn-primary btn-sm">✓ Close</button>
</div>