{{-- _tab-participation.blade.php --}}
@php
  $p_total  = $counts['participation'] ?? 0;
  $p_month  = \App\Models\LdRequest::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
  $p_fin    = \App\Models\LdRequest::where('financial_requested', true)->count();
  $p_lvls   = \App\Models\LdRequest::selectRaw('level, count(*) as n')->groupBy('level')->pluck('n','level')->toArray();
@endphp

<style>
/* ── Participation table fixes ────────────────────────────────────── */
#idx-p-participation .idx-table {
  table-layout: fixed;
  width: 100%;
}

/* Column widths */
#idx-p-participation .idx-table colgroup col:nth-child(1) { width: 36px; }   /* # */
#idx-p-participation .idx-table colgroup col:nth-child(2) { width: 150px; }  /* Participant */
#idx-p-participation .idx-table colgroup col:nth-child(3) { width: 110px; }  /* Campus */
#idx-p-participation .idx-table colgroup col:nth-child(4) { width: auto; }   /* Intervention — takes remaining */
#idx-p-participation .idx-table colgroup col:nth-child(5) { width: 150px; }  /* Type */
#idx-p-participation .idx-table colgroup col:nth-child(6) { width: 110px; }  /* Level */
#idx-p-participation .idx-table colgroup col:nth-child(7) { width: 210px; }  /* Date — wide for date ranges */
#idx-p-participation .idx-table colgroup col:nth-child(8) { width: 82px; }   /* Financial */
#idx-p-participation .idx-table colgroup col:nth-child(9) { width: 130px; }  /* Actions */

/* All cells: consistent vertical rhythm */
#idx-p-participation .idx-table td,
#idx-p-participation .idx-table th {
  vertical-align: middle;
  padding: 7px 10px;
}

/* Participant name + position */
#idx-p-participation .par-name {
  font-weight: 500;
  font-size: .82rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 130px;
}
#idx-p-participation .par-sub {
  font-size: .70rem;
  color: var(--color-text-secondary, #888);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 130px;
}

/* Campus */
#idx-p-participation .par-campus {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 100px;
}

/* Intervention title + office */
#idx-p-participation .par-title {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}
#idx-p-participation .par-office {
  font-size: .68rem;
  color: var(--color-text-secondary, #888);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}

/* Type badges — pill complete, text truncates with tooltip */
#idx-p-participation .par-types {
  display: flex;
  flex-wrap: wrap;
  gap: 3px;
}
#idx-p-participation .par-types .badge {
  display: inline-block;
  max-width: 140px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: middle;
}

/* Actions */
#idx-p-participation .idx-act {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
  align-items: center;
}
#idx-p-participation .idx-act .btn {
  padding: 2px 6px;
  font-size: .72rem;
  flex-shrink: 0;
}
#idx-p-participation .par-actions-wrap {
  display: flex;
  align-items: center;
  gap: 5px;
  flex-wrap: nowrap;
}
</style>

<div class="idx-panel {{ request('tab', 'participation') === 'participation' ? 'active' : '' }}" id="idx-p-participation" role="tabpanel">
<div class="idx-panel-body">

  {{-- Stats --}}
  <div class="idx-stats">
    <div class="idx-stat">
      <div class="idx-stat-label">Total</div>
      <div class="idx-stat-num">{{ $p_total }}</div>
      <div class="idx-stat-sub">participation requests</div>
    </div>
    <div class="idx-stat">
      <div class="idx-stat-label">This Month</div>
      <div class="idx-stat-num">{{ $p_month }}</div>
      <div class="idx-stat-sub">new submissions</div>
    </div>
    <div class="idx-stat">
      <div class="idx-stat-label">Financial</div>
      <div class="idx-stat-num">{{ $p_fin }}</div>
      <div class="idx-stat-sub">requested funding</div>
    </div>
    <div class="idx-stat">
      <div class="idx-stat-label">By Level</div>
      <div class="idx-mini-bars">
        @foreach(['Local','Regional','National','International'] as $lv)
          @php $n = $p_lvls[$lv] ?? 0; $pct = $p_total > 0 ? ($n/$p_total)*100 : 0; @endphp
          <div class="idx-mini-row">
            <span class="idx-mini-lbl">{{ $lv }}</span>
            <div class="idx-mini-track"><div class="idx-mini-fill" style="width:{{ $pct }}%"></div></div>
            <span class="idx-mini-val">{{ $n }}</span>
          </div>
        @endforeach
      </div>
    </div>
  </div>

  {{-- Toolbar --}}
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="participation">
        <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search name, title…">
        <select name="type" onchange="this.form.submit()" class="filter-select">
          <option value="">All Types</option>
          @foreach($types ?? [] as $t)
            <option value="{{ $t }}" {{ request('type')===$t ? 'selected' : '' }}>{{ $t }}</option>
          @endforeach
        </select>
        <select name="level" onchange="this.form.submit()" class="filter-select">
          <option value="">All Levels</option>
          @foreach($levels ?? [] as $l)
            <option value="{{ $l }}" {{ request('level')===$l ? 'selected' : '' }}>{{ $l }}</option>
          @endforeach
        </select>
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request()->anyFilled(['search','type','level']))
          <a href="{{ route('ld.index') }}?tab=participation" class="btn btn-ghost btn-sm">✕ Clear</a>
        @endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('participation','📋 Participation Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openCreateModal()">＋ New Request</button>
    </div>
  </div>

  {{-- Table --}}
  @if(isset($records) && $records->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <colgroup>
          <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Participant</th>
            <th>Campus</th>
            <th>Intervention</th>
            <th>Type</th>
            <th>Level</th>
            <th>Date</th>
            <th>Financial</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($records as $i => $r)
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>

            <td title="{{ $r->participant_name }} — {{ $r->position }}">
              <span class="par-name">{{ $r->participant_name }}</span>
              <span class="par-sub">{{ $r->position }}</span>
            </td>

            <td title="{{ $r->campus }}">
              <span class="par-campus idx-muted">{{ $r->campus }}</span>
            </td>

            <td title="{{ $r->title }} · {{ $r->college_office }}">
              <span class="par-title">{{ $r->title }}</span>
              <span class="par-office">{{ $r->college_office }}</span>
            </td>

            <td>
              <div class="par-types">
                @foreach(($r->types ?? []) as $t)
                  <span class="badge badge-crimson" style="font-size:.6rem" title="{{ $t }}">{{ $t }}</span>
                @endforeach
              </div>
            </td>

            <td style="white-space:nowrap">
              <span class="badge badge-gold" style="font-size:.6rem" title="{{ $r->level }}">{{ $r->level }}</span>
            </td>

            <td class="idx-muted" style="white-space:nowrap" title="{{ $r->intervention_date }}">{{ $r->intervention_date }}</td>

            <td style="white-space:nowrap">
              @if($r->financial_requested)
                <span class="badge badge-green" style="font-size:.6rem">Yes</span>
              @else
                <span class="idx-muted">—</span>
              @endif
            </td>

            <td style="white-space:nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" title="View details" onclick="openViewModal({{ $r->id }})">👁</button>
                <button class="btn btn-outline btn-sm" title="Edit" onclick="openEditModal({{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" title="Print" onclick="openPrintModal('{{ route('ld.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" title="Attach MOV" data-mov="{{ $r->id }}"
                  onclick="openMovModal('{{ route('ld.mov.upload',$r->id) }}','{{ $r->mov_path ? route('ld.mov.view',$r->id) : '' }}','{{ $r->mov_original_name ?? '' }}',{{ $r->id }})">
                  📎
                </button>
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
      <span class="idx-empty-icon">📋</span>
      <p>No participation requests yet.</p>
      <button class="btn btn-primary btn-sm" onclick="openCreateModal()">＋ Create First Request</button>
    </div>
  @endif

</div>
</div>