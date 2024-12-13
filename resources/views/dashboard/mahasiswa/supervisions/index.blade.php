<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Supervision Page">
    <x-navbars.sidebar activePage='dosen-pembimbing'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Dosen Pembimbing"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Enhanced Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-chalkboard-teacher me-2"></i>Dosen Pembimbing
                                    </h3>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Pilih dan ajukan dosen pembimbing untuk skripsi Anda
                                    </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            @if (!Auth::user()->proposal)
                                <div class="empty-state text-center py-5">
                                    <div class="empty-state-icon mb-4">
                                        <i class="fas fa-file-alt fa-4x text-muted"></i>
                                    </div>
                                    <h5 class="text-muted">Belum Ada Proposal</h5>
                                    <p class="text-sm text-muted mb-4">Anda harus mengajukan proposal terlebih dahulu
                                    </p>
                                    <a href="{{ route('proposals.create') }}" class="btn btn-primary">
                                        <i class="fas fa-plus me-2"></i>Ajukan Proposal
                                    </a>
                                </div>
                            @else
                                @if ($approvedSupervision->count() > 0)
                                    <div class="row g-4">
                                        @foreach ($approvedSupervision as $superVision)
                                            <div class="col-md-6">
                                                <div class="card h-100 shadow-xs hover-shadow-lg transition-all">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex align-items-center mb-3">
                                                            <div
                                                                class="avatar avatar-xl bg-gradient-primary rounded-circle me-3">
                                                                {{ strtoupper(substr($superVision->dosen->user->name, 0, 1)) }}
                                                            </div>
                                                            <div>
                                                                <h5 class="mb-1">
                                                                    <a href="{{ route('supervisions.showDosen', $superVision->dosen) }}"
                                                                        class="text-decoration-none text-dark">
                                                                        {{ $superVision->dosen->user->name }}
                                                                    </a>
                                                                </h5>
                                                                <span class="badge bg-gradient-success">
                                                                    {{ $superVision->dosen_pembimbing == 'pembimbing_1' ? 'Pembimbing 1' : 'Pembimbing 2' }}
                                                                </span>
                                                            </div>
                                                        </div>
                                                        <div class="info-group">
                                                            <div class="d-flex align-items-center mb-2">
                                                                <i class="fas fa-id-card text-primary me-2"></i>
                                                                <span>NIDN: {{ $superVision->dosen->nidn }}</span>
                                                            </div>
                                                            <div class="d-flex align-items-center">
                                                                <i class="fas fa-envelope text-primary me-2"></i>
                                                                <span>{{ $superVision->dosen->user->email }}</span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @else
                                    <!-- Search Input -->
                                    <div class="row mb-4">
                                        <div class="col-md-6">
                                            <div class="input-group input-group-outline">
                                                <label class="form-label">Cari dosen...</label>
                                                <input type="text" class="form-control" id="searchDosen">
                                            </div>
                                        </div>
                                    </div>

                                    <div class="row g-4" id="dosenList">
                                        @foreach ($dosens as $dosen)
                                            <div class="col-md-6 dosen-card mb-4">
                                                <div
                                                    class="card h-100 border-0 shadow-sm hover:shadow-lg transition-all duration-300">
                                                    <div class="card-body p-4">
                                                        <div class="d-flex align-items-center justify-content-between">
                                                            <div class="d-flex align-items-center">
                                                                <!-- Profile Image/Avatar -->
                                                                @if ($dosen->user->image)
                                                                    <div class="me-3">
                                                                        <img src="{{ asset('storage/images/users/' . $dosen->user->image) }}"
                                                                            alt="{{ $dosen->user->name }}"
                                                                            class="rounded-circle object-cover"
                                                                            style="width: 64px; height: 64px;">
                                                                    </div>
                                                                @else
                                                                    <div
                                                                        class="avatar avatar-xl bg-gradient-primary text-white rounded-circle me-3">
                                                                        {{ strtoupper(substr($dosen->user->name, 0, 1)) }}
                                                                    </div>
                                                                @endif

                                                                <!-- Info Section -->
                                                                <div>
                                                                    <h5 class="mb-1 font-weight-bold">
                                                                        <a href="{{ route('supervisions.showDosen', $dosen) }}"
                                                                            class="text-decoration-none text-dark hover:text-primary transition-colors">
                                                                            {{ $dosen->user->name }}
                                                                        </a>
                                                                    </h5>
                                                                    <div class="info-group">
                                                                        <div
                                                                            class="d-flex align-items-center mb-2 text-muted">
                                                                            <i
                                                                                class="fas fa-id-card text-primary me-2"></i>
                                                                            <span>NIDN: {{ $dosen->nidn }}</span>
                                                                        </div>
                                                                        <div
                                                                            class="d-flex align-items-center text-muted">
                                                                            <i
                                                                                class="fas fa-envelope text-primary me-2"></i>
                                                                            <span>{{ $dosen->user->email }}</span>
                                                                        </div>
                                                                    </div>
                                                                </div>
                                                            </div>

                                                            <!-- Action Button -->
                                                            @php
                                                                $pendingSupervisions = Auth::user()->mahasiswa->superVisions->where(
                                                                    'status',
                                                                    'pending',
                                                                );
                                                                $existingSupervision = Auth::user()
                                                                    ->mahasiswa->superVisions->where(
                                                                        'dosen_id',
                                                                        $dosen->id,
                                                                    )
                                                                    ->first();
                                                                $isPending =
                                                                    $existingSupervision &&
                                                                    $existingSupervision->status == 'pending';

                                                                $hasAnyPending = $pendingSupervisions->isNotEmpty();
                                                            @endphp

                                                            <form action="{{ route('supervisions.store') }}"
                                                                method="POST">
                                                                @csrf
                                                                <input type="hidden" name="mahasiswa_id"
                                                                    value="{{ Auth::user()->mahasiswa->id }}">
                                                                <input type="hidden" name="dosen_id"
                                                                    value="{{ $dosen->id }}">
                                                                <button type="submit"
                                                                    class="btn text-white {{ $isPending ? 'btn-warning' : 'btn-primary' }} px-4 shadow-sm hover:shadow-lg transition-all"
                                                                    {{ ($hasAnyPending && !$isPending) || $isPending ? 'disabled' : '' }}
                                                                    data-bs-toggle="tooltip"
                                                                    title="{{ $isPending ? 'Pengajuan sedang diproses' : ($hasAnyPending ? 'Anda memiliki pengajuan yang sedang diproses' : 'Ajukan sebagai pembimbing') }}">
                                                                    @if ($isPending)
                                                                        <i class="fas fa-clock me-2"></i>
                                                                        Menunggu
                                                                    @else
                                                                        <i class="fas fa-user-plus me-2"></i>Ajukan
                                                                    @endif
                                                                </button>
                                                            </form>
                                                        </div>
                                                    </div>
                                                </div>
                                            </div>
                                        @endforeach
                                    </div>
                                @endif
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

@push('styles')
    <style>
        .card {
            transition: all 0.3s ease;
        }

        .card:hover {
            transform: translateY(-5px);
        }

        .avatar {
            width: 64px;
            height: 64px;
            display: flex;
            align-items: center;
            justify-content: center;
            font-size: 1.5rem;
            font-weight: 600;
        }

        .avatar-xl {
            width: 64px;
            height: 64px;
            font-size: 1.5rem;
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

        .hover-shadow-lg {
            transition: all 0.3s ease;
        }

        .hover-shadow-lg:hover {
            transform: translateY(-5px);
        }

        .info-group {
            font-size: 0.875rem;
            color: #67748e;
        }

        .object-cover {
            object-fit: cover;
        }

        .hover\:shadow-lg:hover {
            box-shadow: 0 10px 15px -3px rgba(0, 0, 0, 0.1);
        }

        .transition-colors {
            transition: color 0.3s ease;
        }

        .hover\:text-primary:hover {
            color: var(--bs-primary) !important;
        }
    </style>
@endpush

@push('scripts')
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const searchInput = document.getElementById('searchDosen');
            const dosenCards = document.querySelectorAll('.dosen-card');

            searchInput?.addEventListener('input', function(e) {
                const searchTerm = e.target.value.toLowerCase();

                dosenCards.forEach(card => {
                    const text = card.textContent.toLowerCase();
                    card.style.display = text.includes(searchTerm) ? '' : 'none';
                });
            });

            // Initialize tooltips
            const tooltipTriggerList = [].slice.call(document.querySelectorAll('[data-bs-toggle="tooltip"]'));
            tooltipTriggerList.map(function(tooltipTriggerEl) {
                return new bootstrap.Tooltip(tooltipTriggerEl);
            });
        });
    </script>
@endpush
