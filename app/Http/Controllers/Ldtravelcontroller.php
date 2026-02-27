<?php

namespace App\Http\Controllers;

use App\Models\LdTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LdTravelController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validateForm($request);
        LdTravel::create($validated);
        return redirect()->route('ld.index', ['tab' => 'travel'])
            ->with('success', 'Authority to travel submitted successfully.');
    }

    public function update(Request $request, LdTravel $travel)
    {
        $validated = $this->validateForm($request);
        $travel->update($validated);
        return redirect()->route('ld.index', ['tab' => 'travel'])
            ->with('success', 'Authority to travel updated successfully.');
    }

    public function destroy(LdTravel $travel)
    {
        $travel->delete();
        return redirect()->route('ld.index', ['tab' => 'travel'])
            ->with('success', 'Record deleted.');
    }

    public function showModal(LdTravel $travel)
    {
        return view('ld.travel.show-modal', ['record' => $travel]);
    }

    public function editModal(LdTravel $travel)
    {
        return view('ld.travel.form', ['record' => $travel]);
    }

    public function formCreate()
    {
        return view('ld.travel.form', ['record' => null]);
    }

    public function print(LdTravel $travel)
    {
        return view('ld.travel.print', ['record' => $travel]);
    }

    public function recordsJson()
    {
        return response()->json([
            'records' => LdTravel::orderByDesc('created_at')->get()
        ]);
    }

    // ── MOV ──────────────────────────────────────────────────────────────────

    public function uploadMov(Request $request, LdTravel $travel)
    {
        $request->validate([
            'mov_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        if ($travel->mov_path && Storage::disk('public')->exists($travel->mov_path)) {
            Storage::disk('public')->delete($travel->mov_path);
        }

        $file = $request->file('mov_file');
        $travel->forceFill([
            'mov_path'          => $file->store('ld/travel/mov', 'public'),
            'mov_original_name' => $file->getClientOriginalName(),
            'mov_size'          => $file->getSize(),
            'mov_mime'          => $file->getMimeType(),
        ])->save();

        return redirect()->route('ld.index', ['tab' => 'travel'])
            ->with('success', '✅ MOV uploaded.');
    }

    public function viewMov(LdTravel $travel)
    {
        abort_unless($travel->mov_path && Storage::disk('public')->exists($travel->mov_path), 404);
        return Storage::disk('public')->response(
            $travel->mov_path,
            $travel->mov_original_name ?? basename($travel->mov_path)
        );
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'employee_names'             => 'required|string',
            'positions'                  => 'nullable|string',
            'travel_dates'               => 'required|string|max:100',
            'travel_time'                => 'nullable|string|max:100',
            'places_visited'             => 'required|string|max:500',
            'purpose'                    => 'required|string',
            'chargeable_against'         => 'nullable|string|max:255',
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