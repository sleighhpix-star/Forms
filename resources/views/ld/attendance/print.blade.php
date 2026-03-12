{{-- resources/views/forms/hrd31.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-HRD-31 &mdash; {{ $record->attendee_name ?? '' }}</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }

body {
  font-family: "Times New Roman", Times, serif;
  font-size: 10pt;
  color: #000;
  background: #e5e7eb;
}

/* ── Print bar ── */
.pbar {
  background: #8B1A2B;
  padding: .35rem 1.1rem;
  display: flex;
  gap: .7rem;
  align-items: center;
  position: sticky;
  top: 0;
  z-index: 10;
}
.pbar button {
  background: #C8922A; color: #fff; border: none; border-radius: 4px;
  padding: .3rem 1rem; font-family: Arial, sans-serif;
  font-size: .78rem; font-weight: 700; cursor: pointer;
  letter-spacing: .02em;
}
.pbar button:hover { background: #b07d22; }
.pbar span { color: rgba(255,255,255,.65); font-size: .78rem; }

/* ── Page shell ── */
.wrap { padding: .7cm 0 1.2cm; display: flex; justify-content: center; }
.sheet {
  width: 17.26cm;
  background: #fff;
  box-shadow: 0 3px 16px rgba(0,0,0,.15);
  padding: .5cm .82cm .6cm .82cm;
}

/* ── Table base ── */
table { width: 100%; border-collapse: collapse; table-layout: fixed; }
td {
  border: 1px solid #000;
  padding: 2pt 5pt;
  vertical-align: middle;
  font-size: 10pt;
  font-family: "Times New Roman", Times, serif;
  line-height: 1.25;
}

/* ── Utility classes ── */
.s   { background: #F2F2F2; }
.c   { text-align: center; }
.r   { text-align: right; }
.vt  { vertical-align: top !important; padding-top: 3pt !important; }
.vm  { vertical-align: middle !important; }
.b   { font-weight: bold; }
.u   { text-decoration: underline; }
.sm  { font-size: 8.5pt; line-height: 1.2; }

/* ── Footer ── */
.foot     { font-size: 9pt; font-style: italic; line-height: 1.35; }
.noteItem { margin-left: 2em; text-indent: -1em; margin-top: 2pt; }
.footBottom { margin-top: 12pt; display: flex; justify-content: space-between; align-items: flex-end; }
.ccLine   { font-size: 8.5pt; font-style: italic; }
.trackWrap{ font-size: 8.5pt; font-style: italic; text-align: right; margin-top: 30pt; }
.trackLine{
  display: inline-block; width: 130px;
  border-bottom: 1px solid #000;
  margin-left: 5pt; height: 10pt; vertical-align: bottom;
}

/* ── Print colour fix ── */
* { -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact; }

@media print {
  @page { size: 8.5in 13in; margin: 0.394in 0.920in 0.295in 0.787in; }
  html, body { margin: 0; padding: 0; background: #fff !important; }
  .pbar { display: none !important; }
  .wrap { padding: 0 !important; display: block !important; }
  .sheet { width: 100% !important; padding: 0 !important; box-shadow: none !important; }
  table { width: 100% !important; }
  td { padding: 2pt 4pt !important; font-size: 10pt !important; }
  .foot { font-size: 8.5pt !important; }
}
</style>
</head>
<body>

@php
  $r   = $record ?? null;
  $act = $r ? (is_string($r->activity_types) ? json_decode($r->activity_types, true) : ($r->activity_types ?? [])) : [];
  $nat = $r ? (is_string($r->natures)        ? json_decode($r->natures, true)        : ($r->natures        ?? [])) : [];
  $cov = $r ? (is_string($r->coverage)       ? json_decode($r->coverage, true)       : ($r->coverage       ?? [])) : [];
  $fin = (bool)($r?->financial_requested ?? false);

  // Checkbox: red-filled when true, empty box when false
  $chk = fn($v) => $v
    ? '<span style="display:inline-block;width:9.5pt;height:9.5pt;background:#C00000;border:1px solid #900;vertical-align:middle;position:relative;top:-1pt;flex-shrink:0;-webkit-print-color-adjust:exact;print-color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:9.5pt;height:9.5pt;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;flex-shrink:0;"></span>';

  $v = fn($f, $d = '') => e($r?->$f ?? $d);
@endphp

{{-- ── Print bar ── --}}
<div class="pbar">
  <span>BatStateU-FO-HRD-31 &mdash; Preview</span>
  <button onclick="window.print()">&#128424;&nbsp; Print / Save PDF</button>
</div>

<div class="wrap"><div class="sheet">

{{-- ════════════ HEADER ════════════ --}}
<table>
  <colgroup>
    <col style="width:9%">
    <col style="width:37%">
    <col style="width:35%">
    <col style="width:19%">
  </colgroup>
  <tr style="height:0.90cm">
    <td class="c" style="padding:2pt;">
      @php $logo = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logo))
        <img src="{{ asset('images/batstateu-logo.png') }}"
             style="width:1.2cm;height:1.2cm;object-fit:contain;display:block;margin:0 auto;">
      @else
        <div style="width:1.2cm;height:1.2cm;border:1px dashed #bbb;margin:0 auto;"></div>
      @endif
    </td>
    <td style="font-size:9.5pt;">Reference No.: BatStateU-FO-HRD-31</td>
    <td style="font-size:9.5pt;">Effectivity Date: October 27, 2025</td>
    <td style="font-size:9.5pt;">&nbsp;Revision No.: 00</td>
  </tr>
</table>

{{-- ════════════ BODY — 12-col grid ════════════ --}}
<table style="margin-top:-1px;">
  <colgroup>
    <col style="width:5.5%">  {{-- 1 --}}
    <col style="width:5.5%">  {{-- 2 --}}
    <col style="width:8%">    {{-- 3 --}}
    <col style="width:8%">    {{-- 4 --}}
    <col style="width:7%">    {{-- 5 --}}
    <col style="width:7%">    {{-- 6 --}}
    <col style="width:8%">    {{-- 7 --}}
    <col style="width:7%">    {{-- 8 --}}
    <col style="width:7%">    {{-- 9 --}}
    <col style="width:8%">    {{-- 10 --}}
    <col style="width:11%">   {{-- 11 --}}
    <col style="width:18%">   {{-- 12 --}}
  </colgroup>

  {{-- R01 Title --}}
  <tr>
    <td colspan="12" class="c b" style="font-size:11.5pt;padding:6pt 4pt;line-height:1.4;letter-spacing:.01em;">
      REQUEST FOR ATTENDANCE TO EXTERNAL MEETINGS AND OTHER NON-TRAINING RELATED ACTIVITIES
    </td>
  </tr>

  {{-- R02 Name --}}
  <tr style="height:0.68cm">
    <td colspan="3" class="s">Name of Attendee:</td>
    <td colspan="9">{!! $v('attendee_name') !!}</td>
  </tr>

  {{-- R03 Campus --}}
  <tr style="height:0.68cm">
    <td colspan="3" class="s">Campus/ Operating Unit:</td>
    <td colspan="9">{!! $v('campus') !!}</td>
  </tr>

  {{-- R04 College | Employment Status — [3][4][3][2] --}}
  <tr style="height:0.62cm">
    <td colspan="3" class="s">College/Office:</td>
    <td colspan="4">{!! $v('college_office') !!}</td>
    <td colspan="3" class="s sm">Employment Status:</td>
    <td colspan="2">{!! $v('employment_status') !!}</td>
  </tr>

  {{-- R05 Position --}}
  <tr style="height:0.62cm">
    <td colspan="3" class="s sm">Academic Rank/<br>Position/Designation:</td>
    <td colspan="9">{!! $v('position') !!}</td>
  </tr>

  {{-- R06 Type of Activity --}}
  <tr style="height:1.35cm">
    <td colspan="3" class="s vm">Type of Activity:</td>
    <td colspan="9" style="padding:3pt 5pt 3pt 5pt;font-size:9pt;vertical-align:middle;overflow:hidden;">
      <div style="display:flex;justify-content:space-between;align-items:center;margin-bottom:4pt;">
        <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;">{!! $chk(in_array('Meeting',$act)) !!} Meeting</span>
        <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;">{!! $chk(in_array('Planning Session',$act)) !!} Planning Session</span>
        <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;">{!! $chk(in_array('Benchmarking',$act)) !!} Benchmarking</span>
        <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;">{!! $chk(in_array('Project/Product Launch',$act)||in_array('Project/ Product Launch',$act)) !!} Project/ Product Launch</span>
      </div>
      <div style="display:flex;align-items:center;gap:10pt;">
        <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;">{!! $chk(in_array('Ceremonial/Representational',$act)||in_array('Ceremonial/ Representational Events',$act)) !!} Ceremonial/ Representational Events</span>
        <span style="display:inline-flex;align-items:center;gap:3pt;flex:1;">
          @php $aOther = $r?->activity_type_others ?? null; @endphp
          {!! $chk(!empty($aOther)) !!} Others:&nbsp;<span style="flex:1;border-bottom:1px solid #000;height:11pt;line-height:11pt;display:inline-block;min-width:50pt;">{{ $aOther ?? '' }}</span>
        </span>
      </div>
    </td>
  </tr>

  {{-- R07 Nature of Participation --}}
  <tr style="height:1.45cm">
    <td colspan="3" class="s vm">Nature of Participation:</td>
    <td colspan="9" style="padding:4pt 6pt;font-size:9.5pt;vertical-align:middle;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup>
          <col style="width:16%"><col style="width:17%"><col style="width:16%">
          <col style="width:16%"><col style="width:18%"><col style="width:17%">
        </colgroup>
        <tr>
          <td style="border:none;padding:0 0 4pt 0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Attendee',$nat)) !!} Attendee</span></td>
          <td style="border:none;padding:0 0 4pt 0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Presenter',$nat)) !!} Presenter</span></td>
          <td style="border:none;padding:0 0 4pt 0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Officer',$nat)) !!} Officer</span></td>
          <td style="border:none;padding:0 0 4pt 0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Speaker',$nat)) !!} Speaker</span></td>
          <td style="border:none;padding:0 0 4pt 0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Facilitator',$nat)) !!} Facilitator</span></td>
          <td style="border:none;padding:0 0 4pt 0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Organizer',$nat)) !!} Organizer</span></td>
        </tr>
        <tr>
          <td style="border:none;padding:0;white-space:nowrap;"><span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(in_array('Exhibitor',$nat)) !!} Exhibitor</span></td>
          <td colspan="5" style="border:none;padding:0;">
            @php $nOther = $r?->nature_others ?? null; @endphp
            <span style="display:inline-flex;align-items:center;gap:4pt;width:100%;">
              {!! $chk(!empty($nOther)) !!} Others:&nbsp;<span style="flex:1;border-bottom:1px solid #000;height:11pt;line-height:11pt;display:inline-block;min-width:80pt;">{{ !empty($nOther) ? e($nOther) : '' }}</span>
            </span>
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- R08 Purpose --}}
  <tr style="height:0.68cm">
    <td colspan="3" class="s">Purpose of Activity:</td>
    <td colspan="9">{!! $v('purpose') !!}</td>
  </tr>

  {{-- R09 Level — evenly spread --}}
  <tr style="height:0.65cm">
    <td colspan="3" class="s">Level:</td>
    <td colspan="9" style="font-size:9.5pt;padding:0;">
      <span style="display:flex;justify-content:space-evenly;align-items:center;width:100%;height:100%;">
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='Local') !!} Local</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='Regional') !!} Regional</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='National') !!} National</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='International') !!} International</span>
      </span>
    </td>
  </tr>

  {{-- R10 Date | Actual Hours — [2][5] | [3][2] = 12 --}}
  <tr style="height:0.65cm">
    <td colspan="2" class="s">Date:</td>
    <td colspan="5">{!! $v('activity_date') !!}</td>
    <td colspan="3" class="s sm">Actual No. of<br>Hours:</td>
    <td colspan="2">{!! $v('hours') !!}</td>
  </tr>

  {{-- R11 Venue | Organizer — same split as R10 --}}
  <tr style="height:0.78cm">
    <td colspan="2" class="s">Venue:</td>
    <td colspan="5">{!! $v('venue') !!}</td>
    <td colspan="3" class="s sm">Sponsor Agency/<br>Organizer:</td>
    <td colspan="2">{!! $v('organizer') !!}</td>
  </tr>

  {{-- R12 Financial Assistance — label cols 1-10, Yes+No cols 11-12 (no divider) --}}
  <tr style="height:0.65cm">
    <td colspan="10" class="s">Is financial assistance requested from the University?</td>
    <td colspan="2" style="font-size:9.5pt;">
      <span style="display:inline-flex;align-items:center;justify-content:space-around;width:100%;">
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk($fin) !!} Yes</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(!$fin) !!} No</span>
      </span>
    </td>
  </tr>

  {{-- R13 Total Amount — same split as R12 --}}
  <tr style="height:0.65cm">
    <td colspan="10" class="s">If yes, how much is the <u>total amount</u> being requested?</td>
    <td colspan="2" style="white-space:nowrap;">
      Php&nbsp;{{ ($fin && !empty($r?->amount_requested)) ? number_format((float)$r->amount_requested, 2) : '_____________.00' }}
    </td>
  </tr>

  {{-- R14–R16 Coverage (label rowspans 3) --}}
  <tr style="height:0.48cm">
    <td colspan="2" rowspan="3" class="s vm">Coverage:</td>
    <td colspan="3" style="border-bottom:none;border-right:none;font-size:9.5pt;">{!! $chk(in_array('registration',$cov)) !!} Registration</td>
    <td colspan="4" style="border-bottom:none;border-right:none;border-left:none;font-size:9.5pt;">{!! $chk(in_array('accommodation',$cov)) !!} Accommodation</td>
    <td colspan="3" style="border-bottom:none;border-left:none;font-size:9.5pt;">{!! $chk(in_array('materials',$cov)) !!} Materials/ Kit</td>
  </tr>
  <tr style="height:0.50cm">
    <td colspan="3" style="border-top:none;border-bottom:none;border-right:none;font-size:9.5pt;">{!! $chk(in_array('speaker_fee',$cov)) !!} Speaker&#x2019;s Fee</td>
    <td colspan="4" style="border-top:none;border-bottom:none;border-right:none;border-left:none;font-size:9.5pt;">{!! $chk(in_array('meals',$cov)) !!} Meals/ Snacks</td>
    <td colspan="3" style="border-top:none;border-bottom:none;border-left:none;font-size:9.5pt;">{!! $chk(in_array('transportation',$cov)) !!} Transportation</td>
  </tr>
  <tr style="height:0.55cm">
    <td colspan="10" style="border-top:none;font-size:9.5pt;">
      @php $cOther = $r?->coverage_others ?? null; @endphp
      {!! $chk(!empty($cOther)) !!} Others, specify:&nbsp;<span style="display:inline-block;border-bottom:1px solid #000;min-width:140pt;height:11pt;vertical-align:bottom;">{{ !empty($cOther) ? e($cOther) : '' }}</span>
    </td>
  </tr>

  {{-- R17 Signatories row 1 --}}
  <tr style="height:1.75cm">
    <td colspan="6" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Requested by:</div>
      <div style="height:0.62cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ strtoupper($r?->sig_requested_name ?? 'DR. BRYAN JOHN A. MAGOLING') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $r?->sig_requested_position ?? 'Director, Research Management Services' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
    <td colspan="6" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Reviewed by:</div>
      <div style="height:0.62cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ strtoupper($r?->sig_reviewed_name ?? 'ENGR. ALBERTSON D. AMANTE') }}</div>
      <div style="text-align:center;font-size:10pt;">Vice President for Research, Development,</div>
      <div style="text-align:center;font-size:10pt;">and Extension Services</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
  </tr>

  {{-- R18 Signatories row 2 --}}
  <tr style="height:1.65cm">
    <td colspan="6" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ strtoupper($r?->sig_recommending_name ?? 'ATTY. NOEL ALBERTO S. OMANDAP') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $r?->sig_recommending_position ?? 'Vice President for Administration and Finance' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
    <td colspan="6" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ strtoupper($r?->sig_approved_name ?? 'DR. TIRSO A. RONQUILLO') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $r?->sig_approved_position ?? 'University President' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
  </tr>

</table>

{{-- ════════════ FOOTER ════════════ --}}
<div style="margin-top:5pt;">
  <p class="foot"><em>Required Attachments: (1) official invitation/ call for participation, (2) signed itinerary of travel, if requesting for financial support</em></p>
  <p class="foot" style="margin-top:6pt;"><em>Notes:</em></p>
  <p class="foot noteItem"><em>1.&nbsp;For faculty with designation, the counterpart VP/VC shall countersign as notice prior to the assessment by the reviewing VP/VC.</em></p>
  <p class="foot noteItem"><em>2.&nbsp;For extension campuses, there shall be an initial of the Campus Director prior to recommendation of the Vice Chancellor Concerned.</em></p>
  <p class="foot noteItem"><em>3.&nbsp;The signature of the VPAF/VCAF shall only be required if requesting for financial support.</em></p>
</div>

<div style="margin-top:12pt;">
  <div class="ccLine"><em>cc: HRMO</em></div>
</div>
<div style="margin-top:30pt;text-align:right;">
  <div class="trackWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">{{ !empty($r?->tracking_number) ? $r->tracking_number : '' }}</span>
  </div>
</div>

</div></div>
</body>
</html>