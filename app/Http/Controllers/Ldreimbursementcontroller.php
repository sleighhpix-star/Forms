<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Concerns\HandlesMovUpload;
use App\Models\LdReimbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Str;

class LdReimbursementController extends Controller
{
    use HandlesMovUpload;

    public function store(Request $request)
    {
        $validated = $this->validateForm($request);
        $validated['expense_items'] = $this->buildExpenseItems($request);

        if (empty($validated['tracking_number'])) {
            $validated['tracking_number'] = 'LR-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        }

        LdReimbursement::create($validated);

        return redirect()->route('ld.index', ['tab' => 'reimbursement'])
            ->with('success', 'Reimbursement request submitted successfully.');
    }

    public function update(Request $request, LdReimbursement $reimbursement)
    {
        $validated = $this->validateForm($request);
        $validated['expense_items'] = $this->buildExpenseItems($request);

        if (empty($validated['tracking_number']) && empty($reimbursement->tracking_number)) {
            $validated['tracking_number'] = 'LR-' . date('Ymd') . '-' . Str::upper(Str::random(6));
        }

        $reimbursement->update($validated);

        return redirect()->route('ld.index', ['tab' => 'reimbursement'])
            ->with('success', 'Reimbursement request updated successfully.');
    }

    public function destroy(LdReimbursement $reimbursement)
    {
        $reimbursement->delete();

        return redirect()->route('ld.index', ['tab' => 'reimbursement'])
            ->with('success', 'Record deleted.');
    }

    public function showModal(LdReimbursement $reimbursement)
    {
        return view('ld.reimbursement.show-modal', ['record' => $reimbursement]);
    }

    public function editModal(LdReimbursement $reimbursement)
    {
        return view('ld.reimbursement.form', ['record' => $reimbursement]);
    }

    public function formCreate()
    {
        return view('ld.reimbursement.form', ['record' => null]);
    }

    public function print(LdReimbursement $reimbursement)
    {
        return view('ld.reimbursement.print', ['record' => $reimbursement]);
    }

    public function recordsJson()
    {
        return response()->json([
            'records' => LdReimbursement::orderByDesc('created_at')->get(),
        ]);
    }

    public function uploadMov(Request $request, LdReimbursement $reimbursement)
    {
        return parent::uploadMov($request, $reimbursement, 'reimbursement', 'reimbursement');
    }

    public function viewMov(LdReimbursement $reimbursement)
    {
        return parent::viewMov($reimbursement);
    }

    // ── Private ───────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'tracking_number'           => 'nullable|string|max:100',
            'department'                => 'required|string|max:255',
            'activity_types'            => 'required|array|min:1',
            'activity_types.*'          => 'string',
            'activity_type_others'      => 'nullable|string|max:255',
            'venue'                     => 'nullable|string|max:255',
            'activity_date'             => 'nullable|string|max:100',
            'reason'                    => 'nullable|string',
            'remarks'                   => 'nullable|string',
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

    /**
     * Convert parallel form arrays (payees[], descriptions[], ...) into
     * a single JSON array of expense-row objects for storage.
     */
    private function buildExpenseItems(Request $request): array
    {
        $payees       = $request->input('payees', []);
        $descriptions = $request->input('descriptions', []);
        $quantities   = $request->input('quantities', []);
        $unitCosts    = $request->input('unit_costs', []);
        $amounts      = $request->input('amounts', []);

        $items = [];
        foreach ($payees as $i => $payee) {
            $desc = $descriptions[$i] ?? '';

            if (empty($payee) && empty($desc)) {
                continue;
            }

            $qty      = (float) ($quantities[$i] ?? 0);
            $unitCost = (float) ($unitCosts[$i] ?? 0);
            $amount   = (float) ($amounts[$i] ?? ($qty * $unitCost));

            $items[] = [
                'payee'       => $payee,
                'description' => $desc,
                'quantity'    => $qty ?: null,
                'unit_cost'   => $unitCost ?: null,
                'amount'      => $amount,
            ];
        }

        return $items;
    }
}
