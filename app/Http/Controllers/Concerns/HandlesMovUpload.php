<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

trait HandlesMovUpload
{
    public function uploadMov(Request $request, Model $record, string $folder, string $tab): \Illuminate\Http\RedirectResponse
    {
        $request->validate([
            'mov_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        if ($record->mov_path && Storage::disk('public')->exists($record->mov_path)) {
            Storage::disk('public')->delete($record->mov_path);
        }

        $file = $request->file('mov_file');
        $record->forceFill([
            'mov_path'          => $file->store("ld/{$folder}/mov", 'public'),
            'mov_original_name' => $file->getClientOriginalName(),
            'mov_size'          => $file->getSize(),
            'mov_mime'          => $file->getMimeType(),
        ])->save();

        return redirect()->route('ld.index', ['tab' => $tab])
            ->with('success', '✅ MOV uploaded.');
    }

    public function viewMov(Model $record): \Symfony\Component\HttpFoundation\StreamedResponse
    {
        abort_unless(
            $record->mov_path && Storage::disk('public')->exists($record->mov_path),
            404
        );

        return Storage::disk('public')->response(
            $record->mov_path,
            $record->mov_original_name ?? basename($record->mov_path)
        );
    }
}
