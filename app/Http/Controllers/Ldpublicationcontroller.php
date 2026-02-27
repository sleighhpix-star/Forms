<?php

namespace App\Http\Controllers;

use App\Models\LdPublication;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LdPublicationController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validateForm($request);
        LdPublication::create($validated);
        return redirect()->route('ld.index', ['tab' => 'publication'])
            ->with('success', 'Publication incentive request submitted successfully.');
    }

    public function update(Request $request, LdPublication $publication)
    {
        $validated = $this->validateForm($request);
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
            'records' => LdPublication::orderByDesc('created_at')->get()
        ]);
    }

    // ── MOV ──────────────────────────────────────────────────────────────────

    public function uploadMov(Request $request, LdPublication $publication)
    {
        $request->validate([
            'mov_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        if ($publication->mov_path && Storage::disk('public')->exists($publication->mov_path)) {
            Storage::disk('public')->delete($publication->mov_path);
        }

        $file = $request->file('mov_file');
        $publication->forceFill([
            'mov_path'          => $file->store('ld/publication/mov', 'public'),
            'mov_original_name' => $file->getClientOriginalName(),
            'mov_size'          => $file->getSize(),
            'mov_mime'          => $file->getMimeType(),
        ])->save();

        return redirect()->route('ld.index', ['tab' => 'publication'])
            ->with('success', '✅ MOV uploaded.');
    }

    public function viewMov(LdPublication $publication)
    {
        abort_unless($publication->mov_path && Storage::disk('public')->exists($publication->mov_path), 404);
        return Storage::disk('public')->response(
            $publication->mov_path,
            $publication->mov_original_name ?? basename($publication->mov_path)
        );
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'faculty_name'               => 'required|string|max:255',
            'campus'                     => 'required|string|max:255',
            'employment_status'          => 'required|string|max:100',
            'college_office'             => 'required|string|max:255',
            'position'                   => 'required|string|max:255',
            'paper_title'                => 'required|string|max:500',
            'co_authors'                 => 'nullable|string|max:500',
            'journal_title'              => 'required|string|max:500',
            'vol_issue'                  => 'nullable|string|max:100',
            'issn_isbn'                  => 'nullable|string|max:100',
            'publisher'                  => 'nullable|string|max:255',
            'editors'                    => 'nullable|string|max:500',
            'website'                    => 'nullable|url|max:500',
            'email_address'              => 'nullable|email|max:255',
            'pub_scope'                  => 'required|string',
            'pub_format'                 => 'nullable|string',
            'nature'                     => 'required|string',
            'amount_requested'           => 'required|numeric|min:0',
            'has_previous_claim'         => 'required|boolean',
            'previous_claim_amount'      => 'nullable|numeric|min:0',
            'prev_paper_title'           => 'nullable|string|max:500',
            'prev_co_authors'            => 'nullable|string|max:500',
            'prev_journal_title'         => 'nullable|string|max:500',
            'prev_vol_issue'             => 'nullable|string|max:100',
            'prev_issn_isbn'             => 'nullable|string|max:100',
            'prev_doi'                   => 'nullable|string|max:255',
            'prev_publisher'             => 'nullable|string|max:255',
            'prev_editors'               => 'nullable|string|max:500',
            'prev_pub_scope'             => 'nullable|string',
            'sig_requested_name'         => 'nullable|string|max:255',
            'sig_requested_position'     => 'nullable|string|max:255',
            'sig_reviewed_name'          => 'nullable|string|max:255',
            'sig_reviewed_position'      => 'nullable|string|max:255',
            'sig_recommending_name'      => 'nullable|string|max:255',
            'sig_recommending_position'  => 'nullable|string|max:255',
            'sig_approved_name'          => 'nullable|string|max:255',
            'sig_approved_position'      => 'nullable|string|max:255',
        ]);
    }
}