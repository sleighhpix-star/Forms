<?php

namespace App\Http\Controllers;

use App\Models\LdAttendance;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LdAttendanceController extends Controller
{
    // ── Shared signatory defaults ─────────────────────────────────────────────
    private array $sigDefaults = [
        'sig_requested_name'        => 'Dr. Bryan John A. Magoling',
        'sig_requested_position'    => 'Director, Research Management Services',
        'sig_reviewed_name'         => 'Engr. Albertson D. Amante',
        'sig_reviewed_position'     => 'VP for Research, Development and Extension Services',
        'sig_recommending_name'     => 'Atty. Noel Alberto S. Omandap',
        'sig_recommending_position' => 'VP for Administration and Finance',
        'sig_approved_name'         => 'Dr. Tirso A. Ronquillo',
        'sig_approved_position'     => 'University President',
    ];

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);
        LdAttendance::create($validated);
        return redirect()->route('ld.index', ['tab' => 'attendance'])
            ->with('success', 'Attendance request submitted successfully.');
    }

    public function update(Request $request, LdAttendance $attendance)
    {
        $validated = $this->validateForm($request);
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
            'records' => LdAttendance::orderByDesc('created_at')->get()
        ]);
    }

    // ── MOV ──────────────────────────────────────────────────────────────────

    public function uploadMov(Request $request, LdAttendance $attendance)
    {
        $request->validate([
            'mov_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        if ($attendance->mov_path && Storage::disk('public')->exists($attendance->mov_path)) {
            Storage::disk('public')->delete($attendance->mov_path);
        }

        $file = $request->file('mov_file');
        $attendance->forceFill([
            'mov_path'          => $file->store('ld/attendance/mov', 'public'),
            'mov_original_name' => $file->getClientOriginalName(),
            'mov_size'          => $file->getSize(),
            'mov_mime'          => $file->getMimeType(),
        ])->save();

        return redirect()->route('ld.index', ['tab' => 'attendance'])
            ->with('success', '✅ MOV uploaded.');
    }

    public function viewMov(LdAttendance $attendance)
    {
        abort_unless($attendance->mov_path && Storage::disk('public')->exists($attendance->mov_path), 404);
        return Storage::disk('public')->response(
            $attendance->mov_path,
            $attendance->mov_original_name ?? basename($attendance->mov_path)
        );
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'attendee_name'              => 'required|string|max:255',
            'campus'                     => 'required|string|max:255',
            'employment_status'          => 'required|string|max:100',
            'college_office'             => 'required|string|max:255',
            'position'                   => 'required|string|max:255',
            'activity_types'             => 'required|array|min:1',
            'activity_types.*'           => 'string',
            'activity_type_others'       => 'nullable|string|max:255',
            'natures'                    => 'required|array|min:1',
            'natures.*'                  => 'string',
            'nature_others'              => 'nullable|string|max:255',
            'purpose'                    => 'required|string',
            'level'                      => 'required|string',
            'activity_date'              => 'required|string|max:100',
            'hours'                      => 'nullable|integer|min:1',
            'venue'                      => 'required|string|max:255',
            'organizer'                  => 'required|string|max:255',
            'financial_requested'        => 'required|boolean',
            'amount_requested'           => 'nullable|numeric|min:0',
            'coverage'                   => 'nullable|array',
            'coverage.*'                 => 'string',
            'coverage_others'            => 'nullable|string|max:255',
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