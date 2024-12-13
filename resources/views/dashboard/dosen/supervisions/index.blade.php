<x-layout bodyClass="g-sidenav-show bg-gray-200" title="Supervision Page">
    <x-navbars.sidebar activePage='mahasiswa-bimbingan'></x-navbars.sidebar>
    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Bimbingan Mahasiswa"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <!-- Card Header -->
                        <div class="card-header bg-gradient-primary p-4">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h4 class="text-white mb-0">
                                        <i class="fas fa-book me-2"></i>Daftar Mahasiswa Bimbingan
                                    </h4>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Kelola dan pantau progress mahasiswa bimbingan Anda </p>
                                </div>
                            </div>
                        </div>

                        <div class="card-body p-0">
                            @if ($students->isEmpty())
                                <div class="text-center py-5">
                                    <div class="empty-state">
                                        <i class="fas fa-users fa-4x text-muted mb-3"></i>
                                        <h5>Belum Ada Mahasiswa Bimbingan</h5>
                                        <p class="text-muted">Anda belum memiliki mahasiswa yang dibimbing saat ini</p>
                                    </div>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table align-items-center mb-0">
                                        <thead class="bg-light">
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Mahasiswa</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Progress</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Last Activity</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 ps-2">
                                                    Status</th>
                                                <th
                                                    class="text-end text-uppercase text-secondary text-xxs font-weight-bolder opacity-7 pe-2">
                                                    Actions</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($students as $student)
                                                <tr>
                                                    <td>
                                                        <div class="d-flex px-2 py-1">
                                                            <div
                                                                class="avatar avatar-sm me-3 bg-gradient-primary rounded-circle">
                                                                {{ strtoupper(substr($student->user->name, 0, 1)) }}
                                                            </div>
                                                            <div class="d-flex flex-column justify-content-center">
                                                                <h6 class="mb-0 text-sm">{{ $student->user->name }}</h6>
                                                                <p class="text-xs text-secondary mb-0">
                                                                    {{ $student->nim }}</p>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <div class="progress-wrapper w-75">
                                                            <div class="progress-info">
                                                                <div class="progress-percentage">
                                                                    <span class="text-xs font-weight-bold">60%</span>
                                                                </div>
                                                            </div>
                                                            <div class="progress">
                                                                <div class="progress-bar bg-gradient-info w-60"
                                                                    role="progressbar" aria-valuenow="60"
                                                                    aria-valuemin="0" aria-valuemax="100"></div>
                                                            </div>
                                                        </div>
                                                    </td>
                                                    <td>
                                                        <span class="text-xs">
                                                            <i class="fas fa-clock text-info me-1"></i>
                                                            {{ \Carbon\Carbon::now()->subDays(rand(0, 7))->diffForHumans() }}
                                                        </span>
                                                    </td>
                                                    <td>
                                                        <span class="badge badge-sm bg-gradient-success">Active</span>
                                                    </td>
                                                    <td class="text-end">
                                                        <a href="{{ route('supervisions.showMahasiswa', $student) }}"
                                                            class="btn btn-link text-dark px-3 mb-0">
                                                            <i class="fas fa-eye text-dark me-2"></i>View Details
                                                        </a>
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
</x-layout>

<style>
    .avatar {
        width: 40px;
        height: 40px;
        display: flex;
        align-items: center;
        justify-content: center;
        color: white;
        font-weight: 600;
    }

    .progress {
        height: 3px;
        border-radius: 2px;
    }

    .progress-bar {
        height: 3px;
        border-radius: 2px;
    }

    .empty-state {
        padding: 3rem 1.5rem;
    }

    .badge {
        text-transform: uppercase;
        font-size: 65%;
        padding: 0.5em 0.8em;
    }
</style>

<script>
    document.addEventListener('DOMContentLoaded', function() {
        const searchInput = document.getElementById('searchStudent');
        const filterSelect = document.getElementById('filterProgress');
        const tableRows = document.querySelectorAll('tbody tr');

        function filterTable() {
            const searchTerm = searchInput.value.toLowerCase();
            const filterValue = filterSelect.value.toLowerCase();

            tableRows.forEach(row => {
                const text = row.textContent.toLowerCase();
                const progressText = row.querySelector('.progress-percentage').textContent;

                const matchesSearch = text.includes(searchTerm);
                const matchesFilter = filterValue === '' || progressText.includes(filterValue);

                row.style.display = matchesSearch && matchesFilter ? '' : 'none';
            });
        }

        searchInput.addEventListener('input', filterTable);
        filterSelect.addEventListener('change', filterTable);
    });
</script>
