<x-layout bodyClass="g-sidenav-show bg-gray-100" title="Evaluate Seminar Proposal">
    <x-navbars.sidebar activePage='seminar-proposal'></x-navbars.sidebar>

    <main class="main-content position-relative max-height-vh-100 h-100 border-radius-lg">
        <x-navbars.navs.auth titlePage="Evaluate Seminar Proposal"></x-navbars.navs.auth>

        <div class="container-fluid py-4">
            <div class="row">
                <div class="col-12">
                    <div class="card shadow-lg">
                        <div class="card-header bg-gradient-primary p-5">
                            <h2 class="text-white mb-0">
                                <i class="fas fa-chalkboard-teacher me-2"></i> Evaluate Seminar Proposal
                            </h2>
                            <p class="text-white text-sm mb-0 opacity-8">
                                Mahasiswa: {{ $seminarproposal->mahasiswa->user->name }}
                                ({{ $seminarproposal->mahasiswa->nim }})
                            </p>
                        </div>
                        <div class="card-body p-4">
                            <form action="{{ route('seminarproposal.updateEvaluation', $seminarproposal) }}"
                                method="POST">
                                @csrf
                                @method('PUT')
                                <input type="hidden" name="assessment_id" value="{{ $assessment->id }}">

                                @foreach ($criterias as $type => $typeCriterias)
                                    <div class="card mb-4">
                                        <div class="card-header bg-light">
                                            <h5 class="mb-0">{{ ucfirst($type) }} Assessment</h5>
                                        </div>
                                        <div class="card-body">
                                            @foreach ($typeCriterias as $criteria)
                                                <div class="mb-4">
                                                    <div class="d-flex justify-content-between align-items-center mb-2">
                                                        <label class="form-label mb-0">{{ $criteria->name }}</label>
                                                        <span class="badge bg-primary">Weight:
                                                            {{ $criteria->weight }}%</span>
                                                    </div>
                                                    <input type="number" name="scores[{{ $criteria->id }}]"
                                                        class="form-control" min="0" max="100"
                                                        step="0.01" required>
                                                </div>
                                            @endforeach
                                        </div>
                                    </div>
                                @endforeach

                                <div class="d-flex justify-content-end">
                                    <a href="{{ route('seminarproposals.index') }}"
                                        class="btn btn-light me-2">Cancel</a>
                                    <button type="submit" class="btn bg-gradient-primary">
                                        <i class="fas fa-save me-2"></i>Save Assessment
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
