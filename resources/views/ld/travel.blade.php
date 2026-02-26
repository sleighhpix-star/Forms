<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-GSO-03-A &mdash; Authority to Travel</title>
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
.vt { vertical-align: top; padding-top: 3pt; }
.vm { vertical-align: middle; }
.bold { font-weight: bold; }
.nb { border: none !important; }
.foot { border: none; padding: 0; margin: 0; font-size: 8.5pt; font-style: italic; line-height: 1.25; }
.footBottom { margin-top: 14pt; }
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
  .foot { font-size: 8pt !important; }
}
</style>
</head>
<body>

<div class="pbar">
  <span>BatStateU-FO-GSO-03-A &mdash; Preview</span>
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
    <td>Reference No.: BatStateU-FO-GSO-03-A</td>
    <td>Effectivity Date: May 18, 2022</td>
    <td>&nbsp;Revision No.: 02</td>
  </tr>
</table>

<table>
  <colgroup>
    <col style="width:20%"><col style="width:30%"><col style="width:20%"><col style="width:30%">
  </colgroup>

  {{-- Title --}}
  <tr style="height:1.1cm">
    <td colspan="4" class="c bold" style="font-size:13pt;text-transform:uppercase;line-height:1.4;">
      AUTHORITY TO TRAVEL<br>
      <span style="font-size:10pt;">(CENTRAL ADMINISTRATION)</span>
    </td>
  </tr>

  {{-- Employee Names --}}
  <tr style="height:1.40cm">
    <td class="s vt">Employee Name/s:</td>
    <td colspan="3" class="vt" style="white-space:pre-line;">{{ $record->employee_names ?? '' }}</td>
  </tr>

  {{-- Position --}}
  <tr style="height:1.00cm">
    <td class="s vt">Position:</td>
    <td colspan="3" class="vt" style="white-space:pre-line;">{{ $record->positions ?? '' }}</td>
  </tr>

  {{-- Date / Time --}}
  <tr style="height:0.65cm">
    <td class="s">Date/s of Travel:</td>
    <td>{{ $record->travel_dates ?? '' }}</td>
    <td class="s">Time:</td>
    <td>{{ $record->travel_time ?? '' }}</td>
  </tr>

  {{-- Place --}}
  <tr style="height:0.80cm">
    <td class="s">Place/s to be Visited:</td>
    <td colspan="3">{{ $record->places_visited ?? '' }}</td>
  </tr>

  {{-- Purpose --}}
  <tr style="height:1.20cm">
    <td class="s vt">Purpose of Travel:</td>
    <td colspan="3" class="vt">{{ $record->purpose ?? '' }}</td>
  </tr>

  {{-- Chargeable --}}
  <tr style="height:0.65cm">
    <td class="s">Chargeable against:</td>
    <td colspan="3">{{ $record->chargeable_against ?? 'N/A' }}</td>
  </tr>

  {{-- Signatories --}}
  <tr style="height:1.70cm">
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Requested by: <span style="font-size:8pt;font-style:italic;">*</span></div>
      <div style="height:0.65cm;"></div>
      <div style="text-align:center;font-weight:bold;">Dr. BRYAN JOHN A. MAGOLING</div>
      <div style="text-align:center;">Director for Research Management Services</div>
      <div style="margin-top:2pt;">Date:</div>
    </td>
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.65cm;"></div>
      <div style="text-align:center;font-weight:bold;">Engr. ALBERTSON D. AMANTE</div>
      <div style="text-align:center;">Vice President for Research, Development, and Extension Services</div>
      <div style="margin-top:2pt;">Date:</div>
    </td>
  </tr>
  <tr style="height:1.60cm">
    <td colspan="4" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Approved by:</div>
      <div style="height:0.65cm;"></div>
      <div style="text-align:center;font-weight:bold;">Atty. NOEL ALBERTO S. OMANDAP</div>
      <div style="text-align:center;">Vice President for Administration and Finance</div>
      <div style="margin-top:2pt;">Date:</div>
    </td>
  </tr>
</table>

<p class="foot"><em>* - requires initial of Immediate Supervisor</em></p>

<div class="footBottom">
  <div class="trackLineWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">@if(!empty($record->tracking_number)){{ $record->tracking_number }}@endif</span>
  </div>
</div>

</div></div>
</body>
</html>