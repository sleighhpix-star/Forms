{{-- _tab-attendance.blade.php --}}
@php
  $a_total = $counts['attendance'] ?? 0;
  $a_month = \App\Models\LdAttendance::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
  $a_fin   = \App\Models\LdAttendance::where('financial_requested',true)->count();
  $a_lvls  = \App\Models\LdAttendance::selectRaw('level, count(*) as n')->groupBy('level')->pluck('n','level')->toArray();
@endphp
<div class="idx-panel {{ request('tab') === 'attendance' ? 'active' : '' }}" id="idx-p-attendance" role="tabpanel">
<div class="idx-panel-body">
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $a_total }}</div><div class="idx-stat-sub">attendance requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $a_month }}</div><div class="idx-stat-sub">new submissions</div></div>
    <div class="idx-stat"><div class="idx-stat-label">Financial</div><div class="idx-stat-num">{{ $a_fin }}</div><div class="idx-stat-sub">requested funding</div></div>
    <div class="idx-stat">
      <div class="idx-stat-label">By Level</div>
      <div class="idx-mini-bars">
        @foreach(['Local','Regional','National','International'] as $lv)
          @php $n = $a_lvls[$lv] ?? 0; $pct = $a_total>0?($n/$a_total)*100:0; @endphp
          <div class="idx-mini-row"><span class="idx-mini-lbl">{{ $lv }}</span><div class="idx-mini-track"><div class="idx-mini-fill" style="width:{{ $pct }}%"></div></div><span class="idx-mini-val">{{ $n }}</span></div>
        @endforeach
      </div>
    </div>
  </div>
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
  @if(isset($attendanceRecords) && $attendanceRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <thead><tr><th>#</th><th>Attendee</th><th>Campus / Office</th><th>Activity Type</th><th>Purpose</th><th>Level</th><th>Date</th><th>Financial</th><th>Actions</th></tr></thead>
        <tbody>
          @foreach($attendanceRecords as $i => $r)
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>
            <td><strong style="font-weight:600">{{ $r->attendee_name }}</strong><div class="idx-muted">{{ $r->position }}</div></td>
            <td class="idx-muted">{{ $r->campus }}<div style="font-size:.72rem">{{ $r->college_office }}</div></td>
            <td class="idx-nowrap">@foreach(($r->activity_types??[]) as $t)<span class="badge badge-crimson" style="font-size:.6rem">{{ $t }}</span>@endforeach</td>
            <td><span class="idx-trunc" title="{{ $r->purpose }}">{{ $r->purpose }}</span></td>
            <td class="idx-nowrap"><span class="badge badge-gold" style="font-size:.6rem">{{ $r->level }}</span></td>
            <td class="idx-muted idx-nowrap">{{ $r->activity_date }}</td>
            <td>@if($r->financial_requested)<span class="badge badge-green" style="font-size:.6rem">Yes</span>@else<span class="idx-muted">—</span>@endif</td>
            <td class="idx-nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" onclick="openGenericView('attendance',{{ $r->id }},'📅 Attendance Details')">👁</button>
                <button class="btn btn-outline btn-sm" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.attendance.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" onclick="openMovModal('{{ route('ld.attendance.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.attendance.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
              </div>
              @if($r->mov_path)<span class="badge badge-green" style="font-size:.58rem;margin-top:3px;display:inline-block">MOV ✓</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  @else
    <div class="idx-empty"><span class="idx-empty-icon">📅</span><p>No attendance requests yet.</p><button class="btn btn-primary btn-sm" onclick="openFormModal('attendance','📅 New Attendance Request')">＋ Create First Request</button></div>
  @endif
</div>
</div>