<header class="bg-white/80 backdrop-blur-xl shadow-lg border-b border-gray-100 sticky top-0 z-50">
    <div class="container mx-auto px-6 py-4">
        <div class="flex items-center justify-between">
            <!-- Brand with Enhanced Gradient Text and Animation -->
            <div class="flex items-center space-x-4 group">
                <div class="relative">
                    <img src="{{ Auth::user()->image ? asset('storage/images/users/' . Auth::user()->image) : asset('assets/images/users/default.jpg') }}"
                        alt="Logo" class="h-12 w-auto transition-transform duration-300 group-hover:scale-105">
                    <div
                        class="absolute inset-0 bg-blue-500/20 rounded-full blur-xl group-hover:blur-2xl transition-all duration-300 opacity-0 group-hover:opacity-100">
                    </div>
                </div>
                <div class="flex flex-col">
                    <span
                        class="text-2xl font-bold bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-800 bg-clip-text text-transparent tracking-tight hover:tracking-normal transition-all duration-300">
                        Universitas Airlangga
                    </span>
                    <span class="text-sm text-gray-500 font-medium tracking-wide">Excellence with Morality</span>
                </div>
            </div>

            <!-- Right Actions with Enhanced Interactivity -->
            <div class="flex items-center space-x-8">
                <!-- Enhanced Search Bar -->
                <div class="hidden md:block relative group">
                    <div class="relative">
                        <span
                            class="absolute inset-y-0 left-0 flex items-center pl-4 transition-transform duration-300 group-focus-within:scale-110">
                            <svg class="w-5 h-5 text-gray-400 transition-colors duration-300 group-hover:text-blue-500"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 21L15 15M17 10C17 13.866 13.866 17 10 17C6.13401 17 3 13.866 3 10C3 6.13401 6.13401 3 10 3C13.866 3 17 6.13401 17 10Z">
                                </path>
                            </svg>
                        </span>
                        <input type="text"
                            class="w-64 py-2.5 pl-12 pr-4 text-gray-700 bg-gray-50/70 border border-gray-200 rounded-xl
                                placeholder-gray-400 transition-all duration-300
                                focus:outline-none focus:border-blue-500 focus:ring-4 focus:ring-blue-200/50 focus:bg-white focus:w-80
                                hover:border-blue-300 hover:bg-gray-50"
                            placeholder="Search anything...">
                    </div>
                </div>

                <!-- Enhanced Notifications -->
                <div class="relative group">
                    <button
                        class="relative p-2.5 text-gray-600 hover:text-blue-600 rounded-xl
                        transition-all duration-300 focus:outline-none focus:ring-4 focus:ring-blue-200/50
                        hover:bg-blue-50 active:scale-95">
                        <svg class="w-6 h-6 transition-transform duration-300 group-hover:scale-110" fill="none"
                            stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M15 17h5l-1.405-1.405A2.032 2.032 0 0118 14.158V11a6.002 6.002 0 00-4-5.659V5a2 2 0 10-4 0v.341C7.67 6.165 6 8.388 6 11v3.159c0 .538-.214 1.055-.595 1.436L4 17h5m6 0v1a3 3 0 11-6 0v-1m6 0H9">
                            </path>
                        </svg>

                        {{-- Enhanced Notification Badge --}}
                        <span class="absolute -top-1 -right-1 flex h-5 w-5">
                            <span
                                class="animate-ping absolute inline-flex h-full w-full rounded-full bg-red-400 opacity-75"></span>
                            <span
                                class="relative inline-flex rounded-full h-5 w-5 bg-gradient-to-r from-red-500 to-red-600 items-center justify-center text-[10px] text-white font-bold">3</span>
                        </span>
                    </button>

                    {{-- Enhanced Notifications Dropdown --}}
                    <div
                        class="hidden group-hover:block absolute right-0 mt-4 w-96 bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-100 py-2 transform transition-all duration-300 opacity-0 group-hover:opacity-100">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <div class="flex items-center justify-between">
                                <h3 class="text-sm font-semibold text-gray-800">Notifications</h3>
                                <span class="px-2 py-1 text-xs font-medium text-blue-600 bg-blue-50 rounded-full">3
                                    New</span>
                            </div>
                        </div>
                        <div class="max-h-[400px] overflow-y-auto">
                            @for ($i = 1; $i <= 3; $i++)
                                <div class="px-4 py-3 hover:bg-gray-50 transition-colors duration-200">
                                    <div class="flex items-start space-x-3">
                                        <div class="flex-shrink-0 mt-1">
                                            <div
                                                class="h-8 w-8 rounded-full bg-blue-100 flex items-center justify-center">
                                                <svg class="w-4 h-4 text-blue-600" fill="none" stroke="currentColor"
                                                    viewBox="0 0 24 24">
                                                    <path stroke-linecap="round" stroke-linejoin="round"
                                                        stroke-width="2"
                                                        d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                                    </path>
                                                </svg>
                                            </div>
                                        </div>
                                        <div class="flex-1">
                                            <p class="text-sm text-gray-800 font-medium">New assignment uploaded</p>
                                            <p class="text-xs text-gray-500 mt-1">Your teacher uploaded a new assignment
                                                for Mathematics II</p>
                                            <span class="text-xs text-blue-600 font-medium mt-2 inline-block">2 mins
                                                ago</span>
                                        </div>
                                    </div>
                                </div>
                            @endfor
                        </div>
                        <div class="px-4 py-2 border-t border-gray-100">
                            <a href="#" class="text-sm text-blue-600 hover:text-blue-700 font-medium">View all
                                notifications</a>
                        </div>
                    </div>
                </div>

                <!-- Enhanced User Menu -->
                <div class="relative group">
                    <button class="flex items-center space-x-3 focus:outline-none group">
                        <div class="relative">
                            <img class="h-10 w-10 rounded-full object-cover ring-2 ring-blue-500/30 transition-all duration-300 group-hover:ring-blue-500/80"
                                src="{{ Auth::user()->profile_photo_url ?? asset('images/profile.jpg') }}"
                                alt="{{ Auth::user()->name ?? 'Profile' }}">
                            <span
                                class="absolute bottom-0 right-0 h-3 w-3 bg-green-400 border-2 border-white rounded-full"></span>
                        </div>
                        <svg class="w-4 h-4 text-gray-400 transition-transform duration-300 group-hover:rotate-180"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M19 9l-7 7-7-7" />
                        </svg>
                    </button>

                    {{-- Enhanced User Dropdown --}}
                    <div
                        class="hidden group-hover:block absolute right-0 mt-1 w-64 bg-white/80 backdrop-blur-xl rounded-2xl shadow-xl border border-gray-100 py-2 transform transition-all duration-300 opacity-0 group-hover:opacity-100">
                        <div class="px-4 py-3 border-b border-gray-100">
                            <p class="text-sm font-medium text-gray-800">{{ Auth::user()->name ?? 'User Name' }}</p>
                            <p class="text-xs text-gray-500 mt-1">{{ Auth::user()->email ?? 'user@example.com' }}</p>
                        </div>

                        <div class="py-2">
                            <a href="{{ route('profile.index') }}"
                                class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M16 7a4 4 0 11-8 0 4 4 0 018 0zM12 14a7 7 0 00-7 7h14a7 7 0 00-7-7z" />
                                </svg>
                                Profile Settings
                            </a>
                            <a href="#"
                                class="flex items-center px-5 py-3 text-sm text-gray-700 hover:bg-gray-50 transition-colors duration-200">
                                <svg class="w-4 h-4 mr-3 text-gray-400" fill="none" stroke="currentColor"
                                    viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M10.325 4.317c.426-1.756 2.924-1.756 3.35 0a1.724 1.724 0 002.573 1.066c1.543-.94 3.31.826 2.37 2.37a1.724 1.724 0 001.065 2.572c1.756.426 1.756 2.924 0 3.35a1.724 1.724 0 00-1.066 2.573c.94 1.543-.826 3.31-2.37 2.37a1.724 1.724 0 00-2.572 1.065c-.426 1.756-2.924 1.756-3.35 0a1.724 1.724 0 00-2.573-1.066c-1.543.94-3.31-.826-2.37-2.37a1.724 1.724 0 00-1.065-2.572c-1.756-.426-1.756-2.924 0-3.35a1.724 1.724 0 001.066-2.573c-.94-1.543.826-3.31 2.37-2.37.996.608 2.296.07 2.572-1.065z" />
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M15 12a3 3 0 11-6 0 3 3 0 016 0z" />
                                </svg>
                                Account Settings
                            </a>
                        </div>

                        <div class="py-2 border-t border-gray-100">
                            <form action="{{ route('logout') }}" method="POST">
                                @csrf
                                <button type="submit"
                                    class="flex items-center w-full px-5 py-3 text-sm text-red-600 hover:bg-red-50 transition-colors duration-200">
                                    <svg class="w-4 h-4 mr-3 text-red-500" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M17 16l4-4m0 0l-4-4m4 4H7m6 4v1a3 3 0 01-3 3H6a3 3 0 01-3-3V7a3 3 0 013-3h4a3 3 0 013 3v1" />
                                    </svg>
                                    Sign Out
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</header>
