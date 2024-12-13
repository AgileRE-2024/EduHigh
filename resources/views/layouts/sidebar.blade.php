<aside
    class="w-64 min-h-screen fixed bg-white/80 backdrop-blur-xl border-r border-gray-100 shadow-lg top-0 left-0 transition-all duration-300 group/sidebar">
    {{-- Profile Section with glassmorphism effect --}}
    <div class="relative px-6 py-6 border-b border-gray-100 bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800">
        <div class="flex items-center space-x-4">
            <div class="relative group/profile">
                <img class="h-16 w-16 rounded-full object-cover ring-4 ring-white/20 p-0.5 transition-all duration-300 group-hover/profile:scale-105"
                    src="{{ Auth::user()->image ? asset('storage/images/users/' . Auth::user()->image) : asset('assets/images/users/default.jpg') }}"
                    alt="{{ Auth::user()->name ?? 'Profile' }}">
                <span
                    class="absolute bottom-1 right-1 w-4 h-4 bg-emerald-400 border-2 border-white rounded-full shadow-lg animate-pulse"></span>
            </div>
            <div class="flex flex-col">
                <h2 class="text-xl font-bold text-white truncate tracking-tight">
                    {{ Auth::user()->name ?? 'User Name' }}
                </h2>
                <span
                    class="text-sm text-blue-100 font-medium tracking-wide">{{ Auth::user()->nim ?? '187221049' }}</span>
            </div>
        </div>
    </div>

    <nav class="px-4 py-6 space-y-2">
        @php
            $menuItems = [
                [
                    'route' => 'dashboard',
                    'label' => 'Dashboard',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M3 12l2-2m0 0l7-7 7 7M5 10v10a1 1 0 001 1h3m10-11l2 2m-2-2v10a1 1 0 01-1 1h-3m-6 0a1 1 0 001-1v-4a1 1 0 011-1h2a1 1 0 011 1v4a1 1 0 001 1m-6 0h6"/>',
                    'role' => ['admin', 'dosen', 'mahasiswa'],
                ],
                [
                    'route' => 'profile.index',
                    'label' => 'Profile',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z"/>',
                    'role' => ['admin', 'dosen', 'mahasiswa'],
                ],
                [
                    'route' => 'proposals.index',
                    'label' => 'Proposal',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253"/>',
                    'role' => ['mahasiswa'],
                ],
                [
                    'route' => 'supervisions.index',
                    'label' => 'Supervisions',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                    'role' => ['mahasiswa', 'dosen'],
                ],
                [
                    'route' => 'logbooks.index',
                    'label' => 'Logbooks',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z"/>',
                    'role' => ['mahasiswa', 'dosen'],
                ],
                [
                    'route' => 'schedules.index',
                    'label' => 'Schedules',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z"/>',
                    'role' => ['mahasiswa', 'dosen'],
                ],
                [
                    'route' => 'appointments.index',
                    'label' => 'Appointments',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                    'role' => ['mahasiswa', 'dosen'],
                ],
                [
                    'route' => 'appointments.request',
                    'label' => 'Request Appointments',
                    'icon' =>
                        '<path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7"/>',
                    'role' => ['dosen'],
                ],
            ];
        @endphp

        @foreach ($menuItems as $item)
            @if (in_array(Auth::user()->role, $item['role']))
                <a href="{{ route($item['route']) }}"
                    class="group flex items-center px-4 py-3.5 rounded-xl transition-all duration-300
                        {{ request()->routeIs($item['route'])
                            ? 'bg-gradient-to-r from-blue-600 to-blue-700 text-white shadow-lg shadow-blue-500/30 scale-105'
                            : 'text-gray-700 hover:bg-blue-50 hover:text-blue-600 hover:shadow-md hover:scale-[1.02]' }}">
                    <div class="relative">
                        <svg class="w-5 h-5 transition-all duration-300 group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            {!! $item['icon'] !!}
                        </svg>
                        @if (request()->routeIs($item['route']))
                            <span class="absolute -right-1 -top-1 w-2 h-2 bg-white rounded-full"></span>
                        @endif
                    </div>
                    <span class="ml-4 font-semibold tracking-wide">{{ $item['label'] }}</span>
                </a>
            @endif
        @endforeach
    </nav>

    {{-- Logout Button with improved styling --}}
    <div class="absolute w-full bottom-0 px-6 py-6 border-t border-gray-100 bg-white/80 backdrop-blur-sm">
        <form action="{{ route('logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="group flex items-center justify-center w-full px-4 py-3.5 text-sm font-semibold text-white
                    bg-gradient-to-br from-blue-600 via-blue-700 to-indigo-800 rounded-xl 
                    transition-all duration-300 
                    hover:shadow-lg hover:shadow-blue-500/30 hover:scale-[1.02]
                    focus:ring-2 focus:ring-blue-500 focus:ring-offset-2
                    active:scale-95">
                <svg class="w-4 h-4 mr-2 transition-transform duration-300 group-hover:rotate-12" fill="none"
                    stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                </svg>
                <span class="tracking-wider">Sign Out</span>
            </button>
        </form>
    </div>
</aside>
