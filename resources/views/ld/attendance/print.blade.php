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
  font-size: 11pt;
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
  font-size: 11pt;
  font-family: "Times New Roman", Times, serif;
  line-height: 1.25;
}

/* ── Label cells ── */
.lbl {
  background: #F2F2F2;
  font-size: 11pt !important;
  vertical-align: middle !important;
  line-height: 1.2;
  overflow: hidden;
}

/* ── Utility classes ── */
.s   { background: #F2F2F2; }
.c   { text-align: center; }
.r   { text-align: right; }
.vt  { vertical-align: top !important; padding-top: 3pt !important; }
.vm  { vertical-align: middle !important; }
.b   { font-weight: bold; }
.u   { text-decoration: underline; }
.sm  { font-size: 11pt; line-height: 1.2; }

/* ── Others field: checkbox + label + underlined stretch ── */
.others-wrap {
  display: inline-flex;
  align-items: flex-start; /* keep this */
  gap: 4pt;
  flex: 1;
  min-width: 0;
}

.others-chk {
  display: inline-flex;
  align-items: center;
  flex-shrink: 0;
  margin-top: 2pt; /* key fix */
}
.others-label {
  white-space: nowrap;
  flex-shrink: 0;
  font-size: 11pt;
  line-height: 1.4;
}
.others-line {
  flex: 1;
  min-width: 0;
  font-size: 11pt;
  line-height: 1.4;
  word-break: break-word;
  white-space: normal;
  text-decoration: underline;
  text-underline-offset: 3px;
  text-decoration-skip-ink: none;
}

/* ── Footer ── */
.foot     { font-size: 10pt; font-style: italic; line-height: 1.35; }
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
  @page { size: 8.5in 13in; margin: 0.5in 0.5in 0.5in 0.5in; }
  html, body { margin: 0; padding: 0; background: #fff !important; }
  .pbar { display: none !important; }
  .wrap { padding: 0 !important; display: block !important; }
  .sheet { width: 100% !important; padding: 0 !important; box-shadow: none !important; }
  table { width: 100% !important; }
  td { padding: 2pt 4pt !important; }
  .lbl { font-size: 11pt !important; }
  .foot { font-size: 9pt !important; }
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
    ? '<span style="display:inline-block;width:15pt;height:15pt;background:#C00000;border:1px solid #900;vertical-align:middle;position:relative;top:-1pt;flex-shrink:0;-webkit-print-color-adjust:exact;print-color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:15pt;height:15pt;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;flex-shrink:0;"></span>';

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
    <col style="width:6%">    {{-- 1 --}}
    <col style="width:6%">    {{-- 2 --}}
    <col style="width:11%">   {{-- 3 --}}
    <col style="width:8%">    {{-- 4 --}}
    <col style="width:6.5%">  {{-- 5 --}}
    <col style="width:6.5%">  {{-- 6 --}}
    <col style="width:7%">    {{-- 7 --}}
    <col style="width:6.5%">  {{-- 8 --}}
    <col style="width:6.5%">  {{-- 9 --}}
    <col style="width:8%">    {{-- 10 --}}
    <col style="width:10%">   {{-- 11 --}}
    <col style="width:18%">   {{-- 12 --}}
  </colgroup>

  {{-- R01 Title --}}
  <tr>
    <td colspan="12" class="c b" style="font-size:12pt;padding:6pt 4pt;line-height:1.4;letter-spacing:.01em;">
      REQUEST FOR ATTENDANCE TO EXTERNAL MEETINGS AND OTHER NON-TRAINING RELATED ACTIVITIES
    </td>
  </tr>

  {{-- R02 Name --}}
  <tr style="height:0.72cm">
    <td colspan="3" class="lbl">Name of Attendee:</td>
    <td colspan="9">{!! $v('attendee_name') !!}</td>
  </tr>

  {{-- R03 Campus --}}
  <tr style="height:0.72cm">
    <td colspan="3" class="lbl">Campus/ Operating Unit:</td>
    <td colspan="9">{!! $v('campus') !!}</td>
  </tr>

  {{-- R04 College | Employment Status --}}
  <tr style="height:0.72cm">
    <td colspan="3" class="lbl">College/Office:</td>
    <td colspan="4">{!! $v('college_office') !!}</td>
    <td colspan="3" class="lbl">Employment Status:</td>
    <td colspan="2">{!! $v('employment_status') !!}</td>
  </tr>

  {{-- R05 Position --}}
  <tr style="height:0.72cm">
    <td colspan="3" class="lbl">Academic Rank/<br>Position/Designation:</td>
    <td colspan="9">{!! $v('position') !!}</td>
  </tr>

  {{-- R06 Type of Activity --}}
  <tr>
    <td colspan="3" class="lbl vm">Type of Activity:</td>
    <td colspan="9" style="padding:3pt 5pt;font-size:11pt;vertical-align:middle;">
      <div style="display:flex;flex-direction:column;gap:4pt;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:6pt;">
          <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Meeting',$act)) !!} Meeting</span>
          <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Planning Session',$act)) !!} Planning Session</span>
          <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Benchmarking',$act)) !!} Benchmarking</span>
          <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Project/Product Launch',$act)||in_array('Project/ Product Launch',$act)) !!} Project/ Product Launch</span>
        </div>
        <div style="display:flex;align-items:flex-start;gap:6pt;min-width:0;">
          <span style="display:inline-flex;align-items:center;gap:3pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Ceremonial/Representational',$act)||in_array('Ceremonial/ Representational Events',$act)) !!} Ceremonial/ Representational Events</span>
          @php $aOther = $r?->activity_type_others ?? null; @endphp
          <span class="others-wrap">
            <span class="others-chk">{!! $chk(!empty($aOther)) !!}</span>
            <span class="others-label">Others:</span>
            <span class="others-line">{{ $aOther ?? '' }}</span>
          </span>
        </div>
      </div>
    </td>
  </tr>

  {{-- R07 Nature of Participation --}}
  <tr>
    <td colspan="3" class="lbl vm">Nature of Participation:</td>
    <td colspan="9" style="padding:4pt 6pt;font-size:11pt;vertical-align:middle;">
      <div style="display:flex;flex-direction:column;gap:4pt;">
        <div style="display:flex;justify-content:space-between;align-items:center;gap:4pt;">
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Attendee',$nat)) !!} Attendee</span>
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Presenter',$nat)) !!} Presenter</span>
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Officer',$nat)) !!} Officer</span>
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Speaker',$nat)) !!} Speaker</span>
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Facilitator',$nat)) !!} Facilitator</span>
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Organizer',$nat)) !!} Organizer</span>
        </div>
        <div style="display:flex;align-items:flex-start;gap:6pt;min-width:0;">
          <span style="display:inline-flex;align-items:center;gap:4pt;white-space:nowrap;flex-shrink:0;">{!! $chk(in_array('Exhibitor',$nat)) !!} Exhibitor</span>
          @php $nOther = $r?->nature_others ?? null; @endphp
          <span class="others-wrap">
            <span class="others-chk">{!! $chk(!empty($nOther)) !!}</span>
            <span class="others-label">Others:</span>
            <span class="others-line">{{ !empty($nOther) ? e($nOther) : '' }}</span>
          </span>
        </div>
      </div>
    </td>
  </tr>

  {{-- R08 Purpose --}}
  <tr style="height:0.72cm">
    <td colspan="3" class="lbl">Purpose of Activity:</td>
    <td colspan="9">{!! $v('purpose') !!}</td>
  </tr>

  {{-- R09 Level --}}
  <tr style="height:0.72cm">
    <td colspan="3" class="lbl">Level:</td>
    <td colspan="9" style="font-size:11pt;padding:0;">
      <span style="display:flex;justify-content:flex-start;gap:75px;width:100%;height:100%;">
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='Local') !!} Local</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='Regional') !!} Regional</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='National') !!} National</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(($r?->level??'')==='International') !!} International</span>
      </span>
    </td>
  </tr>

  {{-- R10 Date | Actual Hours --}}
  <tr style="height:0.72cm">
    <td colspan="2" class="lbl">Date:</td>
    <td colspan="5">{!! $v('activity_date') !!}</td>
    <td colspan="3" class="lbl">Actual No. of Hours:</td>
    <td colspan="2">{!! $v('hours') !!}</td>
  </tr>

  {{-- R11 Venue | Organizer --}}
  <tr style="height:0.72cm">
    <td colspan="2" class="lbl">Venue:</td>
    <td colspan="5">{!! $v('venue') !!}</td>
    <td colspan="3" class="lbl">Sponsor Agency/<br>Organizer:</td>
    <td colspan="2">{!! $v('organizer') !!}</td>
  </tr>

  {{-- R12 Financial Assistance --}}
  <tr style="height:0.72cm">
    <td colspan="10" class="lbl">Is financial assistance requested from the University?</td>
    <td colspan="2" style="font-size:11pt;">
      <span style="display:inline-flex;align-items:center;justify-content:space-around;width:100%;">
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk($fin) !!} Yes</span>
        <span style="display:inline-flex;align-items:center;gap:4pt;">{!! $chk(!$fin) !!} No</span>
      </span>
    </td>
  </tr>

  {{-- R13 Total Amount --}}
  <tr style="height:0.72cm">
    <td colspan="10" class="lbl">If yes, how much is the <u>total amount</u> being requested?</td>
    <td colspan="2" style="white-space:nowrap;">
      Php&nbsp;{{ ($fin && !empty($r?->amount_requested)) ? number_format((float)$r->amount_requested, 2) : '_____________.00' }}
    </td>
  </tr>

  {{-- R14–R16 Coverage (label rowspans 3) --}}
  <tr style="height:0.52cm">
    <td colspan="2" rowspan="3" class="lbl vm">Coverage:</td>
    <td colspan="3" style="border-bottom:none;border-right:none;font-size:11pt;">{!! $chk(in_array('registration',$cov)) !!} Registration</td>
    <td colspan="4" style="border-bottom:none;border-right:none;border-left:none;font-size:11pt;">{!! $chk(in_array('accommodation',$cov)) !!} Accommodation</td>
    <td colspan="3" style="border-bottom:none;border-left:none;font-size:11pt;">{!! $chk(in_array('materials',$cov)) !!} Materials/ Kit</td>
  </tr>
  <tr style="height:0.52cm">
    <td colspan="3" style="border-top:none;border-bottom:none;border-right:none;font-size:11pt;">{!! $chk(in_array('speaker_fee',$cov)) !!} Speaker&#x2019;s Fee</td>
    <td colspan="4" style="border-top:none;border-bottom:none;border-right:none;border-left:none;font-size:11pt;">{!! $chk(in_array('meals',$cov)) !!} Meals/ Snacks</td>
    <td colspan="3" style="border-top:none;border-bottom:none;border-left:none;font-size:11pt;">{!! $chk(in_array('transportation',$cov)) !!} Transportation</td>
  </tr>
  <tr style="height:0.55cm">
    <td colspan="10" style="border-top:none;font-size:11pt;">
      @php $cOther = $r?->coverage_others ?? null; @endphp
      <span class="others-wrap" style="width:100%;display:flex;">
        <span class="others-chk">{!! $chk(!empty($cOther)) !!}</span>
        <span class="others-label">Others, specify:</span>
        <span class="others-line">{{ !empty($cOther) ? e($cOther) : '' }}</span>
      </span>
    </td>
  </tr>

  {{-- R17 Signatories row 1 --}}
  <tr style="height:1.75cm">
    <td colspan="7" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Requested by:</div>
      <div style="height:0.62cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;margin-top:15pt;">{{ strtoupper($r?->sig_requested_name ?? 'DR. BRYAN JOHN A. MAGOLING') }}</div>
      <div style="text-align:center;font-size:11pt;">{{ $r?->sig_requested_position ?? 'Director, Research Management Services' }}</div>
      <div style="font-size:11pt;margin-top:3pt;margin-left:30pt;">Date Signed:</div>
    </td>
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Reviewed by:</div>
      <div style="height:0.62cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;">{{ strtoupper($r?->sig_reviewed_name ?? 'ENGR. ALBERTSON D. AMANTE') }}</div>
      <div style="text-align:center;font-size:11pt;">Vice President for Research, Development,</div>
      <div style="text-align:center;font-size:11pt;">and Extension Services</div>
      <div style="font-size:11pt;margin-top:3pt;margin-left:30pt;">Date Signed:</div>
    </td>
  </tr>

  {{-- R18 Signatories row 2 --}}
  <tr style="height:1.65cm">
    <td colspan="7" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;">{{ strtoupper($r?->sig_recommending_name ?? 'ATTY. NOEL ALBERTO S. OMANDAP') }}</div>
      <div style="text-align:center;font-size:11pt;">{{ $r?->sig_recommending_position ?? 'Vice President for Administration and Finance' }}</div>
      <div style="font-size:11pt;margin-top:3pt;margin-left:30pt;">Date Signed:</div>
    </td>
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:11pt;">Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:11pt;">{{ strtoupper($r?->sig_approved_name ?? 'DR. TIRSO A. RONQUILLO') }}</div>
      <div style="text-align:center;font-size:11pt;">{{ $r?->sig_approved_position ?? 'University President' }}</div>
      <div style="font-size:11pt;margin-top:3pt;margin-left:30pt;">Date Signed:</div>
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
<div style="margin-top:40pt;text-align:right;">
  <div class="trackWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">{{ !empty($r?->tracking_number) ? $r->tracking_number : '' }}</span>
  </div>
</div>

</div></div>
</body>
</html>