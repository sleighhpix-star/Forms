<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-RMS-11 &mdash; {{ $record->faculty_name ?? '' }}</title>
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
.sec-title { font-weight: bold; font-size: 9pt; background: #D9D9D9; text-align: center; padding: 2pt; }
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
@endphp

<div class="pbar">
  <span>BatStateU-FO-RMS-11 &mdash; Preview</span>
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
    <td>Reference No.: BatStateU-FO-RMS-11</td>
    <td>Effectivity Date: May 18, 2022</td>
    <td>&nbsp;Revision No.: 02</td>
  </tr>
</table>

<table>
  <colgroup>
    <col style="width:30%"><col style="width:20%"><col style="width:20%"><col style="width:30%">
  </colgroup>

  {{-- Title --}}
  <tr style="height:0.9cm">
    <td colspan="4" class="c bold" style="font-size:12pt;text-transform:uppercase;">
      REQUEST FOR RESEARCH PUBLICATION INCENTIVE
    </td>
  </tr>

  {{-- Researcher info --}}
  <tr style="height:0.65cm">
    <td class="s">Name of faculty member / employee:</td>
    <td colspan="3">{{ $record->faculty_name ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">College / Office:</td>
    <td>{{ $record->college_office ?? '' }}</td>
    <td class="s">Employment Status:</td>
    <td>{{ $record->employment_status ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Campus:</td>
    <td>{{ $record->campus ?? '' }}</td>
    <td class="s">Position / Designation:</td>
    <td>{{ $record->position ?? '' }}</td>
  </tr>

  {{-- Paper details section --}}
  <tr><td colspan="4" class="sec-title">PAPER DETAILS</td></tr>
  <tr style="height:0.65cm">
    <td class="s">Title of paper:</td>
    <td colspan="3">{{ $record->paper_title ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Co-author/s (if any):</td>
    <td colspan="3">{{ $record->co_authors ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Title of the journal:</td>
    <td colspan="3">{{ $record->journal_title ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Vol. / Issue / No.:</td>
    <td>{{ $record->vol_issue ?? '' }}</td>
    <td class="s">ISSN / ISBN:</td>
    <td>{{ $record->issn_isbn ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Publisher:</td>
    <td>{{ $record->publisher ?? '' }}</td>
    <td class="s">Editors:</td>
    <td>{{ $record->editors ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Website:</td>
    <td>{{ $record->website ?? '' }}</td>
    <td class="s">Email address:</td>
    <td>{{ $record->email_address ?? '' }}</td>
  </tr>

  {{-- Type of publication --}}
  <tr style="height:0.65cm">
    <td class="s">Type of publication:</td>
    <td style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;"><tr>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->pub_scope??'')==='Regional') !!} Regional</td>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->pub_scope??'')==='National') !!} National</td>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->pub_scope??'')==='International') !!} International</td>
      </tr></table>
    </td>
    <td class="s">Format:</td>
    <td style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;"><tr>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->pub_format??'')==='Print') !!} Print journal</td>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->pub_format??'')==='Online') !!} Online journal</td>
      </tr></table>
    </td>
  </tr>

  {{-- Nature --}}
  <tr style="height:0.65cm">
    <td class="s">Nature:</td>
    <td colspan="3" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:33%"><col style="width:17%"><col style="width:33%"><col style="width:17%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->nature??'')==='CHED accredited (multidisciplinary)') !!} CHED accredited (multidisciplinary)</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->nature??'')==='ISI indexed') !!} ISI indexed</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->nature??'')==='CHED accredited (specific discipline)') !!} CHED accredited (specific discipline)</td>
          <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->nature??'')==='SCOPUS indexed') !!} SCOPUS indexed</td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Amount requested --}}
  <tr style="height:0.70cm">
    <td colspan="2" class="s">How much is the total amount being requested for incentive?</td>
    <td class="c" style="border-right:none;">Php</td>
    <td style="border-left:none;">
      @if($record->amount_requested ?? null)
        {{ number_format((float)$record->amount_requested, 2) }}
      @else
        _____________.00
      @endif
    </td>
  </tr>

  {{-- Previous claim --}}
  <tr style="height:0.80cm">
    <td colspan="2" class="s" style="font-size:9.5pt;line-height:1.2;">Has the faculty/ employee previously claimed research publication incentive for paper published in CHED accredited journal within current year?</td>
    <td class="c" style="border-right:none;">{!! $chk($record->has_previous_claim ?? false) !!} Yes</td>
    <td style="border-left:none;">{!! $chk(!($record->has_previous_claim ?? false)) !!} No</td>
  </tr>
  <tr style="height:0.65cm">
    <td colspan="2" class="s">If Yes, how much did the university shoulder for that incentive?</td>
    <td class="c" style="border-right:none;">Php</td>
    <td style="border-left:none;">
      @if($record->previous_claim_amount ?? null)
        {{ number_format((float)$record->previous_claim_amount, 2) }}
      @else
        _____________.00
      @endif
    </td>
  </tr>

  {{-- Previous paper section --}}
  <tr><td colspan="4" class="sec-title">PREVIOUS PAPER DETAILS (if applicable)</td></tr>
  <tr style="height:0.65cm">
    <td class="s">Title of the paper:</td>
    <td colspan="3">{{ $record->prev_paper_title ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Co-authors (if any):</td>
    <td colspan="3">{{ $record->prev_co_authors ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Title of the journal:</td>
    <td colspan="3">{{ $record->prev_journal_title ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Vol. / Issue / No.:</td>
    <td>{{ $record->prev_vol_issue ?? '' }}</td>
    <td class="s">ISSN / ISBN:</td>
    <td>{{ $record->prev_issn_isbn ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">DOI (for e-journal):</td>
    <td>{{ $record->prev_doi ?? '' }}</td>
    <td class="s">Publisher:</td>
    <td>{{ $record->prev_publisher ?? '' }}</td>
  </tr>
  <tr style="height:0.65cm">
    <td class="s">Editors:</td>
    <td>{{ $record->prev_editors ?? '' }}</td>
    <td class="s">Type of publication:</td>
    <td style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;"><tr>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->prev_pub_scope??'')==='Regional') !!} Regional</td>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->prev_pub_scope??'')==='National') !!} National</td>
        <td style="border:none;padding:1pt 2pt;white-space:nowrap;">{!! $chk(($record->prev_pub_scope??'')==='International') !!} International</td>
      </tr></table>
    </td>
  </tr>

  {{-- Signatories --}}
  <tr style="height:1.60cm">
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Requested by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">NAME</div>
      <div style="text-align:center;">Director for Research Management</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">NAME</div>
      <div style="text-align:center;">Vice President for Research, Development and Extension Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>
  <tr style="height:1.50cm">
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">NAME</div>
      <div style="text-align:center;">Vice President for Administration and Finance</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="2" style="vertical-align:top;padding:3pt 8pt;line-height:1.3;">
      <div>Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;">NAME</div>
      <div style="text-align:center;">University President</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>
</table>

<p class="foot"><em>Required Attachments: (1) Certificate/Notice of Paper Acceptance; (2) Certificate of Authorship; (3) Copy of the page in the Research Manual; (4) Hard Copy of the Research Journal; (5) Proof of the Peer Review Process; (6) Copy of the Journal Title and Table of Contents bearing the Names and Affiliation of the Requester</em></p>

<div class="footBottom">
  <div class="ccLine"><em>cc: HRMO/ FTDC</em></div>
  <div class="trackLineWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">@if(!empty($record->tracking_number)){{ $record->tracking_number }}@endif</span>
  </div>
</div>

</div></div>
</body>
</html>