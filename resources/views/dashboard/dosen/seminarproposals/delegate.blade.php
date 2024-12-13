<!-- index.blade.php -->
<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Review Seminar Proposal">
    <x-navbars.sidebar activePage="delegate-seminar-proposal"></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Review Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-tasks me-2"></i>Review Seminar Proposal
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Kelola pengajuan seminar proposal mahasiswa bimbingan Anda
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <div class="table-responsive">
                                <table class="table table-hover">
                                    <thead>
                                        <tr>
                                            <th>NIM</th>
                                            <th>Nama Mahasiswa</th>
                                            <th>Tanggal Pengajuan</th>
                                            <th>Status</th>
                                            <th>Aksi</th>
                                        </tr>
                                    </thead>
                                    <tbody>
                                        @foreach ($seminarProposals as $seminarproposal)
                                            <tr>
                                                <td>{{ $seminarproposal->mahasiswa->nim }}</td>
                                                <td>{{ $seminarproposal->mahasiswa->user->name }}</td>
                                                <td>{{ $seminarproposal->created_at->format('d-m-Y') }}</td>
                                                <td>{{ ucfirst($seminarproposal->status) }}</td>
                                                <td>
                                                    <button type="button" class="btn btn-primary assign-penguji"
                                                        data-bs-toggle="modal" data-bs-target="#assignPengujiModal"
                                                        data-proposal-id="{{ $seminarproposal->id }}">
                                                        <i class="fas fa-edit me-2"></i>Review
                                                    </button>
                                                </td>
                                            </tr>
                                        @endforeach
                                    </tbody>
                                </table>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        </div>
        <!-- Add this modal structure before closing </main> tag -->
        <div class="modal fade" id="assignPengujiModal" tabindex="-1" aria-labelledby="assignPengujiModalLabel"
            aria-hidden="true">
            <div class="modal-dialog">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="assignPengujiModalLabel">Assign Dosen Penguji</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <form id="assignPengujiForm" method="POST">
                        @csrf
                        @method('PUT')
                        <div class="modal-body">
                            <div class="mb-3">
                                <label for="penguji_id" class="form-label">Pilih Dosen Penguji</label>
                                <select class="form-select" id="penguji_id" name="penguji_id" required>
                                    <option value="">Pilih Dosen Penguji</option>
                                </select>
                            </div>
                        </div>
                        <div class="modal-footer">
                            <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Batal</button>
                            <button type="submit" class="btn btn-primary">Simpan</button>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </main>
    <link rel="stylesheet" href="https://cdn.jsdelivr.net/npm/sweetalert2@11/dist/sweetalert2.min.css">
    <script src="https://cdn.jsdelivr.net/npm/sweetalert2@11"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const assignPengujiModal = document.getElementById('assignPengujiModal');
            const assignPengujiForm = document.getElementById('assignPengujiForm');
            const pengujiSelect = document.getElementById('penguji_id');
            const submitButton = assignPengujiForm.querySelector('button[type="submit"]');

            // Modal show handler
            assignPengujiModal.addEventListener('show.bs.modal', async function(event) {
                const button = event.relatedTarget;
                const proposalId = button.getAttribute('data-proposal-id');

                submitButton.disabled = true;
                pengujiSelect.disabled = true;

                assignPengujiForm.action = `/dashboard/seminarproposals/${proposalId}/assign-penguji`;

                try {
                    const response = await fetch(
                        `/dashboard/seminarproposals/${proposalId}/available-dosens`);
                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();

                    pengujiSelect.innerHTML = '<option value="">Pilih Dosen Penguji</option>';

                    data.dosens.forEach(dosen => {
                        const option = document.createElement('option');
                        option.value = dosen.id;
                        option.textContent = dosen.name;
                        if (dosen.id === data.selectedDosenId) {
                            option.selected = true;
                        }
                        pengujiSelect.appendChild(option);
                    });
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: 'Gagal memuat data dosen'
                    });
                } finally {
                    submitButton.disabled = false;
                    pengujiSelect.disabled = false;
                }
            });

            // Form submit handler
            assignPengujiForm.addEventListener('submit', async function(e) {
                e.preventDefault();

                if (!pengujiSelect.value) {
                    Swal.fire({
                        icon: 'warning',
                        title: 'Peringatan',
                        text: 'Silakan pilih dosen penguji terlebih dahulu'
                    });
                    return;
                }

                submitButton.disabled = true;
                submitButton.innerHTML =
                    '<span class="spinner-border spinner-border-sm" role="status" aria-hidden="true"></span> Menyimpan...';

                try {
                    const response = await fetch(this.action, {
                        method: 'POST',
                        headers: {
                            'Content-Type': 'application/json',
                            'X-CSRF-TOKEN': document.querySelector('meta[name="csrf-token"]')
                                .content,
                            'Accept': 'application/json'
                        },
                        body: JSON.stringify({
                            dosen_id: pengujiSelect.value,
                            _method: 'PUT'
                        })
                    });

                    if (!response.ok) throw new Error('Network response was not ok');

                    const data = await response.json();

                    if (data.success) {
                        await Swal.fire({
                            icon: 'success',
                            title: 'Berhasil',
                            text: data.message,
                            timer: 1500
                        });
                        bootstrap.Modal.getInstance(assignPengujiModal).hide();
                        window.location.reload();
                    } else {
                        throw new Error(data.message);
                    }
                } catch (error) {
                    console.error('Error:', error);
                    Swal.fire({
                        icon: 'error',
                        title: 'Error',
                        text: error.message || 'Terjadi kesalahan saat menyimpan data'
                    });
                } finally {
                    submitButton.disabled = false;
                    submitButton.innerHTML = 'Simpan';
                }
            });

            // Reset form on modal close
            assignPengujiModal.addEventListener('hidden.bs.modal', function() {
                assignPengujiForm.reset();
                submitButton.disabled = false;
                submitButton.innerHTML = 'Simpan';
            });
        });
    </script>
</x-layout>
