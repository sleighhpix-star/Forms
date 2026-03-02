{{-- resources/views/forms/hrd31.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-HRD-31 — {{ $record->attendee_name ?? '' }}</title>
<style>
  *{ box-sizing:border-box; margin:0; padding:0; }
  body{ font-family:"Times New Roman", Times, serif; font-size:11pt; color:#000; background:#fff; }

  .pbar{ background:#8B1A2B; padding:.3rem 1rem; display:flex; gap:.6rem; align-items:center; }
  .pbar button{
    background:#C8922A; color:#fff; border:none; border-radius:5px;
    padding:.28rem .8rem; font-family:Arial, sans-serif;
    font-size:.78rem; font-weight:700; cursor:pointer;
  }
  .pbar span{ color:rgba(255,255,255,.75); font-size:.78rem; }

  .wrap{ padding:.2cm 0; display:flex; justify-content:center; }
  .sheet{ width:17.26cm; font-family:"Times New Roman", Times, serif; font-size:10pt; }

  table{ width:100%; border-collapse:collapse; table-layout:fixed; }
  td{
    border:1px solid #000;
    padding:2pt 5pt;
    vertical-align:middle;
    font-size:10pt;
    line-height:1.2;
  }

  .s{ background:#F2F2F2; }
  .c{ text-align:center; }
  .vt{ vertical-align:top; padding-top:3pt; }
  .vm{ vertical-align:middle; }
  .b{ font-weight:bold; }
  .u{ text-decoration:underline; }
  .tiny{ font-size:9pt; line-height:1.1; }

  .cb{
    display:inline-block;
    width:1em; height:1em;
    vertical-align:middle;
    position:relative; top:-1pt;
    border:1px solid #000;
  }
  .cb.on{ background:#C00000; border-color:#900; }

  .blank{
    display:inline-block;
    border-bottom:1px solid #000;
    min-width:90pt;
    height:10pt;
    vertical-align:bottom;
  }
  .blank.lg{ min-width:160pt; }

  .foot{ border:none; padding:0; margin:0; font-size:9pt; font-style:italic; line-height:1.25; }
  .noteItem{ margin-left:2.0em; text-indent:-1.0em; margin-top:2pt; }
  .footBottom{ margin-top:14pt; }
  .ccLine{ font-size:8pt; font-style:italic; }
  .trackWrap{ font-size:8pt; font-style:italic; text-align:right; margin-top:40pt; }
  .trackLine{
    display:inline-block; width:130px;
    border-bottom:1px solid #000; margin-left:6pt;
    height:10pt; vertical-align:bottom;
  }

  *{
    -webkit-print-color-adjust:exact;
    print-color-adjust:exact;
    color-adjust:exact;
  }

  @media print{
    @page{ size:8.5in 13in; margin:0.394in 0.920in 0.295in 0.787in; }
    html, body{ margin:0; padding:0; }
    .pbar{ display:none !important; }
    .wrap{ padding:0 !important; display:block !important; }
    .sheet{ width:100% !important; }
    table{ width:100% !important; table-layout:fixed !important; }
    td{ padding:2pt 4pt !important; font-size:10pt !important; line-height:1.2 !important; }
    .foot{ font-size:8.5pt !important; }
    .trackWrap{ margin-top:40pt !important; }
  }
</style>
</head>
<body>

@php
  // Normalize arrays (support JSON strings)
  $act = $record->activity_types ?? [];
  $nat = $record->natures ?? [];
  $cov = $record->coverage ?? [];

  if (is_string($act)) $act = json_decode($act, true) ?: [];
  if (is_string($nat)) $nat = json_decode($nat, true) ?: [];
  if (is_string($cov)) $cov = json_decode($cov, true) ?: [];

  $cb = function($bool){
    return $bool ? '<span class="cb on"></span>' : '<span class="cb"></span>';
  };

  // Optional: pretty date like Word (if your record stores Y-m-d)
  $fmtDate = function($v){
    if (!$v) return '';
    try {
      if ($v instanceof \Carbon\CarbonInterface) return $v->format('F j, Y');
      return \Carbon\Carbon::parse($v)->format('F j, Y');
    } catch (\Throwable $e) {
      return (string)$v;
    }
  };
@endphp

<div class="pbar">
  <span>BatStateU-FO-HRD-31 — Preview</span>
  <button type="button" onclick="window.print()">🖨 Print / Save PDF</button>
</div>

<div class="wrap">
  <div class="sheet">

    {{-- HEADER --}}
    <table style="margin-bottom:0;">
      <colgroup>
        <col style="width:9.18%">
        <col style="width:37.01%">
        <col style="width:34.71%">
        <col style="width:19.10%">
      </colgroup>
      <tr style="height:0.88cm;">
        <td class="c" style="padding:2pt;">
          @php $logo = public_path('images/batstateu-logo.png'); @endphp
          @if(file_exists($logo))
            <img src="{{ asset('images/batstateu-logo.png') }}"
                 style="width:1.2cm;height:1.2cm;object-fit:contain;display:block;margin:0 auto;">
          @else
            <div style="width:1.2cm;height:1.2cm;border:1px dashed #aaa;margin:0 auto;"></div>
          @endif
        </td>
        <td>Reference No.: BatStateU-FO-HRD-31</td>
        <td>Effectivity Date: October 27, 2025</td>
        <td>&nbsp;Revision No.: 00</td>
      </tr>
    </table>

    {{-- MAIN TABLE (12-column grid) --}}
    <table>
      <colgroup>
        <col style="width:6%"><col style="width:6%"><col style="width:8%"><col style="width:8%">
        <col style="width:8%"><col style="width:8%"><col style="width:8%"><col style="width:8%">
        <col style="width:8%"><col style="width:8%"><col style="width:12%"><col style="width:12%">
      </colgroup>

      {{-- TITLE --}}
      <tr style="height:1.1cm;">
        <td colspan="12" class="c b" style="font-size:11pt;text-transform:uppercase;line-height:1.4;">
          REQUEST FOR ATTENDANCE TO EXTERNAL MEETINGS AND<br>
          OTHER NON-TRAINING RELATED ACTIVITIES
        </td>
      </tr>

      {{-- NAME --}}
      <tr style="height:0.70cm;">
        <td colspan="3" class="s">Name of Attendee:</td>
        <td colspan="9">{{ $record->attendee_name ?? '' }}</td>
      </tr>

      {{-- CAMPUS + EMPLOYMENT --}}
      <tr style="height:0.70cm;">
        <td colspan="3" class="s">Campus/ Operating Unit:</td>
        <td colspan="4">{{ $record->campus ?? '' }}</td>
        <td colspan="3" class="s">Employment Status:</td>
        <td colspan="2">{{ $record->employment_status ?? '' }}</td>
      </tr>

      {{-- COLLEGE + POSITION --}}
      <tr style="height:0.55cm;">
        <td colspan="3" class="s">College/ Office:</td>
        <td colspan="4">{{ $record->college_office ?? '' }}</td>
        <td colspan="3" class="s tiny">Academic Rank/ Position/Designation:</td>
        <td colspan="2">{{ $record->position ?? '' }}</td>
      </tr>

      {{-- TYPE OF ACTIVITY --}}
      <tr style="height:1.35cm;">
        <td colspan="3" class="s vm">Type of Activity:</td>
        <td colspan="9" class="vt" style="padding:2pt 4pt;font-size:9pt;">
          <div style="display:grid;grid-template-columns:repeat(2,1fr);gap:2pt 18pt;">
            <div>{!! $cb(in_array('Meeting',$act)) !!} <span style="margin-left:6pt;">Meeting</span></div>
            <div>{!! $cb(in_array('Project/Product Launch',$act) || in_array('Project/ Product Launch',$act)) !!} <span style="margin-left:6pt;">Project/ Product Launch</span></div>
            <div>{!! $cb(in_array('Benchmarking',$act)) !!} <span style="margin-left:6pt;">Benchmarking</span></div>
            <div>{!! $cb(in_array('Planning Session',$act)) !!} <span style="margin-left:6pt;">Planning Session</span></div>

            <div>
              @php $aOther = $record->activity_type_others ?? null; @endphp
              {!! $cb(!empty($aOther)) !!} <span style="margin-left:6pt;">Others:</span>
              @if(!empty($aOther))
                <span class="blank" style="min-width:140pt;">{{ $aOther }}</span>
              @else
                <span class="blank" style="min-width:140pt;">&nbsp;</span>
              @endif
            </div>

            <div>
              {!! $cb(in_array('Ceremonial/Representational',$act) || in_array('Ceremonial/ Representational',$act) || in_array('Ceremonial/ Representational Events',$act)) !!}
              <span style="margin-left:6pt;">Ceremonial/ Representational Events</span>
            </div>
          </div>
        </td>
      </tr>

      {{-- NATURE OF PARTICIPATION --}}
      <tr style="height:1.30cm;">
        <td colspan="3" class="s vm">Nature of Participation:</td>
        <td colspan="9" class="vt" style="padding:2pt 4pt;font-size:9pt;">
          <div style="display:grid;grid-template-columns:repeat(6,1fr);gap:2pt 10pt;">
            <div>{!! $cb(in_array('Organizer',$nat)) !!} <span style="margin-left:6pt;">Organizer</span></div>
            <div>{!! $cb(in_array('Facilitator',$nat)) !!} <span style="margin-left:6pt;">Facilitator</span></div>
            <div>{!! $cb(in_array('Speaker',$nat)) !!} <span style="margin-left:6pt;">Speaker</span></div>
            <div>{!! $cb(in_array('Officer',$nat)) !!} <span style="margin-left:6pt;">Officer</span></div>
            <div>{!! $cb(in_array('Presenter',$nat)) !!} <span style="margin-left:6pt;">Presenter</span></div>
            <div>{!! $cb(in_array('Attendee',$nat)) !!} <span style="margin-left:6pt;">Attendee</span></div>

            <div>
              {!! $cb(in_array('Exhibitor',$nat)) !!} <span style="margin-left:6pt;">Exhibitor</span>
            </div>
            <div style="grid-column:2 / span 5;">
              @php $nOther = $record->nature_others ?? null; @endphp
              {!! $cb(!empty($nOther)) !!} <span style="margin-left:6pt;">Others:</span>
              @if(!empty($nOther))
                <span class="blank lg" style="min-width:260pt;">{{ $nOther }}</span>
              @else
                <span class="blank lg" style="min-width:260pt;">&nbsp;</span>
              @endif
            </div>
          </div>
        </td>
      </tr>

      {{-- PURPOSE --}}
      <tr style="height:1.00cm;">
        <td colspan="3" class="s vt">Purpose of Activity:</td>
        <td colspan="9">{{ $record->purpose ?? '' }}</td>
      </tr>

      {{-- LEVEL --}}
      <tr style="height:0.70cm;">
        <td colspan="3" class="s">Level:</td>
        <td colspan="9" style="padding:2pt 4pt;font-size:9pt;">
          <div style="display:grid;grid-template-columns:repeat(4,1fr);gap:2pt 14pt;">
            <div>{!! $cb(($record->level ?? '')==='Local') !!} <span style="margin-left:6pt;">Local</span></div>
            <div>{!! $cb(($record->level ?? '')==='Regional') !!} <span style="margin-left:6pt;">Regional</span></div>
            <div>{!! $cb(($record->level ?? '')==='National') !!} <span style="margin-left:6pt;">National</span></div>
            <div>{!! $cb(($record->level ?? '')==='International') !!} <span style="margin-left:6pt;">International</span></div>
          </div>
        </td>
      </tr>

      {{-- ✅ DATE + HOURS (make HOURS label start at same vertical line as SPONSOR label) --}}
      {{-- We force BOTH rows to use the same left/right split:
           [Date/Venue label=2 cols] [Date/Venue value=6 cols] [Hours/Sponsor label=2 cols] [Hours/Sponsor value=2 cols]
           So Hours and Sponsor are perfectly aligned. --}}
      <tr style="height:0.65cm;">
        <td colspan="2" class="s">Date:</td>
        <td colspan="6">{{ $fmtDate($record->activity_date ?? '') }}</td>

        <td colspan="2" class="s">Actual No. of Hours:</td>
        <td colspan="2">{{ $record->hours ?? '' }}</td>
      </tr>

      <tr style="height:0.65cm;">
        <td colspan="2" class="s">Venue:</td>
        <td colspan="6">{{ $record->venue ?? '' }}</td>

        <td colspan="2" class="s">Sponsor Agency/ Organizer:</td>
        <td colspan="2">{{ $record->organizer ?? '' }}</td>
      </tr>

      {{-- FINANCIAL ASSISTANCE --}}
      <tr style="height:0.65cm;">
        <td colspan="8" class="s">Is financial assistance requested from the University?</td>
        <td colspan="2" class="c" style="border-right:none;">
          {!! $cb((bool)($record->financial_requested ?? false)) !!} <span style="margin-left:6pt;">Yes</span>
        </td>
        <td colspan="2" class="c" style="border-left:none;">
          {!! $cb(!(bool)($record->financial_requested ?? false)) !!} <span style="margin-left:6pt;">No</span>
        </td>
      </tr>

      {{-- AMOUNT --}}
      <tr style="height:0.65cm;">
        <td colspan="8" class="s">
          If yes, how much is the <span class="u">total amount</span> being requested?
        </td>
        <td class="c" style="border-right:none;">Php</td>
        <td colspan="3" style="border-left:none;">
          @if(($record->financial_requested ?? false) && ($record->amount_requested ?? null) !== null && $record->amount_requested !== '')
            {{ number_format((float)$record->amount_requested, 2) }}
          @else
            _____________.00
          @endif
        </td>
      </tr>

      {{-- COVERAGE (3 rows) --}}
      <tr style="height:0.40cm;">
        <td colspan="2" rowspan="3" class="s vm">Coverage:</td>
        <td colspan="3" style="border-bottom:none;border-right:none;">
          {!! $cb(in_array('registration',$cov)) !!} <span style="margin-left:6pt;">Registration</span>
        </td>
        <td colspan="3" style="border-bottom:none;border-left:none;border-right:none;">
          {!! $cb(in_array('accommodation',$cov)) !!} <span style="margin-left:6pt;">Accommodation</span>
        </td>
        <td colspan="4" style="border-bottom:none;border-left:none;">
          {!! $cb(in_array('materials',$cov)) !!} <span style="margin-left:6pt;">Materials/ Kit</span>
        </td>
      </tr>
      <tr style="height:0.50cm;">
        <td colspan="3" style="border-top:none;border-bottom:none;border-right:none;">
          {!! $cb(in_array('speaker_fee',$cov)) !!} <span style="margin-left:6pt;">Speaker’s Fee</span>
        </td>
        <td colspan="3" style="border-top:none;border-bottom:none;border-left:none;border-right:none;">
          {!! $cb(in_array('meals',$cov)) !!} <span style="margin-left:6pt;">Meals/ Snacks</span>
        </td>
        <td colspan="4" style="border-top:none;border-bottom:none;border-left:none;">
          {!! $cb(in_array('transportation',$cov)) !!} <span style="margin-left:6pt;">Transportation</span>
        </td>
      </tr>
      <tr style="height:0.55cm;">
        <td colspan="10" style="border-top:none;">
          @php $cOther = $record->coverage_others ?? null; @endphp
          {!! $cb(!empty($cOther)) !!} <span style="margin-left:6pt;">Others, specify:</span>
          @if(!empty($cOther))
            <span style="margin-left:6pt;">{{ $cOther }}</span>
          @else
            <span style="margin-left:6pt;">_______________________</span>
          @endif
        </td>
      </tr>

      {{-- SIGNATORIES ROW 1 --}}
      <tr style="height:1.65cm;">
        <td colspan="6" class="vt" style="padding:3pt 8pt; line-height:1.3;">
          <div>Requested by:</div>
          <div style="height:0.60cm;"></div>
          <div class="c b">Dr. BRYAN JOHN A. MAGOLING</div>
          <div class="c">Director, Research Management Services</div>
          <div style="margin-top:2pt;">Date Signed:</div>
        </td>
        <td colspan="6" class="vt" style="padding:3pt 8pt; line-height:1.3;">
          <div>Reviewed by:</div>
          <div style="height:0.60cm;"></div>
          <div class="c b">Engr. ALBERTSON D. AMANTE</div>
          <div class="c">Vice President for Research, Development,</div>
          <div class="c">and Extension Services</div>
          <div style="margin-top:2pt;">Date Signed:</div>
        </td>
      </tr>

      {{-- SIGNATORIES ROW 2 --}}
      <tr style="height:1.55cm;">
        <td colspan="6" class="vt" style="padding:3pt 8pt; line-height:1.3;">
          <div>Recommending Approval:</div>
          <div style="height:0.55cm;"></div>
          <div class="c b">Atty. NOEL ALBERTO S. OMANDAP</div>
          <div class="c">Vice President for Administration and Finance</div>
          <div style="margin-top:2pt;">Date Signed:</div>
        </td>
        <td colspan="6" class="vt" style="padding:3pt 8pt; line-height:1.3;">
          <div>Approved by:</div>
          <div style="height:0.55cm;"></div>
          <div class="c b">Dr. TIRSO A. RONQUILLO</div>
          <div class="c">University President</div>
          <div style="margin-top:2pt;">Date Signed:</div>
        </td>
      </tr>
    </table>

    {{-- FOOTERS --}}
    <p class="foot">
      <em>Required Attachments: (1) official invitation/ call for participation, (2) signed itinerary of travel, if requesting for financial support</em>
    </p>

    <p class="foot" style="margin-top:8pt;"><em>Notes:</em></p>
    <p class="foot noteItem"><em>1.&nbsp;For faculty with designation, the counterpart VP/VC shall countersign as notice prior to the assessment by the reviewing VP/VC.</em></p>
    <p class="foot noteItem"><em>2.&nbsp;For extension campuses, there shall be an initial of the Campus Director prior to recommendation of the Vice Chancellor Concerned.</em></p>
    <p class="foot noteItem"><em>3.&nbsp;The signature of the VPAF/VCAF shall only be required if requesting for financial support.</em></p>

    <div class="footBottom">
      <div class="ccLine"><em>cc: HRMO</em></div>
      <div class="trackWrap">
        <em>Tracking Number:</em>
        <span class="trackLine">@if(!empty($record->tracking_number)){{ $record->tracking_number }}@endif</span>
      </div>
    </div>

  </div>
</div>

</body>
</html>