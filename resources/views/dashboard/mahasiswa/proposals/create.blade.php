<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Create Proposal Page">
    <x-navbars.sidebar activePage='proposals'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Create Proposal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h3 class="text-white mb-0">
                                    <i class="fas fa-edit me-2"></i>Buat Usulan Topik Skripsi
                                </h3>
                                <a href="{{ route('proposals.index') }}" class="btn btn-outline-light">
                                    <i class="fas fa-arrow-left me-2"></i>Kembali
                                </a>
                            </div>
                        </div>
                        <div class="card-body py-5">
                            @if ($errors->any())
                                <div class="alert alert-danger">
                                    <strong>Terjadi kesalahan!</strong> Silakan periksa inputan Anda.
                                    <ul class="mb-0">
                                        @foreach ($errors->all() as $error)
                                            <li class="text-sm">{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                </div>
                            @endif

                            <form action="{{ route('proposals.store') }}" id="proposalForm" method="POST">
                                @csrf

                                <!-- Section I: Pengusul -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user me-2 text-primary"></i>I. Pengusul
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label class="form-label">Nama Pengusul</label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                                disabled>
                                        </div>
                                        <div class="mb-3">
                                            <label class="form-label">NIM Pengusul</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->mahasiswa->nim }}" disabled>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section II: Topik -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-bookmark me-2 text-primary"></i>II. Topik
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 input-group input-group-outline">
                                            <label for="topic" class="form-label">Nama Topik</label>
                                            <input type="text" name="topic" id="topic" class="form-control"
                                                required>
                                        </div>
                                        <div class="mb-3 input-group input-group-static">
                                            <select name="subkbk_id" id="subkbk_id" class="form-control pb-4" required>
                                                <option value="">Pilih KBK</option>
                                                @foreach ($subkbks as $subkbk)
                                                    <option value="{{ $subkbk->id }}">{{ $subkbk->name }}</option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section III: Usulan Judul Skripsi -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-alt me-2 text-primary"></i>III. Usulan Judul Skripsi
                                        </h5>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-input"
                                            data-target="title-container">
                                            <i class="fas fa-plus me-1"></i> Tambah Judul
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="title-container">
                                            <div class="input-group mb-3 input-group-outline">
                                                <input type="text" name="titles[]" class="form-control"
                                                    placeholder="Masukkan Judul Skripsi" required>
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section IV: Latar Belakang Masalah -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-file-alt me-2 text-primary"></i>IV. Latar Belakang Masalah
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 input-group input-group-dynamic">
                                            <textarea name="background" id="background" class="form-control" rows="4"
                                                placeholder="Permasalahan yang Akan Diselesaikan" spellcheck="false"></textarea>
                                        </div>
                                        <div class="mb-3">
                                            <div id="reason-container">
                                                <div class="input-group input-group-outline mb-2">
                                                    <input type="text" name="backgroundReasons[]"
                                                        class="form-control" placeholder="Alasan Pemilihan Masalah">
                                                    <button type="button" class="btn btn-outline-danger remove-input">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            </div>
                                            <button type="button" class="btn btn-sm btn-outline-primary add-input mt-2"
                                                data-target="reason-container">
                                                <i class="fas fa-plus"></i> Tambah Alasan
                                            </button>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section V: Penelitian Sebelumnya -->
                                <div class="card mb-4">
                                    <div
                                        class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="fas fa-search me-2 text-primary"></i>V. Penelitian Sebelumnya
                                        </h5>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-research">
                                            <i class="fas fa-plus"></i> Tambah Penelitian
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="research-container">
                                            <div class="research-group mb-4">
                                                <div class="mb-3 input-group input-group-outline">
                                                    <label class="form-label">Judul Penelitian</label>
                                                    <input type="text" name="previousResearches[0][title]"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3 input-group input-group-outline">
                                                    <label class="form-label">DOI</label>
                                                    <input type="text" name="previousResearches[0][doi]"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3 input-group input-group-outline">
                                                    <label class="form-label">Penulis</label>
                                                    <input type="text" name="previousResearches[0][authors]"
                                                        class="form-control">
                                                </div>
                                                <div class="mb-3 input-group input-group-dynamic">
                                                    <textarea name="previousResearches[0][problem_statement]" class="form-control"
                                                        placeholder="Permasalahan yang Diangkat" rows="5" spellcheck="false"></textarea>
                                                </div>
                                                <div class="mb-3 input-group input-group-dynamic">
                                                    <textarea name="previousResearches[0][results]" class="form-control" rows="5" placeholder="Hasil Penelitian"
                                                        spellcheck="false"></textarea>
                                                </div>
                                                <button type="button" class="btn btn-outline-danger remove-research">
                                                    <i class="fas fa-trash-alt"></i> Hapus Penelitian
                                                </button>
                                            </div>
                                        </div>
                                    </div>
                                </div>

                                <!-- Section VI: Rumusan Masalah -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-question-circle me-2 text-primary"></i>VI. Rumusan Masalah
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="question-container">
                                            <div class="input-group input-group-outline mb-2">
                                                <input type="text" name="researchQuestions[]" class="form-control"
                                                    placeholder="Rumusan Masalah">
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-input mt-2"
                                            data-target="question-container">
                                            <i class="fas fa-plus"></i> Tambah Rumusan
                                        </button>
                                    </div>
                                </div>

                                <!-- Section VII: Output Penelitian -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-clipboard-check me-2 text-primary"></i>VII. Output
                                            Penelitian
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div id="output-container">
                                            <div class="input-group input-group-outline mb-2">
                                                <input type="text" name="outputs[]" class="form-control"
                                                    placeholder="Output Penelitian">
                                                <button type="button" class="btn btn-outline-danger remove-input">
                                                    <i class="fas fa-trash-alt"></i>
                                                </button>
                                            </div>
                                        </div>
                                        <button type="button" class="btn btn-sm btn-outline-primary add-input mt-2"
                                            data-target="output-container">
                                            <i class="fas fa-plus"></i> Tambah Output
                                        </button>
                                    </div>
                                </div>

                                <div class="card mb-4">
                                    <div
                                        class="card-header bg-light d-flex justify-content-between align-items-center">
                                        <h5 class="mb-0">
                                            <i class="fas fa-book me-2 text-primary"></i>VIII. Layout Pemecahan Masalah
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3 input-group input-group-dynamic">
                                            <textarea name="methodology" class="form-control" placeholder="Permasalahan yang Diangkat" rows="5"
                                                spellcheck="false"></textarea>
                                        </div>

                                    </div </div>

                                    <!-- Submit Button -->
                                    <div class="d-flex justify-content-center mt-4">
                                        <button type="submit" class="btn btn-success">Submit Proposal</button>
                                    </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    @push('scripts')
        <script>
            document.addEventListener('DOMContentLoaded', function() {
                const form = document.getElementById('proposalForm');

                // Generic function to add input fields
                function addInput(containerId, inputName, placeholder) {
                    const container = document.getElementById(containerId);
                    const newInput = document.createElement('div');
                    newInput.className = 'input-group input-group-outline mb-2';
                    newInput.innerHTML = `
                    <input type="text" name="${inputName}[]" class="form-control" placeholder="${placeholder}" required>
                    <button type="button" class="btn btn-outline-danger remove-input">
                        <i class="fas fa-trash-alt"></i>
                    </button>
                `;
                    container.appendChild(newInput);
                }

                // Add input field
                form.addEventListener('click', function(e) {
                    if (e.target.classList.contains('add-input')) {
                        const target = e.target.dataset.target;
                        const inputName = target.replace('-container', '');
                        const placeholder = e.target.textContent.trim().replace('Tambah ', '');
                        addInput(target, inputName, placeholder);
                    }
                });

                // Remove input field
                form.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-input') || e.target.closest('.remove-input')) {
                        const inputGroup = e.target.closest('.input-group');
                        if (inputGroup) {
                            inputGroup.remove();
                        }
                    }
                });

                // Add research group
                const addResearchBtn = document.querySelector('.add-research');
                const researchContainer = document.getElementById('research-container');
                let researchCount = 1;

                addResearchBtn.addEventListener('click', function() {
                    const newResearch = document.createElement('div');
                    newResearch.className = 'research-group mb-4';
                    newResearch.innerHTML = `
                    <div class="mb-3 input-group input-group-outline">
                        <label class="form-label">Judul Penelitian</label>
                        <input type="text" name="previousResearches[${researchCount}][title]" class="form-control">
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <label class="form-label">DOI</label>
                        <input type="text" name="previousResearches[${researchCount}][doi]" class="form-control">
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <label class="form-label">Penulis</label>
                        <input type="text" name="previousResearches[${researchCount}][authors]" class="form-control">
                    </div>
                    <div class="mb-3 input-group input-group-dynamic">
                        <textarea name="previousResearches[${researchCount}][problem_statement]" class="form-control" rows="5" placeholder="Permasalahan yang Diangkat" spellcheck="false"></textarea>
                    </div>
                    <div class="mb-3 input-group input-group-dynamic">
                        <textarea name="previousResearches[${researchCount}][results]" class="form-control" rows="5" placeholder="Hasil Penelitian" spellcheck="false"></textarea>
                    </div>
                    <button type="button" class="btn btn-outline-danger remove-research">
                        <i class="fas fa-trash-alt"></i> Hapus Penelitian
                    </button>
                `;
                    researchContainer.appendChild(newResearch);
                    researchCount++;
                });

                // Remove research group
                researchContainer.addEventListener('click', function(e) {
                    if (e.target.classList.contains('remove-research') || e.target.closest(
                            '.remove-research')) {
                        const researchGroup = e.target.closest('.research-group');
                        if (researchGroup) {
                            researchGroup.remove();
                        }
                    }
                });
            });
        </script>
    @endpush
</x-layout>
