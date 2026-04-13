<?php

namespace App\Http\Controllers\Concerns;

use Illuminate\Database\Eloquent\Model;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Symfony\Component\HttpFoundation\StreamedResponse;

/**
 * Reusable MOV (Means of Verification) upload and streaming logic.
 *
 * Each controller that uses this trait must define its own public
 * uploadMov() / viewMov() methods and delegate to the protected helpers:
 *
 *   public function uploadMov(Request $request, Model $record)
 *   {
 *       return $this->handleMovUpload($request, $record, 'participation', 'participation');
 *   }
 *
 *   public function viewMov(Model $record)
 *   {
 *       return $this->handleMovView($record);
 *   }
 */
trait HandlesMovUpload
{
    /**
     * Validate, store, and persist a MOV file upload.
     *
     * @param  Request  $request
     * @param  Model    $record   Eloquent model with mov_* columns.
     * @param  string   $folder   Storage sub-folder inside ld/ (e.g. 'participation').
     * @param  string   $tab      Tab name used for the post-upload redirect.
     */
    protected function handleMovUpload(
        Request $request,
        Model   $record,
        string  $folder,
        string  $tab
    ): RedirectResponse {
        $request->validate([
            'mov_file' => 'required|file|max:10240|mimes:pdf,jpg,jpeg,png,doc,docx,xls,xlsx',
        ]);

        // Delete the existing file before storing the new one.
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
            ->with('success', 'MOV uploaded successfully.');
    }

    /**
     * Stream a stored MOV file to the browser.
     *
     * @param  Model  $record  Eloquent model with mov_* columns.
     */
    protected function handleMovView(Model $record): StreamedResponse
    {
        abort_unless(
            $record->mov_path && Storage::disk('public')->exists($record->mov_path),
            404,
            'MOV file not found.'
        );

        return Storage::disk('public')->response(
            $record->mov_path,
            $record->mov_original_name ?? basename($record->mov_path)
        );
    }
}
