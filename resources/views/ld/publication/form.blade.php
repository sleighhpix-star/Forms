@php
  $record ??= null;
  $employmentStatuses = ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'];
  $scopes  = ['Regional', 'National', 'International'];
  $formats = ['Print', 'Online'];
  $natures = [
    'CHED accredited (multidisciplinary)',
    'CHED accredited (specific discipline)',
    'ISI indexed',
    'SCOPUS indexed',
  ];
  $isEdit = isset($record) && $record?->id;
  $action = $isEdit
    ? route('ld.publication.update', $record->id)
    : route('ld.publication.store');
@endphp

<style>
.sig-grid { display:grid; grid-template-columns:repeat(auto-fill,minmax(200px,1fr)); gap:1rem; margin-top:.5rem; }
.sig-box { border:1px solid #e5e7eb; border-radius:10px; padding:.75rem 1rem; background:#fafafa; transition:border-color .15s,background .15s; }
.sig-box:focus-within { border-color:var(--maroon); background:#fff; }
.sig-role { font-size:.68rem; font-weight:700; color:#9ca3af; text-transform:uppercase; letter-spacing:.5pt; margin-bottom:.45rem; }
.sig-field-wrap { position:relative; }
.sig-name-input { width:100%; border:none; border-bottom:1.5px dashed #d1d5db; background:transparent; font-size:.85rem; font-weight:700; color:#111827; padding:.15rem 1.4rem .15rem 0; outline:none; font-family:inherit; transition:border-color .15s; }
.sig-name-input:focus { border-bottom-color:var(--maroon); border-bottom-style:solid; }
.sig-pos-input { width:100%; border:none; border-bottom:1px dashed #e5e7eb; background:transparent; font-size:.72rem; color:#6b7280; padding:.15rem 1.4rem .15rem 0; outline:none; font-family:inherit; margin-top:.3rem; transition:border-color .15s; }
.sig-pos-input:focus { border-bottom-color:var(--maroon); border-bottom-style:solid; }
.sig-edit-icon { position:absolute; right:0; top:50%; transform:translateY(-50%); font-size:.65rem; color:#d1d5db; pointer-events:none; }
.sig-box:focus-within .sig-edit-icon { color:var(--maroon); }
.sig-reset-btn { margin-top:.5rem; font-size:.65rem; color:#9ca3af; background:none; border:none; cursor:pointer; padding:0; text-decoration:underline; }
.sig-reset-btn:hover { color:var(--maroon); }
.prev-section { background:#fdf9f0; border:1px solid #fde68a; border-radius:10px; padding:1rem 1.25rem; margin-top:.5rem; }
.prev-section-label { font-size:.72rem; font-weight:700; color:#b45309; margin-bottom:.75rem; text-transform:uppercase; letter-spacing:.4pt; }
</style>

<div class="page" style="max-width:880px">
  <form action="{{ $action }}" method="POST" id="publication-form">
    @csrf
    @if($isEdit) @method('PUT') @endif

    <div class="card">

      {{-- ══ RESEARCHER INFORMATION ══ --}}
      <div class="card-section">
        <div class="section-label">Researcher Information</div>
        <div class="field-grid cols-2">

          <div class="field span-2">
            <label>Name of Faculty / Employee <span class="req">*</span></label>
            <input type="text" name="faculty_name"
                   value="{{ old('faculty_name', $record?->faculty_name) }}"
                   placeholder="Last Name, First Name, Middle Name" required>
          </div>

          <div class="field">
            <label>Campus <span class="req">*</span></label>
            <input type="text" name="campus"
                   value="{{ old('campus', $record?->campus) }}"
                   placeholder="e.g. Alangilan Campus" required>
          </div>

          <div class="field">
            <label>Employment Status <span class="req">*</span></label>
            <select name="employment_status" required>
              <option value="">— Select —</option>
              @foreach($employmentStatuses as $s)
                <option value="{{ $s }}" {{ old('employment_status', $record?->employment_status) === $s ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>College / Office <span class="req">*</span></label>
            <input type="text" name="college_office"
                   value="{{ old('college_office', $record?->college_office) }}"
                   placeholder="e.g. College of Engineering" required>
          </div>

          <div class="field">
            <label>Position / Designation <span class="req">*</span></label>
            <input type="text" name="position"
                   value="{{ old('position', $record?->position) }}"
                   placeholder="e.g. Assistant Professor II" required>
          </div>

        </div>
      </div>

      {{-- ══ PAPER DETAILS ══ --}}
      <div class="card-section">
        <div class="section-label">Paper / Publication Details</div>
        <div class="field-grid cols-2">

          <div class="field span-2">
            <label>Title of Paper <span class="req">*</span></label>
            <input type="text" name="paper_title"
                   value="{{ old('paper_title', $record?->paper_title) }}"
                   placeholder="Full title of the research paper" required>
          </div>

          <div class="field span-2">
            <label>Co-author/s</label>
            <input type="text" name="co_authors"
                   value="{{ old('co_authors', $record?->co_authors) }}"
                   placeholder="Separate names with comma">
          </div>

          <div class="field span-2">
            <label>Title of Journal <span class="req">*</span></label>
            <input type="text" name="journal_title"
                   value="{{ old('journal_title', $record?->journal_title) }}"
                   placeholder="Full journal title" required>
          </div>

          <div class="field">
            <label>Vol. / Issue / No.</label>
            <input type="text" name="vol_issue"
                   value="{{ old('vol_issue', $record?->vol_issue) }}"
                   placeholder="e.g. Vol. 12, Issue 3">
          </div>

          <div class="field">
            <label>ISSN / ISBN</label>
            <input type="text" name="issn_isbn"
                   value="{{ old('issn_isbn', $record?->issn_isbn) }}"
                   placeholder="e.g. 1234-5678">
          </div>

          <div class="field">
            <label>Publisher</label>
            <input type="text" name="publisher"
                   value="{{ old('publisher', $record?->publisher) }}"
                   placeholder="Publisher name">
          </div>

          <div class="field">
            <label>Editor/s</label>
            <input type="text" name="editors"
                   value="{{ old('editors', $record?->editors) }}"
                   placeholder="Editor names">
          </div>

          <div class="field">
            <label>Website</label>
            <input type="url" name="website"
                   value="{{ old('website', $record?->website) }}"
                   placeholder="https://...">
          </div>

          <div class="field">
            <label>Email Address</label>
            <input type="email" name="email_address"
                   value="{{ old('email_address', $record?->email_address) }}"
                   placeholder="journal@email.com">
          </div>

          <div class="field">
            <label>Type of Publication (Scope) <span class="req">*</span></label>
            <select name="pub_scope" required>
              <option value="">— Select —</option>
              @foreach($scopes as $s)
                <option value="{{ $s }}" {{ old('pub_scope', $record?->pub_scope) === $s ? 'selected' : '' }}>{{ $s }}</option>
              @endforeach
            </select>
          </div>

          <div class="field">
            <label>Format</label>
            <select name="pub_format">
              <option value="">— Select —</option>
              @foreach($formats as $f)
                <option value="{{ $f }}" {{ old('pub_format', $record?->pub_format) === $f ? 'selected' : '' }}>{{ $f }}</option>
              @endforeach
            </select>
          </div>

          <div class="field span-2">
            <label>Nature of Publication <span class="req">*</span></label>
            <select name="nature" required>
              <option value="">— Select —</option>
              @foreach($natures as $n)
                <option value="{{ $n }}" {{ old('nature', $record?->nature) === $n ? 'selected' : '' }}>{{ $n }}</option>
              @endforeach
            </select>
          </div>

        </div>
      </div>

      {{-- ══ INCENTIVE DETAILS ══ --}}
      <div class="card-section">
        <div class="section-label">Incentive Details</div>
        <div class="field-grid cols-2">

          <div class="field">
            <label>Amount Requested (₱) <span class="req">*</span></label>
            <input type="number" name="amount_requested" min="0" step="0.01"
                   value="{{ old('amount_requested', $record?->amount_requested) }}"
                   placeholder="0.00" required>
          </div>

          <div class="field" style="align-self:end;">
            <div class="yn-row" style="border:none;padding:0;">
              <div>Previously claimed incentive for the same paper?</div>
              <div class="yn-opts">
                <label>
                  <input type="radio" name="has_previous_claim" value="1"
                    {{ old('has_previous_claim', $record?->has_previous_claim) == '1' ? 'checked' : '' }}
                    onchange="document.getElementById('pub_prev_section').style.display=''"> Yes
                </label>
                <label>
                  <input type="radio" name="has_previous_claim" value="0"
                    {{ old('has_previous_claim', $record?->has_previous_claim ?? '0') == '0' ? 'checked' : '' }}
                    onchange="document.getElementById('pub_prev_section').style.display='none'"> No
                </label>
              </div>
            </div>
          </div>

        </div>

        {{-- Previous claim details --}}
        <div id="pub_prev_section" style="{{ old('has_previous_claim', $record?->has_previous_claim) == '1' ? '' : 'display:none' }}; margin-top:.75rem;">
          <div class="prev-section">
            <div class="prev-section-label">Previous Claim Details</div>
            <div class="field-grid cols-2">
              <div class="field">
                <label>Previous Claim Amount (₱)</label>
                <input type="number" name="previous_claim_amount" min="0" step="0.01"
                       value="{{ old('previous_claim_amount', $record?->previous_claim_amount) }}" placeholder="0.00">
              </div>
              <div class="field span-2">
                <label>Previous Paper Title</label>
                <input type="text" name="prev_paper_title"
                       value="{{ old('prev_paper_title', $record?->prev_paper_title) }}" placeholder="Title of previously claimed paper">
              </div>
              <div class="field span-2">
                <label>Previous Co-authors</label>
                <input type="text" name="prev_co_authors"
                       value="{{ old('prev_co_authors', $record?->prev_co_authors) }}" placeholder="Separate names with comma">
              </div>
              <div class="field span-2">
                <label>Previous Journal Title</label>
                <input type="text" name="prev_journal_title"
                       value="{{ old('prev_journal_title', $record?->prev_journal_title) }}" placeholder="Journal title">
              </div>
              <div class="field">
                <label>Previous Vol. / Issue / No.</label>
                <input type="text" name="prev_vol_issue"
                       value="{{ old('prev_vol_issue', $record?->prev_vol_issue) }}" placeholder="e.g. Vol. 10, Issue 1">
              </div>
              <div class="field">
                <label>Previous ISSN / ISBN</label>
                <input type="text" name="prev_issn_isbn"
                       value="{{ old('prev_issn_isbn', $record?->prev_issn_isbn) }}" placeholder="e.g. 1234-5678">
              </div>
              <div class="field">
                <label>Previous DOI</label>
                <input type="text" name="prev_doi"
                       value="{{ old('prev_doi', $record?->prev_doi) }}" placeholder="e.g. 10.1000/xyz123">
              </div>
              <div class="field">
                <label>Previous Publisher</label>
                <input type="text" name="prev_publisher"
                       value="{{ old('prev_publisher', $record?->prev_publisher) }}" placeholder="Publisher name">
              </div>
              <div class="field">
                <label>Previous Editor/s</label>
                <input type="text" name="prev_editors"
                       value="{{ old('prev_editors', $record?->prev_editors) }}" placeholder="Editor names">
              </div>
              <div class="field">
                <label>Previous Scope</label>
                <select name="prev_pub_scope">
                  <option value="">— Select —</option>
                  @foreach($scopes as $s)
                    <option value="{{ $s }}" {{ old('prev_pub_scope', $record?->prev_pub_scope) === $s ? 'selected' : '' }}>{{ $s }}</option>
                  @endforeach
                </select>
              </div>
            </div>
          </div>
        </div>
      </div>

      {{-- ══ SIGNATORIES ══ --}}
      @php
        $signatories = [
          ['role'=>'Requested by',         'name_field'=>'sig_requested_name',        'position_field'=>'sig_requested_position',        'default_name'=>'Dr. Bryan John A. Magoling',       'default_pos'=>'Director, Research Management Services'],
          ['role'=>'Reviewed by',          'name_field'=>'sig_reviewed_name',         'position_field'=>'sig_reviewed_position',         'default_name'=>'Engr. Albertson D. Amante',        'default_pos'=>'VP for Research, Development and Extension Services'],
          ['role'=>'Recommending Approval','name_field'=>'sig_recommending_name',     'position_field'=>'sig_recommending_position',     'default_name'=>'Atty. Noel Alberto S. Omandap',    'default_pos'=>'VP for Administration and Finance'],
          ['role'=>'Approved by',          'name_field'=>'sig_approved_name',         'position_field'=>'sig_approved_position',         'default_name'=>'Dr. Tirso A. Ronquillo',           'default_pos'=>'University President'],
        ];
      @endphp
      <div class="card-section">
        <div class="section-label">Signatories <span style="font-size:.68rem;font-weight:400;color:#9ca3af;margin-left:.5rem;">— pre-filled with standard names, click any field to edit</span></div>
        <div class="sig-grid">
          @foreach($signatories as $sig)
          <div class="sig-box">
            <div class="sig-role">{{ $sig['role'] }}</div>
            <div class="sig-field-wrap">
              <input type="text" class="sig-name-input" name="{{ $sig['name_field'] }}"
                     value="{{ old($sig['name_field'], $record?->{$sig['name_field']} ?? $sig['default_name']) }}"
                     data-default="{{ $sig['default_name'] }}">
              <span class="sig-edit-icon">✎</span>
            </div>
            <div class="sig-field-wrap">
              <input type="text" class="sig-pos-input" name="{{ $sig['position_field'] }}"
                     value="{{ old($sig['position_field'], $record?->{$sig['position_field']} ?? $sig['default_pos']) }}"
                     data-default="{{ $sig['default_pos'] }}">
              <span class="sig-edit-icon" style="font-size:.55rem;">✎</span>
            </div>
            <button type="button" class="sig-reset-btn" onclick="resetSignatory(this)">↺ Reset to default</button>
          </div>
          @endforeach
        </div>
      </div>

      <div class="form-actions">
        <button type="button" onclick="closeModal('genericFormModal')" class="btn btn-ghost">Cancel</button>
        <button type="reset" class="btn btn-outline" onclick="document.querySelectorAll('#publication-form [data-default]').forEach(i=>i.value=i.dataset.default)">Clear</button>
        <button type="submit" class="btn btn-primary">💾 {{ $isEdit ? 'Update' : 'Save' }} Request</button>
      </div>

    </div>
  </form>
</div>

<script>
function resetSignatory(btn) {
  btn.closest('.sig-box').querySelectorAll('[data-default]').forEach(i => i.value = i.dataset.default);
}
</script>