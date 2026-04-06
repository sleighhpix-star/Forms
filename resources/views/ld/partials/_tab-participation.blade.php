{{-- _tab-participation.blade.php --}}
@php
  $p_total  = $counts['participation'] ?? 0;
  $p_month  = \App\Models\LdRequest::whereMonth('created_at', now()->month)->whereYear('created_at', now()->year)->count();
  $p_fin    = \App\Models\LdRequest::where('financial_requested', true)->count();
  $p_lvls   = \App\Models\LdRequest::selectRaw('level, count(*) as n')->groupBy('level')->pluck('n','level')->toArray();
@endphp

<div class="idx-panel active" id="idx-p-participation" role="tabpanel">
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
            <option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ $t }}</option>
          @endforeach
        </select>
        <select name="level" onchange="this.form.submit()" class="filter-select">
          <option value="">All Levels</option>
          @foreach($levels ?? [] as $l)
            <option value="{{ $l }}" {{ request('level')===$l?'selected':'' }}>{{ $l }}</option>
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
        <thead><tr>
          <th>#</th><th>Participant</th><th>Campus</th>
          <th>Intervention</th><th>Type</th><th>Level</th>
          <th>Date</th><th>Financial</th><th>Actions</th>
        </tr></thead>
        <tbody>
          @foreach($records as $i => $r)
          <tr>
            <td class="idx-muted">{{ $records->firstItem() + $i }}</td>
            <td>
              <strong style="font-weight:600">{{ $r->participant_name }}</strong>
              <div class="idx-muted">{{ $r->position }}</div>
            </td>
            <td class="idx-muted">{{ $r->campus }}</td>
            <td>
              <span class="idx-trunc" title="{{ $r->title }}">{{ $r->title }}</span>
              <div class="idx-muted" style="font-size:.73rem">{{ $r->college_office }}</div>
            </td>
            <td class="idx-nowrap">
              @foreach(($r->types ?? []) as $t)
                <span class="badge badge-crimson" style="font-size:.6rem">{{ $t }}</span>
              @endforeach
            </td>
            <td class="idx-nowrap"><span class="badge badge-gold" style="font-size:.6rem">{{ $r->level }}</span></td>
            <td class="idx-muted idx-nowrap">{{ $r->intervention_date }}</td>
            <td>
              @if($r->financial_requested)
                <span class="badge badge-green" style="font-size:.6rem">Yes</span>
              @else
                <span class="idx-muted">—</span>
              @endif
            </td>
            <td class="idx-nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" onclick="openViewModal({{ $r->id }})">👁</button>
                <button class="btn btn-outline btn-sm" onclick="openEditModal({{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" data-mov="{{ $r->id }}"
                  onclick="openMovModal('{{ route('ld.mov.upload',$r->id) }}','{{ $r->mov_path ? route('ld.mov.view',$r->id) : '' }}','{{ $r->mov_original_name ?? '' }}',{{ $r->id }})">
                  📎
                </button>
              </div>
              @if($r->mov_path)<span class="badge badge-green" style="font-size:.58rem;margin-top:3px;display:inline-block">MOV ✓</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($records->hasPages())
      <div class="idx-pagination">{{ $records->appends(['tab'=>'participation'])->links('ld.partials.pagination') }}</div>
    @endif
  @else
    <div class="idx-empty">
      <span class="idx-empty-icon">📋</span>
      <p>No participation requests yet.</p>
      <button class="btn btn-primary btn-sm" onclick="openCreateModal()">＋ Create First Request</button>
    </div>
  @endif

</div>
</div>
