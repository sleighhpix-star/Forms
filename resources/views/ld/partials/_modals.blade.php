{{-- _modals.blade.php — All modal dialogs --}}

{{-- Print preview (iframe) --}}
<div class="idx-overlay" id="printModal">
  <div class="idx-iframe-wrap">
    <div class="idx-modal-head">
      <span class="idx-modal-title">🖨 Print Preview</span>
      <button class="idx-modal-close" onclick="closePrintModal()">✕ Close</button>
    </div>
    <iframe id="printModalFrame" src=""></iframe>
  </div>
</div>

{{-- Participation — view --}}
<div class="idx-overlay" id="viewModal" style="align-items:center;padding:24px 16px">
  <div class="idx-modal" style="display:flex;flex-direction:column;width:100%;max-width:520px;max-height:88vh;margin:auto">
    <div class="idx-modal-head" style="flex-shrink:0">
      <span class="idx-modal-title">📋 Request Details</span>
      <button class="idx-modal-close" onclick="closeModal('viewModal')">✕ Close</button>
    </div>
    <div id="viewModalBody" style="flex:1;overflow-y:auto;display:flex;flex-direction:column;">
      <div class="idx-modal-loading"><p style="color:var(--ink-4)">Loading…</p></div>
    </div>
  </div>
</div>

{{-- Participation — create --}}
<div class="idx-overlay" id="createModal">
  <div class="idx-modal" style="max-width:860px">
    <div class="idx-modal-head">
      <span class="idx-modal-title">＋ New Participation Request</span>
      <button class="idx-modal-close" onclick="closeModal('createModal')">✕ Close</button>
    </div>
    <div id="createModalBody" style="max-height:85vh;overflow-y:auto">
      @include('ld.create-form')
    </div>
  </div>
</div>

{{-- Participation — edit --}}
<div class="idx-overlay" id="editModal">
  <div class="idx-modal" style="max-width:860px">
    <div class="idx-modal-head">
      <span class="idx-modal-title">✏️ Edit Request</span>
      <button class="idx-modal-close" onclick="closeModal('editModal')">✕ Close</button>
    </div>
    <div id="editModalBody" class="idx-modal-body" style="max-height:85vh;overflow-y:auto"><p style="color:var(--ink-4)">Loading…</p></div>
  </div>
</div>

{{-- Generic form (Attendance / Publication / Reimbursement / Travel create & edit) --}}
<div class="idx-overlay" id="gFormModal">
  <div class="idx-modal" style="max-width:860px">
    <div class="idx-modal-head">
      <span class="idx-modal-title" id="gFormTitle">New Request</span>
      <button class="idx-modal-close" onclick="closeModal('gFormModal')">✕ Close</button>
    </div>
    <div id="gFormBody" class="idx-modal-body" style="max-height:85vh;overflow-y:auto"><p style="color:var(--ink-4)">Loading…</p></div>
  </div>
</div>

{{-- Generic view (Attendance / Publication / Reimbursement / Travel detail) --}}
<div class="idx-overlay" id="gViewModal" style="align-items:center;padding:24px 16px">
  <div class="idx-modal" style="display:flex;flex-direction:column;width:100%;max-width:520px;max-height:88vh;margin:auto">
    <div class="idx-modal-head" style="flex-shrink:0">
      <span class="idx-modal-title" id="gViewTitle">Details</span>
      <button class="idx-modal-close" onclick="closeModal('gViewModal')">✕ Close</button>
    </div>
    <div id="gViewBody" style="flex:1;overflow-y:auto;display:flex;flex-direction:column;">
      <div class="idx-modal-loading"><p style="color:var(--ink-4)">Loading…</p></div>
    </div>
  </div>
</div>

{{-- Records popup (full-width table browser) --}}
<div class="idx-overlay" id="recordsModal" style="align-items:flex-start">
  <div class="idx-records-wrap">
    <div class="idx-modal-head">
      <span class="idx-modal-title" id="recTitle">Records</span>
      <div style="display:flex;align-items:center;gap:8px">
        <button class="btn btn-gold btn-sm" onclick="recAddNew()" style="font-size:.74rem">＋ Add</button>
        <button class="idx-modal-close" onclick="closeRecords()">✕ Close</button>
      </div>
    </div>
    <div class="idx-rec-filters">
      <div style="display:flex;align-items:center;gap:8px;flex-wrap:wrap">
        <input type="text" id="recSearch" placeholder="🔍 Search all fields…" oninput="applyRecFilters()" style="width:200px">
        <select id="recMonth" onchange="applyRecFilters()">
          <option value="">All Months</option>
          <option value="1">January</option><option value="2">February</option><option value="3">March</option>
          <option value="4">April</option><option value="5">May</option><option value="6">June</option>
          <option value="7">July</option><option value="8">August</option><option value="9">September</option>
          <option value="10">October</option><option value="11">November</option><option value="12">December</option>
        </select>
        <select id="recYear" onchange="applyRecFilters()"><option value="">All Years</option></select>
        <select id="recLevel" onchange="applyRecFilters()">
          <option value="">All Levels</option>
          <option>Local</option><option>Regional</option><option>National</option><option>International</option>
        </select>
        <select id="recFin" onchange="applyRecFilters()">
          <option value="">Financial — All</option>
          <option value="1">Financial — Yes</option>
          <option value="0">Financial — No</option>
        </select>
        <button id="recClearBtn" onclick="clearRecFilters()" style="padding:6px 10px;border:1.5px solid var(--border);border-radius:var(--r-sm);background:white;cursor:pointer;font-size:.75rem;color:var(--ink-4);display:none">✕ Clear</button>
      </div>
      <div style="display:flex;align-items:center;gap:8px">
        <span id="recCount" style="font-size:.76rem;color:var(--ink-4)"></span>
        <div class="idx-dl-wrap" id="dlWrap">
          <button onclick="toggleDlMenu()" style="display:flex;align-items:center;gap:5px;padding:6px 13px;background:var(--c);color:white;border:none;border-radius:var(--r-sm);font-size:.76rem;font-weight:600;cursor:pointer">⬇ Export <span style="font-size:.58rem;opacity:.7">▼</span></button>
          <div class="idx-dl-menu" id="dlMenu">
            <div class="idx-dl-hd">Export as CSV</div>
            <button class="idx-dl-btn" onclick="downloadCSV('filtered')">📄 Filtered view</button>
            <button class="idx-dl-btn" onclick="downloadCSV('all')">📦 All records</button>
          </div>
        </div>
      </div>
    </div>
    <div class="idx-rec-body"><div class="idx-rec-scroll"><div id="recContent"><div style="padding:48px;text-align:center;color:var(--ink-4)">⏳ Loading…</div></div></div></div>
    <div class="idx-rec-footer">
      <span id="recFooter"></span>
      <button class="btn btn-ghost btn-sm" onclick="closeRecords()">Close</button>
    </div>
  </div>
</div>

{{-- MOV upload --}}
<div class="idx-overlay" id="movModal">
  <div class="idx-modal idx-modal-sm">
    <div class="idx-modal-head">
      <span class="idx-modal-title">📎 Upload MOV</span>
      <button class="idx-modal-close" onclick="closeModal('movModal')">✕ Close</button>
    </div>
    <div style="padding:24px">
      <form id="movForm" method="POST" action="" enctype="multipart/form-data">
        @csrf
        <input type="hidden" name="mov_record_id" id="movRecordId">
        <div style="margin-bottom:14px">
          <label style="display:block;font-weight:600;font-size:.82rem;margin-bottom:6px;color:var(--ink-2)">Select file</label>
          <input type="file" name="mov_file" required style="width:100%;padding:8px 10px;border:1.5px solid var(--border);border-radius:var(--r-md)">
        </div>
        <div id="movExisting" style="display:none;padding:12px;border:1px solid var(--border);border-radius:var(--r-md);margin-bottom:14px;background:var(--surface-2)">
          <div style="font-size:.76rem;color:var(--ink-4);margin-bottom:6px">Current MOV:</div>
          <button type="button" id="movPreviewBtn" class="btn btn-ghost btn-sm" style="margin-bottom:4px">👁 Preview</button>
          <div id="movName" style="font-size:.72rem;color:var(--ink-4)"></div>
        </div>
        <div style="display:flex;justify-content:space-between;gap:12px">
          <button type="button" class="btn btn-ghost" onclick="closeModal('movModal')">Cancel</button>
          <button type="submit" class="btn btn-primary">Upload</button>
        </div>
      </form>
    </div>
  </div>
</div>

{{-- MOV preview --}}
<div class="idx-overlay" id="movPreviewModal">
  <div class="idx-mov-wrap">
    <div class="idx-modal-head">
      <span class="idx-modal-title" id="movPreviewTitle">📎 MOV Preview</span>
      <div style="display:flex;gap:8px;align-items:center">
        <a id="movDlBtn" href="#" target="_blank" class="idx-modal-close" style="text-decoration:none">⬇ Download</a>
        <button class="idx-modal-close" onclick="closeMovPreview()">✕ Close</button>
      </div>
    </div>
    <div id="movImgCon" style="display:none;flex:1;overflow:auto;background:#f0f0f0;align-items:center;justify-content:center">
      <img id="movPreviewImg" style="max-width:100%;max-height:100%;object-fit:contain;display:block;margin:auto">
    </div>
    <iframe id="movPreviewFrame" style="flex:1;width:100%;border:none;background:#f0f0f0;display:none"></iframe>
    {{-- mammoth.js docx preview --}}
    <div id="movDocxCon" style="display:none;flex:1;overflow:auto;background:#fff;padding:2rem;">
      <div id="movDocxLoading" style="text-align:center;padding:2rem;color:#666;">⏳ Loading document preview...</div>
      <div id="movDocxContent" style="max-width:800px;margin:0 auto;font-family:Times New Roman,serif;font-size:11pt;line-height:1.6;"></div>
    </div>
    <div id="movUnsupported" style="display:none;flex:1;align-items:center;justify-content:center;flex-direction:column;gap:16px;background:#f0f0f0">
      <div style="font-size:3rem">📄</div>
      <p style="font-weight:600;color:var(--ink-2)" id="movUnsuppName"></p>
      <p style="color:var(--ink-4);font-size:.875rem">This file type cannot be previewed in the browser.</p>
      <a id="movUnsuppDl" href="#" target="_blank" class="btn btn-primary">⬇ Download File</a>
    </div>
  </div>
</div>