<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesMovUpload;
use App\Models\LdAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LdAttendanceController extends Controller
{
    use HandlesMovUpload;

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number'])) {
            $validated['tracking_number'] = 'LA-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        LdAttendance::create($validated);

        return redirect()->route('ld.index', ['tab' => 'attendance'])
            ->with('success', 'Attendance request submitted successfully.');
    }

    public function update(Request $request, LdAttendance $attendance)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number']) && empty($attendance->tracking_number)) {
            $validated['tracking_number'] = 'LA-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        $attendance->update($validated);

        return redirect()->route('ld.index', ['tab' => 'attendance'])
            ->with('success', 'Attendance request updated successfully.');
    }

    public function destroy(LdAttendance $attendance)
    {
        $attendance->delete();

        return redirect()->route('ld.index', ['tab' => 'attendance'])
            ->with('success', 'Record deleted.');
    }

    public function showModal(LdAttendance $attendance)
    {
        return view('ld.attendance.show-modal', ['record' => $attendance]);
    }

    public function editModal(LdAttendance $attendance)
    {
        return view('ld.attendance.form', ['record' => $attendance]);
    }

    public function formCreate()
    {
        return view('ld.attendance.form', ['record' => null]);
    }

    public function print(LdAttendance $attendance)
    {
        return view('ld.attendance.print', ['record' => $attendance]);
    }

    public function recordsJson()
    {
        return response()->json([
            'records' => LdAttendance::orderByDesc('created_at')->get(),
        ]);
    }

    public function uploadMov(Request $request, LdAttendance $attendance)
    {
        return $this->handleMovUpload($request, $attendance, 'attendance', 'attendance');
    }

    public function viewMov(LdAttendance $attendance)
    {
        return $this->handleMovView($attendance);
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'tracking_number'           => 'nullable|string|max:100',
            'attendee_name'             => 'required|string|max:255',
            'campus'                    => 'required|string|max:255',
            'employment_status'         => 'required|string|max:100',
            'college_office'            => 'required|string|max:255',
            'position'                  => 'required|string|max:255',
            'activity_types'            => 'required|array|min:1',
            'activity_types.*'          => 'string',
            'activity_type_others'      => 'required_if:activity_types.*,Others|nullable|string|max:255',
            'natures'                   => 'required|array|min:1',
            'natures.*'                 => 'string',
            'nature_others'             => 'required_if:natures.*,Others|nullable|string|max:255',
            'purpose'                   => 'required|string',
            'level'                     => 'required|string',
            'activity_date'             => 'required|string|max:100',
            'hours'                     => 'nullable|integer|min:1',
            'venue'                     => 'required|string|max:255',
            'organizer'                 => 'required|string|max:255',
            'financial_requested'       => 'required|boolean',
            'amount_requested'          => 'nullable|numeric|min:0',
            'coverage'                  => 'nullable|array',
            'coverage.*'                => 'string',
            'coverage_others'           => 'required_if:coverage.*,Others|nullable|string|max:255',
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
