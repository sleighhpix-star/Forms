<?php

use App\Http\Controllers\LdRequestController;
use App\Http\Controllers\Ld\LdAttendanceController;
use App\Http\Controllers\Ld\LdPublicationController;
use App\Http\Controllers\Ld\LdReimbursementController;
use App\Http\Controllers\Ld\LdTravelController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('ld.index'));

Route::prefix('ld-requests')->name('ld.')->group(function () {

    // ── Participation (existing) ──────────────────────────────
    Route::get('/',                [LdRequestController::class, 'index'])->name('index');
    Route::get('/create',          [LdRequestController::class, 'create'])->name('create');
    Route::post('/',               [LdRequestController::class, 'store'])->name('store');

    // ── Records JSON endpoints (MUST be before /{ld} wildcards) ──
    Route::get('/records/participation',  [LdRequestController::class, 'recordsParticipation'])->name('records.participation');
    Route::get('/records/attendance',     [LdRequestController::class, 'recordsAttendance'])->name('records.attendance');
    Route::get('/records/publication',    [LdRequestController::class, 'recordsPublication'])->name('records.publication');
    Route::get('/records/reimbursement',  [LdRequestController::class, 'recordsReimbursement'])->name('records.reimbursement');
    Route::get('/records/travel',         [LdRequestController::class, 'recordsTravel'])->name('records.travel');

    // ── Form partials ─────────────────────────────────────────
    Route::get('/form/attendance',    [LdAttendanceController::class,    'createForm'])->name('form.attendance');
    Route::get('/form/publication',   [LdPublicationController::class,   'createForm'])->name('form.publication');
    Route::get('/form/reimbursement', [LdReimbursementController::class, 'createForm'])->name('form.reimbursement');
    Route::get('/form/travel',        [LdTravelController::class,        'createForm'])->name('form.travel');

    // ── Participation (wildcard — keep AFTER all static routes) ──
    Route::get('/{ld}/show-modal', [LdRequestController::class, 'showModal'])->name('showModal');
    Route::get('/{ld}/edit-modal', [LdRequestController::class, 'editModal'])->name('editModal');
    Route::get('/{ld}/edit',       [LdRequestController::class, 'edit'])->name('edit');
    Route::put('/{ld}',            [LdRequestController::class, 'update'])->name('update');
    Route::get('/{ld}/print',      [LdRequestController::class, 'print'])->name('print');
    Route::delete('/{ld}',         [LdRequestController::class, 'destroy'])->name('destroy');
    Route::post('/{ld}/mov',       [LdRequestController::class, 'uploadMov'])->name('mov.upload');
    Route::get('/{ld}/mov/view',   [LdRequestController::class, 'viewMov'])->name('mov.view');

    // ── Attendance ────────────────────────────────────────────
    Route::post('/attendance',                [LdAttendanceController::class, 'store'])->name('attendance.store');
    Route::get('/attendance/{id}/show-modal', [LdAttendanceController::class, 'showModal'])->name('attendance.show-modal');
    Route::get('/attendance/{id}/edit-modal', [LdAttendanceController::class, 'editModal'])->name('attendance.edit-modal');
    Route::put('/attendance/{id}',            [LdAttendanceController::class, 'update'])->name('attendance.update');
    Route::get('/attendance/{id}/print',      [LdAttendanceController::class, 'print'])->name('attendance.print');
    Route::post('/attendance/{id}/mov',       [LdAttendanceController::class, 'movUpload'])->name('attendance.mov.upload');
    Route::get('/attendance/{id}/mov/view',   [LdAttendanceController::class, 'movView'])->name('attendance.mov.view');

    // ── Publication ───────────────────────────────────────────
    Route::post('/publication',                [LdPublicationController::class, 'store'])->name('publication.store');
    Route::get('/publication/{id}/show-modal', [LdPublicationController::class, 'showModal'])->name('publication.show-modal');
    Route::get('/publication/{id}/edit-modal', [LdPublicationController::class, 'editModal'])->name('publication.edit-modal');
    Route::put('/publication/{id}',            [LdPublicationController::class, 'update'])->name('publication.update');
    Route::get('/publication/{id}/print',      [LdPublicationController::class, 'print'])->name('publication.print');
    Route::post('/publication/{id}/mov',       [LdPublicationController::class, 'movUpload'])->name('publication.mov.upload');
    Route::get('/publication/{id}/mov/view',   [LdPublicationController::class, 'movView'])->name('publication.mov.view');

    // ── Reimbursement ─────────────────────────────────────────
    Route::post('/reimbursement',                [LdReimbursementController::class, 'store'])->name('reimbursement.store');
    Route::get('/reimbursement/{id}/show-modal', [LdReimbursementController::class, 'showModal'])->name('reimbursement.show-modal');
    Route::get('/reimbursement/{id}/edit-modal', [LdReimbursementController::class, 'editModal'])->name('reimbursement.edit-modal');
    Route::put('/reimbursement/{id}',            [LdReimbursementController::class, 'update'])->name('reimbursement.update');
    Route::get('/reimbursement/{id}/print',      [LdReimbursementController::class, 'print'])->name('reimbursement.print');
    Route::post('/reimbursement/{id}/mov',       [LdReimbursementController::class, 'movUpload'])->name('reimbursement.mov.upload');
    Route::get('/reimbursement/{id}/mov/view',   [LdReimbursementController::class, 'movView'])->name('reimbursement.mov.view');

    // ── Travel ────────────────────────────────────────────────
    Route::post('/travel',                [LdTravelController::class, 'store'])->name('travel.store');
    Route::get('/travel/{id}/show-modal', [LdTravelController::class, 'showModal'])->name('travel.show-modal');
    Route::get('/travel/{id}/edit-modal', [LdTravelController::class, 'editModal'])->name('travel.edit-modal');
    Route::put('/travel/{id}',            [LdTravelController::class, 'update'])->name('travel.update');
    Route::get('/travel/{id}/print',      [LdTravelController::class, 'print'])->name('travel.print');
    Route::post('/travel/{id}/mov',       [LdTravelController::class, 'movUpload'])->name('travel.mov.upload');
    Route::get('/travel/{id}/mov/view',   [LdTravelController::class, 'movView'])->name('travel.mov.view');
});