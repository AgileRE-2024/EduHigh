<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Proposal Page">
    <x-navbars.sidebar activePage='proposals'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Proposal"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Enhanced Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-file-alt me-2"></i>Form Usulan Topik Skripsi
                                    </h3>
                                    <p class="text-white-50 mb-0">Silakan lengkapi data proposal Anda</p>
                                </div>
                                @if (Auth::user()->proposal)
                                    <a href="{{ route('proposals.edit', Auth::user()->proposal->id) }}"
                                        class="btn btn-warning">
                                        <i class="fas fa-edit me-2"></i>Perbarui Proposal
                                    </a>
                                @endif
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if (Auth::user()->proposal)
                                <!-- Section I: Pengusul -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-user me-2 text-primary"></i>I. Pengusul
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>Nama:</strong> {{ Auth::user()->name }}</p>
                                        <p><strong>NIM:</strong> {{ Auth::user()->mahasiswa->nim }}</p>
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
                                        <p><strong>Nama Topik:</strong> {{ $proposal->topic ?? 'Belum ditentukan' }}</p>
                                        <p><strong>KBK:</strong> {{ $proposal->subkbk->name ?? 'Belum ditentukan' }}</p>
                                    </div>
                                </div>

                                <!-- Section III: Usulan Judul Skripsi -->
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-lightbulb me-2 text-primary"></i>III. Usulan Judul Skripsi
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($proposal->titles->isEmpty())
                                            <p class="text-muted">Belum ada judul skripsi yang diusulkan.</p>
                                        @else
                                            <ol>
                                                @foreach ($proposal->titles as $title)
                                                    <li>{{ $title->name }}</li>
                                                @endforeach
                                            </ol>
                                        @endif
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
                                        <p><strong>a. Permasalahan yang akan diselesaikan:</strong></p>
                                        <p>{{ $proposal->background ?? 'Belum diisi' }}</p>
                                        <p><strong>b. Alasan pemilihan masalah:</strong></p>
                                        @if ($proposal->backgroundReasons->isEmpty())
                                            <p class="text-muted">Belum ada alasan pemilihan masalah yang diinput.</p>
                                        @else
                                            <ul>
                                                @foreach ($proposal->backgroundReasons as $reason)
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
                                            <i class="fas fa-search me-2 text-primary"></i>V. Penelitian Sebelumnya
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        @if ($proposal->previousResearches->isEmpty())
                                            <p class="text-muted">Belum ada penelitian sebelumnya yang diinput.</p>
                                        @else
                                            @foreach ($proposal->previousResearches as $previousResearch)
                                                <div class="mb-3">
                                                    <p><strong>Judul:</strong> {{ $previousResearch->title }}</p>
                                                    <p><strong>Penulis:</strong> {{ $previousResearch->authors }}</p>
                                                    <p><strong>DOI:</strong> {{ $previousResearch->doi }}</p>
                                                    <p><strong>Permasalahan yang diangkat:</strong>
                                                        {{ $previousResearch->problem_statement }}</p>
                                                    <p><strong>Hasil penelitian:</strong>
                                                        {{ $previousResearch->results }}</p>
                                                </div>
                                            @endforeach
                                        @endif
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
                                        @if ($proposal->researchQuestions->isEmpty())
                                            <p class="text-muted">Belum ada rumusan masalah yang diinput.</p>
                                        @else
                                            <ul>
                                                @foreach ($proposal->researchQuestions as $researchQuestion)
                                                    <li>{{ $researchQuestion->question }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
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
                                        @if ($proposal->outputs->isEmpty())
                                            <p class="text-muted">Belum ada output penelitian yang diinput.</p>
                                        @else
                                            <ul>
                                                @foreach ($proposal->outputs as $output)
                                                    <li>{{ $output->research_output }}</li>
                                                @endforeach
                                            </ul>
                                        @endif
                                    </div>
                                </div>
                                <div class="card mb-4">
                                    <div class="card-header bg-light">
                                        <h5 class="mb-0">
                                            <i class="fas fa-clipboard-check me-2 text-primary"></i>VIII. Layout
                                            Pemecahan Masalah
                                        </h5>
                                    </div>
                                    <div class="card-body">
                                        <p><strong>
                                                Metode Penelitian:
                                            </strong>
                                            {{ $proposal->methodology }}</p>
                                    </div>
                                </div>
                            @else
                                <!-- Empty State -->
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon mb-4">
                                        <i class="fas fa-file-alt fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">Belum Ada Proposal</h5>
                                    <p class="text-sm text-muted mb-4">Anda belum membuat proposal skripsi Anda.</p>
                                    <a href="{{ route('proposals.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Buat Proposal
                                    </a>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<!-- Additional Styles -->
@push('styles')
    <style>
        .card-header h5 {
            font-size: 1.1rem;
            font-weight: 600;
        }

        .empty-state {
            padding: 3rem 1.5rem;
        }

        .empty-state-icon {
            width: 80px;
            height: 80px;
            margin: 0 auto;
            background: #f8f9fa;
            border-radius: 50%;
            display: flex;
            align-items: center;
            justify-content: center;
        }

        .empty-state-icon i {
            font-size: 3rem;
            color: #a0a4a8;
        }
    </style>
@endpush
