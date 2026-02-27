<?php

namespace App\Http\Controllers;

use App\Models\LdReimbursement;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class LdReimbursementController extends Controller
{
    public function store(Request $request)
    {
        $validated = $this->validateForm($request);
        $validated['expense_items'] = $this->buildExpenseItems($request);
        LdReimbursement::create($validated);
        return redirect()->route('ld.index', ['tab' => 'reimbursement'])
            ->with('success', 'Reimbursement request submitted successfully.');
    }

    public function update(Request $request, LdReimbursement $reimbursement)
    {
        $validated = $this->validateForm($request);
        $validated['expense_items'] = $this->buildExpenseItems($request);
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
            'records' => LdReimbursement::orderByDesc('created_at')->get()
        ]);
    }

    // ── MOV ──────────────────────────────────────────────────────────────────

    public function uploadMov(Request $request, LdReimbursement $reimbursement)
    {
        $request->validate([
            'mov_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        if ($reimbursement->mov_path && Storage::disk('public')->exists($reimbursement->mov_path)) {
            Storage::disk('public')->delete($reimbursement->mov_path);
        }

        $file = $request->file('mov_file');
        $reimbursement->forceFill([
            'mov_path'          => $file->store('ld/reimbursement/mov', 'public'),
            'mov_original_name' => $file->getClientOriginalName(),
            'mov_size'          => $file->getSize(),
            'mov_mime'          => $file->getMimeType(),
        ])->save();

        return redirect()->route('ld.index', ['tab' => 'reimbursement'])
            ->with('success', '✅ MOV uploaded.');
    }

    public function viewMov(LdReimbursement $reimbursement)
    {
        abort_unless($reimbursement->mov_path && Storage::disk('public')->exists($reimbursement->mov_path), 404);
        return Storage::disk('public')->response(
            $reimbursement->mov_path,
            $reimbursement->mov_original_name ?? basename($reimbursement->mov_path)
        );
    }

    // ── Private ──────────────────────────────────────────────────────────────

    private function validateForm(Request $request): array
    {
        return $request->validate([
            'department'                 => 'required|string|max:255',
            'activity_types'             => 'required|array|min:1',
            'activity_types.*'           => 'string',
            'activity_type_others'       => 'nullable|string|max:255',
            'venue'                      => 'nullable|string|max:255',
            'activity_date'              => 'nullable|string|max:100',
            'reason'                     => 'nullable|string',
            'remarks'                    => 'nullable|string',
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

    /**
     * Convert flat arrays (payees[], descriptions[], ...) into a JSON array of objects.
     * The form sends parallel arrays for each expense row.
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
            // Skip completely empty rows
            $desc = $descriptions[$i] ?? '';
            if (empty($payee) && empty($desc)) continue;

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