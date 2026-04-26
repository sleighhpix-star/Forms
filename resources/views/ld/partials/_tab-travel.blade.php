{{-- _tab-travel.blade.php --}}
@php
  $tv_total = $counts['travel'] ?? 0;
  $tv_month = \App\Models\LdTravel::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
@endphp

<style>
/* ── Travel table fixes ───────────────────────────────────────────── */
#idx-p-travel .idx-table {
  table-layout: fixed;
  width: 100%;
}

/* Column widths */
#idx-p-travel .idx-table colgroup col:nth-child(1) { width: 36px; }   /* # */
#idx-p-travel .idx-table colgroup col:nth-child(2) { width: 160px; }  /* Employee/s */
#idx-p-travel .idx-table colgroup col:nth-child(3) { width: 150px; }  /* Places to Visit */
#idx-p-travel .idx-table colgroup col:nth-child(4) { width: auto; }   /* Purpose — takes remaining */
#idx-p-travel .idx-table colgroup col:nth-child(5) { width: 210px; }  /* Date/s — wide for date ranges */
#idx-p-travel .idx-table colgroup col:nth-child(6) { width: 140px; }  /* Chargeable To */
#idx-p-travel .idx-table colgroup col:nth-child(7) { width: 130px; }  /* Actions */

/* All cells: consistent vertical rhythm */
#idx-p-travel .idx-table td,
#idx-p-travel .idx-table th {
  vertical-align: middle;
  padding: 7px 10px;
}

/* Employee/s */
#idx-p-travel .trv-employee {
  font-size: .82rem;
  font-weight: 500;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 140px;
}

/* Places, Purpose, Chargeable — truncate with tooltip */
#idx-p-travel .trv-trunc {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}

/* Actions */
#idx-p-travel .idx-act {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
  align-items: center;
}
#idx-p-travel .idx-act .btn {
  padding: 2px 6px;
  font-size: .72rem;
  flex-shrink: 0;
}
</style>

<div class="idx-panel {{ request('tab') === 'travel' ? 'active' : '' }}" id="idx-p-travel" role="tabpanel">
<div class="idx-panel-body">

  {{-- Stats --}}
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $tv_total }}</div><div class="idx-stat-sub">travel authority requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $tv_month }}</div><div class="idx-stat-sub">new submissions</div></div>
  </div>

  {{-- Toolbar --}}
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="travel">
        <input type="text" name="trv_q" value="{{ request('trv_q') }}" placeholder="🔍 Search employee, place…">
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request('trv_q'))
          <a href="{{ route('ld.index') }}?tab=travel" class="btn btn-ghost btn-sm">✕ Clear</a>
        @endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('travel','✈️ Travel Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('travel','✈️ New Authority to Travel')">＋ New Request</button>
    </div>
  </div>

  {{-- Table --}}
  @if(isset($travelRecords) && $travelRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <colgroup>
          <col><col><col><col><col><col><col>
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Employee/s</th>
            <th>Places to Visit</th>
            <th>Purpose</th>
            <th>Date/s</th>
            <th>Chargeable To</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($travelRecords as $r)
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>

            <td title="{{ $r->employee_names }}">
              <span class="trv-employee">{{ $r->employee_names }}</span>
            </td>

            <td title="{{ $r->places_visited }}">
              <span class="trv-trunc idx-muted">{{ $r->places_visited }}</span>
            </td>

            <td title="{{ $r->purpose }}">
              <span class="trv-trunc">{{ $r->purpose }}</span>
            </td>

            <td class="idx-muted" style="white-space:nowrap" title="{{ $r->travel_dates }}">{{ $r->travel_dates }}</td>

            <td title="{{ $r->chargeable_against }}">
              <span class="trv-trunc idx-muted">{{ $r->chargeable_against }}</span>
            </td>

            <td style="white-space:nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" title="View details" onclick="openGenericView('travel',{{ $r->id }},'✈️ Travel Details')">👁</button>
                <button class="btn btn-outline btn-sm" title="Edit" onclick="openFormModal('travel-edit','✏️ Edit',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" title="Print" onclick="openPrintModal('{{ route('ld.travel.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" title="Attach MOV" onclick="openMovModal('{{ route('ld.travel.mov.upload',$r->id) }}','{{ $r->mov_path ? route('ld.travel.mov.view',$r->id) : '' }}','{{ $r->mov_original_name ?? '' }}',{{ $r->id }})">📎</button>
              </div>
              @if($r->mov_path)
                <div style="font-size:.62rem;color:#3B6D11;margin-top:2px;white-space:nowrap">✓ mov</div>
              @endif
            </td>

          </tr>
          @endforeach
        </tbody>
      </table>
    </div>

  @else
    <div class="idx-empty">
      <span class="idx-empty-icon">✈️</span>
      <p>No travel authority requests yet.</p>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('travel','✈️ New Authority to Travel')">＋ Create First Request</button>
    </div>
  @endif

</div>
</div>