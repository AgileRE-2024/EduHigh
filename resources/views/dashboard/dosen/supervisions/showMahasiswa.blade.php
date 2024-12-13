<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Informasi Mahasiswa">
    <x-navbars.sidebar activePage='dosen-pembimbing'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Informasi Mahasiswa"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <!-- Tombol Kembali -->
            <div class="mb-4">
                <a href="{{ url()->previous() }}" class="btn btn-primary">
                    <i class="fas fa-arrow-left me-2"></i>Kembali
                </a>
            </div>
            <!-- Kartu Informasi Mahasiswa -->
            <div class="card shadow-lg mb-4">
                <!-- Header Kartu -->
                <div class="card-header bg-gradient-primary p-5">
                    <div class="d-flex align-items-center">
                        <!-- Foto Profil -->
                        @if ($mahasiswa->user->image)
                            <img src="{{ asset('storage/images/users/' . $mahasiswa->user->image) }}"
                                alt="{{ $mahasiswa->user->name }}"
                                class="rounded-circle me-4 border-4 border-white shadow"
                                style="width: 100px; height: 100px; object-fit: cover;">
                        @else
                            <div class="avatar avatar-xxl bg-white text-primary rounded-circle me-4 border-4 border-white shadow d-flex align-items-center justify-content-center"
                                style="width: 100px; height: 100px; font-size: 2.5rem;">
                                {{ strtoupper(substr($mahasiswa->user->name, 0, 1)) }}
                            </div>
                        @endif
                        <div>
                            <h2 class="text-white mb-1 font-weight-bold">{{ $mahasiswa->user->name }}</h2>
                            <p class="text-white mb-0 font-weight-light">
                                <i class="fas fa-id-card me-2"></i>NIM: {{ $mahasiswa->nim }}
                            </p>
                            <p class="text-white mb-0 font-weight-light">
                                <i class="fas fa-envelope me-2"></i>{{ $mahasiswa->user->email }}
                            </p>
                        </div>
                    </div>
                </div>
                <!-- Isi Kartu -->
                <div class="card-body p-4">
                    @if ($mahasiswa->user->proposal)
                        <!-- Informasi Proposal -->
                        <div class="mb-5">
                            <h4 class="mb-4 text-primary"><i class="fas fa-file-alt me-2"></i>Informasi Proposal</h4>
                            <div class="row">
                                <div class="col-md-6 mb-3">
                                    <h6 class="text-muted">Topik</h6>
                                    <p class="font-weight-bold">{{ $mahasiswa->user->proposal->topic }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h6 class="text-muted">KBK</h6>
                                    <p class="font-weight-bold">{{ $mahasiswa->user->proposal->subkbk->kbk->name }}</p>
                                </div>
                                <div class="col-md-3 mb-3">
                                    <h6 class="text-muted">Sub-KBK</h6>
                                    <p class="font-weight-bold">{{ $mahasiswa->user->proposal->subkbk->name }}</p>
                                </div>
                            </div>
                            <h6 class="text-muted">Latar Belakang</h6>
                            <p class="font-weight-bold">{{ $mahasiswa->user->proposal->background }}</p>
                        </div>

                        <!-- Judul Proposal -->
                        <div class="mb-5">
                            <h5 class="mb-3 text-primary"><i class="fas fa-heading me-2"></i>Judul Proposal</h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($mahasiswa->user->proposal->titles as $title)
                                    <li class="list-group-item px-0">{{ $title->name }}</li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Pertanyaan Penelitian -->
                        <div class="mb-5">
                            <h5 class="mb-3 text-primary"><i class="fas fa-question-circle me-2"></i>Pertanyaan
                                Penelitian</h5>
                            <div class="accordion" id="accordionQuestions">
                                @foreach ($mahasiswa->user->proposal->researchQuestions as $index => $question)
                                    <div class="accordion-item">
                                        <h2 class="accordion-header" id="heading{{ $index }}">
                                            <button class="accordion-button collapsed" type="button"
                                                data-bs-toggle="collapse" data-bs-target="#collapse{{ $index }}"
                                                aria-expanded="false" aria-controls="collapse{{ $index }}">
                                                {{ $question->question }}
                                            </button>
                                        </h2>
                                        <div id="collapse{{ $index }}" class="accordion-collapse collapse"
                                            aria-labelledby="heading{{ $index }}"
                                            data-bs-parent="#accordionQuestions">
                                            <div class="accordion-body">
                                                @if ($question->reasons->isNotEmpty())
                                                    <h6 class="mb-2">Alasan:</h6>
                                                    <ul class="list-unstyled">
                                                        @foreach ($question->reasons as $reason)
                                                            <li class="mb-2"><i
                                                                    class="fas fa-check-circle text-success me-2"></i>{{ $reason->reason }}
                                                            </li>
                                                        @endforeach
                                                    </ul>
                                                @else
                                                    <p class="text-muted">Tidak ada alasan yang tercatat.</p>
                                                @endif
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Penelitian Sebelumnya -->
                        <div class="mb-5">
                            <h5 class="mb-3 text-primary"><i class="fas fa-search me-2"></i>Penelitian Sebelumnya</h5>
                            <div class="row">
                                @foreach ($mahasiswa->user->proposal->previousResearches as $research)
                                    <div class="col-md-6 mb-4">
                                        <div class="card h-100 shadow-sm">
                                            <div class="card-body">
                                                <h6 class="card-title font-weight-bold">{{ $research->title }}</h6>
                                                <p class="card-text"><small
                                                        class="text-muted">{{ $research->authors }}</small></p>
                                                <p class="card-text"><strong>DOI:</strong> <a
                                                        href="https://doi.org/{{ $research->doi }}"
                                                        target="_blank">{{ $research->doi }}</a></p>
                                                <p class="card-text"><strong>Pernyataan Masalah:</strong>
                                                    {{ $research->problem_statement }}</p>
                                                <p class="card-text"><strong>Hasil:</strong> {{ $research->results }}
                                                </p>
                                            </div>
                                        </div>
                                    </div>
                                @endforeach
                            </div>
                        </div>

                        <!-- Output Penelitian -->
                        <div class="mb-5">
                            <h5 class="mb-3 text-primary"><i class="fas fa-clipboard-check me-2"></i>Output Penelitian
                            </h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($mahasiswa->user->proposal->outputs as $output)
                                    <li class="list-group-item px-0 d-flex align-items-center">
                                        <i class="fas fa-check-circle text-success me-3"></i>
                                        {{ $output->research_output }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>

                        <!-- Alasan Latar Belakang -->
                        <div class="mb-5">
                            <h5 class="mb-3 text-primary"><i class="fas fa-lightbulb me-2"></i>Alasan Latar Belakang
                            </h5>
                            <ul class="list-group list-group-flush">
                                @foreach ($mahasiswa->user->proposal->backgroundReasons as $reason)
                                    <li class="list-group-item px-0 d-flex align-items-center">
                                        <i class="fas fa-angle-right text-primary me-3"></i>
                                        {{ $reason->reason }}
                                    </li>
                                @endforeach
                            </ul>
                        </div>
                    @else
                        <div class="alert alert-info" role="alert">
                            <i class="fas fa-info-circle me-2"></i>
                            Mahasiswa ini belum memiliki proposal yang terdaftar.
                        </div>
                    @endif
                </div>
            </div>
        </div>
    </main>
</x-layout>

@push('js')
    <script>
        // Initialize Bootstrap tooltips
        var tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'))
        var tooltipList = tooltipTriggerList.map(function(tooltipTriggerEl) {
            return new bootstrap.Tooltip(tooltipTriggerEl)
        })
    </script>
@endpush
