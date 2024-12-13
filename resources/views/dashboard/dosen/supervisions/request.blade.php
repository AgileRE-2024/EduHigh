<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Supervision Requests">
    <x-navbars.sidebar activePage='pengajuan-mahasiswa'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Pengajuan Mahasiswa"></x-navbars.navs.auth>

        <div class="container-fluid py-4">

            <div class="card shadow-lg">
                <!-- Card Header -->
                <div class="card-header bg-gradient-primary p-4">
                    <div class="d-flex justify-content-between align-items-center">
                        <div>
                            <h4 class="text-white mb-0">
                                <i class="fas fa-user-clock me-2"></i>Pengajuan Mahasiswa
                            </h4>
                            <p class="text-white text-sm mb-0 opacity-8">
                                Kelola dan tindak lanjuti pengajuan bimbingan mahasiswa Anda
                            </p>
                        </div>
                    </div>
                </div>

                <div class="card-body p-0">
                    @if ($students->isEmpty())
                        <div class="text-center py-5">
                            <div class="empty-state">
                                <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                                <h5 class="text-muted">Belum Ada Pengajuan</h5>
                                <p class="text-sm text-muted">Belum ada mahasiswa yang mengajukan bimbingan</p>
                            </div>
                        </div>
                    @else
                        <div class="list-group list-group-flush" id="student-container">
                            @foreach ($students as $student)
                                <div class="list-group-item student-item p-4" data-supervision-id="{{ $student->id }}">
                                    <div class="row align-items-center">
                                        <div class="col-auto">
                                            <div class="avatar avatar-xl bg-gradient-primary rounded-circle">
                                                {{ strtoupper(substr($student->mahasiswa->user->name, 0, 1)) }}
                                            </div>
                                        </div>
                                        <div class="col ml-n2">
                                            <h5 class="mb-1">
                                                <a href="{{ route('supervisions.showMahasiswa', $student->mahasiswa) }}"
                                                    class="text-dark text-decoration-none">
                                                    {{ $student->mahasiswa->user->name }}
                                                </a>
                                            </h5>
                                            <p class="text-sm text-muted mb-0">
                                                <i class="fas fa-id-card me-2"></i>{{ $student->mahasiswa->nim }}
                                            </p>
                                            <p class="text-sm text-muted mb-0">
                                                <i
                                                    class="fas fa-envelope me-2"></i>{{ $student->mahasiswa->user->email }}
                                            </p>
                                        </div>
                                        <div class="col-auto">
                                            <div class="d-flex gap-2">
                                                <button type="button" class="btn btn-info btn-sm px-3"
                                                    data-bs-toggle="modal"
                                                    data-bs-target="#proposalModal{{ $student->id }}">
                                                    <i class="fas fa-eye me-2"></i>Lihat Proposal
                                                </button>
                                            </div>
                                        </div>
                                        <div class="modal fade" id="proposalModal{{ $student->id }}" tabindex="-1"
                                            aria-labelledby="proposalModalLabel{{ $student->id }}" aria-hidden="true">
                                            <div class="modal-dialog modal-lg">
                                                <div class="modal-content">
                                                    <div class="modal-header">
                                                        <h5 class="modal-title"
                                                            id="proposalModalLabel{{ $student->id }}">
                                                            Proposal {{ $student->name }}
                                                        </h5>
                                                        <button type="button" class="btn-close" data-bs-dismiss="modal"
                                                            aria-label="Close"></button>
                                                    </div>
                                                    <div class="modal-body">
                                                        @if ($student->mahasiswa->user->proposal)
                                                            <!-- Section I: Pengusul -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i class="fas fa-user me-2 text-primary"></i>I.
                                                                        Pengusul
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p><strong>Nama:</strong>
                                                                        {{ $student->mahasiswa->user->name }}</p>
                                                                    <p><strong>NIM:</strong>
                                                                        {{ $student->mahasiswa->nim }}</p>
                                                                </div>
                                                            </div>

                                                            <!-- Section II: Topik -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-bookmark me-2 text-primary"></i>II.
                                                                        Topik
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p><strong>Nama Topik:</strong>
                                                                        {{ $student->mahasiswa->user->proposal->topic ?? 'Belum ditentukan' }}
                                                                    </p>
                                                                    <p><strong>KBK:</strong>
                                                                        {{ $student->mahasiswa->user->proposal->subkbk->name ?? 'Belum ditentukan' }}
                                                                    </p>
                                                                </div>
                                                            </div>

                                                            <!-- Section III: Judul Skripsi -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-lightbulb me-2 text-primary"></i>III.
                                                                        Usulan Judul Skripsi
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($student->mahasiswa->user->proposal->titles->isEmpty())
                                                                        <p class="text-muted">Belum ada judul skripsi
                                                                            yang diusulkan.</p>
                                                                    @else
                                                                        <ol>
                                                                            @foreach ($student->mahasiswa->user->proposal->titles as $title)
                                                                                <li>{{ $title->name }}</li>
                                                                            @endforeach
                                                                        </ol>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Section IV: Latar Belakang -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-file-alt me-2 text-primary"></i>IV.
                                                                        Latar Belakang Masalah
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p><strong>a. Permasalahan yang akan
                                                                            diselesaikan:</strong></p>
                                                                    <p>{{ $student->mahasiswa->user->proposal->background ?? 'Belum diisi' }}
                                                                    </p>
                                                                    <p><strong>b. Alasan pemilihan masalah:</strong></p>
                                                                    @if ($student->mahasiswa->user->proposal->backgroundReasons->isEmpty())
                                                                        <p class="text-muted">Belum ada alasan pemilihan
                                                                            masalah.</p>
                                                                    @else
                                                                        <ul>
                                                                            @foreach ($student->mahasiswa->user->proposal->backgroundReasons as $reason)
                                                                                <li>{{ $reason->reason }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Section V: Penelitian Sebelumnya -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-search me-2 text-primary"></i>V.
                                                                        Penelitian Sebelumnya
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($student->mahasiswa->user->proposal->previousResearches->isEmpty())
                                                                        <p class="text-muted">Belum ada penelitian
                                                                            sebelumnya yang diinput.</p>
                                                                    @else
                                                                        @foreach ($student->mahasiswa->user->proposal->previousResearches as $previousResearch)
                                                                            <div class="mb-3">
                                                                                <p><strong>Judul:</strong>
                                                                                    {{ $previousResearch->title }}</p>
                                                                                <p><strong>Penulis:</strong>
                                                                                    {{ $previousResearch->authors }}
                                                                                </p>
                                                                                <p><strong>DOI:</strong>
                                                                                    {{ $previousResearch->doi }}</p>
                                                                                <p><strong>Permasalahan yang
                                                                                        diangkat:</strong>
                                                                                    {{ $previousResearch->problem_statement }}
                                                                                </p>
                                                                                <p><strong>Hasil penelitian:</strong>
                                                                                    {{ $previousResearch->results }}
                                                                                </p>
                                                                            </div>
                                                                        @endforeach
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Section VI: Rumusan Masalah -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-question-circle me-2 text-primary"></i>VI.
                                                                        Rumusan Masalah
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($student->mahasiswa->user->proposal->researchQuestions->isEmpty())
                                                                        <p class="text-muted">Belum ada rumusan masalah
                                                                            yang diinput.</p>
                                                                    @else
                                                                        <ul>
                                                                            @foreach ($student->mahasiswa->user->proposal->researchQuestions as $researchQuestion)
                                                                                <li>{{ $researchQuestion->question }}
                                                                                </li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Section VII: Output Penelitian -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-clipboard-check me-2 text-primary"></i>VII.
                                                                        Output Penelitian
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    @if ($student->mahasiswa->user->proposal->outputs->isEmpty())
                                                                        <p class="text-muted">Belum ada output
                                                                            penelitian yang diinput.</p>
                                                                    @else
                                                                        <ul>
                                                                            @foreach ($student->mahasiswa->user->proposal->outputs as $output)
                                                                                <li>{{ $output->research_output }}</li>
                                                                            @endforeach
                                                                        </ul>
                                                                    @endif
                                                                </div>
                                                            </div>

                                                            <!-- Section VIII: Layout Pemecahan Masalah -->
                                                            <div class="card mb-4">
                                                                <div class="card-header bg-light">
                                                                    <h5 class="mb-0">
                                                                        <i
                                                                            class="fas fa-clipboard-check me-2 text-primary"></i>VIII.
                                                                        Layout Pemecahan Masalah
                                                                    </h5>
                                                                </div>
                                                                <div class="card-body">
                                                                    <p><strong>Metode Penelitian:</strong>
                                                                        {{ $student->mahasiswa->user->proposal->methodology ?? 'Belum diisi' }}
                                                                    </p>
                                                                </div>
                                                            </div>
                                                        @else
                                                            <!-- Empty State -->
                                                            <div class="empty-state text-center py-5">
                                                                <div class="empty-state-icon mb-4">
                                                                    <i class="fas fa-file-alt fa-4x text-muted"></i>
                                                                </div>
                                                                <h5 class="text-muted">Belum Ada Proposal</h5>
                                                                <p class="text-sm text-muted mb-4">Mahasiswa belum
                                                                    membuat proposal skripsi.</p>
                                                            </div>
                                                        @endif
                                                    </div>
                                                    <div class="modal-footer">
                                                        <button type="button" class="btn btn-secondary"
                                                            data-bs-dismiss="modal">Tutup</button>
                                                        <button type="button" class="btn btn-success approve-btn"
                                                            data-supervision-id="{{ $student->id }}">Setujui</button>
                                                        <button type="button" class="btn btn-danger reject-btn"
                                                            data-supervision-id="{{ $student->id }}">Tolak</button>
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            @endforeach
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>

    <!-- Optional JavaScript for search functionality -->
    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                // Modal functionality
                const modals = document.querySelectorAll('.modal');
                modals.forEach(modal => {
                    modal.addEventListener('shown.bs.modal', function() {});
                });

                const approveButtons = document.querySelectorAll('.approve-btn');
                const rejectButtons = document.querySelectorAll('.reject-btn');

                approveButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const supervisionId = this.getAttribute('data-supervision-id');
                        updateSupervision(supervisionId, 'approve');
                    });
                });

                rejectButtons.forEach(button => {
                    button.addEventListener('click', function() {
                        const supervisionId = this.getAttribute('data-supervision-id');
                        updateSupervision(supervisionId, 'reject');
                    });
                });

                function checkEmptyState() {
                    const studentContainer = document.querySelector('#student-container');
                    if (!studentContainer) {
                        console.error('Student container not found');
                        return;
                    }

                    const studentItems = studentContainer.querySelectorAll('.student-item');

                    if (studentItems.length === 0) {
                        studentContainer.innerHTML = `
            <div class="text-center py-5">
                <div class="empty-state">
                    <i class="fas fa-inbox fa-4x text-muted mb-3"></i>
                    <h5 class="text-muted">Belum Ada Pengajuan</h5>
                    <p class="text-sm text-muted">Belum ada mahasiswa yang mengajukan bimbingan</p>
                </div>
            </div>
        `;
                    }
                }

                function updateSupervision(supervisionId, action) {
                    const url = `/dashboard/supervisions/${supervisionId}/${action}`;
                    const csrfToken = document.querySelector('meta[name="csrf-token"]')?.getAttribute('content');

                    if (!csrfToken) {
                        console.error('CSRF token not found');
                        return;
                    }

                    fetch(url, {
                            method: 'PATCH',
                            headers: {
                                'Content-Type': 'application/json',
                                'X-CSRF-TOKEN': csrfToken
                            },
                            body: JSON.stringify({
                                supervision_id: supervisionId
                            })
                        })
                        .then(response => response.json())
                        .then(data => {
                            if (data.success) {
                                // Close the modal
                                const modal = document.querySelector(`#proposalModal${supervisionId}`);
                                if (modal) {
                                    const bsModal = bootstrap.Modal.getInstance(modal);
                                    bsModal?.hide();
                                }
                                const studentItem = document.querySelector(
                                    `.student-item[data-supervision-id="${supervisionId}"]`);
                                if (studentItem) {
                                    studentItem.remove();
                                    checkEmptyState();
                                }
                            }
                        })
                        .catch(error => {
                            console.error('Error:', error);
                            alert('Terjadi kesalahan. Silakan coba lagi.');
                        });
                }
            });
        </script>
    @endpush
</x-layout>
