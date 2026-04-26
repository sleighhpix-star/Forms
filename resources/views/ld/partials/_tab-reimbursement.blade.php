{{-- _tab-reimbursement.blade.php --}}
@php
  $ri_total = $counts['reimbursement'] ?? 0;
  $ri_month = \App\Models\LdReimbursement::whereMonth('created_at',now()->month)->whereYear('created_at',now()->year)->count();
@endphp

<style>
/* ── Reimbursement table fixes ────────────────────────────────────── */
#idx-p-reimbursement .idx-table {
  table-layout: fixed;
  width: 100%;
}

/* Column widths */
#idx-p-reimbursement .idx-table colgroup col:nth-child(1) { width: 36px; }   /* # */
#idx-p-reimbursement .idx-table colgroup col:nth-child(2) { width: 160px; }  /* Department */
#idx-p-reimbursement .idx-table colgroup col:nth-child(3) { width: 150px; }  /* Activity */
#idx-p-reimbursement .idx-table colgroup col:nth-child(4) { width: auto; }   /* Venue — takes remaining */
#idx-p-reimbursement .idx-table colgroup col:nth-child(5) { width: 210px; }  /* Date — wide for date ranges */
#idx-p-reimbursement .idx-table colgroup col:nth-child(6) { width: 110px; }  /* Total */
#idx-p-reimbursement .idx-table colgroup col:nth-child(7) { width: 130px; }  /* Actions */

/* All cells: consistent vertical rhythm */
#idx-p-reimbursement .idx-table td,
#idx-p-reimbursement .idx-table th {
  vertical-align: middle;
  padding: 7px 10px;
}

/* Department */
#idx-p-reimbursement .rei-dept {
  font-weight: 500;
  font-size: .82rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
  max-width: 140px;
}

/* Venue */
#idx-p-reimbursement .rei-venue {
  font-size: .78rem;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  display: block;
}

/* Activity type badges — pill complete, text truncates with tooltip */
#idx-p-reimbursement .rei-types {
  display: flex;
  flex-wrap: wrap;
  gap: 3px;
}
#idx-p-reimbursement .rei-types .badge {
  display: inline-block;
  max-width: 140px;
  white-space: nowrap;
  overflow: hidden;
  text-overflow: ellipsis;
  vertical-align: middle;
}

/* Actions */
#idx-p-reimbursement .idx-act {
  display: flex;
  flex-wrap: nowrap;
  gap: 2px;
  align-items: center;
}
#idx-p-reimbursement .idx-act .btn {
  padding: 2px 6px;
  font-size: .72rem;
  flex-shrink: 0;
}
</style>

<div class="idx-panel {{ request('tab') === 'reimbursement' ? 'active' : '' }}" id="idx-p-reimbursement" role="tabpanel">
<div class="idx-panel-body">

  {{-- Stats --}}
  <div class="idx-stats">
    <div class="idx-stat"><div class="idx-stat-label">Total</div><div class="idx-stat-num">{{ $ri_total }}</div><div class="idx-stat-sub">reimbursement requests</div></div>
    <div class="idx-stat"><div class="idx-stat-label">This Month</div><div class="idx-stat-num">{{ $ri_month }}</div><div class="idx-stat-sub">new submissions</div></div>
  </div>

  {{-- Toolbar --}}
  <div class="idx-toolbar">
    <div class="idx-toolbar-l">
      <form method="GET" action="{{ route('ld.index') }}" style="display:contents">
        <input type="hidden" name="tab" value="reimbursement">
        <input type="text" name="rei_q" value="{{ request('rei_q') }}" placeholder="🔍 Search department…">
        <button class="btn btn-primary btn-sm" type="submit">Search</button>
        @if(request('rei_q'))
          <a href="{{ route('ld.index') }}?tab=reimbursement" class="btn btn-ghost btn-sm">✕ Clear</a>
        @endif
      </form>
    </div>
    <div class="idx-toolbar-r">
      <button class="btn btn-ghost btn-sm" onclick="openRecordsModal('reimbursement','💰 Reimbursement Records')">📊 All Records</button>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')">＋ New Request</button>
    </div>
  </div>

  {{-- Table --}}
  @if(isset($reimbursementRecords) && $reimbursementRecords->count())
    <div class="idx-table-wrap">
      <table class="idx-table">
        <colgroup>
          <col><col><col><col><col><col><col>
        </colgroup>
        <thead>
          <tr>
            <th>#</th>
            <th>Department</th>
            <th>Activity</th>
            <th>Venue</th>
            <th>Date</th>
            <th>Total</th>
            <th>Actions</th>
          </tr>
        </thead>
        <tbody>
          @foreach($reimbursementRecords as $r)
          @php $tot = collect($r->expense_items ?? [])->sum(fn($x) => (float)($x['amount'] ?? 0)); @endphp
          <tr>
            <td class="idx-muted">{{ $loop->iteration }}</td>

            <td title="{{ $r->department }}">
              <span class="rei-dept">{{ $r->department }}</span>
            </td>

            <td>
              <div class="rei-types">
                @foreach(($r->activity_types ?? []) as $t)
                  <span class="badge badge-crimson" style="font-size:.6rem" title="{{ $t }}">{{ $t }}</span>
                @endforeach
              </div>
            </td>

            <td title="{{ $r->venue }}">
              <span class="rei-venue idx-muted">{{ $r->venue }}</span>
            </td>

            <td class="idx-muted" style="white-space:nowrap" title="{{ $r->activity_date }}">{{ $r->activity_date }}</td>

            <td style="white-space:nowrap">
              @if($tot > 0)
                <strong>₱{{ number_format($tot,2) }}</strong>
              @else
                <span class="idx-muted">—</span>
              @endif
            </td>

            <td style="white-space:nowrap">
              <div class="idx-act">
                <button class="btn btn-ghost btn-sm" title="View details" onclick="openGenericView('reimbursement',{{ $r->id }},'💰 Reimbursement Details')">👁</button>
                <button class="btn btn-outline btn-sm" title="Edit" onclick="openFormModal('reimbursement-edit','✏️ Edit',{{ $r->id }})">✏️</button>
                <button class="btn btn-gold btn-sm" title="Print" onclick="openPrintModal('{{ route('ld.reimbursement.print',$r->id) }}')">🖨</button>
                <button class="btn btn-primary btn-sm" title="Attach MOV" onclick="openMovModal('{{ route('ld.reimbursement.mov.upload',$r->id) }}','{{ $r->mov_path ? route('ld.reimbursement.mov.view',$r->id) : '' }}','{{ $r->mov_original_name ?? '' }}',{{ $r->id }})">📎</button>
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
      <span class="idx-empty-icon">💰</span>
      <p>No reimbursement requests yet.</p>
      <button class="btn btn-primary btn-sm" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')">＋ Create First Request</button>
    </div>
  @endif

</div>
</div>