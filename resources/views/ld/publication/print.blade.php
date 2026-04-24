{{-- resources/views/ld/publication/print.blade.php --}}
<!DOCTYPE html>
<html lang="en">
<head>
<meta charset="UTF-8">
<title>BatStateU-FO-RMS-11 &mdash; {{ $record->faculty_name ?? '' }}</title>
<style>
*, *::before, *::after { box-sizing: border-box; margin: 0; padding: 0; }
body { font-family: "Times New Roman", Times, serif; font-size: 11pt; color: #000; background: #fff; }

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
td {
  border: 1px solid #000;
  padding: 4px 6px;
  vertical-align: middle;
  word-break: break-word;
  font-size: 11pt;
  font-family: "Times New Roman", Times, serif;
}
.center { text-align: center; }
.bold   { font-weight: bold; }

* { -webkit-print-color-adjust: exact; print-color-adjust: exact; color-adjust: exact; }

@media print {
  .pbar { display: none !important; }
  @page { size: 8.5in 13in; margin: 0.5in 0.5in 0.5in 0.5in; }
  html, body { margin: 0; padding: 0; }
  .wrap { padding: 0 !important; display: block !important; }
  .sheet { width: 100% !important; padding: 0 !important; box-shadow: none !important; }
  td { font-size: 11pt; }
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
  $chk = fn($v) => $v
 ? '<span style="display:inline-block;width:15pt;height:15pt;background:#C00000;border:1px solid #900;vertical-align:middle;flex-shrink:0;-webkit-print-color-adjust:exact;print-color-adjust:exact;"></span>'
 : '<span style="display:inline-block;width:15pt;height:15pt;border:1px solid #000;vertical-align:middle;flex-shrink:0;"></span>';
  $norm = fn($v) => is_string($v) ? strtolower(trim($v)) : $v;

  $sScope  = fn($v) => $norm($record->pub_scope  ?? null) == $norm($v);
  $sMedium = fn($v) => $norm($record->pub_medium ?? null) == $norm($v);
  $pScope  = fn($v) => $norm($record->prev_pub_scope  ?? null) == $norm($v);
  $pMedium = fn($v) => $norm($record->prev_pub_medium ?? null) == $norm($v);

  $nature = $record->nature ?? '';
  $nature_ched_multi   = $record->nature_ched_multi     ?? str_contains(strtolower($nature), 'multidisciplinary');
  $nature_ched_specific = $record->nature_ched_specific ?? str_contains(strtolower($nature), 'specific discipline');
  $nature_isi_indexed  = $record->nature_isi_indexed    ?? str_contains(strtolower($nature), 'isi');
  $nature_scopus_indexed = $record->nature_scopus_indexed ?? str_contains(strtolower($nature), 'scopus');
@endphp

<div class="pbar">
  <span>BatStateU-FO-RMS-11 &mdash; Preview</span>
  <button onclick="window.print()">&#128424;&nbsp; Print / Save PDF</button>
</div>

<div class="wrap"><div class="sheet">

<table>
  <colgroup>
    <col style="width:11%"><col style="width:11%"><col style="width:9%">
    <col style="width:9%"><col style="width:9%"><col style="width:9%">
    <col style="width:9%"><col style="width:9%"><col style="width:9%">
    <col style="width:15%">
  </colgroup>

  {{-- Header --}}
  <tr>
    <td class="center" style="padding:2pt;">
      @php $logo = public_path('images/batstateu-logo.png'); @endphp
      @if(file_exists($logo))
        <img src="{{ asset('images/batstateu-logo.png') }}" style="width:1.2cm;height:1.2cm;object-fit:contain;display:block;margin:0 auto;">
      @else
        <div style="width:1.2cm;height:1.2cm;border:1px dashed #aaa;margin:0 auto"></div>
      @endif
    </td>
    <td colspan="4" style="font-size:9.5pt;">Reference No.: BatStateU-FO-RMS-11</td>
    <td colspan="3" style="font-size:9.5pt;">Effectivity Date: May 18, 2022</td>
    <td colspan="2" style="font-size:9.5pt;">Revision No.: 02</td>
  </tr>

  {{-- Title --}}
  <tr>
    <td colspan="10" class="center bold" style="font-size:12pt;padding:6pt 4pt;">
      REQUEST FOR RESEARCH PUBLICATION INCENTIVE
    </td>
  </tr>

  <tr>
    <td colspan="4">Name of faculty member / employee</td>
    <td colspan="6">{{ $record->faculty_name ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">College / office</td>
    <td colspan="3">{{ $record->college_office ?? '' }}</td>
    <td colspan="3">Employment status</td>
    <td colspan="2">{{ $record->employment_status ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Campus</td>
    <td colspan="3">{{ $record->campus ?? '' }}</td>
    <td colspan="3">Position/designation</td>
    <td colspan="2">{{ $record->position ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Title of paper</td>
    <td colspan="8">{{ $record->paper_title ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Co-author/s (if any)</td>
    <td colspan="8">{{ $record->co_authors ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Title of the journal</td>
    <td colspan="8">{{ $record->journal_title ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Vol./issue/ no.</td>
    <td colspan="3">{{ $record->vol_issue ?? '' }}</td>
    <td colspan="2">ISSN/ISBN</td>
    <td colspan="3">{{ $record->issn_isbn ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Publisher</td>
    <td colspan="8">{{ $record->publisher ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Editors</td>
    <td colspan="8">{{ $record->editors ?? '' }}</td>
  </tr>

  {{-- Type of publication --}}
  <tr>
    <td colspan="2" rowspan="2" style="vertical-align:middle;">Type of publication</td>
    <td colspan="2" style="border:none;vertical-align:middle;">Check one</td>
    <td colspan="2" style="border:none;vertical-align:middle;">{!! $chk($sScope('Regional')) !!} Regional</td>
    <td colspan="2" style="border:none;vertical-align:middle;">{!! $chk($sScope('National')) !!} National</td>
    <td colspan="2" style="border:none;border-right:1px solid #000;vertical-align:middle;">{!! $chk($sScope('International')) !!} International</td>
  </tr>
  <tr>
    <td colspan="2" style="border:none;vertical-align:middle;">Check one</td>
    <td colspan="2" style="border:none;vertical-align:middle;">{!! $chk($sMedium('Print') || $sMedium('Print journal')) !!} Print journal</td>
    <td colspan="4" style="border:none;border-right:1px solid #000;vertical-align:middle;">{!! $chk($sMedium('Online') || $sMedium('Online journal')) !!} Online journal</td>
  </tr>

  <tr>
    <td colspan="2">Website</td>
    <td colspan="3">{{ $record->website ?? '' }}</td>
    <td colspan="2">Email address</td>
    <td colspan="3">{{ $record->email_address ?? '' }}</td>
  </tr>

  {{-- Nature --}}
  <tr>
    <td colspan="2" rowspan="2" style="vertical-align:middle;">Nature</td>
    <td colspan="5" style="border:none;vertical-align:middle;">{!! $chk($nature_ched_multi) !!} CHED accredited (multidisciplinary)</td>
    <td colspan="3" style="border:none;border-right:1px solid #000;vertical-align:middle;">{!! $chk($nature_isi_indexed) !!} ISI indexed</td>
  </tr>
  <tr>
    <td colspan="5" style="border:none;vertical-align:middle;">{!! $chk($nature_ched_specific) !!} CHED accredited (specific discipline)</td>
    <td colspan="3" style="border:none;border-right:1px solid #000;vertical-align:middle;">{!! $chk($nature_scopus_indexed) !!} SCOPUS indexed</td>
  </tr>

  <tr>
    <td colspan="7">How much is the total amount being requested for incentive?</td>
    <td colspan="3" style="vertical-align:middle;">Php &nbsp; {{ $record->amount_requested ? number_format((float)$record->amount_requested, 2) : '' }}</td>
  </tr>

  <tr>
    <td colspan="7">Has the faculty/ employee previously claimed research publication incentive for paper published in CHED accredited journal within current year?</td>
    <td colspan="3" class="center">
      {!! $chk($record->has_previous_claim ?? false) !!} Yes
      &nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;&nbsp;
      {!! $chk(!($record->has_previous_claim ?? false)) !!} No
    </td>
  </tr>

  <tr>
    <td colspan="7">If Yes, how much did the university shoulder for that incentive?</td>
    <td colspan="3" style="vertical-align:middle;">Php &nbsp; {{ $record->previous_claim_amount ? number_format((float)$record->previous_claim_amount, 2) : '' }}</td>
  </tr>

  <tr>
    <td colspan="10">If yes, fill up the details below.</td>
  </tr>

  <tr>
    <td colspan="2">Title of the paper</td>
    <td colspan="8">{{ $record->prev_paper_title ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Co-authors (if any)</td>
    <td colspan="8">{{ $record->prev_co_authors ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Title of the journal</td>
    <td colspan="8">{{ $record->prev_journal_title ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Vol./issue/no.</td>
    <td colspan="3">{{ $record->prev_vol_issue ?? '' }}</td>
    <td colspan="2">ISSN/ISBN</td>
    <td colspan="3">{{ $record->prev_issn_isbn ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">DOI (for e-journal)</td>
    <td colspan="8">{{ $record->prev_doi ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Publisher</td>
    <td colspan="8">{{ $record->prev_publisher ?? '' }}</td>
  </tr>

  <tr>
    <td colspan="2">Editors</td>
    <td colspan="8">{{ $record->prev_editors ?? '' }}</td>
  </tr>

  {{-- Prev Type of publication --}}
  <tr>
    <td colspan="2" rowspan="2" style="vertical-align:middle;">Type of publication</td>
    <td colspan="2" style="border:none;vertical-align:middle;">Check one</td>
    <td colspan="2" style="border:none;vertical-align:middle;">{!! $chk($pScope('Regional')) !!} Regional</td>
    <td colspan="2" style="border:none;vertical-align:middle;">{!! $chk($pScope('National')) !!} National</td>
    <td colspan="2" style="border:none;border-right:1px solid #000;vertical-align:middle;">{!! $chk($pScope('International')) !!} International</td>
  </tr>
  <tr>
    <td colspan="2" style="border:none;vertical-align:middle;">Check one</td>
    <td colspan="2" style="border:none;vertical-align:middle;">{!! $chk($pMedium('Print') || $pMedium('Print journal')) !!} Print journal</td>
    <td colspan="4" style="border:none;border-right:1px solid #000;vertical-align:middle;">{!! $chk($pMedium('Online') || $pMedium('Online journal')) !!} Online journal</td>
  </tr>

  <tr>
    <td colspan="2">Website</td>
    <td colspan="3">{{ $record->prev_website ?? '' }}</td>
    <td colspan="2">Email address</td>
    <td colspan="3">{{ $record->prev_email ?? '' }}</td>
  </tr>

  {{-- Signatories --}}
  <tr style="height:1.75cm">
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Requested by:</div>
      <div style="height:0.62cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;margin-top:15pt;">{{ $fmtName($record->sig_requested_name ?? 'DR. BRYAN JOHN A. MAGOLING') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $record->sig_requested_position ?? 'Director, Research Management Services' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Reviewed by:</div>
      <div style="height:0.62cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ $fmtName($record->sig_reviewed_name ?? 'ENGR. ALBERTSON D. AMANTE') }}</div>
      <div style="text-align:center;font-size:10pt;">Vice President for Research, Development,</div>
      <div style="text-align:center;font-size:10pt;">and Extension Services</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
  </tr>
  <tr style="height:1.65cm">
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Recommending Approval:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ $fmtName($record->sig_recommending_name ?? 'ATTY. NOEL ALBERTO S. OMANDAP') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $record->sig_recommending_position ?? 'Vice President for Administration and Finance' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
    <td colspan="5" style="vertical-align:top;padding:4pt 10pt;line-height:1.35;">
      <div style="font-size:10pt;">Approved by:</div>
      <div style="height:0.55cm;"></div>
      <div style="text-align:center;font-weight:bold;font-size:10pt;">{{ $fmtName($record->sig_approved_name ?? 'DR. TIRSO A. RONQUILLO') }}</div>
      <div style="text-align:center;font-size:10pt;">{{ $record->sig_approved_position ?? 'University President' }}</div>
      <div style="font-size:10pt;margin-top:3pt;">Date Signed:</div>
    </td>
  </tr>

</table>

<p style="margin-top:0pt;font-size:8pt;font-style:italic;line-height:1.35;">
  Required Attachments: (1) Certificate/Notice of Paper Acceptance; (2) Certificate of Authorship,
  (3) Copy of the page in the Research Manual;<br>
  (4) Hard Copy of the Research Journal;
  (5) Proof of the Peer Review Process; (6) Copy of the Journal Title and Table of Contents bearing
  the <br>Names and Affiliation of the Requester
</p>
<div style="margin-top:8pt;font-size:8pt;font-style:italic;">cc: HRMO/ FTDC</div>
<div style="text-align:right;margin-top:2pt;font-size:8pt;font-style:italic;">
  Tracking Number:
  <span style="display:inline-block;width:130px;border-bottom:1px solid #000;margin-left:5pt;height:10pt;vertical-align:bottom;">{{ $record->tracking_number ?? '' }}</span>
</div>

</div></div>
</body>
</html>