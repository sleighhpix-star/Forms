@extends('ld.layouts.app')
@section('title', 'L&D Requests — BatStateU RMS')

@push('styles')
  @include('ld.partials._styles')
@endpush

@section('content')
<div class="idx">

  {{-- Page heading --}}
  <div class="idx-heading">
    <h1>Forms</h1>
    <div style="font-size:.78rem;color:var(--ink-4)">
      Batangas State University &nbsp;&middot;&nbsp; Research Management Services
    </div>
  </div>

  @if(session('success'))
    <div id="idx-toast" class="toast">
      <span style="font-size:1rem">✔</span>
      <span>{{ session('success') }}</span>
    </div>
  @endif

  @if($errors->any())
    <div class="alert alert-error no-print" style="margin-bottom:1rem">
      <span>⚠️</span>
      <div>
        <strong>Please fix the following errors:</strong>
        <ul style="margin-top:.4rem;padding-left:1.2rem">
          @foreach($errors->all() as $e)<li style="font-size:.84rem">{{ $e }}</li>@endforeach
        </ul>
      </div>
    </div>
  @endif

  @include('ld.partials._tabs')

  @include('ld.partials._tab-participation')
  @include('ld.partials._tab-attendance')
  @include('ld.partials._tab-publication')
  @include('ld.partials._tab-reimbursement')
  @include('ld.partials._tab-travel')

  @include('ld.partials._modals')

</div>
@endsection

@push('scripts')
  @include('ld.partials._scripts')
@endpush
