<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesMovUpload;
use App\Models\LdAttendance;
use App\Models\LdPublication;
use App\Models\LdReimbursement;
use App\Models\LdRequest;
use App\Models\LdTravel;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LdRequestController extends Controller
{
    use HandlesMovUpload;

    // ── Constants ─────────────────────────────────────────────────────────────

    private const TYPES = [
        'Seminar', 'Convention', 'Conference', 'Training',
        'Symposium', 'Workshop', 'Immersion',
    ];

    private const LEVELS = ['Local', 'Regional', 'National', 'International'];

    private const NATURES = [
        'Learner', 'Presenter', 'Officer', 'Speaker', 'Facilitator', 'Organizer',
    ];

    private const STATUSES = ['Permanent', 'Temporary', 'Casual', 'Contractual', 'Part-time'];

    private const COVERAGE = [
        'registration'   => 'Registration',
        'accommodation'  => 'Accommodation',
        'materials'      => 'Materials/ Kit',
        'speaker_fee'    => "Speaker's Fee",
        'meals'          => 'Meals/ Snacks',
        'transportation' => 'Transportation',
    ];

    // ── Index ─────────────────────────────────────────────────────────────────

    public function index(Request $request)
    {
        // Tab 1: Participation — use the FTS scope for full-text search,
        // JSONB @> containment for type, and a plain WHERE for level.
        $query = LdRequest::query();
        if ($s = $request->input('search')) {
            // scopeSearch uses the generated fts_vector tsvector column (GIN indexed).
            $query->search($s);
        }
        if ($t = $request->input('type'))  $query->ofType($t);
        if ($l = $request->input('level')) $query->ofLevel($l);
        $records = $query->latest()->get();

        // Tab 2: Attendance
        $attQuery = LdAttendance::query();
        if ($s = $request->input('att_q')) {
            $attQuery->where(function ($q) use ($s) {
                $q->whereRaw('attendee_name ILIKE ?', ["%{$s}%"])
                  ->orWhereRaw('campus ILIKE ?',       ["%{$s}%"])
                  ->orWhereRaw('purpose ILIKE ?',      ["%{$s}%"]);
            });
        }
        if ($t = $request->input('att_type')) {
            $attQuery->whereRaw('activity_types::jsonb @> ?::jsonb', [json_encode([$t])]);
        }
        if ($l = $request->input('att_level')) $attQuery->where('level', $l);
        $attendanceRecords = $attQuery->latest()->get();

        // Tab 3: Publication
        $pubQuery = LdPublication::query();
        if ($s = $request->input('pub_q')) {
            $pubQuery->where(function ($q) use ($s) {
                $q->whereRaw('faculty_name ILIKE ?',  ["%{$s}%"])
                  ->orWhereRaw('paper_title ILIKE ?', ["%{$s}%"])
                  ->orWhereRaw('journal_title ILIKE ?', ["%{$s}%"]);
            });
        }
        if ($sc = $request->input('pub_scope'))  $pubQuery->where('pub_scope', $sc);
        if ($n  = $request->input('pub_nature')) $pubQuery->where('nature', $n);
        $publicationRecords = $pubQuery->latest()->get();

        // Tab 4: Reimbursement
        $reiQuery = LdReimbursement::query();
        if ($s = $request->input('rei_q')) {
            $reiQuery->whereRaw('department ILIKE ?', ["%{$s}%"]);
        }
        $reimbursementRecords = $reiQuery->latest()->get();

        // Tab 5: Travel
        $trvQuery = LdTravel::query();
        if ($s = $request->input('trv_q')) {
            $trvQuery->where(function ($q) use ($s) {
                $q->whereRaw('employee_names ILIKE ?',  ["%{$s}%"])
                  ->orWhereRaw('places_visited ILIKE ?', ["%{$s}%"])
                  ->orWhereRaw('purpose ILIKE ?',        ["%{$s}%"]);
            });
        }
        $travelRecords = $trvQuery->latest()->get();

        $counts = [
            'participation' => LdRequest::count(),
            'attendance'    => LdAttendance::count(),
            'publication'   => LdPublication::count(),
            'reimbursement' => LdReimbursement::count(),
            'travel'        => LdTravel::count(),
        ];

        $filters = $request->only(['search', 'type', 'level']);
        $types   = collect(self::TYPES);
        $levels  = collect(self::LEVELS);

        return view('ld.index', compact(
            'records', 'filters', 'types', 'levels',
            'attendanceRecords', 'publicationRecords',
            'reimbursementRecords', 'travelRecords', 'counts'
        ));
    }

    // ── Create / Store ────────────────────────────────────────────────────────

    public function create()
    {
        return view('ld.create', [
            'employmentStatuses' => self::STATUSES,
            'types'    => self::TYPES,
            'levels'   => self::LEVELS,
            'natures'  => self::NATURES,
            'coverage' => self::COVERAGE,
        ]);
    }

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number'])) {
            $validated['tracking_number'] = 'LD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        LdRequest::create($validated);

        return redirect()->route('ld.index')->with('success', 'Request submitted successfully.');
    }

    // ── Show / Edit / Update / Delete ─────────────────────────────────────────

    public function show(LdRequest $ld)
    {
        return view('ld.show', [
            'ld'       => $ld,
            'record'   => $ld,
            'coverage' => self::COVERAGE,
        ]);
    }

    public function edit(LdRequest $ld)
    {
        return view('ld.edit', [
            'record'             => $ld,
            'employmentStatuses' => self::STATUSES,
            'types'              => self::TYPES,
            'levels'             => self::LEVELS,
            'natures'            => self::NATURES,
            'coverage'           => self::COVERAGE,
        ]);
    }

    public function update(Request $request, LdRequest $ld)
    {
        $validated = $this->validateForm($request);

        if (empty($validated['tracking_number']) && empty($ld->tracking_number)) {
            $validated['tracking_number'] = 'LD-' . now()->format('Ymd') . '-' . Str::upper(Str::random(6));
        }

        $ld->fill($validated);

        if (! $ld->isDirty()) {
            return back()->with('success', 'No changes detected.');
        }

        $ld->save();

        return back()->with('success', 'Request updated successfully.');
    }

    public function destroy(LdRequest $ld)
    {
        $ld->delete();

        return redirect()->route('ld.index')->with('success', 'Request deleted.');
    }

    // ── Modals ────────────────────────────────────────────────────────────────

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

    // ── Records JSON ──────────────────────────────────────────────────────────

    public function recordsParticipation()
    {
        return response()->json(['records' => LdRequest::orderByDesc('created_at')->get()]);
    }

    // ── MOV ───────────────────────────────────────────────────────────────────

    public function uploadMov(Request $request, LdRequest $ld)
    {
        return $this->handleMovUpload($request, $ld, 'participation', 'participation');
    }

    public function viewMov(LdRequest $ld)
    {
        return $this->handleMovView($ld);
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'tracking_number'           => 'nullable|string|max:100',
            'participant_name'          => 'required|string|max:255',
            'campus'                    => 'required|string|max:255',
            'employment_status'         => 'required|string|max:100',
            'college_office'            => 'required|string|max:255',
            'position'                  => 'required|string|max:255',
            'title'                     => 'required|string|max:500',
            'types'                     => 'required|array|min:1',
            'types.*'                   => 'string',
            'type_others'               => 'required_if:types.*,Others|nullable|string|max:255',
            'level'                     => 'required|string',
            'natures'                   => 'required|array|min:1',
            'natures.*'                 => 'string',
            'nature_others'             => 'required_if:natures.*,Others|nullable|string|max:255',
            'competency'                => 'nullable|string',
            'intervention_date'         => 'required|string|max:255',
            'hours'                     => 'nullable|integer|min:1',
            'venue'                     => 'required|string|max:255',
            'organizer'                 => 'required|string|max:255',
            'endorsed_by_org'           => 'required|boolean',
            'related_to_field'          => 'required|boolean',
            'has_pending_ldap'          => 'required|boolean',
            'has_cash_advance'          => 'required|boolean',
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