<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Edit Profile Page">
    <x-navbars.sidebar activePage='user-profile'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Profile"></x-navbars.navs.auth>
        <div class="container-fluid py-4">
            <div class="row justify-content-center">
                <div class="col-md-12">
                    <div class="card shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <h3 class="text-white mb-0">Edit Profile Information</h3>
                            <p class="text-white text-sm mb-0 opacity-8">Update your personal information</p>
                        </div>

                        <div class="card-body p-4">
                            <!-- Validation Errors -->
                            @if ($errors->any())
                                <div class="alert alert-danger alert-dismissible fade show" role="alert">
                                    <strong><i class="fas fa-exclamation-circle me-2"></i>Please fix the following
                                        errors:</strong>
                                    <ul class="mb-0 mt-2">
                                        @foreach ($errors->all() as $error)
                                            <li>{{ $error }}</li>
                                        @endforeach
                                    </ul>
                                    <button type="button" class="btn-close" data-bs-dismiss="alert"
                                        aria-label="Close"></button>
                                </div>
                            @endif

                            <form action="{{ route('profile.update') }}" id="profileForm" method="POST"
                                enctype="multipart/form-data">
                                @csrf
                                @method('PUT')

                                <!-- Profile Picture Section -->
                                <div class="text-center position-relative mb-5">
                                    <div class="avatar-upload">
                                        <div class="avatar-preview"
                                            style="width: 150px; height: 150px; margin: 0 auto;">
                                            <img src="{{ Auth::user()->image ? asset('storage/images/users/' . Auth::user()->image) : asset('assets/img/default.png') }}"
                                                }}" alt="Profile Picture" class="rounded-circle img-fluid"
                                                id="profilePic" style="width: 150px; height: 150px; object-fit: cover;">
                                        </div>
                                        <div class="avatar-edit">
                                            <label for="profilePicInput"
                                                class="btn btn-sm btn-white shadow-sm position-absolute bottom-0 start-50 translate-middle-x">
                                                <i class="fas fa-camera me-2"></i>Change Photo
                                            </label>
                                            <input type="file" class="d-none" name="image" id="profilePicInput"
                                                accept="image/*">
                                        </div>
                                    </div>
                                </div>

                                <!-- Basic Information -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="email" class="form-label text-muted">
                                                <i class="fas fa-envelope me-2"></i>Email
                                            </label>
                                            <input type="email" class="form-control bg-light"
                                                value="{{ Auth::user()->email }}" disabled>
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        @if (Auth::user()->role == 'mahasiswa' or Auth::user()->role == 'dosen')

                                            @if (Auth::user()->role == 'mahasiswa')
                                                <div class="form-group">
                                                    <label for="nim" class="form-label text-muted">
                                                        <i class="fas fa-id-card me-2"></i>NIM
                                                    </label>
                                                    <input type="text" class="form-control bg-light"
                                                        value="{{ Auth::user()->mahasiswa->nim }}" disabled>
                                                </div>
                                            @else
                                                <div class="form-group">
                                                    <label for="nidn" class="form-label text-muted">
                                                        <i class="fas fa-id-badge me-2"></i>NIDN
                                                    </label>
                                                    <input type="text" class="form-control bg-light"
                                                        value="{{ Auth::user()->dosen->nidn }}" disabled>
                                                </div>
                                            @endif
                                        @endif
                                    </div>
                                </div>

                                <!-- Personal Information -->
                                <div class="row">
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="name" class="form-label text-muted">
                                                <i class="fas fa-user me-2"></i>Full Name
                                            </label>
                                            <input type="text" class="form-control" name="name" id="name"
                                                value="{{ Auth::user()->name }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="phone" class="form-label text-muted">
                                                <i class="fas fa-phone me-2"></i>Phone Number
                                            </label>
                                            <input type="text" class="form-control" name="phone" id="phone"
                                                value="{{ Auth::user()->phone }}" placeholder="Enter your phone number">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="date_of_birth" class="form-label text-muted">
                                                <i class="fas fa-birthday-cake me-2"></i>Date of Birth
                                            </label>
                                            <input type="date" class="form-control" name="date_of_birth"
                                                id="date_of_birth" value="{{ Auth::user()->date_of_birth }}">
                                        </div>
                                    </div>
                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="address" class="form-label text-muted">
                                                <i class="fas fa-map-marker-alt me-2"></i>Address
                                            </label>
                                            <input type="text" class="form-control" name="address" id="address"
                                                value="{{ Auth::user()->address }}" placeholder="Enter your address">
                                        </div>
                                    </div>
                                </div>

                                <!-- Submit Buttons -->
                                <div class="text-end mt-4">
                                    <button type="reset" class="btn btn-light me-2">
                                        <i class="fas fa-undo me-2"></i>Reset
                                    </button>
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save me-2"></i>Save Changes
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

<style>
    .avatar-upload {
        position: relative;
        margin-bottom: 20px;
    }

    .avatar-preview {
        border: 6px solid #F8F9FA;
        box-shadow: 0px 2px 4px rgba(0, 0, 0, 0.1);
        border-radius: 50%;
        transition: all 0.3s ease;
    }

    .avatar-preview:hover {
        border-color: #e9ecef;
    }

    .form-control:focus {
        border-color: #4CAF50;
        box-shadow: 0 0 0 0.2rem rgba(76, 175, 80, 0.25);
    }

    .btn-gradient-primary {
        background: linear-gradient(to right, #4CAF50, #45a049);
        border: none;
    }

    .btn-gradient-primary:hover {
        background: linear-gradient(to right, #45a049, #3d8b40);
    }
</style>

<script>
    document.getElementById('profilePicInput').addEventListener('change', function(event) {
        const file = event.target.files[0];
        if (file) {
            const reader = new FileReader();
            reader.onload = function(e) {
                document.getElementById('profilePic').src = e.target.result;
            }
            reader.readAsDataURL(file);
        }
    });
</script>
