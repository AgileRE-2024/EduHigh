<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Edit Kriteria Seminar Proposal">
    <x-navbars.sidebar activePage='proposal-criteria'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Edit Kriteria Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <div class="d-flex justify-content-between align-items-center">
                                <div>
                                    <h2 class="text-white mb-0">
                                        <i class="fas fa-edit me-2"></i>Edit Kriteria
                                    </h2>
                                    <p class="text-white text-sm mb-0 opacity-8">
                                        Perbarui kriteria penilaian untuk seminar proposal
                                    </p>
                                </div>
                            </div>
                        </div>
                        <div class="card-body p-4">
                            <form method="POST" action="{{ route('proposalCriterias.update', $proposalCriteria) }}">
                                @csrf
                                @method('PUT')
                                <div class="row">
                                    <div class="col-md-12 mb-4">
                                        <div class="form-group">
                                            <label for="name" class="form-control-label">Nama Kriteria</label>
                                            <input type="text"
                                                class="form-control @error('name') is-invalid @enderror" id="name"
                                                name="name" value="{{ old('name', $proposalCriteria->name) }}"
                                                required>
                                            @error('name')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="weight" class="form-control-label">Bobot (%)</label>
                                            <input type="number"
                                                class="form-control @error('weight') is-invalid @enderror"
                                                id="weight" name="weight"
                                                value="{{ old('weight', $proposalCriteria->weight) }}" step="0.01"
                                                min="0" max="100" required>
                                            @error('weight')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>

                                    <div class="col-md-6 mb-4">
                                        <div class="form-group">
                                            <label for="type" class="form-control-label">Tipe Penilaian</label>
                                            <select class="form-select @error('type') is-invalid @enderror"
                                                id="type" name="type" required>
                                                <option value="">Pilih Tipe</option>
                                                <option value="material"
                                                    {{ old('type', $proposalCriteria->type) == 'material' ? 'selected' : '' }}>
                                                    Material
                                                </option>
                                                <option value="presentation"
                                                    {{ old('type', $proposalCriteria->type) == 'presentation' ? 'selected' : '' }}>
                                                    Presentation
                                                </option>
                                            </select>
                                            @error('type')
                                                <div class="invalid-feedback">{{ $message }}</div>
                                            @enderror
                                        </div>
                                    </div>
                                </div>

                                <div class="d-flex justify-content-end mt-4">
                                    <a href="{{ route('proposalCriterias.index') }}" class="btn btn-light me-2">
                                        Batal
                                    </a>
                                    <button type="submit" class="btn bg-gradient-primary">
                                        Perbarui Kriteria
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
