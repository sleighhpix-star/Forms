{{-- resources/views/ld/reimbursement/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-REQ-08-A &mdash; {{ $record->department ?? '' }}</title>
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
td { border: 1px solid #000; padding: 3px 5px; vertical-align: middle; font-size: 10pt; font-family: "Times New Roman", Times, serif; word-break: break-word; }
.center { text-align: center; }
.bold   { font-weight: bold; }
.nb     { border: none; }
.s      { background: #f2f2f2; }

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
  $r    = $record ?? null;
  $items = is_array($r?->expense_items) ? $r->expense_items : (json_decode($r?->expense_items ?? '[]', true) ?: []);
  $actTypes = is_array($r?->activity_types) ? $r->activity_types : (json_decode($r?->activity_types ?? '[]', true) ?: []);
  $total = collect($items)->sum(fn($i) => (float)($i['amount'] ?? 0));

  $chk = fn($v) => $v
    ? '<span style="display:inline-block;width:11px;height:11px;background:#C00000;border:1px solid #900;vertical-align:middle;-webkit-print-color-adjust:exact;print-color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:11px;height:11px;border:1px solid #000;vertical-align:middle;"></span>';

  $inTypes = fn($t) => in_array($t, $actTypes);
@endphp

<div class="pbar">
  <span>BatStateU-FO-REQ-08-A &mdash; Preview</span>
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
    <td style="font-size:9.5pt;">Reference No.: BatStateU-FO-REQ-08-A</td>
    <td style="font-size:9.5pt;"><span style="text-decoration:underline;">Effectivity</span> Date: May 18, 2022</td>
    <td style="font-size:9.5pt;">Revision No.: 02</td>
  </tr>
</table>

{{-- ═══ TITLE ═══ --}}
<table style="margin-top:-1px;">
  <tr>
    <td colspan="1" class="center bold" style="font-size:12pt;padding:5pt 4pt;line-height:1.4;border-bottom:none;">
      REQUEST FOR REIMBURSEMENT OF EXPENSES<br>
      <span style="font-size:11pt;">(Central Administration)</span>
    </td>
  </tr>
</table>

{{-- ═══ BODY ═══ --}}
<table style="margin-top:-1px;">
  {{-- 10 cols --}}
  <colgroup>
    <col style="width:18%">{{-- 1 --}}
    <col style="width:8%"> {{-- 2 --}}
    <col style="width:8%"> {{-- 3 --}}
    <col style="width:8%"> {{-- 4 --}}
    <col style="width:8%"> {{-- 5 --}}
    <col style="width:8%"> {{-- 6 --}}
    <col style="width:8%"> {{-- 7 --}}
    <col style="width:10%">{{-- 8 --}}
    <col style="width:10%">{{-- 9 --}}
    <col style="width:14%">{{-- 10 --}}
  </colgroup>

  {{-- Department --}}
  <tr>
    <td colspan="4">Department/ Office: {{ $r?->department ?? '' }}</td>
    <td colspan="6"></td>
  </tr>

  {{-- Expense table header --}}
  <tr class="s">
    <td colspan="2" class="center bold">Name of Payee/s</td>
    <td colspan="4" class="center bold">Item/ Particular/ Description/<br>Specifications</td>
    <td colspan="2" class="center bold">Quantity</td>
    <td colspan="1" class="center bold">Unit Cost</td>
    <td colspan="1" class="center bold">Amount</td>
  </tr>

  {{-- Expense rows (min 6 rows) --}}
  @php $rows = max(count($items), 6); @endphp
  @for($i = 0; $i < $rows; $i++)
    @php $item = $items[$i] ?? []; @endphp
    <tr style="height:0.65cm">
      <td colspan="2">{{ $item['payee'] ?? '' }}</td>
      <td colspan="4">{{ $item['description'] ?? '' }}</td>
      <td colspan="2" class="center">{{ $item['quantity'] ?? '' }}</td>
      <td class="center">{{ isset($item['unit_cost']) && $item['unit_cost'] !== '' ? number_format((float)$item['unit_cost'], 2) : '' }}</td>
      <td class="center">{{ isset($item['amount']) && $item['amount'] !== '' ? number_format((float)$item['amount'], 2) : '' }}</td>
    </tr>
  @endfor

  {{-- Total --}}
  <tr>
    <td colspan="8" style="border:none;"></td>
    <td class="center bold s">Total Amount</td>
    <td class="center">Php {{ $total > 0 ? number_format($total, 2) : '' }}</td>
  </tr>

  {{-- Nature of Activity --}}
  <tr>
    <td colspan="3" rowspan="2" style="vertical-align:middle;font-size:9.5pt;line-height:1.3;">Nature of the Activity where<br>Expenses were Incurred:</td>
    <td colspan="7" style="border:none;font-size:9.5pt;padding:2pt 4pt;">
      <span style="margin-right:12pt;">{!! $chk($inTypes('Seminar/Training')) !!} Seminar/Training</span>
      <span style="margin-right:12pt;">{!! $chk($inTypes('Meeting')) !!} Meeting</span>
      <span>{!! $chk($inTypes('Seminar/Conference')) !!} Seminar/Conference</span>
    </td>
  </tr>
  <tr>
    <td colspan="7" style="border:none;font-size:9.5pt;padding:2pt 4pt;">
      <span style="margin-right:12pt;">{!! $chk($inTypes('Accreditation')) !!} Accreditation</span>
      <span style="margin-right:12pt;">{!! $chk($inTypes('Program')) !!} Program</span>
      <span>{!! $chk(!empty($r?->activity_type_others)) !!} Others, specify: {{ $r?->activity_type_others ?? '' }}</span>
    </td>
  </tr>

  {{-- Details of Activity --}}
  <tr>
    <td colspan="3" rowspan="2" style="vertical-align:middle;">Details of the Activity:</td>
    <td colspan="2" style="font-size:9.5pt;">Venue:</td>
    <td colspan="5">{{ $r?->venue ?? '' }}</td>
  </tr>
  <tr>
    <td colspan="2" style="font-size:9.5pt;">Date:</td>
    <td colspan="5">{{ $r?->activity_date ?? '' }}</td>
  </tr>

  {{-- Reason --}}
  <tr>
    <td colspan="3">Reason for Reimbursement:</td>
    <td colspan="7">{{ $r?->reason ?? '' }}</td>
  </tr>

  {{-- Signatories row 1 --}}
  <tr style="height:2.2cm">
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Requested by:</div>
      <div style="height:0.7cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ $fmtName($r?->sig_requested_name ?? 'DR. BRYAN JOHN A. MAGOLING') }}</div>
      <div style="text-align:center;font-size:9.5pt;">{{ $r?->sig_requested_position ?? 'Director, Research Management Services' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Recommending Approval:</div>
      <div style="height:0.7cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ $fmtName($r?->sig_reviewed_name ?? 'ENGR. ALBERTSON D. AMANTE') }}</div>
      <div style="text-align:center;font-size:9.5pt;">Vice President for Research, Development, and</div>
      <div style="text-align:center;font-size:9.5pt;">Extension Services</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
  </tr>

  {{-- Signatories row 2 --}}
  <tr style="height:2.0cm">
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Approved by:</div>
      <div style="height:0.7cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ $fmtName($r?->sig_recommending_name ?? 'ATTY. NOEL ALBERTO S. OMANDAP') }}</div>
      <div style="text-align:center;font-size:9.5pt;">{{ $r?->sig_recommending_position ?? 'Vice President for Administration and Finance' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Remarks:</div>
      <div style="margin-top:4pt;font-size:10pt;">{{ $r?->remarks ?? '' }}</div>
    </td>
  </tr>

</table>

{{-- Footer --}}
<p style="margin-top:6pt;font-size:8pt;font-style:italic;line-height:1.3;">
  <em>Attachments: Official Receipts, Accomplished Canvass Forms, Approval for the Conduct of the Activity, Signed Acceptance Form*, Travel Authority*, Attendance Sheet* (*if applicable)</em>
</p>
<p style="margin-top:6pt;font-size:8.5pt;">Notes:</p>
<p style="font-size:8.5pt;margin-left:1em;text-indent:-1em;margin-top:2pt;">1.&nbsp; For reimbursements amounting not over Php 500,000.00, the VPAF shall approve/disapprove the request.</p>
<p style="font-size:8.5pt;margin-left:1em;text-indent:-1em;margin-top:2pt;">2.&nbsp; For reimbursements amounting over Php 500,000.00, the University President shall approve/disapprove the request with initial of the VPAF</p>

<div style="text-align:right;margin-top:20pt;font-size:8pt;font-style:italic;">
  Tracking Number:
  <span style="display:inline-block;width:130px;border-bottom:1px solid #000;margin-left:5pt;height:10pt;vertical-align:bottom;">{{ $r?->tracking_number ?? '' }}</span>
</div>

</div></div>
</body>
</html>