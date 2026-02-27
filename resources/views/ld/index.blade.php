@extends('ld.layouts.app')

@section('title', 'Request Records — BatStateU')

@push('styles')
<style>
/* ── Base modal overlay ── */
.modal-overlay {
  display:none; position:fixed; inset:0;
  background:rgba(0,0,0,.55); z-index:9999;
  align-items:flex-start; justify-content:center;
  overflow-y:auto; padding:2rem 1rem;
}
.modal-overlay.active { display:flex; }
.modal-box {
  background:#fff; border-radius:14px;
  width:100%; max-width:860px;
  box-shadow:0 20px 60px rgba(0,0,0,.35);
  margin:auto;
}
.modal-header {
  background:var(--maroon); padding:.75rem 1.25rem;
  display:flex; align-items:center; justify-content:space-between;
  border-radius:14px 14px 0 0;
}
.modal-header span { color:#fff; font-size:.9rem; font-weight:600; }
.modal-close {
  background:rgba(255,255,255,.2); border:none; color:#fff;
  border-radius:6px; padding:.3rem .75rem; cursor:pointer;
  font-size:.85rem; font-weight:600;
}
.modal-close:hover { background:rgba(255,255,255,.35); }
.modal-body { min-height:180px; display:flex; align-items:center; justify-content:center; }

/* ── Print / iframe modal ── */
.print-modal-overlay {
  display:none; position:fixed; inset:0;
  background:rgba(0,0,0,.55); z-index:10000;
  align-items:center; justify-content:center;
}
.print-modal-overlay.active { display:flex; }
.print-modal {
  background:#fff; border-radius:14px;
  width:92vw; max-width:820px; height:90vh;
  display:flex; flex-direction:column; overflow:hidden;
  box-shadow:0 20px 60px rgba(0,0,0,.35);
}
.print-modal-header {
  background:var(--maroon); padding:.75rem 1.25rem;
  display:flex; align-items:center; justify-content:space-between; flex-shrink:0;
}
.print-modal-header span { color:#fff; font-size:.9rem; font-weight:600; }
.print-modal-close {
  background:rgba(255,255,255,.2); border:none; color:#fff;
  border-radius:6px; padding:.3rem .75rem; cursor:pointer; font-size:.85rem; font-weight:600;
}
.print-modal-close:hover { background:rgba(255,255,255,.35); }
.print-modal iframe { flex:1; border:none; width:100%; background:#f5f5f5; }

/* ── Tabs ── */
.form-tabs {
  display:flex; overflow-x:auto; flex-wrap:nowrap; gap:.4rem;
  padding:.75rem 1rem; background:#f3f4f6;
  border-radius:12px 12px 0 0;
  border:1px solid #e5e7eb; border-bottom:none;
}
.form-tab {
  padding:.48rem 1.1rem; border:none; cursor:pointer;
  font-size:.8rem; font-weight:700; white-space:nowrap;
  border-radius:8px; display:flex; align-items:center; gap:.4rem;
  transition:all .18s; background:#e5e7eb; color:#4b5563;
  box-shadow:0 1px 2px rgba(0,0,0,.06);
  letter-spacing:.01em;
}
.form-tab:hover { background:#d1d5db; color:#1f2937; }
.form-tab.active {
  background:var(--maroon); color:#fff;
  box-shadow:0 3px 10px rgba(139,26,43,.35);
}
.tab-badge {
  background:rgba(0,0,0,.12); color:inherit;
  border-radius:20px; padding:.05rem .45rem;
  font-size:.68rem; font-weight:800;
}
.form-tab.active .tab-badge { background:rgba(255,255,255,.25); color:#fff; }

.tab-panel { display:none; }
.tab-panel.active { display:block; }
.tab-content {
  background:white; border:1px solid #e5e7eb;
  border-top:none; border-radius:0 0 12px 12px;
}

/* ── Tab action bar (NEW — sits between tab strip and filter bar) ── */
.tab-action-bar {
  display:flex; align-items:center; justify-content:space-between; flex-wrap:wrap; gap:.5rem;
  padding:.6rem 1.25rem;
  background:#fafafa;
  border-bottom:1px solid #f0f0f0;
}
.tab-action-bar-left { display:flex; align-items:center; gap:.5rem; flex-wrap:wrap; }
.tab-action-bar-right { display:flex; align-items:center; gap:.5rem; }

/* ── Filter bar ── */
.tab-filters {
  padding:.65rem 1.25rem; border-bottom:1px solid #f3f4f6;
  display:flex; flex-wrap:wrap; gap:.5rem; align-items:center;
}
.tab-filters input[type=text] {
  padding:.42rem .85rem; border:1.5px solid var(--gray-200);
  border-radius:8px; font-size:.82rem; width:220px; outline:none;
}
.tab-filters input[type=text]:focus { border-color:var(--maroon); }

/* (global form picker removed — use per-tab buttons instead) */

/* ── Actions column ── */
.act-wrap { display:flex; gap:.3rem; flex-wrap:wrap; }

/* ── Database / Quick-add grid ── */
.db-bar {
  display:flex; align-items:center; justify-content:space-between;
  padding:.55rem 1.25rem; background:#fafafa;
  border-top:1px solid #f3f4f6;
}
.db-bar-label { font-size:.75rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.5pt; }
.btn-db {
  display:flex; align-items:center; gap:.35rem;
  background:#fff; border:1.5px solid #d1d5db; color:#374151;
  border-radius:7px; padding:.3rem .75rem; cursor:pointer;
  font-size:.78rem; font-weight:600; transition:all .15s;
}
.btn-db:hover { border-color:var(--maroon); color:var(--maroon); background:#fdf2f2; }
.qa-grid { display:none; border-top:2px dashed #e5e7eb; background:#fefefe; }
.qa-grid.open { display:block; }
.qa-grid-inner { display:grid; gap:.5rem; padding:.85rem 1.25rem; align-items:end; }
.qa-field label { display:block; font-size:.72rem; font-weight:700; color:#6b7280; margin-bottom:.2rem; text-transform:uppercase; letter-spacing:.3pt; }
.qa-field input, .qa-field select, .qa-field textarea {
  width:100%; padding:.38rem .65rem; border:1.5px solid #d1d5db; border-radius:7px;
  font-size:.8rem; outline:none; font-family:inherit; background:white; transition:border-color .15s;
}
.qa-field input:focus, .qa-field select:focus, .qa-field textarea:focus { border-color:var(--maroon); }
.qa-field textarea { resize:vertical; min-height:2.4rem; }
.qa-actions {
  display:flex; gap:.5rem; padding:.6rem 1.25rem .85rem;
  border-top:1px solid #f3f4f6; background:#fefefe; border-radius:0 0 12px 12px;
}
.btn-qa-save {
  background:var(--maroon); color:#fff; border:none;
  border-radius:7px; padding:.38rem .9rem; font-size:.8rem; font-weight:700; cursor:pointer;
}
.btn-qa-save:hover { background:#6e1522; }
.btn-qa-cancel {
  background:none; color:#6b7280; border:1.5px solid #d1d5db;
  border-radius:7px; padding:.38rem .9rem; font-size:.8rem; font-weight:600; cursor:pointer;
}
.btn-qa-cancel:hover { background:#f3f4f6; }

/* ── Records popup modal ── */
.records-modal-overlay {
  display:none; position:fixed; inset:0;
  background:rgba(0,0,0,.55); z-index:10500;
  align-items:flex-start; justify-content:center;
  overflow-y:auto; padding:2rem 1rem;
}
.records-modal-overlay.active { display:flex; }
.records-modal-box {
  background:#fff; border-radius:14px;
  width:100%; max-width:92vw;
  box-shadow:0 20px 60px rgba(0,0,0,.35);
  margin:auto; overflow:hidden;
}
.records-modal-header {
  background:var(--maroon); padding:.75rem 1.25rem;
  display:flex; align-items:center; justify-content:space-between;
}
.records-modal-header span { color:#fff; font-size:.95rem; font-weight:700; }
.records-modal-search {
  padding:.75rem 1.25rem; background:#f9fafb; border-bottom:1px solid #e5e7eb;
  display:flex; gap:.5rem; align-items:center; flex-wrap:wrap;
}
.records-modal-search input {
  padding:.4rem .85rem; border:1.5px solid #d1d5db; border-radius:8px;
  font-size:.82rem; outline:none; width:260px;
}
.records-modal-search input:focus { border-color:var(--maroon); }
.records-modal-body {
  max-height:calc(90vh - 180px);
  overflow-y:auto;
  overflow-x:hidden;
  display:flex;
  flex-direction:column;
}
.records-scroll-wrap {
  overflow-x:auto;
  overflow-y:visible;
  flex:1;
}
.records-scroll-wrap::-webkit-scrollbar { height:10px; }
.records-scroll-wrap::-webkit-scrollbar-track { background:#f1f1f1; }
.records-scroll-wrap::-webkit-scrollbar-thumb { background:#c7c7c7; border-radius:6px; }
.records-scroll-wrap::-webkit-scrollbar-thumb:hover { background:#a0a0a0; }
.records-scroll-wrap { scrollbar-width:thin; scrollbar-color:#c7c7c7 #f1f1f1; }
.records-modal-footer {
  padding:.6rem 1.25rem; background:#f9fafb;
  border-top:1px solid #e5e7eb;
  display:flex; align-items:center; justify-content:space-between;
  font-size:.78rem; color:#6b7280;
}
.rm-empty {
  padding:3rem; text-align:center; color:#9ca3af;
}
.rm-empty-icon { font-size:2.5rem; margin-bottom:.5rem; }
</style>
@endpush

@section('content')
<div class="page page-wide">

  @if(session('success'))
    <div class="alert alert-success">✅ {{ session('success') }}</div>
  @endif
  @if(session('error'))
    <div class="alert alert-danger">⚠️ {{ session('error') }}</div>
  @endif
  @if(session('mov_debug'))
    <div class="alert alert-info">🧪 {{ session('mov_debug') }}</div>
  @endif
  @if($errors->any())
    <div class="alert alert-danger">
      <strong>Error:</strong>
      <ul style="margin:.4rem 0 0 1.1rem;">
        @foreach($errors->all() as $e)<li>{{ $e }}</li>@endforeach
      </ul>
    </div>
  @endif

  {{-- Page header --}}
  <div class="mb-3">
    <h2 style="font-family:'DM Serif Display',serif;font-size:1.4rem;color:var(--maroon)">
      Request Records
    </h2>
    <p class="text-muted text-sm mt-1">Manage all L&amp;D and administrative request forms</p>
  </div>

  {{-- ═══ TABS ═══ --}}
  <div class="form-tabs">
    <button class="form-tab active" id="tab-participation" onclick="switchTab('participation')">
      📋 Participation <span class="tab-badge">{{ $counts['participation'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-attendance" onclick="switchTab('attendance')">
      📅 Attendance <span class="tab-badge">{{ $counts['attendance'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-publication" onclick="switchTab('publication')">
      📰 Publication Incentive <span class="tab-badge">{{ $counts['publication'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-reimbursement" onclick="switchTab('reimbursement')">
      💰 Reimbursement <span class="tab-badge">{{ $counts['reimbursement'] ?? 0 }}</span>
    </button>
    <button class="form-tab" id="tab-travel" onclick="switchTab('travel')">
      ✈️ Authority to Travel <span class="tab-badge">{{ $counts['travel'] ?? 0 }}</span>
    </button>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 1 — Request for Participation             --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel active" id="panel-participation">
    <div class="tab-content">

      {{-- Tab action bar --}}
      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" onclick="openCreateModal()" style="display:flex;align-items:center;gap:.35rem;">
            ✏️ New Participation Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" onclick="openRecordsModal('participation','📋 Participation Records')" style="display:flex;align-items:center;gap:.35rem;">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="participation">
          <input type="text" name="search" value="{{ request('search') }}" placeholder="🔍 Search name, title...">
          <select class="filter-select" name="type" onchange="this.form.submit()">
            <option value="">All Types</option>
            @foreach($types ?? [] as $t)
              <option value="{{ $t }}" {{ request('type')===$t?'selected':'' }}>{{ $t }}</option>
            @endforeach
          </select>
          <select class="filter-select" name="level" onchange="this.form.submit()">
            <option value="">All Levels</option>
            @foreach($levels ?? [] as $l)
              <option value="{{ $l }}" {{ request('level')===$l?'selected':'' }}>{{ $l }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['search','type','level']))
            <a href="{{ route('ld.index') }}?tab=participation" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($records) && $records->count())
        <table class="data-table">
          <thead><tr>
            <th>#</th><th>Participant</th><th>Campus</th>
            <th>Title of Intervention</th><th>Type</th><th>Level</th>
            <th>Date</th><th>Financial</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($records as $i => $r)
            <tr>
              <td class="muted">{{ $records->firstItem() + $i }}</td>
              <td>
                <strong>{{ $r->participant_name }}</strong>
                <div class="muted text-sm">{{ $r->position }}</div>
              </td>
              <td class="muted">{{ $r->campus }}</td>
              <td style="max-width:200px">
                <span title="{{ $r->title }}" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->title }}</span>
                <div class="muted text-xs">{{ $r->college_office }}</div>
              </td>
              <td>@foreach(($r->types??[]) as $t)<span class="badge badge-maroon">{{ $t }}</span>@endforeach</td>
              <td><span class="badge badge-gold">{{ $r->level }}</span></td>
              <td class="muted">{{ $r->intervention_date }}</td>
              <td>
                @if($r->financial_requested)
                  <span class="badge badge-green">Yes</span>
                @else
                  <span class="text-muted text-sm">No</span>
                @endif
              </td>
              <td>
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" onclick="openViewModal({{ $r->id }})">View</button>
                  <button class="btn btn-ghost btn-sm" onclick="openEditModal({{ $r->id }})">Edit</button>
                  <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.print', $r->id) }}')">🖨</button>
                  <button class="btn btn-primary btn-sm" data-mov-btn="{{ $r->id }}"
                          onclick="openMovModal('{{ route('ld.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
                </div>
                @if($r->mov_path)<div class="mt-1"><span class="badge badge-green">MOV ✓</span></div>@endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if($records->hasPages())
          <div style="padding:1rem 1.25rem;border-top:1px solid var(--gray-100)">
            {{ $records->appends(['tab'=>'participation'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">📋</div><p>No participation requests yet.</p></div>
      @endif

      {{-- db bar --}}
      <div class="db-bar">
        <span class="db-bar-label">📊 Quick Add Row</span>
        <button class="btn-db" onclick="toggleQA('qa-participation')">＋ Add Row</button>
      </div>
      <div class="qa-grid" id="qa-participation">
        <form method="POST" action="{{ route('ld.store') }}" id="qaf-participation">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
            <div class="qa-field"><label>Participant Name*</label><input type="text" name="participant_name" required></div>
            <div class="qa-field"><label>Position</label><input type="text" name="position"></div>
            <div class="qa-field"><label>Campus</label><input type="text" name="campus"></div>
            <div class="qa-field"><label>College / Office</label><input type="text" name="college_office"></div>
            <div class="qa-field"><label>Title of Intervention*</label><input type="text" name="title" required></div>
            <div class="qa-field"><label>Type</label>
              <select name="types[]" multiple style="height:2.6rem;">
                <option>Seminar</option><option>Training</option><option>Convention</option>
                <option>Conference</option><option>Workshop</option><option>Symposium</option><option>Immersion</option>
              </select>
            </div>
            <div class="qa-field"><label>Level</label>
              <select name="level">
                <option value="">—</option><option>Local</option><option>Regional</option><option>National</option><option>International</option>
              </select>
            </div>
            <div class="qa-field"><label>Date</label><input type="date" name="intervention_date"></div>
            <div class="qa-field"><label>Financial Requested</label>
              <select name="financial_requested"><option value="0">No</option><option value="1">Yes</option></select>
            </div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-participation')">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 2 — Request for Attendance               --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-attendance">
    <div class="tab-content">

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" onclick="openFormModal('attendance','📅 New Attendance Request')" style="display:flex;align-items:center;gap:.35rem;">
            ✏️ New Attendance Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" onclick="openRecordsModal('attendance','📅 Attendance Records')" style="display:flex;align-items:center;gap:.35rem;">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="attendance">
          <input type="text" name="att_search" value="{{ request('att_search') }}" placeholder="🔍 Search name, activity...">
          <select class="filter-select" name="att_level" onchange="this.form.submit()">
            <option value="">All Levels</option>
            @foreach(['Local','Regional','National','International'] as $l)
              <option value="{{ $l }}" {{ request('att_level')===$l?'selected':'' }}>{{ $l }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['att_search','att_level']))
            <a href="{{ route('ld.index') }}?tab=attendance" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($attendanceRecords) && $attendanceRecords->count())
        <table class="data-table">
          <thead><tr>
            <th>#</th><th>Attendee</th><th>Campus / Office</th>
            <th>Type of Activity</th><th>Purpose</th>
            <th>Level</th><th>Date</th><th>Financial</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($attendanceRecords as $i => $r)
            <tr>
              <td class="muted">{{ $attendanceRecords->firstItem() + $i }}</td>
              <td>
                <strong>{{ $r->attendee_name }}</strong>
                <div class="muted text-sm">{{ $r->position }}</div>
              </td>
              <td class="muted">
                {{ $r->campus }}
                <div class="muted text-xs">{{ $r->college_office }}</div>
              </td>
              <td>@foreach(($r->activity_types??[]) as $t)<span class="badge badge-maroon">{{ $t }}</span>@endforeach</td>
              <td style="max-width:180px">
                <span title="{{ $r->purpose }}" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->purpose }}</span>
              </td>
              <td><span class="badge badge-gold">{{ $r->level }}</span></td>
              <td class="muted">{{ $r->activity_date }}</td>
              <td>
                @if($r->financial_requested)
                  <span class="badge badge-green">Yes</span>
                @else
                  <span class="text-muted text-sm">No</span>
                @endif
              </td>
              <td>
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" onclick="openGenericView('attendance',{{ $r->id }},'📅 Attendance Details')">View</button>
                  <button class="btn btn-ghost btn-sm" onclick="openFormModal('attendance-edit','✏️ Edit Attendance',{{ $r->id }})">Edit</button>
                  <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.attendance.print',$r->id) }}')">🖨</button>
                  <button class="btn btn-primary btn-sm"
                          onclick="openMovModal('{{ route('ld.attendance.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.attendance.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
                </div>
                @if($r->mov_path)<div class="mt-1"><span class="badge badge-green">MOV ✓</span></div>@endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if($attendanceRecords->hasPages())
          <div style="padding:1rem 1.25rem;border-top:1px solid var(--gray-100)">
            {{ $attendanceRecords->appends(['tab'=>'attendance'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">📅</div><p>No attendance requests yet.</p></div>
      @endif

      <div class="db-bar">
        <span class="db-bar-label">📊 Quick Add Row</span>
        <button class="btn-db" onclick="toggleQA('qa-attendance')">＋ Add Row</button>
      </div>
      <div class="qa-grid" id="qa-attendance">
        <form method="POST" action="{{ route('ld.attendance.store') }}" id="qaf-attendance">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
            <div class="qa-field"><label>Attendee Name*</label><input type="text" name="attendee_name" required></div>
            <div class="qa-field"><label>Position</label><input type="text" name="position"></div>
            <div class="qa-field"><label>Campus</label><input type="text" name="campus"></div>
            <div class="qa-field"><label>College / Office</label><input type="text" name="college_office"></div>
            <div class="qa-field"><label>Employment Status</label>
              <select name="employment_status"><option value="">—</option><option>Permanent</option><option>Temporary</option><option>Contractual</option><option>COS</option></select>
            </div>
            <div class="qa-field"><label>Activity Type</label>
              <select name="activity_types[]" multiple style="height:2.6rem;">
                <option>Meeting</option><option>Planning Session</option><option>Benchmarking</option>
                <option>Project/Product Launch</option><option>Ceremonial/Representational</option>
              </select>
            </div>
            <div class="qa-field"><label>Purpose*</label><input type="text" name="purpose" required></div>
            <div class="qa-field"><label>Level</label>
              <select name="level"><option value="">—</option><option>Local</option><option>Regional</option><option>National</option><option>International</option></select>
            </div>
            <div class="qa-field"><label>Date</label><input type="date" name="activity_date"></div>
            <div class="qa-field"><label>Venue</label><input type="text" name="venue"></div>
            <div class="qa-field"><label>Organizer</label><input type="text" name="organizer"></div>
            <div class="qa-field"><label>Financial Requested</label>
              <select name="financial_requested"><option value="0">No</option><option value="1">Yes</option></select>
            </div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-attendance')">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 3 — Research Publication Incentive        --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-publication">
    <div class="tab-content">

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" onclick="openFormModal('publication','📰 New Publication Incentive Request')" style="display:flex;align-items:center;gap:.35rem;">
            ✏️ New Publication Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" onclick="openRecordsModal('publication','📰 Publication Incentive Records')" style="display:flex;align-items:center;gap:.35rem;">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="publication">
          <input type="text" name="pub_search" value="{{ request('pub_search') }}" placeholder="🔍 Search name, paper title...">
          <select class="filter-select" name="pub_scope" onchange="this.form.submit()">
            <option value="">All Scopes</option>
            @foreach(['Regional','National','International'] as $s)
              <option value="{{ $s }}" {{ request('pub_scope')===$s?'selected':'' }}>{{ $s }}</option>
            @endforeach
          </select>
          <select class="filter-select" name="pub_nature" onchange="this.form.submit()">
            <option value="">All Natures</option>
            @foreach(['CHED accredited (multidisciplinary)','CHED accredited (specific discipline)','ISI indexed','SCOPUS indexed'] as $n)
              <option value="{{ $n }}" {{ request('pub_nature')===$n?'selected':'' }}>{{ $n }}</option>
            @endforeach
          </select>
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['pub_search','pub_scope','pub_nature']))
            <a href="{{ route('ld.index') }}?tab=publication" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($publicationRecords) && $publicationRecords->count())
        <table class="data-table">
          <thead><tr>
            <th>#</th><th>Faculty / Employee</th><th>Campus</th>
            <th>Title of Paper</th><th>Journal</th>
            <th>Scope</th><th>Nature</th><th>Amount</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($publicationRecords as $i => $r)
            <tr>
              <td class="muted">{{ $publicationRecords->firstItem() + $i }}</td>
              <td>
                <strong>{{ $r->faculty_name }}</strong>
                <div class="muted text-sm">{{ $r->position }}</div>
              </td>
              <td class="muted">{{ $r->campus }}</td>
              <td style="max-width:180px">
                <span title="{{ $r->paper_title }}" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->paper_title }}</span>
                <div class="muted text-xs">{{ $r->co_authors }}</div>
              </td>
              <td class="muted" style="max-width:140px">
                <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->journal_title }}</span>
                <div class="muted text-xs">{{ $r->issn_isbn }}</div>
              </td>
              <td><span class="badge badge-gold">{{ $r->pub_scope }}</span></td>
              <td class="muted text-sm">{{ $r->nature }}</td>
              <td class="muted">@if($r->amount_requested)Php {{ number_format($r->amount_requested,2) }}@endif</td>
              <td>
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" onclick="openGenericView('publication',{{ $r->id }},'📰 Publication Details')">View</button>
                  <button class="btn btn-ghost btn-sm" onclick="openFormModal('publication-edit','✏️ Edit Publication',{{ $r->id }})">Edit</button>
                  <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.publication.print',$r->id) }}')">🖨</button>
                  <button class="btn btn-primary btn-sm"
                          onclick="openMovModal('{{ route('ld.publication.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.publication.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
                </div>
                @if($r->mov_path)<div class="mt-1"><span class="badge badge-green">MOV ✓</span></div>@endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if($publicationRecords->hasPages())
          <div style="padding:1rem 1.25rem;border-top:1px solid var(--gray-100)">
            {{ $publicationRecords->appends(['tab'=>'publication'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">📰</div><p>No publication incentive requests yet.</p></div>
      @endif

      <div class="db-bar">
        <span class="db-bar-label">📊 Quick Add Row</span>
        <button class="btn-db" onclick="toggleQA('qa-publication')">＋ Add Row</button>
      </div>
      <div class="qa-grid" id="qa-publication">
        <form method="POST" action="{{ route('ld.publication.store') }}" id="qaf-publication">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(170px,1fr));">
            <div class="qa-field"><label>Faculty / Employee*</label><input type="text" name="faculty_name" required></div>
            <div class="qa-field"><label>Position</label><input type="text" name="position"></div>
            <div class="qa-field"><label>College / Office</label><input type="text" name="college_office"></div>
            <div class="qa-field"><label>Campus</label><input type="text" name="campus"></div>
            <div class="qa-field"><label>Employment Status</label>
              <select name="employment_status"><option value="">—</option><option>Permanent</option><option>Temporary</option><option>Contractual</option><option>COS</option></select>
            </div>
            <div class="qa-field"><label>Title of Paper*</label><input type="text" name="paper_title" required></div>
            <div class="qa-field"><label>Co-author/s</label><input type="text" name="co_authors"></div>
            <div class="qa-field"><label>Journal Title</label><input type="text" name="journal_title"></div>
            <div class="qa-field"><label>ISSN / ISBN</label><input type="text" name="issn_isbn"></div>
            <div class="qa-field"><label>Publisher</label><input type="text" name="publisher"></div>
            <div class="qa-field"><label>Scope</label>
              <select name="pub_scope"><option value="">—</option><option>Regional</option><option>National</option><option>International</option></select>
            </div>
            <div class="qa-field"><label>Format</label>
              <select name="pub_format"><option value="">—</option><option>Print</option><option>Online</option></select>
            </div>
            <div class="qa-field"><label>Nature</label>
              <select name="nature">
                <option value="">—</option>
                <option>CHED accredited (multidisciplinary)</option>
                <option>CHED accredited (specific discipline)</option>
                <option>ISI indexed</option><option>SCOPUS indexed</option>
              </select>
            </div>
            <div class="qa-field"><label>Amount Requested (Php)</label><input type="number" name="amount_requested" step="0.01" min="0"></div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-publication')">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 4 — Reimbursement of Expenses            --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-reimbursement">
    <div class="tab-content">

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" onclick="openFormModal('reimbursement','💰 New Reimbursement Request')" style="display:flex;align-items:center;gap:.35rem;">
            ✏️ New Reimbursement Request
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" onclick="openRecordsModal('reimbursement','💰 Reimbursement Records')" style="display:flex;align-items:center;gap:.35rem;">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="reimbursement">
          <input type="text" name="rei_search" value="{{ request('rei_search') }}" placeholder="🔍 Search department, payee...">
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['rei_search']))
            <a href="{{ route('ld.index') }}?tab=reimbursement" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($reimbursementRecords) && $reimbursementRecords->count())
        <table class="data-table">
          <thead><tr>
            <th>#</th><th>Department / Office</th>
            <th>Particulars</th><th>Activity Type</th>
            <th>Venue</th><th>Date</th><th>Total Amount</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($reimbursementRecords as $i => $r)
            @php $total = collect($r->expense_items ?? [])->sum(fn($x) => (float)($x['amount'] ?? 0)); @endphp
            <tr>
              <td class="muted">{{ $reimbursementRecords->firstItem() + $i }}</td>
              <td><strong>{{ $r->department }}</strong></td>
              <td style="max-width:180px">
                <span style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">
                  {{ collect($r->expense_items??[])->pluck('description')->filter()->take(2)->implode(', ') }}
                </span>
              </td>
              <td>@foreach(($r->activity_types??[]) as $t)<span class="badge badge-maroon">{{ $t }}</span>@endforeach</td>
              <td class="muted">{{ $r->venue }}</td>
              <td class="muted">{{ $r->activity_date }}</td>
              <td><strong>@if($total > 0)Php {{ number_format($total,2) }}@endif</strong></td>
              <td>
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" onclick="openGenericView('reimbursement',{{ $r->id }},'💰 Reimbursement Details')">View</button>
                  <button class="btn btn-ghost btn-sm" onclick="openFormModal('reimbursement-edit','✏️ Edit Reimbursement',{{ $r->id }})">Edit</button>
                  <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.reimbursement.print',$r->id) }}')">🖨</button>
                  <button class="btn btn-primary btn-sm"
                          onclick="openMovModal('{{ route('ld.reimbursement.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.reimbursement.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
                </div>
                @if($r->mov_path)<div class="mt-1"><span class="badge badge-green">MOV ✓</span></div>@endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if($reimbursementRecords->hasPages())
          <div style="padding:1rem 1.25rem;border-top:1px solid var(--gray-100)">
            {{ $reimbursementRecords->appends(['tab'=>'reimbursement'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">💰</div><p>No reimbursement requests yet.</p></div>
      @endif

      <div class="db-bar">
        <span class="db-bar-label">📊 Quick Add Row</span>
        <button class="btn-db" onclick="toggleQA('qa-reimbursement')">＋ Add Row</button>
      </div>
      <div class="qa-grid" id="qa-reimbursement">
        <form method="POST" action="{{ route('ld.reimbursement.store') }}" id="qaf-reimbursement">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(160px,1fr));">
            <div class="qa-field"><label>Department / Office*</label><input type="text" name="department" required></div>
            <div class="qa-field"><label>Payee Name</label><input type="text" name="payee_name"></div>
            <div class="qa-field"><label>Item / Description*</label><input type="text" name="item_description" required></div>
            <div class="qa-field"><label>Quantity</label><input type="number" name="quantity" min="1" step="1"></div>
            <div class="qa-field"><label>Unit Cost (Php)</label><input type="number" name="unit_cost" step="0.01" min="0"></div>
            <div class="qa-field"><label>Amount (Php)</label><input type="number" name="amount" step="0.01" min="0"></div>
            <div class="qa-field"><label>Activity Type</label>
              <select name="activity_types[]" multiple style="height:2.6rem;">
                <option>Seminar/Training</option><option>Meeting</option><option>Seminar/Conference</option>
                <option>Accreditation</option><option>Program</option>
              </select>
            </div>
            <div class="qa-field"><label>Venue</label><input type="text" name="venue"></div>
            <div class="qa-field"><label>Date</label><input type="date" name="activity_date"></div>
            <div class="qa-field"><label>Reason for Reimbursement</label><textarea name="reason"></textarea></div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-reimbursement')">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

  {{-- ══════════════════════════════════════════════ --}}
  {{-- TAB 5 — Authority to Travel                  --}}
  {{-- ══════════════════════════════════════════════ --}}
  <div class="tab-panel" id="panel-travel">
    <div class="tab-content">

      <div class="tab-action-bar">
        <div class="tab-action-bar-left">
          <button class="btn btn-primary btn-sm" onclick="openFormModal('travel','✈️ New Authority to Travel')" style="display:flex;align-items:center;gap:.35rem;">
            ✏️ New Travel Authority
          </button>
        </div>
        <div class="tab-action-bar-right">
          <button class="btn btn-outline btn-sm" onclick="openRecordsModal('travel','✈️ Travel Authority Records')" style="display:flex;align-items:center;gap:.35rem;">
            📊 All Records
          </button>
        </div>
      </div>

      <div class="tab-filters">
        <form method="GET" action="{{ route('ld.index') }}" class="d-flex flex-wrap gap-1 align-center">
          <input type="hidden" name="tab" value="travel">
          <input type="text" name="trv_search" value="{{ request('trv_search') }}" placeholder="🔍 Search employee, place...">
          <button class="btn btn-primary btn-sm" type="submit">Search</button>
          @if(request()->anyFilled(['trv_search']))
            <a href="{{ route('ld.index') }}?tab=travel" class="btn btn-ghost btn-sm">Clear</a>
          @endif
        </form>
      </div>

      @if(isset($travelRecords) && $travelRecords->count())
        <table class="data-table">
          <thead><tr>
            <th>#</th><th>Employee/s</th>
            <th>Place/s to be Visited</th><th>Purpose</th>
            <th>Date of Travel</th><th>Time</th><th>Chargeable To</th><th>Actions</th>
          </tr></thead>
          <tbody>
            @foreach($travelRecords as $i => $r)
            <tr>
              <td class="muted">{{ $travelRecords->firstItem() + $i }}</td>
              <td style="max-width:160px">
                <span title="{{ $r->employee_names }}" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->employee_names }}</span>
              </td>
              <td style="max-width:160px">
                <span title="{{ $r->places_visited }}" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->places_visited }}</span>
              </td>
              <td style="max-width:180px">
                <span title="{{ $r->purpose }}" style="display:block;overflow:hidden;text-overflow:ellipsis;white-space:nowrap;">{{ $r->purpose }}</span>
              </td>
              <td class="muted">{{ $r->travel_dates }}</td>
              <td class="muted">{{ $r->travel_time }}</td>
              <td class="muted">{{ $r->chargeable_against }}</td>
              <td>
                <div class="act-wrap">
                  <button class="btn btn-outline btn-sm" onclick="openGenericView('travel',{{ $r->id }},'✈️ Travel Authority Details')">View</button>
                  <button class="btn btn-ghost btn-sm" onclick="openFormModal('travel-edit','✏️ Edit Travel Authority',{{ $r->id }})">Edit</button>
                  <button class="btn btn-gold btn-sm" onclick="openPrintModal('{{ route('ld.travel.print',$r->id) }}')">🖨</button>
                  <button class="btn btn-primary btn-sm"
                          onclick="openMovModal('{{ route('ld.travel.mov.upload',$r->id) }}','{{ $r->mov_path?route('ld.travel.mov.view',$r->id):'' }}','{{ $r->mov_original_name??'' }}',{{ $r->id }})">📎</button>
                </div>
                @if($r->mov_path)<div class="mt-1"><span class="badge badge-green">MOV ✓</span></div>@endif
              </td>
            </tr>
            @endforeach
          </tbody>
        </table>
        @if($travelRecords->hasPages())
          <div style="padding:1rem 1.25rem;border-top:1px solid var(--gray-100)">
            {{ $travelRecords->appends(['tab'=>'travel'])->links('ld.partials.pagination') }}
          </div>
        @endif
      @else
        <div class="empty-state"><div class="empty-icon">✈️</div><p>No travel authority requests yet.</p></div>
      @endif

      <div class="db-bar">
        <span class="db-bar-label">📊 Quick Add Row</span>
        <button class="btn-db" onclick="toggleQA('qa-travel')">＋ Add Row</button>
      </div>
      <div class="qa-grid" id="qa-travel">
        <form method="POST" action="{{ route('ld.travel.store') }}" id="qaf-travel">
          @csrf
          <div class="qa-grid-inner" style="grid-template-columns:repeat(auto-fill,minmax(180px,1fr));">
            <div class="qa-field"><label>Employee Name/s*</label><textarea name="employee_names" required placeholder="One per line for multiple"></textarea></div>
            <div class="qa-field"><label>Position/s</label><textarea name="positions" placeholder="One per line"></textarea></div>
            <div class="qa-field"><label>Date/s of Travel*</label><input type="text" name="travel_dates" required placeholder="e.g. March 13, 2026"></div>
            <div class="qa-field"><label>Time</label><input type="text" name="travel_time" placeholder="e.g. 8:00 AM – 5:00 PM"></div>
            <div class="qa-field"><label>Place/s to be Visited*</label><input type="text" name="places_visited" required></div>
            <div class="qa-field"><label>Purpose*</label><textarea name="purpose" required></textarea></div>
            <div class="qa-field"><label>Chargeable Against</label><input type="text" name="chargeable_against" placeholder="e.g. N/A or fund source"></div>
          </div>
          <div class="qa-actions">
            <button type="submit" class="btn-qa-save">✓ Save Row</button>
            <button type="button" class="btn-qa-cancel" onclick="toggleQA('qa-travel')">Cancel</button>
          </div>
        </form>
      </div>
    </div>
  </div>

</div>{{-- /page --}}


{{-- ════════════════ MODALS ════════════════ --}}

{{-- Print Modal --}}
<div class="print-modal-overlay" id="printModal">
  <div class="print-modal">
    <div class="print-modal-header">
      <span>🖨 Print Preview</span>
      <button class="print-modal-close" onclick="closePrintModal()">✕ Close</button>
    </div>
    <iframe id="printModalFrame" src=""></iframe>
  </div>
</div>

{{-- Participation: View --}}
<div class="modal-overlay" id="viewModal">
  <div class="modal-box">
    <div class="modal-header"><span>📋 Request Details</span><button class="modal-close" onclick="closeModal('viewModal')">✕ Close</button></div>
    <div id="view-modal-body" class="modal-body"><p style="color:var(--gray-500)">Loading...</p></div>
  </div>
</div>

{{-- Participation: Create --}}
<div class="modal-overlay" id="createModal">
  <div class="modal-box">
    <div class="modal-header"><span>✏️ New Participation Request</span><button class="modal-close" onclick="closeModal('createModal')">✕ Close</button></div>
    <div id="create-modal-body">@include('ld.create-form')</div>
  </div>
</div>

{{-- Participation: Edit --}}
<div class="modal-overlay" id="editModal">
  <div class="modal-box">
    <div class="modal-header"><span>✏️ Edit Request</span><button class="modal-close" onclick="closeModal('editModal')">✕ Close</button></div>
    <div id="edit-modal-body" class="modal-body"><p style="color:var(--gray-500)">Loading...</p></div>
  </div>
</div>

{{-- Generic Form Modal (create & edit for all other 4 forms) --}}
<div class="modal-overlay" id="genericFormModal">
  <div class="modal-box">
    <div class="modal-header">
      <span id="genericFormTitle">New Request</span>
      <button class="modal-close" onclick="closeModal('genericFormModal')">✕ Close</button>
    </div>
    <div id="genericFormBody" class="modal-body"><p style="color:var(--gray-500)">Loading...</p></div>
  </div>
</div>

{{-- Generic View Modal --}}
<div class="modal-overlay" id="genericViewModal">
  <div class="modal-box">
    <div class="modal-header">
      <span id="genericViewTitle">Details</span>
      <button class="modal-close" onclick="closeModal('genericViewModal')">✕ Close</button>
    </div>
    <div id="genericViewBody" class="modal-body"><p style="color:var(--gray-500)">Loading...</p></div>
  </div>
</div>

{{-- ════ Records Popup Modal ════ --}}
<div class="records-modal-overlay" id="recordsModal">
  <div class="records-modal-box">
    <div class="records-modal-header">
      <span id="recordsModalTitle">Records</span>
      <div style="display:flex;align-items:center;gap:.5rem;">
        <button id="recordsAddBtn" class="btn btn-gold btn-sm" onclick="recordsAddNew()" style="font-size:.78rem;padding:.3rem .8rem;">
          ＋ Add Information
        </button>
        <button class="modal-close" onclick="closeRecordsModal()">✕ Close</button>
      </div>
    </div>
    <div class="records-modal-search">
      {{-- Row 1: search + download --}}
      <div style="display:flex;align-items:center;justify-content:space-between;flex-wrap:wrap;gap:.5rem;width:100%;">
        <div style="display:flex;align-items:center;gap:.5rem;flex-wrap:wrap;">
          <input type="text" id="recordsSearchInput" placeholder="🔍 Search all fields..." oninput="applyRecordsFilters()" style="width:220px;">
          <select id="recordsFilterMonth" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:.8rem;outline:none;">
            <option value="">All Months</option>
            <option value="1">January</option><option value="2">February</option><option value="3">March</option>
            <option value="4">April</option><option value="5">May</option><option value="6">June</option>
            <option value="7">July</option><option value="8">August</option><option value="9">September</option>
            <option value="10">October</option><option value="11">November</option><option value="12">December</option>
          </select>
          <select id="recordsFilterYear" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:.8rem;outline:none;">
            <option value="">All Years</option>
          </select>
          <select id="recordsFilterLevel" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:.8rem;outline:none;">
            <option value="">All Levels</option>
            <option>Local</option><option>Regional</option><option>National</option><option>International</option>
          </select>
          <select id="recordsFilterFinancial" onchange="applyRecordsFilters()" style="padding:.4rem .65rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:.8rem;outline:none;">
            <option value="">Financial — All</option>
            <option value="1">Financial — Yes</option>
            <option value="0">Financial — No</option>
          </select>
          <button onclick="clearRecordsFilters()" style="padding:.4rem .75rem;border:1.5px solid #d1d5db;border-radius:8px;font-size:.78rem;background:#fff;cursor:pointer;color:#6b7280;">✕ Clear</button>
        </div>
        <div style="display:flex;align-items:center;gap:.4rem;">
          <span id="recordsCountLabel" style="font-size:.78rem;color:#6b7280;"></span>
          <div style="position:relative;display:inline-block;" id="downloadDropWrap">
            <button onclick="toggleDownloadDrop()" style="display:flex;align-items:center;gap:.35rem;padding:.4rem .85rem;background:var(--maroon);color:#fff;border:none;border-radius:8px;font-size:.78rem;font-weight:600;cursor:pointer;">
              ⬇ Download <span style="font-size:.65rem;opacity:.8;">▼</span>
            </button>
            <div id="downloadDrop" style="display:none;position:absolute;right:0;top:calc(100% + 4px);background:#fff;border:1px solid #e5e7eb;border-radius:10px;box-shadow:0 8px 24px rgba(0,0,0,.15);min-width:190px;z-index:9999;overflow:hidden;">
              <div style="padding:.4rem .75rem;background:#f9fafb;border-bottom:1px solid #e5e7eb;font-size:.68rem;font-weight:700;color:#9ca3af;text-transform:uppercase;letter-spacing:.4pt;">Export as CSV</div>
              <button onclick="downloadCSV('filtered')" style="display:block;width:100%;padding:.55rem .85rem;background:none;border:none;text-align:left;font-size:.8rem;cursor:pointer;color:#111827;">📄 Filtered / Current View</button>
              <button onclick="downloadCSV('all')" style="display:block;width:100%;padding:.55rem .85rem;background:none;border:none;text-align:left;font-size:.8rem;cursor:pointer;color:#111827;border-top:1px solid #f3f4f6;">📦 All Records (unfiltered)</button>
            </div>
          </div>
        </div>
      </div>
    </div>
    <div class="records-modal-body">
      <div class="records-scroll-wrap">
        <div id="recordsModalContent">
          <div class="rm-empty"><div class="rm-empty-icon">⏳</div><p>Loading records…</p></div>
        </div>
      </div>
    </div>
    <div class="records-modal-footer">
      <span id="recordsFooterInfo" style="font-size:.78rem;color:#9ca3af;"></span>
      <button class="btn btn-ghost btn-sm" onclick="closeRecordsModal()">Close</button>
    </div>
  </div>
</div>

{{-- MOV Upload Modal --}}
<div class="modal-overlay" id="movModal">
  <div class="modal-box" style="max-width:520px;">
    <div class="modal-header"><span>📎 Upload MOV</span><button class="modal-close" onclick="closeModal('movModal')">✕ Close</button></div>
    <div style="padding:1.25rem 1.5rem;">
      <form id="movUploadForm" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mov_record_id" id="mov_record_id" value="{{ old('mov_record_id') }}">
        <div style="margin-bottom:.75rem;">
          <label style="display:block;font-weight:600;margin-bottom:.35rem;">Select file</label>
          <input type="file" name="mov_file" required
                 style="width:100%;padding:.55rem .7rem;border:1.5px solid var(--gray-200);border-radius:10px;">
        </div>
        <div id="movExisting" style="display:none;padding:.75rem;border:1px solid var(--gray-100);border-radius:10px;margin-bottom:.9rem;">
          <div class="muted text-sm" style="margin-bottom:.35rem;">Current MOV:</div>
          <button type="button" id="movPreviewBtn" class="btn btn-outline btn-sm" style="margin-bottom:.4rem;">👁 View File</button>
          <div id="movName" class="muted text-xs"></div>
        </div>
        <div class="d-flex justify-between align-center" style="gap:.75rem;">
          <button type="button" class="btn btn-ghost" onclick="closeModal('movModal')">Cancel</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- MOV Preview Modal --}}
<div class="print-modal-overlay" id="movPreviewModal">
  <div class="print-modal" style="max-width:1100px;width:95vw;height:92vh;">
    <div class="print-modal-header">
      <span id="movPreviewTitle">📎 MOV Preview</span>
      <div style="display:flex;gap:.5rem;align-items:center;">
        <a id="movDownloadBtn" href="#" target="_blank" class="print-modal-close" style="text-decoration:none;">⬇ Download</a>
        <button class="print-modal-close" onclick="closeMovPreview()">✕ Close</button>
      </div>
    </div>
    <div id="movImageContainer" style="display:none;flex:1;overflow:auto;background:#f5f5f5;align-items:center;justify-content:center;">
      <img id="movPreviewImage" style="max-width:100%;max-height:100%;object-fit:contain;display:block;margin:auto;">
    </div>
    <iframe id="movPreviewFrame" style="flex:1;width:100%;border:none;background:#f5f5f5;display:none;"></iframe>
    <div id="movUnsupported" style="display:none;flex:1;align-items:center;justify-content:center;flex-direction:column;gap:1rem;background:#f5f5f5;">
      <div style="font-size:3rem;">📄</div>
      <p style="color:#374151;font-weight:600;" id="movUnsupportedName"></p>
      <p style="color:#6b7280;font-size:.875rem;">This file type cannot be previewed in the browser.</p>
      <a id="movUnsupportedDownload" href="#" target="_blank" class="btn btn-primary">⬇ Download File</a>
    </div>
  </div>
</div>

@endsection

@push('scripts')
<script>
/* ── Tab switching ── */
function switchTab(name) {
  document.querySelectorAll('.form-tab').forEach(t => t.classList.remove('active'));
  document.querySelectorAll('.tab-panel').forEach(p => p.classList.remove('active'));
  document.getElementById('tab-' + name)?.classList.add('active');
  document.getElementById('panel-' + name)?.classList.add('active');
  history.replaceState(null, '', '{{ route("ld.index") }}?tab=' + name);
}

document.addEventListener('DOMContentLoaded', function() {
  const params = new URLSearchParams(location.search);
  switchTab(params.get('tab') || 'participation');

  // Re-open MOV modal if validation failed
  const failedId = @json(old('mov_record_id'));
  if (failedId) {
    document.querySelector(`[data-mov-btn="${failedId}"]`)?.click();
  }
});

/* (global form picker removed) */

/* ── Modal helpers ── */
function openModal(id) {
  document.getElementById(id)?.classList.add('active');
  document.body.style.overflow = 'hidden';
}
function closeModal(id) {
  document.getElementById(id)?.classList.remove('active');
  document.body.style.overflow = '';
}
['viewModal','createModal','editModal','genericFormModal','genericViewModal','movModal'].forEach(id => {
  document.getElementById(id)?.addEventListener('click', e => { if (e.target.id === id) closeModal(id); });
});

/* ── Participation: View / Create / Edit ── */
function openViewModal(id) {
  openModal('viewModal');
  document.getElementById('view-modal-body').innerHTML = loadingHtml();
  fetch(`/ld-requests/${id}/show-modal`, { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text()).then(html => { document.getElementById('view-modal-body').innerHTML = html; });
}
function openCreateModal() { openModal('createModal'); }
function openEditModal(id) {
  openModal('editModal');
  document.getElementById('edit-modal-body').innerHTML = loadingHtml();
  fetch(`/ld-requests/${id}/edit-modal`, { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text()).then(html => { document.getElementById('edit-modal-body').innerHTML = html; });
}

/* ── Generic Form Modal ── */
const formRoutes = {
  'attendance':         '/ld-requests/form/attendance',
  'publication':        '/ld-requests/form/publication',
  'reimbursement':      '/ld-requests/form/reimbursement',
  'travel':             '/ld-requests/form/travel',
  'attendance-edit':    id => `/ld-requests/attendance/${id}/edit-modal`,
  'publication-edit':   id => `/ld-requests/publication/${id}/edit-modal`,
  'reimbursement-edit': id => `/ld-requests/reimbursement/${id}/edit-modal`,
  'travel-edit':        id => `/ld-requests/travel/${id}/edit-modal`,
};
function openFormModal(type, title, id = null) {
  document.getElementById('genericFormTitle').textContent = title;
  document.getElementById('genericFormBody').innerHTML = loadingHtml();
  openModal('genericFormModal');
  const route = typeof formRoutes[type] === 'function' ? formRoutes[type](id) : formRoutes[type];
  fetch(route, { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => { document.getElementById('genericFormBody').innerHTML = html; })
    .catch(() => {
      document.getElementById('genericFormBody').innerHTML =
        '<div style="padding:2.5rem;text-align:center;color:#6b7280;">' +
        '<div style="font-size:2.5rem;margin-bottom:.75rem;">🚧</div>' +
        '<strong>Form coming soon</strong><p style="margin-top:.5rem;font-size:.875rem;">This form is under construction.</p></div>';
    });
}

/* ── Generic View Modal ── */
const viewRoutes = {
  attendance:    id => `/ld-requests/attendance/${id}/show-modal`,
  publication:   id => `/ld-requests/publication/${id}/show-modal`,
  reimbursement: id => `/ld-requests/reimbursement/${id}/show-modal`,
  travel:        id => `/ld-requests/travel/${id}/show-modal`,
};
function openGenericView(type, id, title) {
  document.getElementById('genericViewTitle').textContent = title;
  document.getElementById('genericViewBody').innerHTML = loadingHtml();
  openModal('genericViewModal');
  fetch(viewRoutes[type](id), { headers:{ 'X-Requested-With':'XMLHttpRequest' } })
    .then(r => r.text())
    .then(html => { document.getElementById('genericViewBody').innerHTML = html; })
    .catch(() => { document.getElementById('genericViewBody').innerHTML = '<p style="padding:2rem;text-align:center;color:#6b7280;">Could not load details.</p>'; });
}

/* ── Print modal ── */
function openPrintModal(url) {
  document.getElementById('printModalFrame').src = url;
  openModal('printModal');
}
function closePrintModal() {
  document.getElementById('printModal')?.classList.remove('active');
  document.getElementById('printModalFrame').src = '';
  document.body.style.overflow = '';
}
document.getElementById('printModal')?.addEventListener('click', e => { if (e.target.id === 'printModal') closePrintModal(); });

/* ═══════════════════════════════════════════════════
   RECORDS POPUP MODAL
═══════════════════════════════════════════════════ */

const recordsConfig = {
  participation: {
    apiUrl: '/ld-requests/records/participation',
    addFn:  () => { closeRecordsModal(); openCreateModal(); },
    columns: [
      { label: '#',                            key: '_index' },
      { label: 'Participant Name',             key: 'participant_name' },
      { label: 'Position',                     key: 'position' },
      { label: 'Campus',                       key: 'campus' },
      { label: 'College / Office',             key: 'college_office' },
      { label: 'Employment Status',            key: 'employment_status' },
      { label: 'Title of Intervention',        key: 'title' },
      { label: 'Type',                         key: 'types',             array: true },
      { label: 'Other Type',                   key: 'type_others' },
      { label: 'Level',                        key: 'level',             badge: 'gold' },
      { label: 'Nature',                       key: 'natures',           array: true },
      { label: 'Other Nature',                 key: 'nature_others' },
      { label: 'Competency',                   key: 'competency' },
      { label: 'Date',                         key: 'intervention_date' },
      { label: 'Hours',                        key: 'hours' },
      { label: 'Venue',                        key: 'venue' },
      { label: 'Organizer',                    key: 'organizer' },
      { label: 'Endorsed by Org?',             key: 'endorsed_by_org',   bool: true },
      { label: 'Related to Field?',            key: 'related_to_field',  bool: true },
      { label: 'Has Pending LDAP?',            key: 'has_pending_ldap',  bool: true },
      { label: 'Cash Advance?',                key: 'has_cash_advance',  bool: true },
      { label: 'Financial Requested?',         key: 'financial_requested', bool: true },
      { label: 'Amount Requested',             key: 'amount_requested',  currency: true },
      { label: 'Coverage',                     key: 'coverage',          array: true },
      { label: 'Other Coverage',               key: 'coverage_others' },
    ]
  },

  attendance: {
    apiUrl: '/ld-requests/records/attendance',
    addFn:  () => { closeRecordsModal(); openFormModal('attendance','📅 New Attendance Request'); },
    columns: [
      { label: '#',                            key: '_index' },
      { label: 'Attendee Name',                key: 'attendee_name' },
      { label: 'Position',                     key: 'position' },
      { label: 'Campus',                       key: 'campus' },
      { label: 'College / Office',             key: 'college_office' },
      { label: 'Employment Status',            key: 'employment_status' },
      { label: 'Activity Type',                key: 'activity_types',    array: true },
      { label: 'Other Activity',               key: 'activity_type_others' },
      { label: 'Nature',                       key: 'natures',           array: true },
      { label: 'Other Nature',                 key: 'nature_others' },
      { label: 'Purpose',                      key: 'purpose' },
      { label: 'Level',                        key: 'level',             badge: 'gold' },
      { label: 'Date',                         key: 'activity_date' },
      { label: 'Hours',                        key: 'hours' },
      { label: 'Venue',                        key: 'venue' },
      { label: 'Organizer',                    key: 'organizer' },
      { label: 'Financial Requested?',         key: 'financial_requested', bool: true },
      { label: 'Amount Requested',             key: 'amount_requested',  currency: true },
      { label: 'Coverage',                     key: 'coverage',          array: true },
      { label: 'Other Coverage',               key: 'coverage_others' },
    ]
  },

  publication: {
    apiUrl: '/ld-requests/records/publication',
    addFn:  () => { closeRecordsModal(); openFormModal('publication','📰 New Publication Incentive Request'); },
    columns: [
      { label: '#',                            key: '_index' },
      { label: 'Faculty / Employee',           key: 'faculty_name' },
      { label: 'Position',                     key: 'position' },
      { label: 'Campus',                       key: 'campus' },
      { label: 'College / Office',             key: 'college_office' },
      { label: 'Employment Status',            key: 'employment_status' },
      { label: 'Title of Paper',               key: 'paper_title' },
      { label: 'Co-author/s',                  key: 'co_authors' },
      { label: 'Journal Title',                key: 'journal_title' },
      { label: 'Vol. / Issue / No.',           key: 'vol_issue' },
      { label: 'ISSN / ISBN',                  key: 'issn_isbn' },
      { label: 'Publisher',                    key: 'publisher' },
      { label: 'Editors',                      key: 'editors' },
      { label: 'Website',                      key: 'website' },
      { label: 'Email',                        key: 'email_address' },
      { label: 'Scope',                        key: 'pub_scope',         badge: 'gold' },
      { label: 'Format',                       key: 'pub_format' },
      { label: 'Nature',                       key: 'nature' },
      { label: 'Amount Requested',             key: 'amount_requested',  currency: true },
      { label: 'Prev. Claimed?',               key: 'has_previous_claim', bool: true },
      { label: 'Prev. Claim Amount',           key: 'previous_claim_amount', currency: true },
      { label: 'Prev. Paper Title',            key: 'prev_paper_title' },
      { label: 'Prev. Co-authors',             key: 'prev_co_authors' },
      { label: 'Prev. Journal',                key: 'prev_journal_title' },
      { label: 'Prev. Vol./Issue',             key: 'prev_vol_issue' },
      { label: 'Prev. ISSN/ISBN',              key: 'prev_issn_isbn' },
      { label: 'Prev. DOI',                    key: 'prev_doi' },
      { label: 'Prev. Publisher',              key: 'prev_publisher' },
      { label: 'Prev. Editors',                key: 'prev_editors' },
      { label: 'Prev. Scope',                  key: 'prev_pub_scope',    badge: 'gold' },
    ]
  },

  reimbursement: {
    apiUrl: '/ld-requests/records/reimbursement',
    addFn:  () => { closeRecordsModal(); openFormModal('reimbursement','💰 New Reimbursement Request'); },
    columns: [
      { label: '#',                            key: '_index' },
      { label: 'Department / Office',          key: 'department' },
      { label: 'Activity Type',                key: 'activity_types',    array: true },
      { label: 'Other Activity',               key: 'activity_type_others' },
      { label: 'Venue',                        key: 'venue' },
      { label: 'Date',                         key: 'activity_date' },
      { label: 'Reason',                       key: 'reason' },
      { label: 'Remarks',                      key: 'remarks' },
      { label: 'Expense Items',                key: 'expense_items',     expenseCell: true },
      { label: 'Total Amount',                 key: '_total',            totalCalc: true },
    ]
  },

  travel: {
    apiUrl: '/ld-requests/records/travel',
    addFn:  () => { closeRecordsModal(); openFormModal('travel','✈️ New Authority to Travel'); },
    columns: [
      { label: '#',                            key: '_index' },
      { label: 'Employee Name/s',              key: 'employee_names',    pre: true },
      { label: 'Position/s',                   key: 'positions',         pre: true },
      { label: 'Date/s of Travel',             key: 'travel_dates' },
      { label: 'Time',                         key: 'travel_time' },
      { label: 'Place/s to be Visited',        key: 'places_visited' },
      { label: 'Purpose of Travel',            key: 'purpose' },
      { label: 'Chargeable Against',           key: 'chargeable_against' },
    ]
  },
};

let _allRecordsData = [];
let _currentRecordsType = '';

function openRecordsModal(type, title) {
  _currentRecordsType = type;
  _filteredRecordsData = [];
  document.getElementById('recordsModalTitle').textContent = title;
  document.getElementById('recordsSearchInput').value = '';
  document.getElementById('recordsFilterMonth').value = '';
  document.getElementById('recordsFilterYear').value = '';
  document.getElementById('recordsFilterLevel').value = '';
  document.getElementById('recordsFilterFinancial').value = '';
  document.getElementById('recordsCountLabel').textContent = '';
  document.getElementById('recordsFooterInfo').textContent = '';

  // Show/hide level & financial filters based on type
  const hasLevel    = ['participation','attendance'].includes(type);
  const hasFinancial= ['participation','attendance'].includes(type);
  document.getElementById('recordsFilterLevel').style.display    = hasLevel     ? '' : 'none';
  document.getElementById('recordsFilterFinancial').style.display= hasFinancial ? '' : 'none';

  document.getElementById('recordsModalContent').innerHTML =
    '<div class="rm-empty"><div class="rm-empty-icon">⏳</div><p>Loading records…</p></div>';
  document.getElementById('recordsModal').classList.add('active');
  document.body.style.overflow = 'hidden';

  const cfg = recordsConfig[type];
  if (!cfg) return;

  fetch(cfg.apiUrl, { headers: { 'X-Requested-With': 'XMLHttpRequest', 'Accept': 'application/json' } })
    .then(r => r.json())
    .then(data => {
      _allRecordsData = data.records || data || [];
      _filteredRecordsData = [..._allRecordsData];
      populateYearFilter(_allRecordsData, type);
      renderRecordsTable(_allRecordsData, type);
      const total = _allRecordsData.length;
      document.getElementById('recordsCountLabel').textContent = `${total} record${total !== 1 ? 's' : ''}`;
      document.getElementById('recordsFooterInfo').textContent = `Showing all ${total} record${total !== 1 ? 's' : ''}`;
    })
    .catch(err => {
      console.error(err);
      document.getElementById('recordsModalContent').innerHTML =
        '<div class="rm-empty"><div class="rm-empty-icon">⚠️</div><p>Could not load records. Please try again.</p></div>';
    });
}

function closeRecordsModal() {
  document.getElementById('recordsModal').classList.remove('active');
  document.body.style.overflow = '';
  _allRecordsData = [];
  _filteredRecordsData = [];
  _currentRecordsType = '';
}

function recordsAddNew() {
  const cfg = recordsConfig[_currentRecordsType];
  if (cfg && cfg.addFn) cfg.addFn();
}

document.getElementById('recordsModal')?.addEventListener('click', e => {
  if (e.target.id === 'recordsModal') closeRecordsModal();
});

// ── Date-key lookup per type (which field holds the date for month/year filtering)
const recordsDateKey = {
  participation: 'intervention_date',
  attendance:    'activity_date',
  publication:   'created_at',
  reimbursement: 'activity_date',
  travel:        'travel_dates',
};

// ── Level-key lookup (some types use different field names)
const recordsLevelKey = {
  participation: 'level',
  attendance:    'level',
  publication:   'pub_scope',
  reimbursement: null,
  travel:        null,
};

// ── Financial-key lookup
const recordsFinancialKey = {
  participation: 'financial_requested',
  attendance:    'financial_requested',
  publication:   null,
  reimbursement: null,
  travel:        null,
};

let _filteredRecordsData = [];

function populateYearFilter(data, type) {
  const dateKey = recordsDateKey[type];
  const years = new Set();
  data.forEach(row => {
    const raw = row[dateKey] || row['created_at'] || '';
    const m = String(raw).match(/\d{4}/);
    if (m) years.add(m[0]);
  });
  const sel = document.getElementById('recordsFilterYear');
  const current = sel.value;
  sel.innerHTML = '<option value="">All Years</option>';
  [...years].sort((a,b) => b - a).forEach(y => {
    sel.innerHTML += `<option value="${y}" ${current===y?'selected':''}>${y}</option>`;
  });
}

function applyRecordsFilters() {
  const q        = (document.getElementById('recordsSearchInput')?.value || '').toLowerCase().trim();
  const month    = document.getElementById('recordsFilterMonth')?.value || '';
  const year     = document.getElementById('recordsFilterYear')?.value || '';
  const level    = document.getElementById('recordsFilterLevel')?.value || '';
  const financial= document.getElementById('recordsFilterFinancial')?.value;
  const type     = _currentRecordsType;
  const dateKey  = recordsDateKey[type];
  const levelKey = recordsLevelKey[type];
  const finKey   = recordsFinancialKey[type];

  let filtered = _allRecordsData.filter(row => {
    // Text search
    if (q) {
      const match = Object.values(row).some(v => {
        if (Array.isArray(v)) return v.some(x => String(x).toLowerCase().includes(q));
        return String(v ?? '').toLowerCase().includes(q);
      });
      if (!match) return false;
    }

    // Month filter
    if (month) {
      const raw = String(row[dateKey] || row['created_at'] || '');
      const d = new Date(raw.match(/\d{4}-\d{2}-\d{2}/) ? raw : raw.replace(/(\w+ \d+,?\s*\d{4})/,'$1'));
      if (isNaN(d) || (d.getMonth() + 1) !== parseInt(month)) return false;
    }

    // Year filter
    if (year) {
      const raw = String(row[dateKey] || row['created_at'] || '');
      const m = raw.match(/\d{4}/);
      if (!m || m[0] !== year) return false;
    }

    // Level filter
    if (level && levelKey) {
      if (String(row[levelKey] || '').toLowerCase() !== level.toLowerCase()) return false;
    }

    // Financial filter
    if (financial !== '' && financial !== undefined && finKey) {
      const val = row[finKey];
      const wanted = financial === '1';
      if (Boolean(val) !== wanted) return false;
    }

    return true;
  });

  _filteredRecordsData = filtered;
  renderRecordsTable(filtered, type);
  const total = filtered.length;
  document.getElementById('recordsCountLabel').textContent =
    filtered.length === _allRecordsData.length
      ? `${total} record${total !== 1 ? 's' : ''}`
      : `${total} of ${_allRecordsData.length} record${_allRecordsData.length !== 1 ? 's' : ''}`;
  document.getElementById('recordsFooterInfo').textContent =
    filtered.length === _allRecordsData.length
      ? `Showing all ${total} record${total !== 1 ? 's' : ''}`
      : `Filtered: ${total} of ${_allRecordsData.length} records`;
}

function clearRecordsFilters() {
  document.getElementById('recordsSearchInput').value = '';
  document.getElementById('recordsFilterMonth').value = '';
  document.getElementById('recordsFilterYear').value = '';
  document.getElementById('recordsFilterLevel').value = '';
  document.getElementById('recordsFilterFinancial').value = '';
  applyRecordsFilters();
}

/* ── Download CSV ── */
function toggleDownloadDrop() {
  const d = document.getElementById('downloadDrop');
  d.style.display = d.style.display === 'none' ? 'block' : 'none';
}
document.addEventListener('click', e => {
  if (!document.getElementById('downloadDropWrap')?.contains(e.target)) {
    const d = document.getElementById('downloadDrop');
    if (d) d.style.display = 'none';
  }
});

function downloadCSV(mode) {
  document.getElementById('downloadDrop').style.display = 'none';
  const type = _currentRecordsType;
  const cfg  = recordsConfig[type];
  if (!cfg) return;

  const rows = mode === 'all' ? _allRecordsData : (_filteredRecordsData.length ? _filteredRecordsData : _allRecordsData);

  // Build headers — skip _index, _total, expenseCell (flatten separately)
  const cols = cfg.columns.filter(c => c.key !== '_index' && !c.totalCalc);

  const csvRows = [];

  // Header row
  csvRows.push(cols.map(c => csvEsc(c.label)).join(','));

  rows.forEach(row => {
    const cells = cols.map(col => {
      if (col.expenseCell) {
        const items = row[col.key] || [];
        const txt = items.map(i => `${i.description||''} x${i.quantity||''} @ ${i.unit_cost||''} = ${i.amount||''}`).join(' | ');
        return csvEsc(txt);
      }
      if (col.array) {
        const arr = Array.isArray(row[col.key]) ? row[col.key] : [];
        return csvEsc(arr.join(', '));
      }
      if (col.bool) return row[col.key] ? 'Yes' : 'No';
      if (col.currency) {
        const n = parseFloat(row[col.key] || 0);
        return n > 0 ? n.toFixed(2) : '';
      }
      return csvEsc(String(row[col.key] ?? ''));
    });
    csvRows.push(cells.join(','));
  });

  // Add total row for reimbursement
  if (type === 'reimbursement') {
    // already in expense cell
  }

  const blob = new Blob([csvRows.join('\n')], { type: 'text/csv;charset=utf-8;' });
  const url  = URL.createObjectURL(blob);
  const a    = document.createElement('a');
  const ts   = new Date().toISOString().slice(0,10);
  a.href     = url;
  a.download = `${type}-records-${mode === 'all' ? 'all' : 'filtered'}-${ts}.csv`;
  a.click();
  URL.revokeObjectURL(url);
}

function csvEsc(val) {
  const s = String(val ?? '').replace(/"/g, '""');
  return /[,"\n\r]/.test(s) ? `"${s}"` : s;
}

function renderRecordsTable(rows, type) {
  const cfg = recordsConfig[type];
  if (!cfg) return;

  if (!rows || rows.length === 0) {
    document.getElementById('recordsModalContent').innerHTML =
      '<div class="rm-empty"><div class="rm-empty-icon">📭</div><p>No records found.</p></div>';
    return;
  }

  // Columns that should be compact/nowrap vs ones that can wrap
  const wrapKeys = new Set(['title','venue','organizer','purpose','competency',
    'college_office','paper_title','journal_title','co_authors','places_visited',
    'employee_names','positions','reason','remarks','chargeable_against']);

  let html = '<div>';
  html += '<table style="width:100%;border-collapse:collapse;font-size:.78rem;">';

  // THEAD
  html += '<thead><tr>';
  cfg.columns.forEach(col => {
    html += `<th style="padding:.5rem .75rem;background:#f3f4f6;border-bottom:2px solid #e5e7eb;
      border-right:1px solid #e5e7eb;text-align:left;font-size:.68rem;font-weight:700;
      color:#6b7280;text-transform:uppercase;letter-spacing:.4pt;position:sticky;top:0;z-index:1;
      white-space:nowrap;">${esc(col.label)}</th>`;
  });
  html += '</tr></thead>';

  // TBODY
  html += '<tbody>';
  rows.forEach((row, idx) => {
    const bg = idx % 2 === 0 ? '#fff' : '#fafafa';
    html += `<tr style="background:${bg};">`;

    cfg.columns.forEach(col => {
      const canWrap = wrapKeys.has(col.key) || col.array || col.expenseCell || col.pre;
      const cellStyle = canWrap
        ? 'padding:.45rem .75rem;border-bottom:1px solid #f3f4f6;border-right:1px solid #f3f4f6;vertical-align:top;min-width:140px;max-width:260px;white-space:normal;word-break:break-word;'
        : 'padding:.45rem .75rem;border-bottom:1px solid #f3f4f6;border-right:1px solid #f3f4f6;vertical-align:top;white-space:nowrap;';
      html += `<td style="${cellStyle}">`;

      if (col.key === '_index') {
        html += `<span style="color:#9ca3af;">${idx + 1}</span>`;

      } else if (col.totalCalc) {
        const items = row.expense_items || [];
        const total = items.reduce((s, x) => s + parseFloat(x.amount || 0), 0);
        html += total > 0
          ? `<strong>Php ${total.toLocaleString('en-PH',{minimumFractionDigits:2})}</strong>`
          : '<span style="color:#9ca3af;">—</span>';

      } else if (col.expenseCell) {
        const items = row[col.key] || [];
        if (items.length === 0) {
          html += '<span style="color:#9ca3af;">—</span>';
        } else {
          html += '<div style="white-space:normal;min-width:260px;">';
          html += '<table style="width:100%;border-collapse:collapse;font-size:.72rem;">';
          html += '<tr style="background:#f9fafb;">'
            + '<th style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:left;">Payee</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:left;">Description</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:right;">Qty</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:right;">Unit Cost</th>'
            + '<th style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:right;">Amount</th>'
            + '</tr>';
          items.forEach(item => {
            const amt = parseFloat(item.amount || 0);
            const uc  = parseFloat(item.unit_cost || 0);
            html += `<tr>
              <td style="padding:.2rem .4rem;border:1px solid #e5e7eb;">${esc(item.payee||'')}</td>
              <td style="padding:.2rem .4rem;border:1px solid #e5e7eb;">${esc(item.description||'')}</td>
              <td style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:right;">${esc(String(item.quantity||''))}</td>
              <td style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:right;">${uc>0?'Php '+uc.toLocaleString('en-PH',{minimumFractionDigits:2}):''}</td>
              <td style="padding:.2rem .4rem;border:1px solid #e5e7eb;text-align:right;">${amt>0?'Php '+amt.toLocaleString('en-PH',{minimumFractionDigits:2}):''}</td>
            </tr>`;
          });
          html += '</table></div>';
        }

      } else if (col.array) {
        const arr = Array.isArray(row[col.key]) ? row[col.key] : [];
        html += arr.length
          ? '<div style="display:flex;flex-wrap:wrap;gap:.2rem;white-space:normal;">'
            + arr.map(t => `<span class="badge badge-maroon" style="font-size:.65rem;">${esc(t)}</span>`).join('')
            + '</div>'
          : '<span style="color:#9ca3af;">—</span>';

      } else if (col.badge) {
        const v = row[col.key];
        html += v
          ? `<span class="badge badge-${col.badge}" style="font-size:.68rem;">${esc(v)}</span>`
          : '<span style="color:#9ca3af;">—</span>';

      } else if (col.bool) {
        html += row[col.key]
          ? '<span class="badge badge-green" style="font-size:.65rem;">Yes</span>'
          : '<span style="color:#9ca3af;font-size:.72rem;">No</span>';

      } else if (col.currency) {
        const num = parseFloat(row[col.key] || 0);
        html += num > 0
          ? `<span style="font-weight:600;">Php ${num.toLocaleString('en-PH',{minimumFractionDigits:2})}</span>`
          : '<span style="color:#9ca3af;">—</span>';

      } else if (col.pre) {
        const v = row[col.key] || '';
        html += v ? `<div>${esc(v)}</div>` : '<span style="color:#9ca3af;">—</span>';

      } else {
        const v = row[col.key] ?? '';
        html += v !== '' ? `<div>${esc(String(v))}</div>` : '<span style="color:#9ca3af;">—</span>';
      }

      html += '</td>';
    });

    html += '</tr>';
  });

  html += '</tbody></table></div>';
  document.getElementById('recordsModalContent').innerHTML = html;
}

function esc(str) {
  return String(str ?? '').replace(/&/g,'&amp;').replace(/</g,'&lt;').replace(/>/g,'&gt;').replace(/"/g,'&quot;');
}

/* ── Quick add toggle ── */
function toggleQA(id) {
  const el = document.getElementById(id);
  el?.classList.toggle('open');
}

/* ── MOV modal ── */
let _movFileUrl = null, _movFileName = null;
function openMovModal(uploadUrl, fileUrl, fileName, recordId) {
  document.getElementById('movUploadForm').action = uploadUrl;
  document.getElementById('mov_record_id').value  = recordId;
  const ex = document.getElementById('movExisting');
  const nm = document.getElementById('movName');
  const pb = document.getElementById('movPreviewBtn');
  if (fileUrl) {
    ex.style.display = 'block'; nm.textContent = fileName || '';
    _movFileUrl = fileUrl; _movFileName = fileName || '';
    pb.onclick = () => openMovPreview(_movFileUrl, _movFileName);
  } else {
    ex.style.display = 'none'; _movFileUrl = null; _movFileName = null; pb.onclick = null;
  }
  openModal('movModal');
}

/* ── MOV preview ── */
function openMovPreview(url, fileName) {
  const frame   = document.getElementById('movPreviewFrame');
  const imgCon  = document.getElementById('movImageContainer');
  const img     = document.getElementById('movPreviewImage');
  const unsupp  = document.getElementById('movUnsupported');
  const dlBtn   = document.getElementById('movDownloadBtn');
  const titleEl = document.getElementById('movPreviewTitle');

  frame.style.display = 'none'; frame.src = '';
  imgCon.style.display = 'none'; img.src = '';
  unsupp.style.display = 'none';

  const name = fileName || url.split('/').pop() || 'file';
  const ext  = name.split('.').pop().toLowerCase();
  titleEl.textContent = '📎 ' + name;
  dlBtn.href = url;

  const imageExts  = ['jpg','jpeg','png','gif','webp','bmp','svg'];
  const officeExts = ['doc','docx','xls','xlsx','ppt','pptx','odt','ods'];

  if (imageExts.includes(ext)) {
    imgCon.style.display = 'flex'; img.src = url;
  } else if (ext === 'pdf') {
    frame.style.display = 'block'; frame.src = url;
  } else if (officeExts.includes(ext)) {
    frame.style.display = 'block';
    frame.src = `https://docs.google.com/gview?url=${encodeURIComponent(window.location.origin + url)}&embedded=true`;
  } else {
    unsupp.style.display = 'flex';
    document.getElementById('movUnsupportedName').textContent = name;
    document.getElementById('movUnsupportedDownload').href = url;
  }
  openModal('movPreviewModal');
}
function closeMovPreview() {
  const m = document.getElementById('movPreviewModal');
  m?.classList.remove('active');
  document.getElementById('movPreviewFrame').src = '';
  document.getElementById('movPreviewFrame').style.display = 'none';
  document.getElementById('movPreviewImage').src = '';
  document.getElementById('movImageContainer').style.display = 'none';
  document.getElementById('movUnsupported').style.display = 'none';
  document.body.style.overflow = '';
}
document.getElementById('movPreviewModal')?.addEventListener('click', e => { if (e.target.id === 'movPreviewModal') closeMovPreview(); });

/* ── Global Escape ── */
document.addEventListener('keydown', function(e) {
  if (e.key !== 'Escape') return;
  ['viewModal','createModal','editModal','genericFormModal','genericViewModal','movModal'].forEach(closeModal);
  closePrintModal(); closeMovPreview(); closeRecordsModal();
});

/* ── Loading helper ── */
function loadingHtml() {
  return '<p style="padding:2rem;color:var(--gray-500);text-align:center;">Loading...</p>';
}
</script>
@endpush