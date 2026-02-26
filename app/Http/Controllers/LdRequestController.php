<?php

namespace App\Http\Controllers;

use App\Models\LdRequest;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Facades\Log;
use Symfony\Component\HttpFoundation\Response;

class LdRequestController extends Controller
{
    public function index(Request $request)
    {
        $filters = $request->only(['search', 'type', 'level']);

        $query = LdRequest::query();

        if (!empty($filters['search'])) {
            $search = $filters['search'];
            $query->where(function ($q) use ($search) {
                $q->whereRaw('participant_name ILIKE ?', ["%{$search}%"])
                  ->orWhereRaw('title ILIKE ?', ["%{$search}%"])
                  ->orWhereRaw('campus ILIKE ?', ["%{$search}%"])
                  ->orWhereRaw('college_office ILIKE ?', ["%{$search}%"]);
            });
        }

        if (!empty($filters['type'])) {
            $query->whereJsonContains('types', $filters['type']);
        }

        if (!empty($filters['level'])) {
            $query->where('level', $filters['level']);
        }

        $records = $query->latest()->paginate(20)->withQueryString();
        $total   = LdRequest::count();

        $types  = collect(['Seminar', 'Convention', 'Conference', 'Training', 'Symposium', 'Workshop', 'Immersion']);
        $levels = collect(['Local', 'Regional', 'National', 'International']);

        return view('ld.index', compact('records', 'total', 'filters', 'types', 'levels'));
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
            'coverage'            => 'nullable|array',
            'coverage.*'          => 'string',
            'coverage_others'     => 'nullable|string|max:255',
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
            'coverage'            => 'nullable|array',
            'coverage.*'          => 'string',
            'coverage_others'     => 'nullable|string|max:255',
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
     */
    public function recordsAttendance(Request $request)
    {
        $records = \App\Models\AttendanceRequest::orderByDesc('created_at')->get();

        return response()->json(['records' => $records]);
    }

    /**
     * JSON: all publication incentive records
     * Route: GET /ld-requests/records/publication
     */
    public function recordsPublication(Request $request)
    {
        $records = \App\Models\PublicationRequest::orderByDesc('created_at')->get();

        return response()->json(['records' => $records]);
    }

    /**
     * JSON: all reimbursement records
     * Route: GET /ld-requests/records/reimbursement
     */
    public function recordsReimbursement(Request $request)
    {
        $records = \App\Models\ReimbursementRequest::orderByDesc('created_at')->get();

        return response()->json(['records' => $records]);
    }

    /**
     * JSON: all travel authority records
     * Route: GET /ld-requests/records/travel
     */
    public function recordsTravel(Request $request)
    {
        $records = \App\Models\TravelRequest::orderByDesc('created_at')->get();

        return response()->json(['records' => $records]);
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