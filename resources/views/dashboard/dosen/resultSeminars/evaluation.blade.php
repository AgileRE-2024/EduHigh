<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Evaluate Seminar Hasil">
    <x-navbars.sidebar activePage='seminar-hasil'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Evaluate Seminar Hasil"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <h2 class="text-white mb-0">
                                <i class="fas fa-chalkboard-teacher me-2"></i> Evaluate Seminar Hasil
                            </h2>
                            <p class="text-white text-sm mb-0 opacity-8">
                                Mahasiswa: {{ $resultSeminar->mahasiswa->user->name }}
                                ({{ $resultSeminar->mahasiswa->nim }})
                            </p>
                        </div>
                        <div class="card-body p-4">
                            <form id="evaluationForm"
                                action="{{ route('resultSeminars.updateEvaluation', $resultSeminar) }}" method="POST">
                                @csrf
                                @method('PUT')

                                <input type="hidden" name="material_result_assessment_id"
                                    value="{{ $materialAssessment->id }}">
                                <input type="hidden" name="presentation_result_assessment_id"
                                    value="{{ $presentationAssessment->id }}">

                                <!-- Materi Assessment -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Materi Assessment</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($materialAssessment->resultAssessmentCriterias as $resultAssessmentCriteria)
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label
                                                        class="form-label mb-0">{{ $resultAssessmentCriteria->resultCriteria->name }}</label>
                                                    <span class="badge bg-primary">Weight:
                                                        {{ $resultAssessmentCriteria->resultCriteria->weight }}%</span>
                                                </div>
                                                <input type="number"
                                                    name="materials[{{ $resultAssessmentCriteria->id }}]"
                                                    class="form-control" min="0" max="100" step="0.01"
                                                    value="{{ $resultAssessmentCriteria->score ?? '' }}" required>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <!-- Presentasi Assessment -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">Presentasi Assessment</h5>
                                    </div>
                                    <div class="card-body">
                                        @foreach ($presentationAssessment->resultAssessmentCriterias as $resultAssessmentCriteria)
                                            <div class="mb-4">
                                                <div class="d-flex justify-content-between align-items-center mb-2">
                                                    <label
                                                        class="form-label mb-0">{{ $resultAssessmentCriteria->resultCriteria->name }}</label>
                                                    <span class="badge bg-primary">Weight:
                                                        {{ $resultAssessmentCriteria->resultCriteria->weight }}%</span>
                                                </div>
                                                <input type="number"
                                                    name="presentations[{{ $resultAssessmentCriteria->id }}]"
                                                    class="form-control" min="0" max="100" step="0.01"
                                                    value="{{ $resultAssessmentCriteria->score ?? '' }}" required>
                                            </div>
                                        @endforeach
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('resultSeminars.index') }}" class="btn btn-light me-2">Cancel</a>
                                    <button type="button" class="btn bg-gradient-primary" data-bs-toggle="modal"
                                        data-bs-target="#confirmationModal">
                                        <i class="fas fa-save me-2"></i>Save Assessment
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Confirmation Modal -->
    <div class="modal fade" id="confirmationModal" tabindex="-1" aria-labelledby="confirmationModalLabel"
        aria-hidden="true">
        <div class="modal-dialog modal-dialog-centered">
            <div class="modal-content border-0 shadow-lg">
                <div class="modal-header bg-warning text-white border-0">
                    <h5 class="modal-title fw-bold text-white" id="confirmationModalLabel">
                        <i class="fas fa-exclamation-triangle text-white me-2"></i>Konfirmasi Penilaian
                    </h5>
                    <button type="button" class="btn-close btn-close-white" data-bs-dismiss="modal"
                        aria-label="Close"></button>
                </div>
                <div class="modal-body px-4 py-4">
                    <div class="d-flex align-items-center mb-3">
                        <div class="rounded-circle bg-warning bg-opacity-10 p-3 me-3">
                            <i class="fas fa-question-circle text-white fs-4"></i>
                        </div>
                        <p class="mb-0 fs-5">Apakah Anda yakin ingin menyimpan penilaian ini?</p>
                    </div>
                    <div class="alert alert-warning border-0 d-flex align-items-center">
                        <i class="fas fa-info-circle text-white me-2"></i>
                        <p class="mb-0 text-white">Pastikan semua data yang Anda masukkan sudah benar.</p>
                    </div>
                </div>
                <div class="modal-footer border-0 px-4 pb-4">
                    <button type="button" class="btn btn-light px-4" data-bs-dismiss="modal">
                        <i class="fas fa-times me-2"></i>Batal
                    </button>
                    <button type="button" class="btn btn-warning px-4"
                        onclick="document.getElementById('evaluationForm').submit();">
                        <i class="fas fa-check me-2"></i>Ya, Simpan
                    </button>
                </div>
            </div>
        </div>
    </div>
</x-layout>
