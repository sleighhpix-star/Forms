<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-HRD-31 &mdash; {{ $record->attendee_name ?? '' }}</title>
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
  .trackLineWrap { margin-top: 40pt !important; }
}
</style>
</head>
<body>

@php
  $chk = fn($v) => $v
    ? '<span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span>';
  $act  = $record->activity_types ?? [];
  $nat  = $record->natures        ?? [];
  $cov  = $record->coverage       ?? [];
@endphp

<div class="pbar">
  <span>BatStateU-FO-HRD-31 &mdash; Preview</span>
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
    <td>Reference No.: BatStateU-FO-HRD-31</td>
    <td>Effectivity Date: October 27, 2025</td>
    <td>&nbsp;Revision No.: 00</td>
  </tr>
</table>

{{-- MAIN TABLE --}}
<table>
  <colgroup>
    <col style="width:9%"><col style="width:16%"><col style="width:16%"><col style="width:13%"><col style="width:16%"><col style="width:13%"><col style="width:17%">
  </colgroup>

  {{-- Title --}}
  <tr style="height:1.1cm">
    <td colspan="7" class="c bold" style="font-size:11pt;text-transform:uppercase;line-height:1.4;">
      REQUEST FOR ATTENDANCE TO EXTERNAL MEETINGS AND<br>OTHER NON-TRAINING RELATED ACTIVITIES
    </td>
  </tr>

  {{-- Name --}}
  <tr style="height:0.70cm">
    <td colspan="2" class="s">Name of Attendee:</td>
    <td colspan="5">{{ $record->attendee_name ?? '' }}</td>
  </tr>

  {{-- Campus / Employment --}}
  <tr style="height:0.70cm">
    <td colspan="2" class="s">Campus/ Operating Unit:</td>
    <td colspan="2">{{ $record->campus ?? '' }}</td>
    <td class="s">Employment Status:</td>
    <td colspan="2">{{ $record->employment_status ?? '' }}</td>
  </tr>

  {{-- College / Position --}}
  <tr style="height:0.55cm">
    <td colspan="2" class="s">College/ Office:</td>
    <td colspan="2">{{ $record->college_office ?? '' }}</td>
    <td class="s" style="font-size:9pt;line-height:1.1;">Academic Rank/ Position/Designation:</td>
    <td colspan="2">{{ $record->position ?? '' }}</td>
  </tr>

  {{-- Type of Activity --}}
  <tr style="height:1.35cm">
    <td colspan="2" class="s vm">Type of Activity:</td>
    <td colspan="5" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:20%"><col style="width:22%"><col style="width:22%"><col style="width:36%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Meeting',$act)) !!} Meeting</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Planning Session',$act)) !!} Planning Session</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Benchmarking',$act)) !!} Benchmarking</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Project/Product Launch',$act)) !!} Project/ Product Launch</td>
        </tr>
        <tr>
          <td colspan="2" style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Ceremonial/Representational',$act)) !!} Ceremonial/ Representational Events</td>
          <td colspan="2" style="border:none;padding:1pt 2pt;">
            @if($record->activity_type_others ?? null)
              {!! $chk(true) !!} Others: <span style="border-bottom:1px solid #000;display:inline-block;min-width:80pt;vertical-align:bottom;">{{ $record->activity_type_others }}</span>
            @else
              {!! $chk(false) !!} Others: <span style="border-bottom:1px solid #000;display:inline-block;width:80pt;vertical-align:bottom;">&nbsp;</span>
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Nature of Participation --}}
  <tr style="height:1.30cm">
    <td colspan="2" class="s vm">Nature of Participation:</td>
    <td colspan="5" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:16%"><col style="width:18%"><col style="width:16%"><col style="width:18%"><col style="width:18%"><col style="width:14%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Attendee',$nat)) !!} Attendee</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Presenter',$nat)) !!} Presenter</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Officer',$nat)) !!} Officer</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Speaker',$nat)) !!} Speaker</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Facilitator',$nat)) !!} Facilitator</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Organizer',$nat)) !!} Organizer</td>
        </tr>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Exhibitor',$nat)) !!} Exhibitor</td>
          <td colspan="5" style="border:none;padding:1pt 2pt;">
            @if($record->nature_others ?? null)
              {!! $chk(true) !!} Others: <span style="border-bottom:1px solid #000;display:inline-block;min-width:120pt;vertical-align:bottom;">{{ $record->nature_others }}</span>
            @else
              {!! $chk(false) !!} Others: <span style="border-bottom:1px solid #000;display:inline-block;width:120pt;vertical-align:bottom;">&nbsp;</span>
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Purpose --}}
  <tr style="height:1.00cm">
    <td colspan="2" class="s vt">Purpose of Activity:</td>
    <td colspan="5">{{ $record->purpose ?? '' }}</td>
  </tr>

  {{-- Level --}}
  <tr style="height:0.70cm">
    <td colspan="2" class="s">Level:</td>
    <td colspan="5" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:20%"><col style="width:22%"><col style="width:22%"><col style="width:36%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level??'')==='Local') !!} Local</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level??'')==='Regional') !!} Regional</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level??'')==='National') !!} National</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level??'')==='International') !!} International</td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Date / Hours --}}
  <tr style="height:0.65cm">
    <td colspan="2" class="s">Date:</td>
    <td colspan="2">{{ $record->activity_date ?? '' }}</td>
    <td class="s">Actual No. of Hours:</td>
    <td colspan="2">{{ $record->hours ?? '' }}</td>
  </tr>

  {{-- Venue / Organizer --}}
  <tr style="height:0.65cm">
    <td colspan="2" class="s">Venue:</td>
    <td colspan="2">{{ $record->venue ?? '' }}</td>
    <td class="s">Sponsor Agency/ Organizer:</td>
    <td colspan="2">{{ $record->organizer ?? '' }}</td>
  </tr>

  {{-- Financial --}}
  <tr style="height:0.65cm">
    <td colspan="4" class="s">Is financial assistance requested from the University?</td>
    <td class="c" style="border-right:none;">{!! $chk($record->financial_requested ?? false) !!} Yes</td>
    <td class="c" style="border-left:none;border-right:none;">{!! $chk(!($record->financial_requested ?? false)) !!} No</td>
    <td></td>
  </tr>

  {{-- Amount --}}
  <tr style="height:0.65cm">
    <td colspan="4" class="s">If yes, how much is the <span class="ul">total amount</span> being requested?</td>
    <td class="c" style="border-right:none;">Php</td>
    <td colspan="2" style="border-left:none;">
      @if(($record->financial_requested??false) && ($record->amount_requested??null) !== null && $record->amount_requested !== '')
        {{ number_format((float)$record->amount_requested, 2) }}
      @else
        _____________.00
      @endif
    </td>
  </tr>

  {{-- Coverage --}}
  <tr style="height:0.40cm">
    <td rowspan="3" class="s vm">Coverage:</td>
    <td colspan="2" style="border-bottom:none;border-right:none;">{!! $chk(in_array('registration',$cov)) !!} Registration</td>
    <td colspan="2" style="border-bottom:none;border-left:none;border-right:none;">{!! $chk(in_array('accommodation',$cov)) !!} Accommodation</td>
    <td colspan="2" style="border-bottom:none;border-left:none;">{!! $chk(in_array('materials',$cov)) !!} Materials/ Kit</td>
  </tr>
  <tr style="height:0.50cm">
    <td colspan="2" style="border-top:none;border-bottom:none;border-right:none;">{!! $chk(in_array('speaker_fee',$cov)) !!} Speaker&#x2019;s Fee</td>
    <td colspan="2" style="border-top:none;border-bottom:none;border-left:none;border-right:none;">{!! $chk(in_array('meals',$cov)) !!} Meals/ Snacks</td>
    <td colspan="2" style="border-top:none;border-bottom:none;border-left:none;">{!! $chk(in_array('transportation',$cov)) !!} Transportation</td>
  </tr>
  <tr style="height:0.55cm">
    <td colspan="6" style="border-top:none;">
      @if($record->coverage_others ?? null)
        {!! $chk(true) !!} Others, specify: {{ $record->coverage_others }}
      @else
        {!! $chk(false) !!} Others, specify: _______________________
      @endif
    </td>
  </tr>

  {{-- Signatories Row 1 --}}
  <tr style="height:1.65cm">
    <td colspan="4" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Requested by:</div>
      <div style="height:0.60cm;"></div>
      <div style="text-align:center;font-weight:bold;">Dr. BRYAN JOHN A. MAGOLING</div>
      <div style="text-align:center;">Director, Research Management Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="3" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Reviewed by:</div>
      <div style="height:0.60cm;"></div>
      <div style="text-align:center;font-weight:bold;">Engr. ALBERTSON D. AMANTE</div>
      <div style="text-align:center;">Vice President for Research, Development and Extension Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>

  {{-- Signatories Row 2 --}}
  <tr style="height:1.55cm">
    <td colspan="4" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">Atty. NOEL ALBERTO S. OMANDAP</div>
      <div style="text-align:center;">Vice President for Administration and Finance</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="3" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">Dr. TIRSO A. RONQUILLO</div>
      <div style="text-align:center;">University President</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>
</table>

<p class="foot"><em>Required Attachments: (1) official invitation/ call for participation; (2) signed itinerary of travel, if requesting for financial support</em></p>
<p class="foot" style="margin-top:8pt;"><em>Notes:</em></p>
<p class="foot noteItem"><em>1.&nbsp;For faculty with designation, the counterpart VP/VC shall countersign as notice prior to the assessment by the reviewing VP/VC.</em></p>
<p class="foot noteItem"><em>2.&nbsp;For extension campuses, there shall be an initial of the Campus Director prior to recommendation of the Vice Chancellor Concerned.</em></p>
<p class="foot noteItem"><em>3.&nbsp;The signature of the VPAF/VCAF shall only be required if requesting for financial support.</em></p>

<div class="footBottom">
  <div class="ccLine"><em>cc: HRMO</em></div>
  <div class="trackLineWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">@if(!empty($record->tracking_number)){{ $record->tracking_number }}@endif</span>
  </div>
</div>

</div></div>
</body>
</html>