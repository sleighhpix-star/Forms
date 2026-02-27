<?php

use App\Http\Controllers\LdRequestController;
use App\Http\Controllers\LdAttendanceController;
use App\Http\Controllers\LdPublicationController;
use App\Http\Controllers\LdReimbursementController;
use App\Http\Controllers\LdTravelController;
use Illuminate\Support\Facades\Route;

Route::get('/', fn() => redirect()->route('ld.index'));

Route::prefix('ld-requests')->name('ld.')->group(function () {

    // Records JSON — MUST be BEFORE /{ld} wildcard routes
    Route::get('/records/participation',  [LdRequestController::class,      'recordsParticipation'])->name('records.participation');
    Route::get('/records/attendance',     [LdAttendanceController::class,   'recordsJson'])->name('records.attendance');
    Route::get('/records/publication',    [LdPublicationController::class,  'recordsJson'])->name('records.publication');
    Route::get('/records/reimbursement',  [LdReimbursementController::class,'recordsJson'])->name('records.reimbursement');
    Route::get('/records/travel',         [LdTravelController::class,       'recordsJson'])->name('records.travel');

    // Form partials (create modals) — BEFORE wildcards
    Route::get('/form/attendance',    [LdAttendanceController::class,   'formCreate'])->name('form.attendance');
    Route::get('/form/publication',   [LdPublicationController::class,  'formCreate'])->name('form.publication');
    Route::get('/form/reimbursement', [LdReimbursementController::class,'formCreate'])->name('form.reimbursement');
    Route::get('/form/travel',        [LdTravelController::class,       'formCreate'])->name('form.travel');

    // Participation — wildcard /{ld} LAST in this group
    Route::get('/',               [LdRequestController::class, 'index'])->name('index');
    Route::get('/create',         [LdRequestController::class, 'create'])->name('create');
    Route::post('/',              [LdRequestController::class, 'store'])->name('store');
    Route::get('/{ld}/show-modal',[LdRequestController::class, 'showModal'])->name('showModal');
    Route::get('/{ld}/edit-modal',[LdRequestController::class, 'editModal'])->name('editModal');
    Route::get('/{ld}/edit',      [LdRequestController::class, 'edit'])->name('edit');
    Route::put('/{ld}',           [LdRequestController::class, 'update'])->name('update');
    Route::get('/{ld}/print',     [LdRequestController::class, 'print'])->name('print');
    Route::delete('/{ld}',        [LdRequestController::class, 'destroy'])->name('destroy');
    Route::post('/{ld}/mov',      [LdRequestController::class, 'uploadMov'])->name('mov.upload');
    Route::get('/{ld}/mov/view',  [LdRequestController::class, 'viewMov'])->name('mov.view');

    // Attendance
    Route::post('/attendance',                        [LdAttendanceController::class, 'store'])->name('attendance.store');
    Route::put('/attendance/{attendance}',            [LdAttendanceController::class, 'update'])->name('attendance.update');
    Route::delete('/attendance/{attendance}',         [LdAttendanceController::class, 'destroy'])->name('attendance.destroy');
    Route::get('/attendance/{attendance}/show-modal', [LdAttendanceController::class, 'showModal'])->name('attendance.show-modal');
    Route::get('/attendance/{attendance}/edit-modal', [LdAttendanceController::class, 'editModal'])->name('attendance.edit-modal');
    Route::get('/attendance/{attendance}/print',      [LdAttendanceController::class, 'print'])->name('attendance.print');
    Route::post('/attendance/{attendance}/mov',       [LdAttendanceController::class, 'uploadMov'])->name('attendance.mov.upload');
    Route::get('/attendance/{attendance}/mov/view',   [LdAttendanceController::class, 'viewMov'])->name('attendance.mov.view');

    // Publication
    Route::post('/publication',                         [LdPublicationController::class, 'store'])->name('publication.store');
    Route::put('/publication/{publication}',            [LdPublicationController::class, 'update'])->name('publication.update');
    Route::delete('/publication/{publication}',         [LdPublicationController::class, 'destroy'])->name('publication.destroy');
    Route::get('/publication/{publication}/show-modal', [LdPublicationController::class, 'showModal'])->name('publication.show-modal');
    Route::get('/publication/{publication}/edit-modal', [LdPublicationController::class, 'editModal'])->name('publication.edit-modal');
    Route::get('/publication/{publication}/print',      [LdPublicationController::class, 'print'])->name('publication.print');
    Route::post('/publication/{publication}/mov',       [LdPublicationController::class, 'uploadMov'])->name('publication.mov.upload');
    Route::get('/publication/{publication}/mov/view',   [LdPublicationController::class, 'viewMov'])->name('publication.mov.view');

    // Reimbursement
    Route::post('/reimbursement',                           [LdReimbursementController::class, 'store'])->name('reimbursement.store');
    Route::put('/reimbursement/{reimbursement}',            [LdReimbursementController::class, 'update'])->name('reimbursement.update');
    Route::delete('/reimbursement/{reimbursement}',         [LdReimbursementController::class, 'destroy'])->name('reimbursement.destroy');
    Route::get('/reimbursement/{reimbursement}/show-modal', [LdReimbursementController::class, 'showModal'])->name('reimbursement.show-modal');
    Route::get('/reimbursement/{reimbursement}/edit-modal', [LdReimbursementController::class, 'editModal'])->name('reimbursement.edit-modal');
    Route::get('/reimbursement/{reimbursement}/print',      [LdReimbursementController::class, 'print'])->name('reimbursement.print');
    Route::post('/reimbursement/{reimbursement}/mov',       [LdReimbursementController::class, 'uploadMov'])->name('reimbursement.mov.upload');
    Route::get('/reimbursement/{reimbursement}/mov/view',   [LdReimbursementController::class, 'viewMov'])->name('reimbursement.mov.view');

    // Travel
    Route::post('/travel',                    [LdTravelController::class, 'store'])->name('travel.store');
    Route::put('/travel/{travel}',            [LdTravelController::class, 'update'])->name('travel.update');
    Route::delete('/travel/{travel}',         [LdTravelController::class, 'destroy'])->name('travel.destroy');
    Route::get('/travel/{travel}/show-modal', [LdTravelController::class, 'showModal'])->name('travel.show-modal');
    Route::get('/travel/{travel}/edit-modal', [LdTravelController::class, 'editModal'])->name('travel.edit-modal');
    Route::get('/travel/{travel}/print',      [LdTravelController::class, 'print'])->name('travel.print');
    Route::post('/travel/{travel}/mov',       [LdTravelController::class, 'uploadMov'])->name('travel.mov.upload');
    Route::get('/travel/{travel}/mov/view',   [LdTravelController::class, 'viewMov'])->name('travel.mov.view');

});