<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-REQ-08-A &mdash; Reimbursement</title>
<style>
* { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; background: #fff; }
.pbar { background: #8B1A2B; padding: .3rem 1rem; display: flex; gap: .6rem; align-items: center; }
.pbar button { background: #C8922A; color: #fff; border: none; border-radius: 5px; padding: .28rem .8rem;
  font-family: Arial, sans-serif; font-size: .78rem; font-weight: 700; cursor: pointer; }
.pbar span { color: rgba(255,255,255,.7); font-size: .78rem; }
.wrap { padding: 0.2cm 0; display: flex; justify-content: center; }
.sheet { width: 17.26cm; font-family: "Times New Roman", Times, serif; font-size: 10pt; }
table { width: 100%; border-collapse: collapse; table-layout: fixed; }
td { border: 1px solid #000; padding: 2pt 5pt; vertical-align: middle; font-size: 10pt;
  font-family: "Times New Roman", Times, serif; line-height: 1.2; }
.s { background: #F2F2F2; }
.c { text-align: center; }
.r { text-align: right; }
.vt { vertical-align: top; padding-top: 3pt; }
.vm { vertical-align: middle; }
.bold { font-weight: bold; }
.ul { text-decoration: underline; }
.foot { border: none; padding: 0; margin: 0; font-size: 9pt; font-style: italic; line-height: 1.25; }
.noteItem { margin-left: 2.0em; text-indent: -1.0em; margin-top: 2pt; }
.footBottom { margin-top: 14pt; }
.ccLine { font-size: 8pt; font-style: italic; }
.trackLineWrap { font-size: 8pt; font-style: italic; text-align: right; margin-top: 40pt; }
.trackLine { display: inline-block; width: 130px; border-bottom: 1px solid #000; margin-left: 6pt; }
* { -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact; }
@media print {
  @page { size: 8.5in 13in; margin: 0.394in 0.920in 0.295in 0.787in; }
  html, body { margin: 0; padding: 0; }
  .pbar { display: none !important; }
  .wrap { padding: 0 !important; display: block !important; }
  .sheet { width: 100% !important; }
  table { width: 100% !important; table-layout: fixed !important; }
  td { padding: 2pt 4pt !important; font-size: 10pt !important; line-height: 1.2 !important; }
  .foot { font-size: 8.5pt !important; }
}
</style>
</head>
<body>

@php
  $chk = fn($v) => $v
    ? '<span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span>';
  $items    = $record->expense_items ?? [];
  $actTypes = $record->activity_types ?? [];
@endphp

<div class="pbar">
  <span>BatStateU-FO-REQ-08-A &mdash; Preview</span>
  <button onclick="window.print()">&#128424; Print / Save PDF</button>
</div>

<div class="wrap"><div class="sheet">

{{-- HEADER --}}
<table style="margin-bottom:0">
  <colgroup>
    <col style="width:9.18%"><col style="width:37.01%"><col style="width:34.71%"><col style="width:19.10%">
  </colgroup>
  <tr style="height:0.88cm">
    <td class="c" style="padding:2pt;">
      @php $logo = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logo))
        <img src="{{ asset('images/batstateu-logo.png') }}" style="width:1.2cm;height:1.2cm;object-fit:contain;display:block;margin:0 auto;">
      @else
        <div style="width:1.2cm;height:1.2cm;border:1px dashed #aaa;margin:0 auto"></div>
      @endif
    </td>
    <td>Reference No.: BatStateU-FO-REQ-08-A</td>
    <td>Effectivity Date: May 18, 2022</td>
    <td>&nbsp;Revision No.: 02</td>
  </tr>
</table>

<table>
  <colgroup>
    <col style="width:30%"><col style="width:30%"><col style="width:10%"><col style="width:15%"><col style="width:15%">
  </colgroup>

  {{-- Title --}}
  <tr style="height:1.0cm">
    <td colspan="5" class="c bold" style="font-size:12pt;text-transform:uppercase;line-height:1.4;">
      REQUEST FOR REIMBURSEMENT OF EXPENSES<br>
      <span style="font-size:10pt;">(Central Administration)</span>
    </td>
  </tr>

  {{-- Department --}}
  <tr style="height:0.65cm">
    <td colspan="2" class="s">Department/ Office:</td>
    <td colspan="3">{{ $record->department ?? '' }}</td>
  </tr>

  {{-- Expense table header --}}
  <tr style="height:0.55cm">
    <td class="s c bold">Name of Payee/s</td>
    <td class="s c bold">Item/ Particular/ Description/ Specifications</td>
    <td class="s c bold">Quantity</td>
    <td class="s c bold">Unit Cost</td>
    <td class="s c bold">Amount</td>
  </tr>

  {{-- Expense rows (up to 10) --}}
  @for($i = 0; $i < 10; $i++)
  @php $item = $items[$i] ?? null; @endphp
  <tr style="height:0.55cm">
    <td>{{ $item['payee'] ?? '' }}</td>
    <td>{{ $item['description'] ?? '' }}</td>
    <td class="c">{{ $item['quantity'] ?? '' }}</td>
    <td class="r">{{ isset($item['unit_cost']) && $item['unit_cost'] !== '' ? 'Php '.number_format((float)$item['unit_cost'],2) : '' }}</td>
    <td class="r">{{ isset($item['amount']) && $item['amount'] !== '' ? 'Php '.number_format((float)$item['amount'],2) : '' }}</td>
  </tr>
  @endfor

  {{-- Total --}}
  <tr style="height:0.60cm">
    <td colspan="4" class="s bold r" style="padding-right:8pt;">Total Amount</td>
    <td class="r bold">
      @php
        $total = collect($items)->sum(fn($i) => (float)($i['amount'] ?? 0));
      @endphp
      @if($total > 0) Php {{ number_format($total, 2) }} @endif
    </td>
  </tr>

  {{-- Nature of activity --}}
  <tr style="height:0.70cm">
    <td colspan="2" class="s vm">Nature of the Activity where Expenses were Incurred:</td>
    <td colspan="3" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:33%"><col style="width:33%"><col style="width:34%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Seminar/Training',$actTypes)) !!} Seminar/Training</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Meeting',$actTypes)) !!} Meeting</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Seminar/Conference',$actTypes)) !!} Seminar/Conference</td>
        </tr>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Accreditation',$actTypes)) !!} Accreditation</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Program',$actTypes)) !!} Program</td>
          <td style="border:none;padding:1pt 2pt;">
            @if($record->activity_type_others ?? null)
              {!! $chk(true) !!} Others: {{ $record->activity_type_others }}
            @else
              {!! $chk(false) !!} Others: ___________
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Activity details --}}
  <tr style="height:0.65cm">
    <td class="s">Venue:</td>
    <td colspan="4">{{ $record->venue ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Date:</td>
    <td>{{ $record->activity_date ?? '' }}</td>
    <td colspan="3" class="s" style="padding-left:8pt;">Reason for Reimbursement:</td>
  </tr>
  <tr style="height:0.65cm">
    <td colspan="2"></td>
    <td colspan="3">{{ $record->reason ?? '' }}</td>
  </tr>

  {{-- Signatories --}}
  <tr style="height:1.60cm">
    <td colspan="3" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Requested by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">{{ strtoupper($record->requester_name ?? 'NAME') }}</div>
      <div style="text-align:center;">{{ $record->requester_title ?? '' }}</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">Engr. ALBERTSON D. AMANTE</div>
      <div style="text-align:center;">Vice President for Research, Development and Extension Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>
  <tr style="height:1.50cm">
    <td colspan="5" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">Atty. LUZVIMINDA C. ROSALES</div>
      <div style="text-align:center;">Vice President, Administration and Finance</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>

  {{-- Remarks --}}
  <tr style="height:0.80cm">
    <td colspan="2" class="s">Remarks:</td>
    <td colspan="3">{{ $record->remarks ?? '' }}</td>
  </tr>
</table>

<p class="foot"><em>Attachments: Official Receipts, Accomplished Canvass Forms, Approval for the Conduct of the Activity, Signed Acceptance Form*, Travel Authority*, Attendance Sheet* (*if applicable)</em></p>
<p class="foot" style="margin-top:6pt;"><em>Notes:</em></p>
<p class="foot noteItem"><em>1.&nbsp;For reimbursements amounting not over Php 500,000.00, the VPAF shall approve/disapprove the request.</em></p>
<p class="foot noteItem"><em>2.&nbsp;For reimbursements amounting over Php 500,000.00, the University President shall approve/disapprove the request with initial of the VPAF.</em></p>

<div class="footBottom">
  <div class="trackLineWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">@if(!empty($record->tracking_number)){{ $record->tracking_number }}@endif</span>
  </div>
</div>

</div></div>
</body>
</html>