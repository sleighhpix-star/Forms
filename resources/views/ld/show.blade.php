@extends('ld.layouts.app')
@section('title', 'Request — {{ $record->participant_name ?? "" }} — BatStateU')

@section('content')
<div class="page page-sm">

  @if(session('success'))
    <div class="alert alert-success no-print">✅ {{ session('success') }}</div>
  @endif

  {{-- Top bar --}}
  <div class="d-flex justify-between align-center flex-wrap gap-2 mb-2 no-print">
    <a href="{{ route('ld.index') }}" class="btn btn-ghost btn-sm">← Back to Records</a>
    <div class="d-flex gap-1">
      <a href="{{ route('ld.edit', $record) }}" class="btn btn-outline btn-sm">✏️ Edit</a>
      <a href="{{ route('ld.print', $record) }}" target="_blank" class="btn btn-gold btn-sm">🖨 Print</a>
      <form method="POST" action="{{ route('ld.destroy', $record) }}" onsubmit="return confirm('Delete this record?')">
        @csrf @method('DELETE')
        <button class="btn btn-danger btn-sm">🗑 Delete</button>
      </form>
    </div>
  </div>

  <div class="card">

    {{-- Hero header --}}
    <div style="background:var(--c-dk);padding:1.35rem 2rem 1.1rem;border-radius:var(--r-xl) var(--r-xl) 0 0;position:relative;overflow:hidden">
      <div style="position:absolute;bottom:0;left:0;right:0;height:2px;background:linear-gradient(90deg,transparent,var(--g),var(--g-lt),var(--g),transparent);opacity:.6"></div>
      <div class="ref-badge" style="background:rgba(255,255,255,.12);border-color:rgba(255,255,255,.22);color:rgba(255,255,255,.9);margin-bottom:.6rem">
        📋 BatStateU-FO-HRD-28 &middot; Rev. 03
      </div>
      <h1 style="font-family:var(--f-display);color:#fff;font-size:1.25rem;font-weight:400;line-height:1.35;margin-bottom:.35rem">
        Request for Participation in External<br>Learning and Development Interventions
      </h1>
      <div style="display:flex;gap:.75rem;flex-wrap:wrap">
        <span style="font-size:.72rem;color:rgba(255,255,255,.6)">🗓 Submitted <strong style="color:rgba(255,255,255,.88)">{{ $record->created_at->format('F j, Y') }}</strong></span>
        @if($record->tracking_number)
          <span style="font-size:.72rem;color:rgba(255,255,255,.6)">🔖 <strong style="color:rgba(255,255,255,.88)">{{ $record->tracking_number }}</strong></span>
        @endif
      </div>
    </div>

    {{-- Participant Info --}}
    <div class="card-section">
      <div class="section-label">Participant Information</div>
      <div class="detail-grid">
        <div class="detail-field"><div class="dlabel">Name of Participant</div><div class="dval" style="font-weight:600">{{ $record->participant_name }}</div></div>
        <div class="detail-field"><div class="dlabel">Employment Status</div><div class="dval">{{ $record->employment_status }}</div></div>
        <div class="detail-field"><div class="dlabel">Campus / Operating Unit</div><div class="dval">{{ $record->campus }}</div></div>
        <div class="detail-field"><div class="dlabel">College / Office</div><div class="dval">{{ $record->college_office }}</div></div>
        <div class="detail-field"><div class="dlabel">Position / Designation</div><div class="dval">{{ $record->position }}</div></div>
      </div>
    </div>

    {{-- Intervention Details --}}
    <div class="card-section">
      <div class="section-label">Intervention Details</div>
      <div class="detail-field mb-2">
        <div class="dlabel">Title of Intervention</div>
        <div class="dval" style="font-size:1rem;font-weight:600">{{ $record->title }}</div>
      </div>
      <div class="detail-grid">
        <div class="detail-field">
          <div class="dlabel">Type of Intervention</div>
          <div class="dval">@foreach($record->types as $t)<span class="badge badge-crimson">{{ $t }}</span> @endforeach</div>
        </div>
        <div class="detail-field">
          <div class="dlabel">Level</div>
          <div class="dval"><span class="badge badge-gold">{{ $record->level }}</span></div>
        </div>
        <div class="detail-field">
          <div class="dlabel">Nature of Participation</div>
          <div class="dval">@foreach($record->natures as $n)<span class="badge badge-neutral">{{ $n }}</span> @endforeach</div>
        </div>
        <div class="detail-field"><div class="dlabel">Date</div><div class="dval">{{ $record->intervention_date }}</div></div>
        <div class="detail-field"><div class="dlabel">Actual Hours</div><div class="dval">{{ $record->hours ? $record->hours.' hrs' : '—' }}</div></div>
        <div class="detail-field"><div class="dlabel">Venue</div><div class="dval">{{ $record->venue }}</div></div>
        <div class="detail-field"><div class="dlabel">Organizer / Sponsor</div><div class="dval">{{ $record->organizer }}</div></div>
        @if($record->competency)
          <div class="detail-field" style="grid-column:span 2">
            <div class="dlabel">Competencies to be Developed</div>
            <div class="dval">{{ $record->competency }}</div>
          </div>
        @endif
      </div>
    </div>

    {{-- Assessment --}}
    <div class="card-section">
      <div class="section-label">Assessment</div>
      <div class="detail-grid">
        <div class="detail-field"><div class="dlabel">Endorsed by recognized organization?</div><div class="dval"><span class="badge {{ $record->endorsed_by_org ? 'badge-green' : 'badge-neutral' }}">{{ $record->endorsed_by_org ? 'Yes' : 'No' }}</span></div></div>
        <div class="detail-field"><div class="dlabel">Related to current field/workload?</div><div class="dval"><span class="badge {{ $record->related_to_field ? 'badge-green' : 'badge-neutral' }}">{{ $record->related_to_field ? 'Yes' : 'No' }}</span></div></div>
        <div class="detail-field"><div class="dlabel">Has pending LDAP?</div><div class="dval"><span class="badge {{ $record->has_pending_ldap ? 'badge-amber' : 'badge-neutral' }}">{{ $record->has_pending_ldap ? 'Yes' : 'No' }}</span></div></div>
        <div class="detail-field"><div class="dlabel">Has unliquidated cash advance?</div><div class="dval"><span class="badge {{ $record->has_cash_advance ? 'badge-amber' : 'badge-neutral' }}">{{ $record->has_cash_advance ? 'Yes' : 'No' }}</span></div></div>
        <div class="detail-field">
          <div class="dlabel">Financial Assistance Requested?</div>
          <div class="dval"><span class="badge {{ $record->financial_requested ? 'badge-green' : 'badge-neutral' }}">{{ $record->financial_requested ? 'Yes' : 'No' }}</span></div>
        </div>
        @if($record->financial_requested)
          <div class="detail-field">
            <div class="dlabel">Amount Requested</div>
            <div class="dval" style="font-weight:600;color:var(--c)">₱{{ number_format($record->amount_requested ?? 0, 2) }}</div>
          </div>
          @if($record->coverage)
            <div class="detail-field" style="grid-column:span 2">
              <div class="dlabel">Coverage / Items for Financial Assistance</div>
              <div class="dval">
                @foreach((array)$record->coverage as $cov)
                  <span class="badge badge-gold">{{ ucwords(str_replace('_',' ',$cov)) }}</span>
                @endforeach
              </div>
            </div>
          @endif
        @endif
      </div>
    </div>

    {{-- Signatories --}}
    @if($record->sig_requested_name || $record->sig_approved_name)
    <div class="card-section">
      <div class="section-label">Signatories</div>
      <div class="sig-grid" style="pointer-events:none">
        @foreach([['Requested by',$record->sig_requested_name,$record->sig_requested_position],['Reviewed by',$record->sig_reviewed_name,$record->sig_reviewed_position],['Recommending Approval',$record->sig_recommending_name,$record->sig_recommending_position],['Approved by',$record->sig_approved_name,$record->sig_approved_position]] as [$role,$name,$pos])
          @if($name)
          <div class="sig-box">
            <div class="sig-role">{{ $role }}</div>
            <div style="font-size:.88rem;font-weight:600;color:var(--c)">{{ $name }}</div>
            <div style="font-size:.73rem;color:var(--ink-3)">{{ $pos }}</div>
          </div>
          @endif
        @endforeach
      </div>
    </div>
    @endif

  </div>
</div>
@endsection
