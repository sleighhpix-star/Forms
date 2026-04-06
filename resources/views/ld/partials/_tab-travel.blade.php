{{-- _tab-travel.blade.php --}}
@php
  $tv_total = $counts['travel'] ?? 0;
  $tv_month = \App\Models\LdTravel::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
@endphp
<div class="idx-panel {{ request('tab') === 'travel' ? 'active' : '' }}" id="idx-p-travel" role="tabpanel">
<div class="idx-panel-body">
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $tv_total }}</div><div class="idx-stat-sub">travel authority requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $tv_month }}</div><div class="idx-stat-sub">new submissions</div></div>
  </div>
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="travel">
        <input type="text" name="trv_q" value="{{ request('trv_q') }}" placeholder="🔍 Search employee, place…">
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request('trv_q'))<a href="{{ route('ld.index') }}?tab=travel" class="btn btn-ghost btn-sm">✕ Clear</a>@endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('travel','✈️ Travel Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('travel','✈️ New Authority to Travel')">＋ New Request</button>
    </div>
  </div>
  @if(isset($travelRecords) && $travelRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <thead><tr><th>#</th><th>Employee/s</th><th>Places to Visit</th><th>Purpose</th><th>Date/s</th><th>Chargeable To</th><th>Actions</th></tr></thead>
        <tbody>
          @foreach($travelRecords as $i => $r)
          <tr>
            <td class="idx-muted">{{ $travelRecords->firstItem()+$i }}</td>
            <td><span class="idx-trunc" title="{{ $r->employee_names }}">{{ $r->employee_names }}</span></td>
            <td><span class="idx-trunc" title="{{ $r->places_visited }}">{{ $r->places_visited }}</span></td>
            <td><span class="idx-trunc" title="{{ $r->purpose }}">{{ $r->purpose }}</span></td>
            <td class="idx-muted idx-nowrap">{{ $r->travel_dates }}</td>
            <td class="idx-muted"><span class="idx-trunc" title="{{ $r->chargeable_against }}">{{ $r->chargeable_against }}</span></td>
            <td class="idx-nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" onclick="openGenericView('travel',{{ $r->id }},'✈️ Travel Details')">👁</button>
                <button class="btn btn-outline btn-sm" onclick="openFormModal('travel-edit','✏️ Edit',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.travel.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" onclick="openMovModal('{{ route('ld.travel.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.travel.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
              </div>
              @if($r->mov_path)<span class="badge badge-green" style="font-size:.58rem;margin-top:3px;display:inline-block">MOV ✓</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($travelRecords->hasPages())<div class="idx-pagination">{{ $travelRecords->appends(['tab'=>'travel'])->links('ld.partials.pagination') }}</div>@endif
  @else
    <div class="idx-empty"><span class="idx-empty-icon">✈️</span><p>No travel authority requests yet.</p><button class="btn btn-primary btn-sm" onclick="openFormModal('travel','✈️ New Authority to Travel')">＋ Create First Request</button></div>
  @endif
</div>
</div>