{{-- resources/views/forms/rms11.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-RMS-11 — {{ $record->name ?? '' }}</title>
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

.s { background: #d3d3d3; }
.smallText{ font-size: 10pt; line-height: 1.15; }
.foot{ border: none; padding: 0; margin: 0; font-size: 9pt; font-style: italic; line-height: 1.25; }
.footBottom{ margin-top: 18pt; position: relative; }
.ccLine{ font-size: 8pt; font-style: italic; }
.trackLineWrap{ font-size: 8pt; font-style: italic; text-align: right; margin-top: 60pt; }
.trackLine{ display: inline-block; width: 130px; border-bottom: 1px solid #000; margin-left: 6pt; }
.c { text-align: center; }
.vt { vertical-align: top; padding-top: 4pt; }
.vm { vertical-align: middle; }
.bold{ font-weight: bold; }

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
  .ccLine, .trackLineWrap { font-size: 8pt !important; }
  .trackLineWrap { margin-top: 60pt !important; }
  .trackLine { width: 130px !important; border-bottom: 1px solid #000 !important; }
}
</style>
</head>
<body>

@php
  // red-filled checkbox (same as your HRD-28)
  $chk = fn($v) => $v
    ? '<span style="display:inline-block;width:1em;height:1em;background:#C00000;vertical-align:middle;position:relative;top:-1pt;border:1px solid #900;-webkit-print-color-adjust:exact;print-color-adjust:exact;color-adjust:exact;"></span>'
    : '<span style="display:inline-block;width:1em;height:1em;border:1px solid #000;vertical-align:middle;position:relative;top:-1pt;"></span>';

  // Allow JSON or array storage
  $nature = $record->nature ?? [];
  if (is_string($nature)) $nature = json_decode($nature, true) ?: [];

  // Nature flags (supports either explicit boolean columns OR nature array)
  $nature_ched_multi = $record->nature_ched_multi ?? in_array('CHED accredited (multidisciplinary)', $nature) ?? in_array('ched_multi', $nature);
  $nature_ched_spec  = $record->nature_ched_specific ?? in_array('CHED accredited (specific discipline)', $nature) ?? in_array('ched_specific', $nature);
  $nature_isi        = $record->nature_isi_indexed ?? in_array('ISI indexed', $nature) ?? in_array('isi', $nature);
  $nature_scopus     = $record->nature_scopus_indexed ?? in_array('SCOPUS indexed', $nature) ?? in_array('scopus', $nature);

  // publication choices
  $pub_scope  = $record->pub_scope ?? null;   // 'Regional'|'National'|'International' or lowercase
  $pub_medium = $record->pub_medium ?? null;  // 'Print journal'|'Online journal' or print/online

  $prev_pub_scope  = $record->prev_pub_scope ?? null;
  $prev_pub_medium = $record->prev_pub_medium ?? null;

  $norm = fn($v) => is_string($v) ? strtolower(trim($v)) : $v;

  $claimed = $record->previously_claimed ?? null;
  $claimed_yes = in_array($norm($claimed), [true, 1, '1', 'yes', 'y', 'true'], true);

  $fmtMoney = function($v){
    if ($v === null || $v === '') return null;
    if (is_numeric($v)) return number_format((float)$v, 2);
    return $v; // allow preformatted strings
  };

  $sScope = fn($want) => in_array($norm($pub_scope), [$norm($want)], true);
  $sMedium = fn($want) => in_array($norm($pub_medium), [$norm($want)], true);

  $pScope = fn($want) => in_array($norm($prev_pub_scope), [$norm($want)], true);
  $pMedium = fn($want) => in_array($norm($prev_pub_medium), [$norm($want)], true);
@endphp

<div class="pbar">
  <span>BatStateU-FO-RMS-11 — Preview</span>
  <button onclick="window.print()">&#128424; Print / Save PDF</button>
</div>

<div class="wrap"><div class="sheet">

{{-- ═══ HEADER (exact strings) ═══ --}}
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
    <td>Reference No.: BatStateU-FO-RMS-11</td>
    <td>Effectivity Date: May 18, 2022</td>
    <td>&nbsp;Revision No.: 02</td>
  </tr>
</table>

{{-- ═══ MAIN GRID (replica order + labels) ═══ --}}
<table>
  {{-- 4 columns so Employment status + Position/designation are at the right --}}
  <colgroup>
    <col style="width:30%">
    <col style="width:20%">
    <col style="width:30%">
    <col style="width:20%">
  </colgroup>

  {{-- Title --}}
  <tr style="height:0.90cm">
    <td colspan="4" class="c bold" style="font-size:12pt;text-transform:uppercase;">
      REQUEST FOR RESEARCH PUBLICATION INCENTIVE
    </td>
  </tr>

  {{-- Name --}}
  <tr style="height:0.70cm">
    <td class="s">Name of faculty member / employee</td>
    <td colspan="3">{{ $record->name ?? '' }}</td>
  </tr>

  {{-- College / office  | Employment status (RIGHT) --}}
  <tr style="height:0.70cm">
    <td class="s">College / office</td>
    <td>{{ $record->college_office ?? '' }}</td>
    <td class="s">Employment status</td>
    <td>{{ $record->employment_status ?? '' }}</td>
  </tr>

  {{-- Campus | Position/designation (RIGHT) --}}
  <tr style="height:0.70cm">
    <td class="s">Campus</td>
    <td>{{ $record->campus ?? '' }}</td>
    <td class="s">Position/designation</td>
    <td>{{ $record->position_designation ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Title of paper</td>
    <td colspan="3">{{ $record->paper_title ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Co-author/s (if any)</td>
    <td colspan="3">{{ $record->co_authors ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Title of the journal</td>
    <td colspan="3">{{ $record->journal_title ?? '' }}</td>
  </tr>

  {{-- Vol/issue/no + ISSN/ISBN (same row) --}}
  <tr style="height:0.70cm">
    <td class="s">Vol./issue/ no.</td>
    <td>{{ $record->vol_issue_no ?? '' }}</td>
    <td class="s">ISSN/ISBN</td>
    <td>{{ $record->issn_isbn ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Publisher</td>
    <td colspan="3">{{ $record->publisher ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Editors</td>
    <td colspan="3">{{ $record->editors ?? '' }}</td>
  </tr>

  {{-- Type of publication (two "Check one" blocks) --}}
  <tr style="height:1.60cm">
    <td class="s vt">Type of publication<br><span style="font-weight:normal;">Check one</span></td>
    <td colspan="3" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup>
          <col style="width:33.33%"><col style="width:33.33%"><col style="width:33.33%">
        </colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($sScope('regional') || $sScope('Regional')) !!} Regional</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($sScope('national') || $sScope('National')) !!} National</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($sScope('international') || $sScope('International')) !!} International</td>
        </tr>
      </table>

      <div style="height:6pt;"></div>

      <div class="bold">Check one</div>
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:50%"><col style="width:50%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($sMedium('print') || $sMedium('Print journal') || $sMedium('Print')) !!} Print journal</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($sMedium('online') || $sMedium('Online journal') || $sMedium('Online')) !!} Online journal</td>
        </tr>
      </table>
    </td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Website</td>
    <td colspan="3">{{ $record->website ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Email address</td>
    <td colspan="3">{{ $record->email ?? '' }}</td>
  </tr>

  {{-- Nature (2x2) --}}
  <tr style="height:1.10cm">
    <td class="s vt">Nature</td>
    <td colspan="3" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:60%"><col style="width:40%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($nature_ched_multi) !!} CHED accredited (multidisciplinary)</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($nature_isi) !!} ISI indexed</td>
        </tr>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($nature_ched_spec) !!} CHED accredited (specific discipline)</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($nature_scopus) !!} SCOPUS indexed</td>
        </tr>
      </table>
    </td>
  </tr>

  {{-- Amount requested --}}
  <tr style="height:0.70cm">
    <td class="s">How much is the total amount being requested for incentive?</td>
    <td class="c">Php</td>
    <td colspan="2">{{ $fmtMoney($record->amount_requested ?? null) ?? '' }}</td>
  </tr>

  {{-- Previously claimed (Yes/No) --}}
  <tr style="height:0.80cm">
    <td class="s smallText" colspan="2">
      Has the faculty/ employee previously claimed research publication incentive for paper published in CHED accredited journal within current year?
    </td>
    <td class="c">{!! $chk($claimed_yes) !!} Yes</td>
    <td class="c">{!! $chk(!$claimed_yes) !!} No</td>
  </tr>

  {{-- University shoulder amount --}}
  <tr style="height:0.70cm">
    <td class="s">If Yes, how much did the university shoulder for that incentive?</td>
    <td class="c">Php</td>
    <td colspan="2">{{ $fmtMoney($record->amount_university_shoulder ?? null) ?? '' }}</td>
  </tr>

  {{-- If yes fill up details --}}
  <tr style="height:0.60cm">
    <td colspan="4" class="s bold">If yes, fill up the details below.</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Title of the paper</td>
    <td colspan="3">{{ $record->prev_paper_title ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Co-authors (if any)</td>
    <td colspan="3">{{ $record->prev_co_authors ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Title of the journal</td>
    <td colspan="3">{{ $record->prev_journal_title ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Vol./issue/no.</td>
    <td>{{ $record->prev_vol_issue_no ?? '' }}</td>
    <td class="s">ISSN/ISBN</td>
    <td>{{ $record->prev_issn_isbn ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">DOI (for e-journal)</td>
    <td colspan="3">{{ $record->prev_doi ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Publisher</td>
    <td colspan="3">{{ $record->prev_publisher ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Editors</td>
    <td colspan="3">{{ $record->prev_editors ?? '' }}</td>
  </tr>

  {{-- Previous type of publication --}}
  <tr style="height:1.60cm">
    <td class="s vt">Type of publication<br><span style="font-weight:normal;">Check one</span></td>
    <td colspan="3" class="vt" style="padding:2pt 4pt;font-size:9pt;">
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup>
          <col style="width:33.33%"><col style="width:33.33%"><col style="width:33.33%">
        </colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($pScope('regional') || $pScope('Regional')) !!} Regional</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($pScope('national') || $pScope('National')) !!} National</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($pScope('international') || $pScope('International')) !!} International</td>
        </tr>
      </table>

      <div style="height:6pt;"></div>

      <div class="bold">Check one</div>
      <table style="width:100%;border-collapse:collapse;table-layout:fixed;">
        <colgroup><col style="width:50%"><col style="width:50%"></colgroup>
        <tr>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($pMedium('print') || $pMedium('Print journal') || $pMedium('Print')) !!} Print journal</td>
          <td style="border:none;padding:1pt 2pt;">{!! $chk($pMedium('online') || $pMedium('Online journal') || $pMedium('Online')) !!} Online journal</td>
        </tr>
      </table>
    </td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Website</td>
    <td colspan="3">{{ $record->prev_website ?? '' }}</td>
  </tr>

  <tr style="height:0.70cm">
    <td class="s">Email address</td>
    <td colspan="3">{{ $record->prev_email ?? '' }}</td>
  </tr>

  {{-- SIGNATORIES (exact labels/sequence) --}}
  <tr style="height:1.70cm">
    <td colspan="2" class="vt" style="padding:3pt 8pt;line-height:1.3;">
      <div>Requested by:</div>
      <div style="height:0.55cm;"></div>
      <div class="c bold">{{ $record->requested_by_name ?? 'NAME' }}</div>
      <div class="c">Director for Research Management</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="2" class="vt" style="padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div class="c bold">{{ $record->rec1_name ?? 'NAME' }}</div>
      <div class="c">Vice President for Research, Development<br>and Extension Services</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>

  <tr style="height:1.55cm">
    <td colspan="2" class="vt" style="padding:3pt 8pt;line-height:1.3;">
      <div>Recommending Approval:</div>
      <div style="height:0.50cm;"></div>
      <div class="c bold">{{ $record->rec2_name ?? 'NAME' }}</div>
      <div class="c">Vice President for Administration and Finance</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
    <td colspan="2" class="vt" style="padding:3pt 8pt;line-height:1.3;">
      <div>Approved by:</div>
      <div style="height:0.50cm;"></div>
      <div class="c bold">{{ $record->approved_by_name ?? 'NAME' }}</div>
      <div class="c">University President</div>
      <div style="margin-top:2pt;">Date Signed:</div>
    </td>
  </tr>
</table>

{{-- Footer (exact text) --}}
<p class="foot" style="margin-top:10pt;">
  <em>
    Required Attachments: (1) Certificate/Notice of Paper Acceptance; (2) Certificate of Authorship,
    (3) Copy of the page in the Research Manual; (4) Hard Copy of the Research Journal;
    (5) Proof of the Peer Review Process; (6) Copy of the Journal Title and Table of Contents bearing the Names and Affiliation of the Requester
  </em>
</p>

<div class="footBottom">
  <div class="ccLine"><em>cc: HRMO/ FTDC</em></div>
  <div class="trackLineWrap">
    <em>Tracking Number:</em>
    <span class="trackLine">
      @if(!empty($record->tracking_no))
        {{ $record->tracking_no }}
      @endif
    </span>
  </div>
</div>

</div></div>
</body>
</html>