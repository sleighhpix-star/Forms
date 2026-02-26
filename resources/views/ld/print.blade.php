<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-HRD-28 &mdash; {{ $record->participant_name ?? '' }}</title>
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
.s   { background: #d3d3d3; }
.smallText{ font-size: 10pt; line-height: 1.15; }
.foot{ border: none; padding: 0; margin: 0; font-size: 9pt; font-style: italic; line-height: 1.25; }
.noteItem{ margin-left: 2.0em; text-indent: -1.0em; margin-top: 2pt; }
.footBottom{ margin-top: 18pt; position: relative; }
.ccLine{ font-size: 8pt; font-style: italic; }
.trackLineWrap{ font-size: 8pt; font-style: italic; text-align: right; margin-top: 60pt; }
.trackLine{ display: inline-block; width: 130px; border-bottom: 1px solid #000; margin-left: 6pt; }
.c   { text-align: center; }
.vt  { vertical-align: top; padding-top: 4pt; }
.vm  { vertical-align: middle; }
.nb  { border: none; padding: 0; font-size: 8pt; font-style: italic; line-height: 1.4; }
.bold{ font-weight: bold; }
.ul  { text-decoration: underline; }
/* Force background colors to print */
* { -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact; }

@media print {
  @page { size: 8.5in 13in; margin: 0.394in 0.920in 0.295in 0.787in; }
  html, body { margin: 0; padding: 0; -webkit-print-color-adjust: exact !important; print-color-adjust: exact !important; }
  .pbar { display: none !important; }
  .wrap { padding: 0 !important; display: block !important; }
  .sheet { width: 100% !important; font-size: 10.5pt !important; }
  table { width: 100% !important; table-layout: fixed !important; }
  td { padding: 2pt 4pt !important; font-size: 10.5pt !important; line-height: 1.2 !important; }
  .foot { font-size: 8pt !important; line-height: 1.25 !important; }
  .noteItem { margin-left: 2.0em !important; text-indent: -1.0em !important; }
  .ccLine, .trackLineWrap { font-size: 8pt !important; }
  .trackLineWrap { margin-top: 60pt !important; }
  .trackLine { width: 130px !important; border-bottom: 1px solid #000 !important; }
}
</style>
</head>
<body>

@php
  $chk = fn($v) => $v
    ? '<span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span>';
  $sel = $record->types    ?? [];
  $nat = $record->natures  ?? [];
  $cov = $record->coverage ?? [];
@endphp

<div class="pbar">
  <span>BatStateU-FO-HRD-28 &mdash; Preview</span>
  <button onclick="window.print()">&#128424; Print / Save PDF</button>
</div>

<div class="wrap"><div class="sheet">

{{-- ═══ HEADER ═══ --}}
<table style="margin-bottom:0">
  <colgroup>
    <col style="width:9.18%">
    <col style="width:37.01%">
    <col style="width:34.71%">
    <col style="width:19.10%">
  </colgroup>
  <tr style="height:0.88cm">
    <td class="c" style="padding:2pt;vertical-align:middle;">
      @php $logo = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logo))
        <img src="{{ asset('images/batstateu-logo.png') }}"
             style="width:1.2cm;height:1.2cm;object-fit:contain;display:block;margin:0 auto;">
      @else
        <div style="width:1.2cm;height:1.2cm;border:1px dashed #aaa;margin:0 auto"></div>
      @endif
    </td>
    <td>Reference No.: BatStateU-FO-HRD-28</td>
    <td>Effectivity Date: October 27, 2025</td>
    <td>&nbsp;Revision No.: 03</td>
  </tr>
</table>

{{-- ═══ MAIN TABLE — 16-col grid ═══ --}}
<table>
  <colgroup>
    <col style="width:9.18%">
    <col style="width:2.50%">
    <col style="width:13.43%">
    <col style="width:1.44%">
    <col style="width:13.29%">
    <col style="width:6.35%">
    <col style="width:2.87%">
    <col style="width:0.09%">
    <col style="width:0.27%">
    <col style="width:17.03%">
    <col style="width:3.22%">
    <col style="width:2.59%">
    <col style="width:0.08%">
    <col style="width:8.54%">
    <col style="width:0.44%">
    <col style="width:18.67%">
  </colgroup>

  {{-- R01 Title --}}
  <tr style="height:0.9cm">
    <td colspan="16" class="c bold" style="font-size:12pt;text-transform:uppercase;">
      REQUEST FOR PARTICIPATION IN EXTERNAL LEARNING AND DEVELOPMENT INTERVENTIONS
    </td>
  </tr>

  {{-- R02 Name --}}
  <tr style="height:0.74cm">
    <td colspan="4" class="s">Name of Participant:</td>
    <td colspan="12">{{ $record->participant_name ?? '' }}</td>
  </tr>

  {{-- R03 Campus / Employment --}}
  <tr style="height:0.73cm">
    <td colspan="4" class="s">Campus/ Operating Unit:</td>
    <td colspan="3">{{ $record->campus ?? '' }}</td>
    <td colspan="4" class="s">Employment Status:</td>
    <td colspan="5">{{ $record->employment_status ?? '' }}</td>
  </tr>

  {{-- R04 College / Position --}}
  <tr style="height:0.46cm">
    <td colspan="4" class="s">College/ Office:</td>
    <td colspan="3">{{ $record->college_office ?? '' }}</td>
    <td colspan="4" class="s" style="line-height:1.1">Academic Rank/ Position/Designation:</td>
    <td colspan="5">{{ $record->position ?? '' }}</td>
  </tr>

  {{-- R05 Title --}}
  <tr style="height:0.58cm">
    <td colspan="4" class="s">Title of Intervention:</td>
    <td colspan="12">{{ $record->title ?? '' }}</td>
  </tr>

  {{-- R06 Type of Intervention --}}
  <tr style="height:1.35cm">
    <td colspan="4" class="s vm">Type of Intervention:</td>
    <td colspan="12" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup>
          <col style="width:18%">
          <col style="width:20%">
          <col style="width:20%">
          <col style="width:18%">
          <col style="width:24%">
        </colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Seminar',$sel)) !!} Seminar</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Convention',$sel)) !!} Convention</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Conference',$sel)) !!} Conference</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Training',$sel)) !!} Training</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Symposium',$sel)) !!} Symposium</td>
        </tr>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Workshop',$sel)) !!} Workshop</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(in_array('Immersion',$sel)) !!} Immersion</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;" colspan="3">
            @if($record->type_others ?? null)
              <span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;color-adjust:exact;"></span> Others: <span style="display:inline-block;border-bottom:1px solid #000;min-width:120pt;vertical-align:bottom;">{{ $record->type_others }}</span>
            @else
              <span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span> Others: <span style="display:inline-block;border-bottom:1px solid #000;width:120pt;vertical-align:bottom;">&nbsp;</span>
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- R07 Level --}}
  <tr style="height:0.80cm">
    <td colspan="4" class="s">Level:</td>
    <td colspan="12" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;border:none;">
        <colgroup>
          <col style="width:19%"><col style="width:21%"><col style="width:21%"><col style="width:39%">
        </colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level ?? '') === 'Local') !!} Local</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level ?? '') === 'Regional') !!} Regional</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level ?? '') === 'National') !!} National</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->level ?? '') === 'International') !!} International</td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- R08 Nature of Participation --}}
  <tr style="height:1.30cm">
    <td colspan="4" class="s vm">Nature of Participation:</td>
    <td colspan="12" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;border:none;">
        <colgroup>
          <col style="width:19%"><col style="width:21%"><col style="width:21%"><col style="width:18%"><col style="width:21%">
        </colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk(in_array('Learner',$nat)) !!} Learner</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk(in_array('Presenter',$nat)) !!} Presenter</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk(in_array('Officer',$nat)) !!} Officer</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk(in_array('Speaker',$nat)) !!} Speaker</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk(in_array('Facilitator',$nat)) !!} Facilitator</td>
        </tr>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk(in_array('Organizer',$nat)) !!} Organizer</td>
          <td style="border:none;padding:1pt 2pt;" colspan="4">
            @if($record->nature_others ?? null)
              <span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;color-adjust:exact;"></span> Others: <span style="display:inline-block;border-bottom:1px solid #000;min-width:100pt;vertical-align:bottom;">{{ $record->nature_others }}</span>
            @else
              <span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span> Others: <span style="display:inline-block;border-bottom:1px solid #000;width:100pt;vertical-align:bottom;">&nbsp;</span>
            @endif
          </td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- R09 Competency --}}
  <tr style="height:1.20cm">
    <td colspan="4" class="s vt">Competency/competencies to be developed/ enhanced <em>(if participating as a learner):</em></td>
    <td colspan="12">{{ $record->competency ?? '' }}</td>
  </tr>

  {{-- R10 Date / Hours --}}
  <tr style="height:0.67cm">
    <td colspan="2" class="s">Date:</td>
    <td colspan="3">{{ $record->intervention_date ?? '' }}</td>
    <td colspan="5" class="s">Actual No. of Hours:</td>
    <td colspan="6">{{ $record->hours ?? '' }}</td>
  </tr>

  {{-- R11 Venue / Organizer --}}
  <tr style="height:0.69cm">
    <td colspan="2" class="s">Venue:</td>
    <td colspan="3">{{ $record->venue ?? '' }}</td>
    <td colspan="5" class="s">Sponsor Agency/ Organizer:</td>
    <td colspan="6">{{ $record->organizer ?? '' }}</td>
  </tr>

  {{-- R12 endorsed_by_org --}}
  <tr style="height:0.66cm">
    <td colspan="10" class="s">Endorsed by a recognized or registered professional organization?</td>
    <td colspan="4" class="c" style="border-right:none;">{!! $chk($record->endorsed_by_org ?? false) !!} Yes</td>
    <td colspan="2" class="c" style="border-left:none;">{!! $chk(!($record->endorsed_by_org ?? false)) !!} No</td>
  </tr>

  {{-- R13 related_to_field --}}
  <tr style="height:0.66cm">
    <td colspan="10" class="s">Related to the participant&rsquo;s current field/work load?</td>
    <td colspan="4" class="c" style="border-right:none;">{!! $chk($record->related_to_field ?? false) !!} Yes</td>
    <td colspan="2" class="c" style="border-left:none;">{!! $chk(!($record->related_to_field ?? false)) !!} No</td>
  </tr>

  {{-- R14 has_pending_ldap --}}
  <tr style="height:1.10cm">
    <td colspan="10" class="s smallText" style="vertical-align:middle;">Has pending implementation of Learning and Development Application Plan?<br><em>(If yes, please attach status of implementation by using BatStateU-FO-HRD-30)</em></td>
    <td colspan="4" class="c" style="border-right:none;">{!! $chk($record->has_pending_ldap ?? false) !!} Yes</td>
    <td colspan="2" class="c" style="border-left:none;">{!! $chk(!($record->has_pending_ldap ?? false)) !!} No</td>
  </tr>

  {{-- R15 has_cash_advance --}}
  <tr style="height:0.66cm">
    <td colspan="10" class="s">Has any unliquidated cash advance?</td>
    <td colspan="4" class="c" style="border-right:none;">{!! $chk($record->has_cash_advance ?? false) !!} Yes</td>
    <td colspan="2" class="c" style="border-left:none;">{!! $chk(!($record->has_cash_advance ?? false)) !!} No</td>
  </tr>

  {{-- R16 financial_requested --}}
  <tr style="height:0.66cm">
    <td colspan="10" class="s">Is financial assistance requested from the University?</td>
    <td colspan="4" class="c" style="border-right:none;">{!! $chk($record->financial_requested ?? false) !!} Yes</td>
    <td colspan="2" class="c" style="border-left:none;">{!! $chk(!($record->financial_requested ?? false)) !!} No</td>
  </tr>

  {{-- R17 Amount --}}
  <tr style="height:0.66cm">
    <td colspan="10" class="s">If yes, how much is the <span class="ul">total amount</span> being requested?</td>
    <td colspan="2" class="c" style="border-right:none;">Php</td>
    <td colspan="4" style="border-left:none;">
      @if(($record->financial_requested ?? false) && ($record->amount_requested ?? null) !== null && $record->amount_requested !== '')
        {{ number_format((float) $record->amount_requested, 2) }}
      @else
        _____________.00
      @endif
    </td>
  </tr>

  {{-- R18-R20 Coverage --}}
  <tr style="height:0.40cm">
    <td colspan="3" rowspan="3" class="s vm">Coverage:</td>
    <td colspan="4" style="border-bottom:none;border-right:none;">{!! $chk(in_array('registration',$cov)) !!} Registration</td>
    <td colspan="5" style="border-bottom:none;border-left:none;border-right:none;">{!! $chk(in_array('accommodation',$cov)) !!} Accommodation</td>
    <td colspan="4" style="border-bottom:none;border-left:none;">{!! $chk(in_array('materials',$cov)) !!} Materials/ Kit</td>
  </tr>
  <tr style="height:0.54cm">
    <td colspan="4" style="border-top:none;border-bottom:none;border-right:none;">{!! $chk(in_array('speaker_fee',$cov)) !!} Speaker&#x2019;s Fee</td>
    <td colspan="5" style="border-top:none;border-bottom:none;border-left:none;border-right:none;">{!! $chk(in_array('meals',$cov)) !!} Meals/ Snacks</td>
    <td colspan="4" style="border-top:none;border-bottom:none;border-left:none;">{!! $chk(in_array('transportation',$cov)) !!} Transportation</td>
  </tr>
  <tr style="height:0.58cm">
    <td colspan="13" style="border-top:none;">
      @if($record->coverage_others ?? null)
        <span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;color-adjust:exact;"></span> Others, specify: {{ $record->coverage_others }}
      @else
        <span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span> Others, specify: _______________________
      @endif
    </td>
  </tr>

  {{-- R21 Signatories row 1 --}}
  <tr style="height:1.70cm">
    <td colspan="8" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Requested by:</div>
      <div style="height:0.65cm;"></div>
      <div style="text-align:center;font-weight:bold;">Dr. BRYAN JOHN A. MAGOLING</div>
      <div style="text-align:center;">Director, Research Management Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="8" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Reviewed by:</div>
      <div style="height:0.65cm;"></div>
      <div style="text-align:center;font-weight:bold;">Engr. ALBERTSON D. AMANTE</div>
      <div style="text-align:center;">Vice President for Research, Development and Extension Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>

  {{-- R22 Signatories row 2 --}}
  <tr style="height:1.55cm">
    <td colspan="8" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">Atty. NOEL ALBERTO S. OMANDAP</div>
      <div style="text-align:center;">Vice President for Administration and Finance</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="8" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">Dr. TIRSO A. RONQUILLO</div>
      <div style="text-align:center;">University President</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>

</table>

{{-- Footer notes --}}
<p class="foot"><em>Required Attachments: (1) Official endorsement/ invitation from professional organization; (2) program of activities; (3) signed itinerary of travel, if requesting for financial support; (4) Learning and Development Application Plan, if attending as a learner</em></p>

<p class="foot" style="margin-top:10pt;"><em>Notes:</em></p>

<p class="foot noteItem"><em>1.&nbsp;For faculty with designation, the counterpart VP/VC shall countersign as notice prior to the assessment by the reviewing VP/VC.</em></p>
<p class="foot noteItem"><em>2.&nbsp;For extension campuses, there shall be an initial of the Campus Director prior to review of the VC Concerned.</em></p>
<p class="foot noteItem"><em>3.&nbsp;Copy of approved request, signed Narrative Report for External Learning and Development Interventions (BatStateU-FO-HRD-32-B) and copy of certificate of participation shall be submitted to the HRMO concerned within one (1) week after attendance to the L&amp;D intervention.</em></p>
<p class="foot noteItem"><em>4.&nbsp;For those attending as a learner, Learning and Development Intervention Impact Assessment Form (BatStateU-FO-HRD-21) shall be submitted to the HRMO concerned three (3) months after attendance to the L&amp;D intervention.</em></p>

<div class="footBottom">
  <div class="ccLine"><em>cc: HRMO</em></div>
  <div class="trackLineWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">
      @if(!empty($record->tracking_number))
        {{ $record->tracking_number }}
      @endif
    </span>
  </div>
</div>

</div></div>
</body>
</html>