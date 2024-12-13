@props(['activePage'])

<aside
    class="sidenav navbar navbar-vertical navbar-expand-xs border-0 border-radius-xl my-3 fixed-start ms-3 bg-gradient-dark"
    id="sidenav-main">
    <div class="sidenav-header">
        <i class="fas fa-times p-3 cursor-pointer text-white opacity-5 position-absolute end-0 top-0 d-none d-xl-none"
            aria-hidden="true" id="iconSidenav"></i>
        <a class="navbar-brand m-0 d-flex text-wrap align-items-center" href=" {{ route('dashboard') }} ">
            <img src="{{ asset('assets') }}/img/logo-ct.png" class="navbar-brand-img h-100" alt="main_logo">
            <span class="ms-2 font-weight-bold text-white">EduHigh</span>
        </a>
    </div>
    <hr class="horizontal light mt-0 mb-2">
    <div class="collapse navbar-collapse  w-auto " id="sidenav-collapse-main">
        <ul class="navbar-nav">
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'dashboard' ? ' active bg-gradient-primary' : '' }} "
                    href="{{ route('dashboard') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">dashboard</i>
                    </div>
                    <span class="nav-link-text ms-1">Dashboard</span>
                </a>
            </li>
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'user-profile' ? 'active bg-gradient-primary' : '' }} "
                    href="{{ route('profile.index') }}">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i style="font-size: 1.2rem;" class="fas fa-user-circle text-center"></i>
                    </div>
                    <span class="nav-link-text ms-1">My Profile</span>
                </a>
            </li>

            @if (Auth::user()->role == 'admin')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'proposal-criteria' ? 'active bg-gradient-primary' : '' }} "
                        href="{{ route('proposalCriterias.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">rule</i>
                        </div>
                        <span class="nav-link-text ms-1">Kriteria Seminar Proposal</span>
                    </a>
                </li>
            @endif

            @if (Auth::user()->role == 'mahasiswa')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'proposals' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('proposals.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10 text-center"
                                style="font-size: 1.2rem;">content_paste</i>
                        </div>
                        <span class="nav-link-text ms-1">Proposal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'dosen-pembimbing' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('supervisions.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person</i>
                        </div>
                        <span class="nav-link-text ms-1">Dosen Pembimbing</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'pengajuan-bimbingan' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('schedules.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assignment_ind</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'jadwal-bimbingan' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('appointments.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">schedule</i>
                        </div>
                        <span class="nav-link-text ms-1">Jadwal Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'log-book' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('logbooks.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">book</i>
                        </div>
                        <span class="nav-link-text ms-1">Log Book</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white " data-bs-toggle="collapse" href="#pengajuanSeminar" role="button"
                        aria-expanded="false" aria-controls="pengajuanSeminar">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">event_note</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Seminar</span>
                    </a>
                    <div class="collapse {{ in_array($activePage, ['seminar-proposals', 'seminar-results']) ? 'show' : '' }}"
                        id="pengajuanSeminar">
                        <ul class="nav ms-4 ps-3">
                            <!-- Sub-item Proposal -->
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'seminar-proposals' ? ' active bg-gradient-primary' : '' }} "
                                    href="{{ route('seminarproposals.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">content_paste</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Proposal</span>
                                </a>
                            </li>
                            <!-- Sub-item Hasil -->
                            <li class="nav-item">
                                <a class="nav-link text-white {{ $activePage == 'result-seminars' ? ' active bg-gradient-primary' : '' }} "
                                    href="{{ route('resultSeminars.index') }}">
                                    <div
                                        class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                        <i class="material-icons opacity-10">check_circle</i>
                                    </div>
                                    <span class="nav-link-text ms-1">Hasil</span>
                                </a>
                            </li>
                        </ul>
                    </div>
                </li>
            @endif

            @if (Auth::user()->role == 'dosen')
                @if (Auth::user()->dosen->role == 'dosen_koordinator')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ $activePage == 'koordinasi-pembimbing' ? ' active bg-gradient-primary' : '' }} "
                            href="{{ route('supervisions.showKoordinasiPembimbing') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">groups</i>
                            </div>
                            <span class="nav-link-text ms-1">Koordinasi Pembimbing</span>
                        </a>
                    </li>
                @elseif(Auth::user()->dosen->role == 'kaprodi')
                    <li class="nav-item">
                        <a class="nav-link text-white {{ $activePage == 'delegate-seminar-proposal' ? ' active bg-gradient-primary' : '' }}  "
                            href="{{ route('seminarproposals.delegate') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">book</i>
                            </div>
                            <span class="nav-link-text ms-1">Delegasi Seminar Proposal</span>
                        </a>
                    </li>
                    <li class="nav-item">
                        <a class="nav-link text-white {{ $activePage == 'delegate-seminar-hasil' ? ' active bg-gradient-primary' : '' }}  "
                            href="{{ route('resultSeminars.delegate') }}">
                            <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                                <i class="material-icons opacity-10">grading</i>
                            </div>
                            <span class="nav-link-text ms-1">Delegasi Seminar Hasil</span>
                        </a>
                    </li>
                @endif
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'pengajuan-mahasiswa' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('supervisions.request') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">person_add</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Mahasiswa</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'pengajuan-sempro' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('seminarproposals.request') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">preview</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Seminar Proposal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'pengajuan-semhas' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('resultSeminars.request') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">assessment</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Seminar Hasil</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'pengajuan-bimbingan' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('appointments.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">schedule_send</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Bimbingan</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'pengajuan-logbook' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('logbooks.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">library_books</i>
                        </div>
                        <span class="nav-link-text ms-1">Pengajuan Logbook</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'mahasiswa-bimbingan' ? ' active bg-gradient-primary' : '' }} "
                        href="{{ route('supervisions.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">supervised_user_circle</i>
                        </div>
                        <span class="nav-link-text ms-1">Mahasiswa Bimbingan</span>
                    </a>
                </li>

                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'jadwal-bimbingan' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('schedules.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">calendar_today</i>
                        </div>
                        <span class="nav-link-text ms-1">Jadwal Bimbingan</span>
                    </a>
                </li>





            @endif
            @if (Auth::user()->role == 'admin' or Auth::user()->role == 'dosen')
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'seminar-proposal' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('seminarproposals.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">book</i>
                        </div>
                        <span class="nav-link-text ms-1">Seminar Proposal</span>
                    </a>
                </li>
                <li class="nav-item">
                    <a class="nav-link text-white {{ $activePage == 'seminar-hasil' ? ' active bg-gradient-primary' : '' }}  "
                        href="{{ route('resultSeminars.index') }}">
                        <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                            <i class="material-icons opacity-10">grading</i>
                        </div>
                        <span class="nav-link-text ms-1">Seminar Hasil</span>
                    </a>
                </li>
            @endif
            <li class="nav-item">
                <a class="nav-link text-white {{ $activePage == 'notifications' ? ' active bg-gradient-primary' : '' }}  "
                    href="">
                    <div class="text-white text-center me-2 d-flex align-items-center justify-content-center">
                        <i class="material-icons opacity-10">notifications</i>
                    </div>
                    <span class="nav-link-text ms-1">Notifications</span>
                </a>
            </li>
        </ul>
    </div>
</aside>
