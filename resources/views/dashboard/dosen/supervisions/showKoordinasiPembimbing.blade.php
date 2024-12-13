<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Super Vision Page">
    <x-navbars.sidebar activePage='koordinasi-pembimbing'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <!-- Navbar -->
        <x-navbars.navs.auth titlePage="Koordinasi Pembimbing"></x-navbars.navs.auth>
        <!-- End Navbar -->
        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-lg-12 col-md-6">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="row align-items-center">
                                <div class="col-md-6">
                                    <h3 class="text-white mb-0">
                                        <i class="fas fa-user-friends me-2"></i>Koordinasi Pembimbing
                                    </h3>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Koordinasi pembimbing mahasiswa yang membutuhkan pembimbing 2
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if ($mahasiswas->isEmpty())
                                <p class="card-text">Tidak ada mahasiswa yang membutuhkan pembimbing 2 saat ini.</p>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-bordered">
                                        <thead class="bg-light">
                                            <tr>
                                                <th>Nama Mahasiswa</th>
                                                <th>NIM</th>
                                                <th>Judul Proposal</th>
                                                <th>Pembimbing 1</th>
                                                <th>Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($mahasiswas as $mahasiswa)
                                                <tr>
                                                    <td>{{ $mahasiswa->user->name }}</td>
                                                    <td>{{ $mahasiswa->nim }}</td>
                                                    <td>{{ $mahasiswa->user->proposal->titles->first()->name }}</td>
                                                    <td>{{ $mahasiswa->superVisions->where('dosen_pembimbing', 'pembimbing_1')->first()->dosen->user->name }}
                                                    </td>
                                                    <td>
                                                        <button type="button" class="btn btn-primary btn-sm"
                                                            data-bs-toggle="modal" data-bs-target="#assignModal"
                                                            data-mahasiswa-id="{{ $mahasiswa->id }}"
                                                            data-kbk-id="{{ $mahasiswa->user->proposal->subkbk->kbk->id }}">
                                                            Pilih Pembimbing 2
                                                        </button>
                                                    </td>
                                                </tr>
                                            @endforeach
                                        </tbody>
                                    </table>
                                </div>
                            @endif
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </main>

    <!-- Modal -->
    <div class="modal fade" id="assignModal" tabindex="-1" aria-labelledby="assignModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="assignModalLabel">Pilih Pembimbing 2</h5>
                    <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                </div>
                <div class="modal-body">
                    <form id="assignForm" action="{{ route('supervisions.assignPembimbing2') }}" method="POST">
                        @csrf
                        <input type="hidden" name="mahasiswa_id" id="mahasiswa_id">
                        <div class="mb-3">
                            <label for="dosen_id" class="form-label">Pilih Dosen</label>
                            <select name="dosen_id" id="dosen_id" class="form-select" required>
                                <!-- Options will be populated by JavaScript -->
                            </select>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Tutup</button>
                            <button type="submit" class="btn btn-primary">Assign</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-layout>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const assignModal = document.getElementById('assignModal');
        assignModal.addEventListener('show.bs.modal', function(event) {
            const button = event.relatedTarget;
            const mahasiswaId = button.getAttribute('data-mahasiswa-id');
            const kbkId = button.getAttribute('data-kbk-id');

            // Set mahasiswa_id in the form
            document.getElementById('mahasiswa_id').value = mahasiswaId;

            // Fetch dosens based on KBK ID and Mahasiswa ID
            fetch(`/api/dosens?kbk_id=${kbkId}&mahasiswa_id=${mahasiswaId}`)
                .then(response => response.json())
                .then(data => {
                    const dosenSelect = document.getElementById('dosen_id');
                    dosenSelect.innerHTML = '<option value="">Pilih Dosen</option>';
                    data.forEach(dosen => {
                        const option = document.createElement('option');
                        option.value = dosen.id;
                        option.textContent = dosen.user.name;
                        dosenSelect.appendChild(option);
                    });
                });
        });
    });
</script>
