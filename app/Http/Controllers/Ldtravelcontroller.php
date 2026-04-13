<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesMovUpload;
use App\Models\LdTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LdTravelController extends Controller
{
    use HandlesMovUpload;

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number'])) {
            $validated['tracking_number'] = 'LTv-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        LdTravel::create($validated);

        return redirect()->route('ld.index', ['tab' => 'travel'])
            ->with('success', 'Authority to travel submitted successfully.');
    }

    public function update(Request $request, LdTravel $travel)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number']) && empty($travel->tracking_number)) {
            $validated['tracking_number'] = 'LTv-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

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
            'records' => LdTravel::orderByDesc('created_at')->get(),
        ]);
    }

    public function uploadMov(Request $request, LdTravel $travel)
    {
        return $this->handleMovUpload($request, $travel, 'travel', 'travel');
    }

    public function viewMov(LdTravel $travel)
    {
        return $this->handleMovView($travel);
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'tracking_number'           => 'nullable|string|max:100',
            'employee_names'            => 'required|string',
            'positions'                 => 'nullable|string',
            'travel_dates'              => 'required|string|max:100',
            'travel_time'               => 'nullable|string|max:100',
            'places_visited'            => 'required|string|max:500',
            'purpose'                   => 'required|string',
            'chargeable_against'        => 'nullable|string|max:255',
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
