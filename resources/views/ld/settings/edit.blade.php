@extends('ld.layouts.app')

@section('title', 'Signatory Settings — BatStateU')

@section('content')
<div style="max-width:680px;margin:2rem auto;padding:0 1rem;">

  <div style="margin-bottom:1.5rem;">
    <h2 style="font-size:1.15rem;font-weight:700;color:var(--ink);margin:0 0 .25rem;">⚙️ Signatory Defaults</h2>
    <p style="font-size:.82rem;color:var(--ink-faint);margin:0;">
      These names and positions are pre-filled on all new forms. Each record can still be edited individually before saving.
    </p>
  </div>

  @if(session('success'))
    <div style="background:#d1fae5;border:1px solid #6ee7b7;color:#065f46;padding:.75rem 1rem;border-radius:var(--radius);margin-bottom:1rem;font-size:.85rem;">
      ✅ {{ session('success') }}
    </div>
  @endif

  <form method="POST" action="{{ route('settings.update') }}">
    @csrf
    @method('PUT')

    @php
      $rows = [
        ['role' => 'Requested by',          'name_key' => 'sig_requested_name',        'pos_key' => 'sig_requested_position'],
        ['role' => 'Reviewed by',           'name_key' => 'sig_reviewed_name',         'pos_key' => 'sig_reviewed_position'],
        ['role' => 'Recommending Approval', 'name_key' => 'sig_recommending_name',     'pos_key' => 'sig_recommending_position'],
        ['role' => 'Approved by',           'name_key' => 'sig_approved_name',         'pos_key' => 'sig_approved_position'],
      ];
    @endphp

    <div style="display:flex;flex-direction:column;gap:1rem;">
      @foreach($rows as $row)
      <div style="background:white;border:1px solid var(--ivory-deep);border-radius:var(--radius);padding:1.25rem;">
        <div style="font-size:.72rem;font-weight:700;color:var(--crimson);text-transform:uppercase;letter-spacing:.05em;margin-bottom:.75rem;">
          {{ $row['role'] }}
        </div>
        <div style="display:grid;grid-template-columns:1fr 1fr;gap:.75rem;">
          <div>
            <label style="display:block;font-size:.75rem;color:var(--ink-faint);margin-bottom:.3rem;">Name</label>
            <input type="text"
                   name="{{ $row['name_key'] }}"
                   value="{{ old($row['name_key'], $signatories[$row['name_key']] ?? '') }}"
                   required
                   style="width:100%;padding:.45rem .65rem;border:1px solid var(--ivory-deep);border-radius:var(--radius-sm);font-size:.85rem;font-family:var(--font-body);">
            @error($row['name_key'])
              <div style="color:#dc2626;font-size:.72rem;margin-top:.2rem;">{{ $message }}</div>
            @enderror
          </div>
          <div>
            <label style="display:block;font-size:.75rem;color:var(--ink-faint);margin-bottom:.3rem;">Position / Title</label>
            <input type="text"
                   name="{{ $row['pos_key'] }}"
                   value="{{ old($row['pos_key'], $signatories[$row['pos_key']] ?? '') }}"
                   required
                   style="width:100%;padding:.45rem .65rem;border:1px solid var(--ivory-deep);border-radius:var(--radius-sm);font-size:.85rem;font-family:var(--font-body);">
            @error($row['pos_key'])
              <div style="color:#dc2626;font-size:.72rem;margin-top:.2rem;">{{ $message }}</div>
            @enderror
          </div>
        </div>
      </div>
      @endforeach
    </div>

    <div style="margin-top:1.25rem;display:flex;justify-content:flex-end;gap:.5rem;">
      <a href="{{ route('ld.index') }}" class="btn btn-ghost">Cancel</a>
      <button type="submit" class="btn btn-primary">💾 Save Changes</button>
    </div>
  </form>

</div>
@endsection
