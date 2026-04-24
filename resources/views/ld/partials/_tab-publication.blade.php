{{-- _tab-publication.blade.php --}}
@php
  $pb_total = $counts['publication'] ?? 0;
  $pb_month = \App\Models\LdPublication::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
  $pb_avg   = \App\Models\LdPublication::avg('amount_requested') ?? 0;
@endphp
<div class="idx-panel {{ request('tab') === 'publication' ? 'active' : '' }}" id="idx-p-publication" role="tabpanel">
<div class="idx-panel-body">
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $pb_total }}</div><div class="idx-stat-sub">incentive requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $pb_month }}</div><div class="idx-stat-sub">new submissions</div></div>
    <div class="idx-stat"><div class="idx-stat-label">Avg. Amount</div><div class="idx-stat-num" style="font-size:1.3rem">₱{{ number_format($pb_avg,0) }}</div><div class="idx-stat-sub">average incentive</div></div>
  </div>
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="publication">
        <input type="text" name="pub_q" value="{{ request('pub_q') }}" placeholder="🔍 Search name, paper…">
        <select name="pub_scope" onchange="this.form.submit()" class="filter-select">
          <option value="">All Scopes</option>
          @foreach(['Regional','National','International'] as $s)<option value="{{ $s }}" {{ request('pub_scope')===$s?'selected':'' }}>{{ $s }}</option>@endforeach
        </select>
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request()->anyFilled(['pub_q','pub_scope']))<a href="{{ route('ld.index') }}?tab=publication" class="btn btn-ghost btn-sm">✕ Clear</a>@endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('publication','📰 Publication Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('publication','📰 New Publication Request')">＋ New Request</button>
    </div>
  </div>
  @if(isset($publicationRecords) && $publicationRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <thead><tr><th>#</th><th>Faculty</th><th>Title of Paper</th><th>Journal</th><th>Scope</th><th>Amount</th><th>Actions</th></tr></thead>
        <tbody>
          @foreach($publicationRecords as $i => $r)
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>
            <td><strong style="font-weight:600">{{ $r->faculty_name }}</strong><div class="idx-muted">{{ $r->campus }}</div></td>
            <td><span class="idx-trunc" title="{{ $r->paper_title }}">{{ $r->paper_title }}</span></td>
            <td><span class="idx-trunc" title="{{ $r->journal_title }}">{{ $r->journal_title }}</span></td>
            <td class="idx-nowrap"><span class="badge badge-gold" style="font-size:.6rem">{{ $r->pub_scope }}</span></td>
            <td class="idx-nowrap">@if($r->amount_requested)<strong>₱{{ number_format($r->amount_requested,2) }}</strong>@endif</td>
            <td class="idx-nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" onclick="openGenericView('publication',{{ $r->id }},'📰 Publication Details')">👁</button>
                <button class="btn btn-outline btn-sm" onclick="openFormModal('publication-edit','✏️ Edit',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.publication.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" onclick="openMovModal('{{ route('ld.publication.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.publication.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
              </div>
              @if($r->mov_path)<span class="badge badge-green" style="font-size:.58rem;margin-top:3px;display:inline-block">MOV ✓</span>@endif
            </td>
          </tr>
          @endforeach
        </tbody>
      </table>
    </div>
    
  @else
    <div class="idx-empty"><span class="idx-empty-icon">📰</span><p>No publication requests yet.</p><button class="btn btn-primary btn-sm" onclick="openFormModal('publication','📰 New Publication Request')">＋ Create First Request</button></div>
  @endif
</div>
</div>