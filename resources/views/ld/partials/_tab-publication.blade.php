{{-- _tab-publication.blade.php --}}
@php
  $pb_total = $counts['publication'] ?? 0;
  $pb_month = \App\Models\LdPublication::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
  $pb_avg   = \App\Models\LdPublication::avg('amount_requested') ?? 0;
@endphp

<style>
/* ── Publication table fixes ──────────────────────────────────────── */
#idx-p-publication .idx-table {
  table-layout: fixed;
  width: 100%;
}

/* Column widths */
#idx-p-publication .idx-table colgroup col:nth-child(1) { width: 36px; }   /* # */
#idx-p-publication .idx-table colgroup col:nth-child(2) { width: 160px; }  /* Faculty */
#idx-p-publication .idx-table colgroup col:nth-child(3) { width: auto; }   /* Title — takes remaining */
#idx-p-publication .idx-table colgroup col:nth-child(4) { width: 180px; }  /* Journal */
#idx-p-publication .idx-table colgroup col:nth-child(5) { width: 110px; }  /* Scope */
#idx-p-publication .idx-table colgroup col:nth-child(6) { width: 110px; }  /* Amount */
#idx-p-publication .idx-table colgroup col:nth-child(7) { width: 130px; }  /* Actions */

/* All cells: consistent vertical rhythm */
#idx-p-publication .idx-table td,
#idx-p-publication .idx-table th {
  vertical-align: middle;
  padding: 7px 10px;
}

/* Faculty name + campus */
#idx-p-publication .pub-name {
  font-weight: 500;
  font-size: .82rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 140px;
}
#idx-p-publication .pub-sub {
  font-size: .70rem;
  color: var(--color-text-secondary, #888);
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 140px;
}

/* Paper title + journal — truncate with tooltip */
#idx-p-publication .pub-title {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}
#idx-p-publication .pub-journal {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 160px;
}

/* Actions */
#idx-p-publication .idx-act {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
  align-items: center;
}
#idx-p-publication .idx-act .btn {
  padding: 2px 6px;
  font-size: .72rem;
  flex-shrink: 0;
}
</style>

<div class="idx-panel {{ request('tab') === 'publication' ? 'active' : '' }}" id="idx-p-publication" role="tabpanel">
<div class="idx-panel-body">

  {{-- Stats --}}
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $pb_total }}</div><div class="idx-stat-sub">incentive requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $pb_month }}</div><div class="idx-stat-sub">new submissions</div></div>
    <div class="idx-stat"><div class="idx-stat-label">Avg. Amount</div><div class="idx-stat-num" style="font-size:1.3rem">₱{{ number_format($pb_avg,0) }}</div><div class="idx-stat-sub">average incentive</div></div>
  </div>

  {{-- Toolbar --}}
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="publication">
        <input type="text" name="pub_q" value="{{ request('pub_q') }}" placeholder="🔍 Search name, paper…">
        <select name="pub_scope" onchange="this.form.submit()" class="filter-select">
          <option value="">All Scopes</option>
          @foreach(['Regional','National','International'] as $s)
            <option value="{{ $s }}" {{ request('pub_scope')===$s ? 'selected' : '' }}>{{ $s }}</option>
          @endforeach
        </select>
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request()->anyFilled(['pub_q','pub_scope']))
          <a href="{{ route('ld.index') }}?tab=publication" class="btn btn-ghost btn-sm">✕ Clear</a>
        @endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('publication','📰 Publication Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('publication','📰 New Publication Request')">＋ New Request</button>
    </div>
  </div>

  {{-- Table --}}
  @if(isset($publicationRecords) && $publicationRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <colgroup>
          <col><col><col><col><col><col><col>
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Faculty</th>
            <th>Title of Paper</th>
            <th>Journal</th>
            <th>Scope</th>
            <th>Amount</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($publicationRecords as $r)
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>

            <td title="{{ $r->faculty_name }} — {{ $r->campus }}">
              <span class="pub-name">{{ $r->faculty_name }}</span>
              <span class="pub-sub">{{ $r->campus }}</span>
            </td>

            <td title="{{ $r->paper_title }}">
              <span class="pub-title">{{ $r->paper_title }}</span>
            </td>

            <td title="{{ $r->journal_title }}">
              <span class="pub-journal">{{ $r->journal_title }}</span>
            </td>

            <td style="white-space:nowrap">
              <span class="badge badge-gold" style="font-size:.6rem" title="{{ $r->pub_scope }}">{{ $r->pub_scope }}</span>
            </td>

            <td style="white-space:nowrap">
              @if($r->amount_requested)
                <strong>₱{{ number_format($r->amount_requested,2) }}</strong>
              @else
                <span class="idx-muted">—</span>
              @endif
            </td>

            <td style="white-space:nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" title="View details" onclick="openGenericView('publication',{{ $r->id }},'📰 Publication Details')">👁</button>
                <button class="btn btn-outline btn-sm" title="Edit" onclick="openFormModal('publication-edit','✏️ Edit',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" title="Print" onclick="openPrintModal('{{ route('ld.publication.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" title="Attach MOV" onclick="openMovModal('{{ route('ld.publication.mov.upload',$r->id) }}','{{ $r->mov_path ? route('ld.publication.mov.view',$r->id) : '' }}','{{ $r->mov_original_name ?? '' }}',{{ $r->id }})">📎</button>
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
      <span class="idx-empty-icon">📰</span>
      <p>No publication requests yet.</p>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('publication','📰 New Publication Request')">＋ Create First Request</button>
    </div>
  @endif

</div>
</div>