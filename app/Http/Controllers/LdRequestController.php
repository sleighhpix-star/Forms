<?php

namespace App\Http\Controllers;

use App\Models\LdRequest;
use App\Models\LdAttendance;
use App\Models\LdPublication;
use App\Models\LdReimbursement;
use App\Models\LdTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LdRequestController extends Controller
{
    public function index(Request $request)
    {
        $types  = collect(['Seminar', 'Convention', 'Conference', 'Training', 'Symposium', 'Workshop', 'Immersion']);
        $levels = collect(['Local', 'Regional', 'National', 'International']);

        // ── Tab 1: Participation ─────────────────────────────────────────────
        $filters = $request->only(['search', 'type', 'level']);
        $query   = LdRequest::query();
        if (!empty($filters['search'])) {
            $s = $filters['search'];
            $query->where(fn($q) => $q
                ->whereRaw('participant_name ILIKE ?', ["%{$s}%"])
                ->orWhereRaw('title ILIKE ?',          ["%{$s}%"])
                ->orWhereRaw('campus ILIKE ?',          ["%{$s}%"])
                ->orWhereRaw('college_office ILIKE ?',  ["%{$s}%"])
            );
        }
        if (!empty($filters['type']))  $query->whereJsonContains('types', $filters['type']);
        if (!empty($filters['level'])) $query->where('level', $filters['level']);
        $records = $query->latest()->paginate(20)->withQueryString();

        // ── Tab 2: Attendance ────────────────────────────────────────────────
        $attQuery = LdAttendance::query();
        if ($s = $request->input('att_search')) {
            $attQuery->where(fn($q) => $q
                ->whereRaw('attendee_name ILIKE ?', ["%{$s}%"])
                ->orWhereRaw('campus ILIKE ?',       ["%{$s}%"])
                ->orWhereRaw('purpose ILIKE ?',      ["%{$s}%"])
            );
        }
        if ($l = $request->input('att_level')) $attQuery->where('level', $l);
        $attendanceRecords = $attQuery->latest()->paginate(20, ['*'], 'att_page')->withQueryString();

        // ── Tab 3: Publication ───────────────────────────────────────────────
        $pubQuery = LdPublication::query();
        if ($s = $request->input('pub_search')) {
            $pubQuery->where(fn($q) => $q
                ->whereRaw('faculty_name ILIKE ?',  ["%{$s}%"])
                ->orWhereRaw('paper_title ILIKE ?', ["%{$s}%"])
                ->orWhereRaw('journal_title ILIKE ?', ["%{$s}%"])
            );
        }
        if ($sc = $request->input('pub_scope'))  $pubQuery->where('pub_scope', $sc);
        if ($n  = $request->input('pub_nature')) $pubQuery->where('nature', $n);
        $publicationRecords = $pubQuery->latest()->paginate(20, ['*'], 'pub_page')->withQueryString();

        // ── Tab 4: Reimbursement ─────────────────────────────────────────────
        $reiQuery = LdReimbursement::query();
        if ($s = $request->input('rei_search')) {
            $reiQuery->whereRaw('department ILIKE ?', ["%{$s}%"]);
        }
        $reimbursementRecords = $reiQuery->latest()->paginate(20, ['*'], 'rei_page')->withQueryString();

        // ── Tab 5: Travel ────────────────────────────────────────────────────
        $trvQuery = LdTravel::query();
        if ($s = $request->input('trv_search')) {
            $trvQuery->where(fn($q) => $q
                ->whereRaw('employee_names ILIKE ?', ["%{$s}%"])
                ->orWhereRaw('places_visited ILIKE ?', ["%{$s}%"])
                ->orWhereRaw('purpose ILIKE ?',        ["%{$s}%"])
            );
        }
        $travelRecords = $trvQuery->latest()->paginate(20, ['*'], 'trv_page')->withQueryString();

        // ── Tab counts (unfiltered) ──────────────────────────────────────────
        $counts = [
            'participation' => LdRequest::count(),
            'attendance'    => LdAttendance::count(),
            'publication'   => LdPublication::count(),
            'reimbursement' => LdReimbursement::count(),
            'travel'        => LdTravel::count(),
        ];

        return view('ld.index', compact(
            'records', 'filters', 'types', 'levels',
            'attendanceRecords',
            'publicationRecords',
            'reimbursementRecords',
            'travelRecords',
            'counts'
        ));
    }

    public function create()
    {
        return view('ld.create', [
            'employmentStatuses' => ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'],
            'types'    => ['Seminar', 'Convention', 'Conference', 'Training', 'Symposium', 'Workshop', 'Immersion'],
            'levels'   => ['Local', 'Regional', 'National', 'International'],
            'natures'  => ['Learner', 'Presenter', 'Officer', 'Speaker', 'Facilitator', 'Organizer'],
            'coverage' => [
                'registration'   => 'Registration',
                'accommodation'  => 'Accommodation',
                'materials'      => 'Materials/ Kit',
                'speaker_fee'    => "Speaker's Fee",
                'meals'          => 'Meals/ Snacks',
                'transportation' => 'Transportation',
            ],
        ]);
    }

    public function store(Request $request)
    {
        $validated = $request->validate([
            'participant_name'    => 'required|string|max:255',
            'campus'              => 'required|string|max:255',
            'employment_status'   => 'required|string|max:100',
            'college_office'      => 'required|string|max:255',
            'position'            => 'required|string|max:255',
            'title'               => 'required|string|max:500',
            'types'               => 'required|array|min:1',
            'types.*'             => 'string',
            'type_others'         => 'nullable|string|max:255',
            'level'               => 'required|string',
            'natures'             => 'required|array|min:1',
            'natures.*'           => 'string',
            'nature_others'       => 'nullable|string|max:255',
            'competency'          => 'nullable|string',
            'intervention_date'   => 'required|string|max:100',
            'hours'               => 'nullable|integer|min:1',
            'venue'               => 'required|string|max:255',
            'organizer'           => 'required|string|max:255',
            'endorsed_by_org'     => 'required|boolean',
            'related_to_field'    => 'required|boolean',
            'has_pending_ldap'    => 'required|boolean',
            'has_cash_advance'    => 'required|boolean',
            'financial_requested' => 'required|boolean',
            'amount_requested'    => 'nullable|numeric|min:0',
            'coverage'                  => 'nullable|array',
            'coverage.*'                => 'string',
            'coverage_others'           => 'nullable|string|max:255',
            'sig_requested_name'        => 'nullable|string|max:255',
            'sig_requested_position'    => 'nullable|string|max:255',
            'sig_reviewed_name'         => 'nullable|string|max:255',
            'sig_reviewed_position'     => 'nullable|string|max:255',
            'sig_recommending_name'     => 'nullable|string|max:255',
            'sig_recommending_position' => 'nullable|string|max:255',
            'sig_approved_name'         => 'nullable|string|max:255',
            'sig_approved_position'     => 'nullable|string|max:255',
        ]);

        LdRequest::create($validated);

        return redirect()->route('ld.index')->with('success', 'Request submitted successfully.');
    }

    public function show(LdRequest $ld)
    {
        $coverage = [
            'registration'   => 'Registration',
            'accommodation'  => 'Accommodation',
            'materials'      => 'Materials/ Kit',
            'speaker_fee'    => "Speaker's Fee",
            'meals'          => 'Meals/ Snacks',
            'transportation' => 'Transportation',
        ];

        return view('ld.show', compact('ld', 'coverage'))->with('record', $ld);
    }

    public function edit(LdRequest $ld)
    {
        return view('ld.edit', [
            'record'             => $ld,
            'employmentStatuses' => ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'],
            'types'    => ['Seminar', 'Convention', 'Conference', 'Training', 'Symposium', 'Workshop', 'Immersion'],
            'levels'   => ['Local', 'Regional', 'National', 'International'],
            'natures'  => ['Learner', 'Presenter', 'Officer', 'Speaker', 'Facilitator', 'Organizer'],
            'coverage' => [
                'registration'   => 'Registration',
                'accommodation'  => 'Accommodation',
                'materials'      => 'Materials/ Kit',
                'speaker_fee'    => "Speaker's Fee",
                'meals'          => 'Meals/ Snacks',
                'transportation' => 'Transportation',
            ],
        ]);
    }

    public function update(Request $request, LdRequest $ld)
    {
        $validated = $request->validate([
            'participant_name'    => 'required|string|max:255',
            'campus'              => 'required|string|max:255',
            'employment_status'   => 'required|string|max:100',
            'college_office'      => 'required|string|max:255',
            'position'            => 'required|string|max:255',
            'title'               => 'required|string|max:500',
            'types'               => 'required|array|min:1',
            'types.*'             => 'string',
            'type_others'         => 'nullable|string|max:255',
            'level'               => 'required|string',
            'natures'             => 'required|array|min:1',
            'natures.*'           => 'string',
            'nature_others'       => 'nullable|string|max:255',
            'competency'          => 'nullable|string',
            'intervention_date'   => 'required|string|max:100',
            'hours'               => 'nullable|integer|min:1',
            'venue'               => 'required|string|max:255',
            'organizer'           => 'required|string|max:255',
            'endorsed_by_org'     => 'required|boolean',
            'related_to_field'    => 'required|boolean',
            'has_pending_ldap'    => 'required|boolean',
            'has_cash_advance'    => 'required|boolean',
            'financial_requested' => 'required|boolean',
            'amount_requested'    => 'nullable|numeric|min:0',
            'coverage'                  => 'nullable|array',
            'coverage.*'                => 'string',
            'coverage_others'           => 'nullable|string|max:255',
            'sig_requested_name'        => 'nullable|string|max:255',
            'sig_requested_position'    => 'nullable|string|max:255',
            'sig_reviewed_name'         => 'nullable|string|max:255',
            'sig_reviewed_position'     => 'nullable|string|max:255',
            'sig_recommending_name'     => 'nullable|string|max:255',
            'sig_recommending_position' => 'nullable|string|max:255',
            'sig_approved_name'         => 'nullable|string|max:255',
            'sig_approved_position'     => 'nullable|string|max:255',
        ]);

        $ld->update($validated);

        return redirect()->route('ld.show', $ld)->with('success', 'Request updated successfully.');
    }

    public function destroy(LdRequest $ld)
    {
        $ld->delete();
        return redirect()->route('ld.index')->with('success', 'Request deleted.');
    }

    public function showModal(LdRequest $ld)
    {
        return view('ld.show-modal', ['record' => $ld]);
    }

    public function editModal(LdRequest $ld)
    {
        return view('ld.edit', ['record' => $ld]);
    }

    public function print(LdRequest $ld)
    {
        return view('ld.print', ['record' => $ld]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // Records JSON endpoints — used by the "All Records" popup modal
    // ─────────────────────────────────────────────────────────────────────────

    /**
     * JSON: all participation records
     * Route: GET /ld-requests/records/participation
     */
    public function recordsParticipation(Request $request)
    {
        $records = LdRequest::orderByDesc('created_at')->get();

        return response()->json(['records' => $records]);
    }

    /**
     * JSON: all attendance records
     * Route: GET /ld-requests/records/attendance
     * NOTE: Uses LdRequest — same table, no separate model yet.
     */
    public function recordsAttendance(Request $request)
    {
        return response()->json(['records' => LdAttendance::orderByDesc('created_at')->get()]);
    }

    /**
     * JSON: all publication incentive records
     * Route: GET /ld-requests/records/publication
     * NOTE: Uses LdRequest — same table, no separate model yet.
     */
    public function recordsPublication(Request $request)
    {
        return response()->json(['records' => LdPublication::orderByDesc('created_at')->get()]);
    }

    /**
     * JSON: all reimbursement records
     * Route: GET /ld-requests/records/reimbursement
     * NOTE: Uses LdRequest — same table, no separate model yet.
     */
    public function recordsReimbursement(Request $request)
    {
        return response()->json(['records' => LdReimbursement::orderByDesc('created_at')->get()]);
    }

    /**
     * JSON: all travel authority records
     * Route: GET /ld-requests/records/travel
     * NOTE: Uses LdRequest — same table, no separate model yet.
     */
    public function recordsTravel(Request $request)
    {
        return response()->json(['records' => LdTravel::orderByDesc('created_at')->get()]);
    }

    // ─────────────────────────────────────────────────────────────────────────
    // MOV Upload & View
    // ─────────────────────────────────────────────────────────────────────────

    public function uploadMov(Request $request, LdRequest $ld)
    {
        $request->merge(['mov_record_id' => $ld->id]);

        $request->validate([
            'mov_file'      => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
            'mov_record_id' => 'required|integer',
        ]);

        try {
            if (!empty($ld->mov_path) && Storage::disk('public')->exists($ld->mov_path)) {
                Storage::disk('public')->delete($ld->mov_path);
            }

            $file = $request->file('mov_file');
            $path = $file->store('ld/mov', 'public');

            $ld->forceFill([
                'mov_original_name' => $file->getClientOriginalName(),
                'mov_path'          => $path,
                'mov_size'          => $file->getSize(),
                'mov_mime'          => $file->getMimeType(),
            ])->save();

            $ld->refresh();

            Log::info('MOV UPLOAD OK', [
                'id'                => $ld->id,
                'mov_path'          => $ld->mov_path,
                'mov_original_name' => $ld->mov_original_name,
            ]);

            return redirect()->route('ld.index')
                ->with('success', '✅ MOV uploaded.')
                ->with('mov_debug', "Saved: id={$ld->id} mov_path={$ld->mov_path}");

        } catch (\Throwable $e) {
            Log::error('MOV UPLOAD FAILED', [
                'id'    => $ld->id,
                'error' => $e->getMessage(),
            ]);

            return redirect()->route('ld.index')
                ->with('error', '❌ Upload failed: ' . $e->getMessage())
                ->withInput(['mov_record_id' => $ld->id]);
        }
    }

    public function viewMov(LdRequest $ld)
    {
        if (!$ld->mov_path) {
            abort(404, 'No MOV file.');
        }

        if (!Storage::disk('public')->exists($ld->mov_path)) {
            abort(404, 'MOV file not found on disk.');
        }

        return Storage::disk('public')->response(
            $ld->mov_path,
            $ld->mov_original_name ?? basename($ld->mov_path)
        );
    }
}