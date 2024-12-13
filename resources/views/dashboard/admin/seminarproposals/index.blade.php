<!-- index.blade.php -->
<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Review Seminar Proposal">
    <x-navbars.sidebar activePage="seminar-proposal"></x-navbars.sidebar>

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
                                                    <a href="{{ route('seminarproposals.edit', $seminarproposal) }}"
                                                        class="btn btn-primary">
                                                        <i class="fas fa-edit me-2"></i>Review
                                                    </a>
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
    </main>
</x-layout>
