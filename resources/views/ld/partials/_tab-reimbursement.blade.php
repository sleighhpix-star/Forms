{{-- _tab-reimbursement.blade.php --}}
@php
  $ri_total = $counts['reimbursement'] ?? 0;
  $ri_month = \App\Models\LdReimbursement::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
@endphp
<div class="idx-panel" id="idx-p-reimbursement" role="tabpanel">
<div class="idx-panel-body">
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $ri_total }}</div><div class="idx-stat-sub">reimbursement requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $ri_month }}</div><div class="idx-stat-sub">new submissions</div></div>
  </div>
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="reimbursement">
        <input type="text" name="rei_q" value="{{ request('rei_q') }}" placeholder="🔍 Search department…">
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request('rei_q'))<a href="{{ route('ld.index') }}?tab=reimbursement" class="btn btn-ghost btn-sm">✕ Clear</a>@endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('reimbursement','💰 Reimbursement Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')">＋ New Request</button>
    </div>
  </div>
  @if(isset($reimbursementRecords) && $reimbursementRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <thead><tr><th>#</th><th>Department</th><th>Activity</th><th>Venue</th><th>Date</th><th>Total</th><th>Actions</th></tr></thead>
        <tbody>
          @foreach($reimbursementRecords as $i => $r)
          @php $tot = collect($r->expense_items??[])->sum(fn($x)=>(float)($x['amount']??0)); @endphp
          <tr>
            <td class="idx-muted">{{ $reimbursementRecords->firstItem()+$i }}</td>
            <td><strong style="font-weight:600">{{ $r->department }}</strong></td>
            <td class="idx-nowrap">@foreach(($r->activity_types??[]) as $t)<span class="badge badge-crimson" style="font-size:.6rem">{{ $t }}</span>@endforeach</td>
            <td class="idx-muted">{{ $r->venue }}</td>
            <td class="idx-muted idx-nowrap">{{ $r->activity_date }}</td>
            <td class="idx-nowrap">@if($tot>0)<strong>₱{{ number_format($tot,2) }}</strong>@endif</td>
            <td class="idx-nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" onclick="openGenericView('reimbursement',{{ $r->id }},'💰 Reimbursement Details')">👁</button>
                <button class="btn btn-outline btn-sm" onclick="openFormModal('reimbursement-edit','✏️ Edit',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.reimbursement.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" onclick="openMovModal('{{ route('ld.reimbursement.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.reimbursement.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
              </div>
              @if($r->mov_path)<span class="badge badge-green" style="font-size:.58rem;margin-top:3px;display:inline-block">MOV ✓</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    @if($reimbursementRecords->hasPages())<div class="idx-pagination">{{ $reimbursementRecords->appends(['tab'=>'reimbursement'])->links('ld.partials.pagination') }}</div>@endif
  @else
    <div class="idx-empty"><span class="idx-empty-icon">💰</span><p>No reimbursement requests yet.</p><button class="btn btn-primary btn-sm" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')">＋ Create First Request</button></div>
  @endif
</div>
</div>
