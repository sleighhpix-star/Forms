<?php

namespace App\Http\Controllers;

use App\Models\Setting;
use Illuminate\Http\Request;

class SettingsController extends Controller
{
    public function edit()
    {
        $signatories = Setting::signatories();

        return view('ld.settings.edit', compact('signatories'));
    }

    public function update(Request $request)
    {
        $validated = $request->validate([
            'sig_requested_name'        => 'required|string|max:255',
            'sig_requested_position'    => 'required|string|max:255',
            'sig_reviewed_name'         => 'required|string|max:255',
            'sig_reviewed_position'     => 'required|string|max:255',
            'sig_recommending_name'     => 'required|string|max:255',
            'sig_recommending_position' => 'required|string|max:255',
            'sig_approved_name'         => 'required|string|max:255',
            'sig_approved_position'     => 'required|string|max:255',
        ]);

        foreach ($validated as $key => $value) {
            Setting::set($key, $value);
        }

        return back()->with('success', 'Signatory defaults updated successfully.');
    }
}
