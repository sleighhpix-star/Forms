{{-- resources/views/ld/travel/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-GSO-03-A &mdash; {{ $record->employee_names ?? '' }}</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; background: #e5e7eb; }

.pbar {
  background: #5C0E24;
  padding: .4rem 1.1rem;
  display: flex; gap: .65rem; align-items: center;
  border-bottom: 2px solid #B5832A;
  font-family: 'Geist', system-ui, sans-serif;
}
.pbar button {
  background: #B5832A; color: #fff; border: none; border-radius: 5px;
  padding: .28rem .85rem; font-family: inherit; font-size: .76rem; font-weight: 600; cursor: pointer;
  transition: background .15s;
}
.pbar button:hover { background: #9A6E20; }
.pbar span { color: rgba(255,255,255,.65); font-size: .76rem; }

.wrap { display: flex; justify-content: center; padding: 0.2cm; }
.sheet {
  width: 17.26cm;
  background: #fff;
  box-shadow: 0 3px 16px rgba(0,0,0,.15);
  padding: .5cm .82cm .6cm .82cm;
}

table { width: 100%; border-collapse: collapse; table-layout: fixed; }
td { border: 1px solid #000; padding: 4px 6px; vertical-align: middle; font-size: 11pt; font-family: "Times New Roman", Times, serif; word-break: break-word; }
.center { text-align: center; }
.bold   { font-weight: bold; }

* { -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact; }

@media print {
  .pbar { display: none !important; }
  @page { size: 8.5in 13in; margin: 0.394in 0.920in 0.295in 0.787in; }
  html, body { margin: 0; padding: 0; background: #fff !important; }
  .wrap { padding: 0 !important; display: block !important; }
  .sheet { width: 100% !important; padding: 0 !important; box-shadow: none !important; }
}
</style>
</head>
<body>

@php

  $fmtName = function($name) {
    $prefixes = ['Dr.','Engr.','Atty.','Prof.','Mr.','Ms.','Mrs.','Gen.','Col.','Maj.','Capt.','Lt.'];
    $words = explode(' ', trim($name));
    $result = [];
    foreach ($words as $word) {
      $upper = strtoupper(rtrim($word, '.'));
      $found = false;
      foreach ($prefixes as $p) {
        if (strtoupper(rtrim($p, '.')) === $upper) {
          $result[] = $p;
          $found = true;
          break;
        }
      }
      if (!$found) $result[] = strtoupper($word);
    }
    return implode(' ', $result);
  };
  $r = $record ?? null;

  // Parse newline-delimited employee names and positions
  $empNames     = array_values(array_filter(array_map('trim', explode("\n", $r?->employee_names ?? ''))));
  $empPositions = array_values(array_filter(array_map('trim', explode("\n", $r?->positions ?? ''))));

  // Places to be visited — split by comma or newline for multi-row display
  $places = array_values(array_filter(array_map('trim', preg_split('/[\n,]+/', $r?->places_visited ?? ''))));
  if (empty($places)) $places = ['', '', ''];
  while (count($places) < 3) $places[] = '';
@endphp

<div class="pbar">
  <span>BatStateU-FO-GSO-03-A &mdash; Preview</span>
  <button onclick="window.print()">&#128424;&nbsp; Print / Save PDF</button>
</div>

<div class="wrap"><div class="sheet">

{{-- ═══ HEADER ═══ --}}
<table>
  <colgroup>
    <col style="width:9%">
    <col style="width:35%">
    <col style="width:32%">
    <col style="width:24%">
  </colgroup>
  <tr style="height:0.90cm">
    <td class="center" style="padding:2pt;">
      @php $logo = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logo))
        <img src="{{ asset('images/batstateu-logo.png') }}" style="width:1.2cm;height:1.2cm;object-fit:contain;display:block;margin:0 auto;">
      @else
        <div style="width:1.2cm;height:1.2cm;border:1px dashed #aaa;margin:0 auto"></div>
      @endif
    </td>
    <td style="font-size:9.5pt;">Reference No.: BatStateU-FO-GSO-03-A</td>
    <td style="font-size:9.5pt;"><span style="text-decoration:underline;">Effectivity</span> Date: May 18, 2022</td>
    <td style="font-size:9.5pt;">Revision No.: 02</td>
  </tr>
</table>

{{-- ═══ TITLE ═══ --}}
<table style="margin-top:-1px;">
  <tr>
    <td class="center bold" style="font-size:12pt;padding:5pt 4pt;line-height:1.4;border-bottom:none;">
      AUTHORITY TO TRAVEL<br>
      <span style="font-size:11pt;">(Central Administration)</span>
    </td>
  </tr>
</table>

{{-- ═══ BODY ═══ --}}
<table style="margin-top:-1px;">
  <colgroup>
    <col style="width:20%">{{-- 1: label --}}
    <col style="width:30%">{{-- 2: value left --}}
    <col style="width:14%">{{-- 3: label right --}}
    <col style="width:36%">{{-- 4: value right --}}
  </colgroup>

  {{-- Employee Name/s + Position --}}
  @php $empRows = max(count($empNames), 1); @endphp
  @for($i = 0; $i < $empRows; $i++)
  <tr style="min-height:0.65cm;">
    @if($i === 0)
      <td rowspan="{{ $empRows }}" style="vertical-align:middle;">Employee Name/s:</td>
    @endif
    <td>{{ $empNames[$i] ?? '' }}</td>
    @if($i === 0)
      <td rowspan="{{ $empRows }}" style="vertical-align:middle;">Position:</td>
    @endif
    <td>{{ $empPositions[$i] ?? '' }}</td>
  </tr>
  @endfor

  {{-- Date/s of Travel + Time --}}
  <tr>
    <td>Date/s of Travel:</td>
    <td>{{ $r?->travel_dates ?? '' }}</td>
    <td>Time:</td>
    <td>{{ $r?->travel_time ?? '' }}</td>
  </tr>

  {{-- Place/s to be Visited (3 rows) --}}
  <tr style="height:0.65cm;">
    <td rowspan="3" style="vertical-align:middle;">Place/s to be Visited:</td>
    <td colspan="3">{{ $places[0] ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm;">
    <td colspan="3">{{ $places[1] ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm;">
    <td colspan="3">{{ $places[2] ?? '' }}</td>
  </tr>

  {{-- Purpose of Travel --}}
  <tr style="height:1.8cm;">
    <td style="vertical-align:top;padding-top:5px;">Purpose of Travel:</td>
    <td colspan="3" style="vertical-align:top;padding-top:5px;">{{ $r?->purpose ?? '' }}</td>
  </tr>

  {{-- Chargeable Against --}}
  <tr>
    <td>Chargeable against:</td>
    <td colspan="3">{{ $r?->chargeable_against ?? '' }}</td>
  </tr>

  {{-- Signatories Row 1: Requested by + Recommending Approval --}}
  <tr style="height:2.4cm;">
    <td colspan="2" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Requested by:</div>
      <div style="height:0.7cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;">{{ $fmtName($r?->sig_requested_name ?? 'DR. BRYAN JOHN A. MAGOLING') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $r?->sig_requested_position ?? 'Director, Research Management Services' }}</div>
      <div style="font-size:11pt;margin-top:4pt;">Date:</div>
    </td>
    <td colspan="2" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Recommending Approval:</div>
      <div style="height:0.7cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;">{{ $fmtName($r?->sig_reviewed_name ?? 'ENGR. ALBERTSON D. AMANTE') }}</div>
      <div style="text-align:center;font-size:10pt;">Vice President for Research, Development,</div>
      <div style="text-align:center;font-size:10pt;">and Extension Services</div>
      <div style="font-size:11pt;margin-top:4pt;">Date:</div>
    </td>
  </tr>

  {{-- Signatories Row 2: Approved by (full width) --}}
  <tr style="height:2.4cm;">
    <td colspan="4" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Approved by:</div>
      <div style="height:0.7cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;">{{ $fmtName($r?->sig_recommending_name ?? 'ATTY. NOEL ALBERTO S. OMANDAP') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $r?->sig_recommending_position ?? 'Vice President for Administration and Finance' }}</div>
      <div style="font-size:11pt;margin-top:4pt;">Date:</div>
    </td>
  </tr>

</table>

<p style="margin-top:6pt;font-size:9pt;font-style:italic;">
  * - requires initial of Immediate Supervisor
</p>

<div style="text-align:right;margin-top:16pt;font-size:8pt;font-style:italic;">
  Tracking Number:
  <span style="display:inline-block;width:130px;border-bottom:1px solid #000;margin-left:5pt;height:10pt;vertical-align:bottom;">{{ $r?->tracking_number ?? '' }}</span>
</div>

</div></div>
</body>
</html>