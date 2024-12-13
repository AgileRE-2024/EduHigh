@php
    $titles = old('titles', $proposal->titles ?? []);
    $backgroundReasons = old('backgroundReasons', $proposal->backgroundReasons ?? []);
    $previousResearches = old('previousResearches', $proposal->previousResearches ?? []);
    $researchQuestions = old('researchQuestions', $proposal->researchQuestions ?? []);
    $outputs = old('outputs', $proposal->outputs ?? []);
@endphp




<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Edit Proposal Page">
    <x-navbars.sidebar activePage='proposals'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Edit Proposal"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-body py-5">
                            <div class="card-header bg-gradient-primary p-4">
                                <div class="d-flex justify-content-between align-items-center">
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-edit me-2"></i>Edit Usulan Topik Skripsi
                                    </h3>
                                    <a href="{{ route('proposals.index') }}" class="btn btn-outline-light">
                                        <i class="fas fa-arrow-left me-2"></i>Kembali
                                    </a>
                                </div>
                            </div>

                            <!-- Display validation errors -->
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

                            <!-- Proposal Edit Form -->
                            <form action="{{ route('proposals.update', $proposal->id) }}" id="profileForm"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user me-2 text-primary"></i>I. Pengusul
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Nama Pengusul -->
                                        <div class="mb-3">
                                            <label class="form-label">Nama Pengusul</label>
                                            <input type="text" class="form-control" value="{{ Auth::user()->name }}"
                                                disabled>
                                        </div>
                                        <!-- NIM Pengusul -->
                                        <div class="mb-3">
                                            <label class="form-label">NIM Pengusul</label>
                                            <input type="text" class="form-control"
                                                value="{{ Auth::user()->mahasiswa->nim }}" disabled>
                                        </div>
                                    </div>
                                </div>


                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-bookmark me-2 text-primary"></i>II. Topik
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <!-- Nama Topik -->
                                        <div class="mb-3">
                                            <label for="topic" class="form-label">Nama Topik</label>
                                            <input type="text" name="topic" id="topic" class="form-control"
                                                value="{{ old('topic', $proposal->topic) }}" required>
                                        </div>
                                        <!-- KBK Selection -->
                                        <div class="mb-3">
                                            <label for="subkbk_id" class="form-label">KBK (Pilih Salah Satu)</label>
                                            <select name="subkbk_id" id="subkbk_id" class="form-select" required>
                                                <option value="">Pilih KBK</option>
                                                @foreach ($subkbks as $subkbk)
                                                    <option value="{{ $subkbk->id }}"
                                                        {{ old('subkbk_id', $proposal->subkbk_id) == $subkbk->id ? 'selected' : '' }}>
                                                        {{ $subkbk->name }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        </div>
                                    </div>
                                </div>
                                <div class="card border-0 shadow-lg mb-4">
                                    <div
                                        class="card-header bg-light text-white d-flex justify-content-between align-items-center py-3">
                                        <h5 class="mb-0 d-flex align-items-center">
                                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24"
                                                viewBox="0 0 24 24" fill="none" stroke="currentColor"
                                                class="me-2 text-primary">
                                                <path
                                                    d="M14.5 2H6a2 2 0 0 0-2 2v16a2 2 0 0 0 2 2h12a2 2 0 0 0 2-2V7.5L14.5 2z">
                                                </path>
                                                <polyline points="14 2 14 8 20 8"></polyline>
                                                <line x1="16" y1="13" x2="8" y2="13">
                                                </line>
                                                <line x1="16" y1="17" x2="8" y2="17">
                                                </line>
                                                <line x1="10" y1="9" x2="8" y2="9">
                                                </line>
                                            </svg>
                                            III. Usulan Judul Skripsi
                                        </h5>
                                        <button type="button" id="add-title"
                                            class="btn btn-sm btn-outline-primary text-primary bg-light px-3">
                                            <i class="fas fa-plus me-1"></i> Tambah Judul
                                        </button>
                                    </div>
                                    <div class="card-body bg-white">
                                        <div id="title-container">
                                            @foreach (old('titles', $proposal->titles) as $index => $title)
                                                <div class="input-group mb-3">
                                                    <input type="text" name="titles[]"
                                                        class="form-control form-control-lg border-primary"
                                                        value="{{ $title->name ?? $title }}"
                                                        placeholder="Masukkan Judul Skripsi" required>
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-input px-3">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            @endforeach
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
                                        <!-- Permasalahan yang akan diselesaikan -->
                                        <div class="mb-3">
                                            <label for="background" class="form-label">Permasalahan yang Akan
                                                Diselesaikan</label>
                                            <textarea name="background" id="background" class="form-control" rows="4" required>{{ old('background', $proposal->background) }}</textarea>
                                        </div>
                                        <!-- Alasan Pemilihan Masalah -->
                                        <div class="mb-3">
                                            <label class="form-label">Alasan Pemilihan Masalah</label>
                                            <div id="reason-container">
                                                @foreach (old('backgroundReasons', $proposal->backgroundReasons) as $index => $reason)
                                                    <div class="input-group mb-2">
                                                        <input type="text" name="backgroundReasons[]"
                                                            class="form-control"
                                                            value="{{ $reason->reason ?? $reason }}" required>
                                                        <button type="button"
                                                            class="btn btn-outline-danger remove-input">
                                                            <i class="fas fa-trash-alt"></i>
                                                        </button>
                                                    </div>
                                                @endforeach
                                            </div>
                                            <button type="button" id="add-reason"
                                                class="btn btn-sm btn-outline-primary mt-2">
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
                                        <button type="button" id="add-research"
                                            class="btn btn-sm btn-outline-primary">
                                            <i class="fas fa-plus"></i> Tambah Penelitian
                                        </button>
                                    </div>
                                    <div class="card-body">
                                        <div id="research-container">
                                            @foreach (old('previousResearches', $proposal->previousResearches) as $index => $research)
                                                <div class="research-group position-relative">
                                                    <button type="button"
                                                        class="btn btn-outline-danger btn-sm position-absolute top-0 end-0 m-2 remove-research">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                    <div class="mb-3">
                                                        <label class="form-label">Judul Penelitian</label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][title]"
                                                            class="form-control"
                                                            value="{{ $research->title ?? $research['title'] }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">DOI</label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][doi]"
                                                            class="form-control"
                                                            value="{{ $research->doi ?? $research['doi'] }}" required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Penulis</label>
                                                        <input type="text"
                                                            name="previousResearches[{{ $index }}][authors]"
                                                            class="form-control"
                                                            value="{{ $research->authors ?? $research['authors'] }}"
                                                            required>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Permasalahan yang Diangkat</label>
                                                        <textarea name="previousResearches[{{ $index }}][problem_statement]" class="form-control" rows="3"
                                                            required>{{ $research->problem_statement ?? $research['problem_statement'] }}</textarea>
                                                    </div>
                                                    <div class="mb-3">
                                                        <label class="form-label">Hasil Penelitian</label>
                                                        <textarea name="previousResearches[{{ $index }}][results]" class="form-control" rows="3" required>{{ $research->results ?? $research['results'] }}</textarea>
                                                    </div>
                                                </div>
                                            @endforeach
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
                                            @foreach (old('researchQuestions', $proposal->researchQuestions) as $index => $question)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="researchQuestions[]"
                                                        class="form-control"
                                                        value="{{ $question->question ?? $question }}" required>
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-input">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-question"
                                            class="btn btn-sm btn-outline-primary mt-2">
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
                                            @foreach (old('outputs', $proposal->outputs) as $index => $output)
                                                <div class="input-group mb-2">
                                                    <input type="text" name="outputs[]" class="form-control"
                                                        value="{{ $output->research_output ?? $output }}" required>
                                                    <button type="button"
                                                        class="btn btn-outline-danger remove-input">
                                                        <i class="fas fa-trash-alt"></i>
                                                    </button>
                                                </div>
                                            @endforeach
                                        </div>
                                        <button type="button" id="add-output"
                                            class="btn btn-sm btn-outline-primary mt-2">
                                            <i class="fas fa-plus"></i> Tambah Output
                                        </button>
                                    </div>
                                </div>

                                <!-- Section VIII: Metode Penelition -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-flask me-2 text-primary"></i>VIII. Layout Pemecahan
                                            Masalah
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <div class="mb-3">
                                            <label for="methodology" class="form-label">Metode Penelitian</label>
                                            <textarea name="methodology" id="methodology" class="form-control" rows="4" required>{{ old('methodology', $proposal->methodology) }}</textarea>
                                        </div>
                                    </div>
                                </div>


                                <!-- Submit Button -->
                                <div class="d-flex justify-content-end">
                                    <button type="submit" class="btn btn-success">
                                        <i class="fas fa-save me-2"></i>Perbarui Proposal
                                    </button>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', () => {
        let titleCount = 1;
        let reasonCount = 1;
        let researchCount = 1;
        let questionCount = 1;
        let outputCount = 1;

        const addTitleButton = document.getElementById('add-title');
        const titleContainer = document.getElementById('title-container');
        // Menambahkan event listener saat tombol tambah judul diklik
        addTitleButton.addEventListener('click', () => {
            const titleInputGroup = document.createElement('div');
            titleInputGroup.className = 'input-group mb-3';

            // Hitung jumlah input saat ini untuk nomor urut
            const currentCount = titleContainer.children.length + 1;

            titleInputGroup.innerHTML = `
            <input type="text" name="titles[]" class="form-control form-control-lg border-primary" 
                   placeholder="Masukkan Judul Skripsi" required>
            <button type="button" class="btn btn-outline-danger remove-input px-3">
                <i class="fas fa-trash-alt"></i>
            </button>
        `;

            titleContainer.appendChild(titleInputGroup);
        });

        // Event delegation untuk menghapus input
        titleContainer.addEventListener('click', function(event) {
            const removeButton = event.target.closest('.remove-input');
            if (removeButton) {
                const inputGroup = removeButton.closest('.input-group');
                inputGroup.remove();

                // Update nomor urut setelah penghapusan
                const inputGroups = this.querySelectorAll('.input-group');
                inputGroups.forEach((group, idx) => {
                    group.querySelector('.input-group-text').textContent = idx + 1;
                });
            }
        });

        // Add new reason input
        document.getElementById('add-reason').addEventListener('click', () => {
            reasonCount++;
            const reasonInputGroup = document.createElement('div');
            reasonInputGroup.className = 'input-group mb-2 input-group-outline';
            reasonInputGroup.innerHTML = `
                <input type="text" name="backgroundReasons[]" class="form-control" placeholder="Alasan ${reasonCount}" required>
                <button type="button" class="btn btn-outline-danger remove-input">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            document.getElementById('reason-container').appendChild(reasonInputGroup);
        });

        // Add new research group
        document.getElementById('add-research').addEventListener('click', () => {
            const researchGroup = document.createElement('div');
            researchGroup.className = 'research-group mb-3 input-group input-group-outline';
            researchGroup.innerHTML = `
                <div class="d-flex flex-column flex-grow-1 gap-2">
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][title]" class="form-control" placeholder="Judul Penelitian ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][doi]" class="form-control" placeholder="DOI ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][authors]" class="form-control" placeholder="Penulis ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][problem_statement]" class="form-control" placeholder="Permasalahan yang Diangkat ${researchCount+1}" required>
                    </div>
                    <div class="mb-3 input-group input-group-outline">
                        <input type="text" name="previousResearches[${researchCount}][results]" class="form-control" placeholder="Hasil/Catatan Penelitian ${researchCount+1}" required>
                    </div>
                </div>
                <button type="button" class="btn btn-outline-danger remove-input ms-2 align-self-start">
                    <i class="fa fa-trash"></i>
                </button>
            `;
            document.getElementById('research-container').appendChild(researchGroup);
            researchCount++;
        });

        // Add new question input for Rumusan Masalah
        document.getElementById('add-question').addEventListener('click', () => {
            questionCount++;
            const questionInputGroup = document.createElement('div');
            questionInputGroup.className = 'input-group mb-2 input-group-outline';
            questionInputGroup.innerHTML = `
            <input type="text" name="researchQuestions[]" class="form-control" placeholder="Rumusan Masalah ${questionCount}" required>
            <button type="button" class="btn btn-outline-danger remove-input">
                <i class="fa fa-trash"></i>
            </button>
        `;
            document.getElementById('question-container').appendChild(questionInputGroup);
        });

        // Add new output input for Output Penelitian
        document.getElementById('add-output').addEventListener('click', () => {
            outputCount++;
            const outputInputGroup = document.createElement('div');
            outputInputGroup.className = 'input-group mb-2 input-group-outline';
            outputInputGroup.innerHTML = `
            <input type="text" name="outputs[]" class="form-control" placeholder="Output Penelitian ${outputCount}" required>
            <button type="button" class="btn btn-outline-danger remove-input">
                <i class="fa fa-trash"></i>
            </button>
        `;
            document.getElementById('output-container').appendChild(outputInputGroup);
        });

        // Remove input on trash icon click
        document.addEventListener('click', (event) => {
            if (event.target.closest('.remove-input')) {
                event.target.closest('.input-group, .research-group').remove();
            }
        });
    });
</script>
