{{-- _tab-attendance.blade.php --}}
@php
  $a_total = $counts['attendance'] ?? 0;
  $a_month = \App\Models\LdAttendance::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
  $a_fin   = \App\Models\LdAttendance::where('financial_requested',true)->count();
  $a_lvls  = \App\Models\LdAttendance::selectRaw('level, count(*) as n')->groupBy('level')->pluck('n','level')->toArray();
@endphp

<style>
/* ── Attendance table fixes ───────────────────────────────────────── */
#idx-p-attendance .idx-table {
  table-layout: fixed;
  width: 100%;
}

/* Column widths — fixed so nothing can grow unbounded */
#idx-p-attendance .idx-table colgroup col:nth-child(1)  { width: 36px; }   /* # */
#idx-p-attendance .idx-table colgroup col:nth-child(2)  { width: 150px; }  /* Attendee */
#idx-p-attendance .idx-table colgroup col:nth-child(3)  { width: 120px; }  /* Campus / Office */
#idx-p-attendance .idx-table colgroup col:nth-child(4)  { width: 150px; }  /* Activity Type */
#idx-p-attendance .idx-table colgroup col:nth-child(5)  { width: auto; }   /* Purpose — takes remaining */
#idx-p-attendance .idx-table colgroup col:nth-child(6)  { width: 110px; }  /* Level */
#idx-p-attendance .idx-table colgroup col:nth-child(7)  { width: 210px; }  /* Date — wide enough for date ranges */
#idx-p-attendance .idx-table colgroup col:nth-child(8)  { width: 82px; }   /* Financial */
#idx-p-attendance .idx-table colgroup col:nth-child(9)  { width: 130px; }  /* Actions */

/* All cells: single-line vertical rhythm, no extra padding */
#idx-p-attendance .idx-table td,
#idx-p-attendance .idx-table th {
  vertical-align: middle;
  padding: 7px 10px;
}

/* Attendee — name truncates, sub-line stays compact */
#idx-p-attendance .att-name {
  font-weight: 500;
  font-size: .82rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 140px;
}
#idx-p-attendance .att-sub {
  font-size: .70rem;
  color: var(--color-text-secondary, #888);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 140px;
}

/* Campus / Office — same two-line treatment */
#idx-p-attendance .att-campus {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 120px;
}
#idx-p-attendance .att-office {
  font-size: .68rem;
  color: var(--color-text-secondary, #888);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 120px;
}

/* Purpose — allow it to truncate with tooltip */
#idx-p-attendance .att-purpose {
  display: block;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  font-size: .78rem;
}

/* Activity type badges — pill stays complete, text truncates with tooltip */
#idx-p-attendance .att-types {
  display: flex;
  flex-wrap: wrap;
  gap: 3px;
}
#idx-p-attendance .att-types .badge {
  display: inline-block;
  max-width: 140px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: middle;
}

/* Actions — keep buttons in one line, no wrapping */
#idx-p-attendance .idx-act {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
  align-items: center;
}
#idx-p-attendance .idx-act .btn {
  padding: 2px 6px;
  font-size: .72rem;
  flex-shrink: 0;
}

/* MOV badge — keep on same row as actions via flex */
#idx-p-attendance .att-actions-wrap {
  display: flex;
  align-items: center;
  gap: 5px;
  flex-wrap: nowrap;
}
</style>

<div class="idx-panel {{ request('tab') === 'attendance' ? 'active' : '' }}" id="idx-p-attendance" role="tabpanel">
<div class="idx-panel-body">

  {{-- Stats --}}
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $a_total }}</div><div class="idx-stat-sub">attendance requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $a_month }}</div><div class="idx-stat-sub">new submissions</div></div>
    <div class="idx-stat"><div class="idx-stat-label">Financial</div><div class="idx-stat-num">{{ $a_fin }}</div><div class="idx-stat-sub">requested funding</div></div>
    <div class="idx-stat">
      <div class="idx-stat-label">By Level</div>
      <div class="idx-mini-bars">
        @foreach(['Local','Regional','National','International'] as $lv)
          @php $n = $a_lvls[$lv] ?? 0; $pct = $a_total>0?($n/$a_total)*100:0; @endphp
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
        <input type="hidden" name="tab" value="attendance">
        <input class="filter-input" type="text" name="att_q" value="{{ request('att_q') }}" placeholder="🔍 Search name, purpose…">
        <select class="filter-select" name="att_type" onchange="this.form.submit()">
          <option value="">All Types</option>
          @foreach(['Meeting','Planning Session','Benchmarking','Project/Product Launch','Ceremonial/Representational'] as $t)
            <option value="{{ $t }}" {{ request('att_type') === $t ? 'selected' : '' }}>{{ $t }}</option>
          @endforeach
        </select>
        <select class="filter-select" name="att_level" onchange="this.form.submit()">
          <option value="">All Levels</option>
          @foreach($levels ?? [] as $l)
            <option value="{{ $l }}" {{ request('att_level') === $l ? 'selected' : '' }}>{{ $l }}</option>
          @endforeach
        </select>
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request()->anyFilled(['att_q','att_type','att_level']))
          <a href="{{ route('ld.index') }}?tab=attendance" class="btn btn-ghost btn-sm">✕ Clear</a>
        @endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('attendance','📅 Attendance Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('attendance','📅 New Attendance Request')">＋ New Request</button>
    </div>
  </div>

  {{-- Table --}}
  @if(isset($attendanceRecords) && $attendanceRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <colgroup>
          <col><col><col><col><col><col><col><col><col>
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Attendee</th>
            <th>Campus / Office</th>
            <th>Activity Type</th>
            <th>Purpose</th>
            <th>Level</th>
            <th>Date</th>
            <th>Financial</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($attendanceRecords as $r)
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>

            <td title="{{ $r->attendee_name }} — {{ $r->position }}">
              <span class="att-name">{{ $r->attendee_name }}</span>
              <span class="att-sub">{{ $r->position }}</span>
            </td>

            <td title="{{ $r->campus }} · {{ $r->college_office }}">
              <span class="att-campus">{{ $r->campus }}</span>
              <span class="att-office">{{ $r->college_office }}</span>
            </td>

            <td>
              <div class="att-types">
                @foreach(($r->activity_types ?? []) as $t)
                  <span class="badge badge-crimson" style="font-size:.6rem" title="{{ $t }}">{{ $t }}</span>
                @endforeach
              </div>
            </td>

            <td title="{{ $r->purpose }}">
              <span class="att-purpose">{{ $r->purpose }}</span>
            </td>

            <td class="idx-nowrap">
              <span class="badge badge-gold" style="font-size:.6rem" title="{{ $r->level }}">{{ $r->level }}</span>
            </td>

            <td class="idx-muted" style="white-space:nowrap" title="{{ $r->activity_date }}">{{ $r->activity_date }}</td>

            <td style="white-space:nowrap">
              @if($r->financial_requested)
                <span class="badge badge-green" style="font-size:.6rem">Yes</span>
              @else
                <span class="idx-muted">—</span>
              @endif
            </td>

            <td style="white-space:nowrap">
              <div class="idx-act">
                  <button class="btn btn-ghost btn-sm" title="View details" onclick="openGenericView('attendance',{{ $r->id }},'📅 Attendance Details')">👁</button>
                  <button class="btn btn-outline btn-sm" title="Edit" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $r->id }})">✏️</button>
                  <button class="btn btn-gold btn-sm" title="Print" onclick="openPrintModal('{{ route('ld.attendance.print',$r->id) }}')">🖨</button>
                  <button class="btn btn-primary btn-sm" title="Attach MOV" onclick="openMovModal('{{ route('ld.attendance.mov.upload',$r->id) }}','{{ $r->mov_path ? route('ld.attendance.mov.view',$r->id) : '' }}','{{ $r->mov_original_name ?? '' }}',{{ $r->id }})">📎</button>
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
      <span class="idx-empty-icon">📅</span>
      <p>No attendance requests yet.</p>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('attendance','📅 New Attendance Request')">＋ Create First Request</button>
    </div>
  @endif

</div>
</div>