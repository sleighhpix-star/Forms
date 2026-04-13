<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesMovUpload;
use App\Models\LdPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LdPublicationController extends Controller
{
    use HandlesMovUpload;

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number'])) {
            $validated['tracking_number'] = 'LP-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        LdPublication::create($validated);

        return redirect()->route('ld.index', ['tab' => 'publication'])
            ->with('success', 'Publication incentive request submitted successfully.');
    }

    public function update(Request $request, LdPublication $publication)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number']) && empty($publication->tracking_number)) {
            $validated['tracking_number'] = 'LP-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        $publication->update($validated);

        return redirect()->route('ld.index', ['tab' => 'publication'])
            ->with('success', 'Publication incentive request updated successfully.');
    }

    public function destroy(LdPublication $publication)
    {
        $publication->delete();

        return redirect()->route('ld.index', ['tab' => 'publication'])
            ->with('success', 'Record deleted.');
    }

    public function showModal(LdPublication $publication)
    {
        return view('ld.publication.show-modal', ['record' => $publication]);
    }

    public function editModal(LdPublication $publication)
    {
        return view('ld.publication.form', ['record' => $publication]);
    }

    public function formCreate()
    {
        return view('ld.publication.form', ['record' => null]);
    }

    public function print(LdPublication $publication)
    {
        return view('ld.publication.print', ['record' => $publication]);
    }

    public function recordsJson()
    {
        return response()->json([
            'records' => LdPublication::orderByDesc('created_at')->get(),
        ]);
    }

    public function uploadMov(Request $request, LdPublication $publication)
    {
        return $this->handleMovUpload($request, $publication, 'publication', 'publication');
    }

    public function viewMov(LdPublication $publication)
    {
        return $this->handleMovView($publication);
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'tracking_number'           => 'nullable|string|max:100',
            'faculty_name'              => 'required|string|max:255',
            'campus'                    => 'required|string|max:255',
            'employment_status'         => 'required|string|max:100',
            'college_office'            => 'required|string|max:255',
            'position'                  => 'required|string|max:255',
            'paper_title'               => 'required|string|max:500',
            'co_authors'                => 'nullable|string|max:500',
            'journal_title'             => 'required|string|max:500',
            'vol_issue'                 => 'nullable|string|max:100',
            'issn_isbn'                 => 'nullable|string|max:100',
            'publisher'                 => 'nullable|string|max:255',
            'editors'                   => 'nullable|string|max:500',
            'website'                   => 'nullable|url|max:500',   // fixed: was plain string
            'email_address'             => 'nullable|email|max:255',
            'pub_scope'                 => 'required|string',
            'pub_format'                => 'nullable|string',
            'nature'                    => 'required|string',
            'amount_requested'          => 'required|numeric|min:0',
            'has_previous_claim'        => 'required|boolean',
            'previous_claim_amount'     => 'nullable|numeric|min:0',
            'prev_paper_title'          => 'nullable|string|max:500',
            'prev_co_authors'           => 'nullable|string|max:500',
            'prev_journal_title'        => 'nullable|string|max:500',
            'prev_vol_issue'            => 'nullable|string|max:100',
            'prev_issn_isbn'            => 'nullable|string|max:100',
            'prev_doi'                  => 'nullable|string|max:255',
            'prev_publisher'            => 'nullable|string|max:255',
            'prev_editors'              => 'nullable|string|max:500',
            'prev_pub_scope'            => 'nullable|string',
            'prev_pub_format'           => 'nullable|string',
            'prev_website'              => 'nullable|url|max:500',   // fixed: was plain string
            'prev_email_address'        => 'nullable|email|max:255',
            'sig_requested_name'        => 'nullable|string|max:255',
            'sig_requested_position'    => 'nullable|string|max:255',
            'sig_reviewed_name'         => 'nullable|string|max:255',
            'sig_reviewed_position'     => 'nullable|string|max:255',
            'sig_recommending_name'     => 'nullable|string|max:255',
            'sig_recommending_position' => 'nullable|string|max:255',
            'sig_approved_name'         => 'nullable|string|max:255',
            'sig_approved_position'     => 'nullable|string|max:255',
        ]);
    }
}
