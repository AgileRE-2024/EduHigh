<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Kriteria Seminar Proposal">
    <x-navbars.sidebar activePage='proposal-criteria'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Kriteria Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">Kriteria Seminar Proposal</h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Daftar kriteria penilaian untuk seminar proposal
                                    </p>
                                </div>
                                <div>
                                    <a href="{{ route('proposalCriterias.create') }}" class="btn btn-white">
                                        Tambah Kriteria
                                    </a>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            @if ($proposalCriterias->isEmpty())
                                <div class="text-center py-5">
                                    <h5>Belum ada kriteria</h5>
                                    <p class="text-muted">Silakan tambahkan kriteria penilaian baru</p>
                                </div>
                            @else
                                <div class="table-responsive">
                                    <table class="table table-hover align-middle">
                                        <thead>
                                            <tr>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    No</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Kriteria</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Bobot</th>
                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Type</th>

                                                <th
                                                    class="text-uppercase text-secondary text-xxs font-weight-bolder opacity-7">
                                                    Aksi</th>
                                            </tr>
                                        </thead>
                                        <tbody>
                                            @foreach ($proposalCriterias as $criteria)
                                                <tr>
                                                    <td class="text-sm">{{ $loop->iteration }}</td>
                                                    <td>
                                                        <h6 class="mb-0">{{ Str::limit($criteria->name, 50) }}</h6>
                                                    </td>

                                                    <td class="text-sm">{{ $criteria->weight }}%</td>
                                                    <td class="text-sm">{{ $criteria->type }}</td>
                                                    <td>
                                                        <div class="btn-group" role="group">
                                                            <a href="{{ route('proposalCriterias.edit', $criteria) }}"
                                                                class="btn btn-sm btn-info">
                                                                Edit
                                                            </a>
                                                            <form
                                                                action="{{ route('proposalCriterias.destroy', $criteria) }}"
                                                                method="POST" class="d-inline">
                                                                @csrf
                                                                @method('DELETE')
                                                                <button type="submit" class="btn btn-sm btn-danger"
                                                                    onclick="return confirm('Apakah Anda yakin ingin menghapus kriteria ini?')">
                                                                    Delete
                                                                </button>
                                                            </form>
                                                        </div>
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
