<!--- Header with Enhanced Modern Education Theme --->
<header class="bg-gradient-to-r from-blue-50 to-white shadow-lg sticky top-0 z-50 backdrop-blur-md">
    <nav class="container mx-auto px-4 py-3 lg:px-8">
        <div class="flex justify-between items-center">
            <!-- Logo Section with Modern Typography -->
            <a href="{{ route('home') }}" class="flex items-center group">
                <svg xmlns="http://www.w3.org/2000/svg"
                    class="w-12 h-12 text-blue-600 mr-3 transform transition-transform group-hover:rotate-6"
                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                        d="M12 6.253v13m0-13C10.832 5.477 9.246 5 7.5 5S4.168 5.477 3 6.253v13C4.168 18.477 5.754 18 7.5 18s3.332.477 4.5 1.253m0-13C13.168 5.477 14.754 5 16.5 5c1.747 0 3.332.477 4.5 1.253v13C19.832 18.477 18.247 18 16.5 18c-1.746 0-3.332.477-4.5 1.253" />
                </svg>
                <span
                    class="text-2xl font-extrabold bg-gradient-to-r from-blue-600 to-indigo-700 bg-clip-text text-transparent tracking-tight">
                    EduHigh
                </span>
            </a>

            <!-- Desktop Navigation -->
            <div class="hidden lg:flex items-center space-x-6">
                <nav class="flex space-x-6">
                    @php
                        $menuItems = [
                            ['name' => 'Beranda', 'route' => 'home'],
                            ['name' => 'Tentang', 'route' => 'home'],
                            ['name' => 'Fitur', 'route' => 'home'],
                            ['name' => 'Kontak', 'route' => 'home'],
                        ];
                    @endphp
                    @foreach ($menuItems as $item)
                        <a href="{{ route($item['route']) }}"
                            class="group relative text-gray-700 font-medium hover:text-blue-600 transition-colors duration-300">
                            <span class="py-2">{{ $item['name'] }}</span>
                            <span
                                class="absolute bottom-0 left-0 w-full h-0.5 bg-blue-600 origin-left scale-x-0 group-hover:scale-x-100 transition-transform duration-300"></span>
                        </a>
                    @endforeach
                </nav>

                <!-- Authentication Buttons with Modern Style -->
                <div class="flex items-center space-x-4">
                    <a href="{{ route('login') }}"
                        class="px-5 py-2.5 text-blue-600 border-2 border-blue-600 rounded-full hover:bg-blue-50 transition-all duration-300 font-semibold text-sm tracking-wide shadow-sm hover:shadow-md">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="px-5 py-2.5 bg-blue-600 text-white rounded-full hover:bg-blue-700 transition-all duration-300 font-semibold text-sm tracking-wide shadow-sm hover:shadow-md">
                        Daftar
                    </a>
                </div>
            </div>

            <!-- Mobile Menu Toggle -->
            <button id="mobile-menu-toggle" class="lg:hidden text-gray-600 hover:text-blue-600 focus:outline-none">
                <svg class="w-7 h-7" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                    <path id="menu-icon" stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                        d="M4 6h16M4 12h16M4 18h16" />
                </svg>
            </button>
        </div>

        <!-- Mobile Menu Dropdown -->
        <div id="mobile-menu"
            class="lg:hidden fixed inset-x-0 top-16 bg-white shadow-lg rounded-b-xl transform transition-transform duration-300 origin-top scale-y-0">
            <nav class="p-4 space-y-3">
                @foreach ($menuItems as $item)
                    <a href="{{ route($item['route']) }}"
                        class="block py-3 px-4 text-gray-700 hover:bg-blue-50 hover:text-blue-600 rounded-lg transition-colors font-medium">
                        {{ $item['name'] }}
                    </a>
                @endforeach

                <div class="pt-4 space-y-3">
                    <a href="{{ route('login') }}"
                        class="block w-full text-center py-3 text-blue-600 border-2 border-blue-600 rounded-lg hover:bg-blue-50 font-semibold">
                        Masuk
                    </a>
                    <a href="{{ route('register') }}"
                        class="block w-full text-center py-3 bg-blue-600 text-white rounded-lg hover:bg-blue-700 font-semibold">
                        Daftar
                    </a>
                </div>
            </nav>
        </div>
    </nav>
</header>

<script>
    document.getElementById('mobile-menu-toggle').addEventListener('click', function() {
        const mobileMenu = document.getElementById('mobile-menu');
        const menuIcon = document.getElementById('menu-icon');

        mobileMenu.classList.toggle('scale-y-0');

        if (mobileMenu.classList.contains('scale-y-0')) {
            menuIcon.setAttribute('d', 'M4 6h16M4 12h16M4 18h16');
        } else {
            menuIcon.setAttribute('d', 'M6 18L18 6M6 6l12 12');
        }
    });
</script>
