<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Show Logbook">
    <x-navbars.sidebar activePage='log-book'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Show Logbook"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <h4 class="text-white mb-0">
                                    <i class="fas fa-book me-2"></i>Detail Logbook
                                </h4>
                                <a href="{{ route('logbooks.index') }}" class="btn btn-light">
                                    <i class="fas fa-arrow-left me-2"></i>Back
                                </a>
                            </div>
                        </div>

                        <div class="card-body p-4">
                            <!-- Status Badge -->
                            <div class="mb-4">
                                @switch($logbook->status)
                                    @case('pending')
                                        <span class="badge bg-gradient-warning">
                                            <i class="fas fa-clock me-2"></i>Pending
                                        </span>
                                    @break

                                    @case('confirmed')
                                        <span class="badge bg-gradient-success">
                                            <i class="fas fa-check me-2"></i>Confirmed
                                        </span>
                                    @break

                                    @case('rejected')
                                        <span class="badge bg-gradient-danger">
                                            <i class="fas fa-times me-2"></i>Rejected
                                        </span>
                                    @break
                                @endswitch
                            </div>

                            <!-- Consultation Details -->
                            <div class="row mb-4">
                                <div class="col-md-6">
                                    <div class="card bg-light">
                                        <div class="card-body">
                                            <h6 class="text-uppercase text-muted mb-3">Consultation Info</h6>
                                            <dl class="row mb-0">
                                                <dt class="col-sm-4">Date</dt>
                                                <dd class="col-sm-8">
                                                    {{ \Carbon\Carbon::parse($logbook->date)->format('d F Y') }}</dd>

                                                <dt class="col-sm-4">Supervisor</dt>
                                                <dd class="col-sm-8">{{ $logbook->superVision->dosen->user->name }}</dd>

                                                @if ($logbook->verified_at)
                                                    <dt class="col-sm-4">Verified At</dt>
                                                    <dd class="col-sm-8">
                                                        {{ \Carbon\Carbon::parse($logbook->verified_at)->format('d F Y H:i') }}
                                                    </dd>
                                                @endif
                                            </dl>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Notes -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-3">Consultation Notes</h6>
                                    <p class="mb-0">{{ $logbook->notes ?? 'No notes available' }}</p>
                                </div>
                            </div>

                            <!-- Supervisor Comments -->
                            <div class="card bg-light">
                                <div class="card-body">
                                    <h6 class="text-uppercase text-muted mb-3">Supervisor Comments</h6>
                                    <p class="mb-0">{{ $logbook->comments ?? 'No comments available' }}</p>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<style>
    .card {
        border: none;
        border-radius: 0.75rem;
    }

    .badge {
        font-size: 0.875rem;
        padding: 0.5rem 1rem;
    }

    dt {
        font-weight: 600;
        color: #344767;
    }

    dd {
        margin-bottom: 0.5rem;
    }

    .text-uppercase {
        letter-spacing: 0.1em;
    }
</style>
