<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Profile Page">
    <x-navbars.sidebar activePage='user-profile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Profile"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    @if (Session::get('success'))
                        <div class="alert alert-success alert-dismissible fade show" role="alert">
                            <i class="fas fa-check-circle me-2"></i>{{ Session::get('success') }}
                            <button type="button" class="btn-close" data-bs-dismiss="alert"
                                aria-label="Close"></button>
                        </div>
                    @endif

                    <!-- Profile Card -->
                    <div class="card card-profile shadow-lg">
                        <!-- Profile Header -->
                        <div class="position-relative">
                            <div class="bg-gradient-primary w-100 h-100 position-absolute opacity-8"
                                style="height: 150px;"></div>
                            <div class="card-profile-image mt-3">
                                @if (Auth::user()->image)
                                    <img src="{{ asset('storage/images/users/' . Auth::user()->image) }}"
                                        alt="Profile Picture" class="rounded-circle img-fluid shadow-lg"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                                @else
                                    <img src="{{ asset('assets/img/default.png') }}" alt="Profile Picture"
                                        class="rounded-circle img-fluid shadow-lg"
                                        style="width: 150px; height: 150px; object-fit: cover; border: 4px solid #fff;">
                                @endif
                            </div>
                        </div>

                        <!-- Profile Info -->
                        <div class="card-body pt-7">
                            <div class="text-center mb-4">
                                <h3 class="mb-1">{{ Auth::user()->name }}</h3>
                                <span class="badge bg-gradient-primary px-3">{{ ucfirst(Auth::user()->role) }}</span>
                            </div>

                            <!-- Quick Stats -->
                            <div class="row g-4 mb-4">
                                @if (Auth::user()->role == 'mahasiswa')
                                    <div class="col-4">
                                        <div class="card bg-light">
                                            <div class="card-body text-center p-3">
                                                <i class="fas fa-book-open text-primary mb-2 fa-2x"></i>
                                                <h6 class="mb-0">Proposal</h6>
                                                <span
                                                    class="small text-muted">{{ Auth::user()->proposal ? 'Submitted' : 'Not Yet' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                @endif
                                <div class="col-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-calendar-check text-primary mb-2 fa-2x"></i>
                                            <h6 class="mb-0">Appointments</h6>
                                            <span
                                                class="small text-muted">{{ Auth::user()->appointments_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                                <div class="col-4">
                                    <div class="card bg-light">
                                        <div class="card-body text-center p-3">
                                            <i class="fas fa-clipboard-list text-primary mb-2 fa-2x"></i>
                                            <h6 class="mb-0">Logbooks</h6>
                                            <span
                                                class="small text-muted">{{ Auth::user()->logbooks_count ?? 0 }}</span>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Personal Information -->
                            <div class="card bg-light mb-4">
                                <div class="card-body">
                                    <h5 class="mb-3">Personal Information</h5>
                                    <div class="row g-4">
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <i class="fas fa-envelope text-primary me-2"></i>
                                                <span class="text-muted">Email:</span>
                                                <span class="fw-medium">{{ Auth::user()->email }}</span>
                                            </div>
                                        </div>
                                        @if (Auth::user()->role == 'mahasiswa' or Auth::user()->role == 'dosen')
                                            <div class="col-md-6">
                                                <div class="info-item">
                                                    <i class="fas fa-id-card text-primary me-2"></i>
                                                    <span
                                                        class="text-muted">{{ Auth::user()->role == 'mahasiswa' ? 'NIM:' : 'NIP:' }}</span>
                                                    <span class="fw-medium">
                                                        {{ Auth::user()->role == 'mahasiswa' ? Auth::user()->mahasiswa->nim : Auth::user()->dosen->nidn }}
                                                    </span>
                                                </div>
                                            </div>
                                        @endif
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <i class="fas fa-map-marker-alt text-primary me-2"></i>
                                                <span class="text-muted">Address:</span>
                                                <span class="fw-medium">{{ Auth::user()->address ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <i class="fas fa-phone text-primary me-2"></i>
                                                <span class="text-muted">Phone:</span>
                                                <span class="fw-medium">{{ Auth::user()->phone ?? '-' }}</span>
                                            </div>
                                        </div>
                                        <div class="col-md-6">
                                            <div class="info-item">
                                                <i class="fas fa-birthday-cake text-primary me-2"></i>
                                                <span class="text-muted">Birth Date:</span>
                                                <span class="fw-medium">{{ Auth::user()->date_of_birth ?? '-' }}</span>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>

                            <!-- Action Buttons -->
                            <div class="text-center">
                                <a href="{{ route('profile.edit') }}" class="btn btn-primary">
                                    <i class="fas fa-edit me-2"></i>Edit Profile
                                </a>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>
</x-layout>

<style>
    .card-profile {
        overflow: hidden;
    }

    .card-profile-image {
        position: relative;
        text-align: center;
        z-index: 1;
    }

    .pt-7 {
        padding-top: 6rem !important;
    }

    .info-item {
        padding: 0.5rem;
        transition: all 0.3s ease;
    }

    .info-item:hover {
        background: rgba(0, 0, 0, 0.03);
        border-radius: 0.5rem;
    }

    .badge {
        font-size: 0.875rem;
        padding: 0.5em 1em;
    }

    .card {
        transition: transform 0.3s ease;
    }

    .card:hover {
        transform: translateY(-5px);
    }
</style>
