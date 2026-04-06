{{-- _tabs.blade.php — Tab navigation bar --}}
@php $activeTab = request('tab', 'participation'); @endphp
<nav class="idx-tabs" role="tablist">
  <button class="idx-tab {{ $activeTab === 'participation' ? 'active' : '' }}" id="idx-t-participation"
          onclick="idxTab('participation')" role="tab"
          aria-selected="{{ $activeTab === 'participation' ? 'true' : 'false' }}" aria-controls="idx-p-participation">
    📋 Participation <span class="idx-tab-n">{{ $counts['participation'] ?? 0 }}</span>
  </button>
  <button class="idx-tab {{ $activeTab === 'attendance' ? 'active' : '' }}" id="idx-t-attendance"
          onclick="idxTab('attendance')" role="tab"
          aria-selected="{{ $activeTab === 'attendance' ? 'true' : 'false' }}" aria-controls="idx-p-attendance">
    📅 Attendance <span class="idx-tab-n">{{ $counts['attendance'] ?? 0 }}</span>
  </button>
  <button class="idx-tab {{ $activeTab === 'publication' ? 'active' : '' }}" id="idx-t-publication"
          onclick="idxTab('publication')" role="tab"
          aria-selected="{{ $activeTab === 'publication' ? 'true' : 'false' }}" aria-controls="idx-p-publication">
    📰 Publication <span class="idx-tab-n">{{ $counts['publication'] ?? 0 }}</span>
  </button>
  <button class="idx-tab {{ $activeTab === 'reimbursement' ? 'active' : '' }}" id="idx-t-reimbursement"
          onclick="idxTab('reimbursement')" role="tab"
          aria-selected="{{ $activeTab === 'reimbursement' ? 'true' : 'false' }}" aria-controls="idx-p-reimbursement">
    💰 Reimbursement <span class="idx-tab-n">{{ $counts['reimbursement'] ?? 0 }}</span>
  </button>
  <button class="idx-tab {{ $activeTab === 'travel' ? 'active' : '' }}" id="idx-t-travel"
          onclick="idxTab('travel')" role="tab"
          aria-selected="{{ $activeTab === 'travel' ? 'true' : 'false' }}" aria-controls="idx-p-travel">
    ✈️ Travel <span class="idx-tab-n">{{ $counts['travel'] ?? 0 }}</span>
  </button>
</nav>