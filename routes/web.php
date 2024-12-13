<?php

use Illuminate\Support\Facades\Route;
use App\Models\Dosen;
use Illuminate\Http\Request;
use App\Http\Controllers\DashboardController;
use App\Http\Controllers\ProfileController;
use App\Http\Controllers\ProposalController;
use App\Http\Controllers\SuperVisionController;
use App\Http\Controllers\ScheduleController;
use App\Http\Controllers\AppointmentController;
use App\Http\Controllers\LogbookController;
use App\Http\Controllers\ProposalAssessmentController;
use App\Http\Controllers\ProposalCriteriaController;
use App\Http\Controllers\ResultSeminarController;
use App\Http\Controllers\ResultSeminarReviewController;
use App\Http\Controllers\SeminarProposalController;
use App\Http\Controllers\SeminarProposalReviewController;
use App\Models\SeminarProposal;

Route::get('/', function () {
    return view('welcome');
})->name('home');

Route::get('/api/dosens', function (Request $request) {
    $kbkId = $request->query('kbk_id');
    $mahasiswaId = $request->query('mahasiswa_id');

    // Get the dosen who are not already Pembimbing 1 for the given mahasiswa
    $dosens = Dosen::where('kbk_id', $kbkId)
        ->whereDoesntHave('superVisions', function ($query) use ($mahasiswaId) {
            $query->where('mahasiswa_id', $mahasiswaId)
                ->where('dosen_pembimbing', 'pembimbing_1');
        })
        ->with('user')
        ->get();

    return response()->json($dosens);
});


Route::middleware(['auth', 'verified'])->prefix('/dashboard')->group(function () {
    Route::get('/', [DashboardController::class, 'index'])->name('dashboard');
    Route::get('/profile', [ProfileController::class, 'index'])->name('profile.index');
    Route::get('/profile/edit', [ProfileController::class, 'edit'])->name('profile.edit');
    Route::put('/profile', [ProfileController::class, 'update'])->name('profile.update');
    Route::delete('/profile', [ProfileController::class, 'destroy'])->name('profile.destroy');
    Route::resource('proposals', ProposalController::class);
    Route::resource('schedules', ScheduleController::class);
    Route::resource('proposalCriterias', ProposalCriteriaController::class);
    Route::post('/resultSeminars/resubmission', [ResultSeminarController::class, 'resubmission'])->name('resultSeminars.resubmission');
    Route::get('/resultSeminars/delegate', [ResultSeminarController::class, 'delegate'])->name('resultSeminars.delegate');
    Route::get('/resultSeminars/request', [ResultSeminarController::class, 'request'])->name('resultSeminars.request');
    Route::get('/resultSeminars/{resultSeminar}/evaluation', [resultSeminarController::class, 'evaluation'])->name('resultSeminars.evaluation');
    Route::put('/resultSeminars/{resultSeminar}/updateEvaluation', [ResultSeminarController::class, 'updateEvaluation'])->name('resultSeminars.updateEvaluation');
    Route::get('/resultSeminars/{resultSeminar}/exportBeritaAcara', [ResultSeminarController::class, 'exportBeritaAcara'])->name('resultSeminars.exportBeritaAcara');
    Route::post('/resultSeminarReview', [ResultSeminarReviewController::class, 'review'])->name('resultSeminarReview');
    Route::resource('resultSeminars', ResultSeminarController::class);
    Route::get('/seminarproposals/{seminarproposal}/evaluation', [SeminarProposalController::class, 'evaluation'])->name('seminarproposal.evaluation');
    Route::get('/seminarproposals/delegate', [SeminarProposalController::class, 'delegate'])->name('seminarproposals.delegate');
    Route::put('/seminarproposals/{seminarproposal}/updateEvaluation', [SeminarProposalController::class, 'updateEvaluation'])->name('seminarproposal.updateEvaluation');
    Route::post('/seminarproposals/resubmission', [SeminarProposalController::class, 'resubmission'])->name('seminarproposals.resubmission');
    Route::get('/seminarproposals/request', [SeminarProposalController::class, 'request'])->name('seminarproposals.request');
    Route::get('/seminarproposals/{seminarproposal}/exportBeritaAcara', [SeminarProposalController::class, 'exportBeritaAcara'])->name('seminarproposals.exportBeritaAcara');
    Route::post('/seminar-proposal-review', [SeminarProposalReviewController::class, 'review'])->name('seminar-proposal-review');
    Route::resource('seminarproposals', SeminarProposalController::class);
    Route::get('/supervisions/koordinasi', [SuperVisionController::class, 'showKoordinasiPembimbing'])->name('supervisions.showKoordinasiPembimbing');
    Route::post('/supervisions/assign-pembimbing2', [SupervisionController::class, 'assignPembimbing2'])->name('supervisions.assignPembimbing2');
    Route::get('/supervisions/request', [SuperVisionController::class, 'request'])->name('supervisions.request');
    Route::get('/supervisions/dosen/{dosen}', [SuperVisionController::class, 'showDosen'])->name('supervisions.showDosen');
    Route::get('/supervisions/mahasiswa/{mahasiswa}', [SuperVisionController::class, 'showMahasiswa'])->name('supervisions.showMahasiswa');
    Route::patch('/supervisions/{supervision}/{action}', [SuperVisionController::class, 'updateStatus'])
        ->name('supervisions.updateStatus')
        ->where('action', 'approve|reject');
    Route::get('/seminarproposals/{seminarproposal}/available-dosens', [SeminarProposalController::class, 'getAvailableDosens'])
        ->name('seminarproposals.available-dosens');
    Route::get('/resultSeminars/{resultSeminar}/available-dosens', [ResultSeminarController::class, 'getAvailableDosens'])
        ->name('resultSeminars.available-dosens');
    Route::put(
        '/resultSeminars/{resultSeminar}/assign-penguji',
        [ResultSeminarController::class, 'assignPenguji']
    )->name('resultSeminars.assign-penguji');

    Route::put(
        '/seminarproposals/{seminarproposal}/assign-penguji',
        [SeminarProposalController::class, 'assignPenguji']
    )
        ->name('seminarproposals.assign-penguji');
    Route::resource('supervisions', SuperVisionController::class);
    Route::resource('appointments', AppointmentController::class);
    Route::get('/logbooks/filter', [LogbookController::class, 'filter'])->name('logbooks.filter');
    Route::post('/logbooks/export', [LogbookController::class, 'export'])->name('logbooks.export');
    Route::put('/logbooks/confirmLogbook/{logbook}', [LogbookController::class, 'confirmLogbook'])->name('logbooks.confirmLogbook');
    Route::resource('logbooks', LogbookController::class);
});

Route::get('viewPdf', [LogbookController::class, 'viewPdf'])->name('viewPdf');
Route::get('berita', [SeminarProposalController::class, 'viewBeritaAcara'])->name('viewBeritaAcara');
Route::get('beritaResult', [ResultSeminarController::class, 'viewBeritaAcara'])->name('viewBeritaAcaraResult');

require __DIR__ . '/auth.php';
