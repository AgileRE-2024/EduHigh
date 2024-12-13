@extends('layouts.guest')

@section('title', 'Selamat Datang di Eduhigh - Sistem Bimbingan Skripsi Digital')

@section('content')
    <div class="relative min-h-screen bg-gradient-to-br from-blue-50 via-white to-indigo-50 overflow-hidden">
        <!-- Animated Background Shapes -->
        <div class="absolute inset-0 pointer-events-none overflow-hidden">
            <div
                class="absolute top-0 left-0 w-96 h-96 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
            </div>
            <div
                class="absolute top-0 right-0 w-96 h-96 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
            </div>
            <div
                class="absolute -bottom-8 left-20 w-96 h-96 bg-gradient-to-br from-purple-100 to-purple-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-4000">
            </div>
        </div>

        <div class="container mx-auto px-4 py-20 sm:py-28 lg:py-32 relative z-10">
            <div class="grid grid-cols-1 lg:grid-cols-2 gap-16 items-center">
                <!-- Content Section -->
                <div class="space-y-8 fade-in-up">
                    <!-- Badges -->
                    <div class="flex flex-wrap gap-3">
                        <span class="badge-primary">
                            <svg class="w-4 h-4 mr-1" fill="currentColor" viewBox="0 0 20 20">
                                <path
                                    d="M9.049 2.927c.3-.921 1.603-.921 1.902 0l1.07 3.292a1 1 0 00.95.69h3.462c.969 0 1.371 1.24.588 1.81l-2.8 2.034a1 1 0 00-.364 1.118l1.07 3.292c.3.921-.755 1.688-1.54 1.118l-2.8-2.034a1 1 0 00-1.175 0l-2.8 2.034c-.784.57-1.838-.197-1.539-1.118l1.07-3.292a1 1 0 00-.364-1.118L2.98 8.72c-.783-.57-.38-1.81.588-1.81h3.461a1 1 0 00.951-.69l1.07-3.292z" />
                            </svg>
                            Solusi Digital Terbaru
                        </span>
                        <span class="badge-secondary">
                            <svg class="w-4 h-4 mr-1" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M21 12a9 9 0 11-18 0 9 9 0 0118 0z" />
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                    d="M9 10a1 1 0 011-1h4a1 1 0 011 1v4a1 1 0 01-1 1h-4a1 1 0 01-1-1v-4z" />
                            </svg>
                            Untuk Mahasiswa
                        </span>
                    </div>

                    <!-- Heading -->
                    <h1
                        class="text-5xl sm:text-6xl lg:text-7xl font-black text-transparent bg-clip-text bg-gradient-to-r from-blue-600 via-indigo-600 to-purple-600 leading-tight tracking-tight slide-in-left">
                        Bimbingan Skripsi Jadi Lebih Mudah
                    </h1>

                    <!-- Description -->
                    <p class="text-xl text-gray-600 leading-relaxed max-w-2xl fade-in">
                        Eduhigh merevolusi proses bimbingan skripsi dengan platform digital yang efisien, terstruktur, dan
                        mudah digunakan. Tingkatkan kolaborasi antara mahasiswa dan dosen.
                    </p>

                    <!-- CTA Buttons -->
                    <div class="flex flex-col sm:flex-row gap-6 animate-slide-in-bottom">
                        <!-- Primary CTA -->
                        <a href="#"
                            class="group relative overflow-hidden inline-flex items-center justify-center px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 via-blue-700 to-indigo-600 text-white font-semibold shadow-lg hover:shadow-2xl transition-all duration-500 hover:scale-105 backdrop-blur-sm">
                            <span class="relative z-10 flex items-center">
                                Mulai Sekarang
                                <svg class="w-5 h-5 ml-2 transform transition-transform duration-500 group-hover:translate-x-1"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                </svg>
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-500">
                            </div>
                            <div
                                class="absolute inset-0 scale-x-0 group-hover:scale-x-100 origin-left transition-transform duration-500 bg-gradient-to-r from-white/10 to-transparent">
                            </div>
                        </a>

                        <!-- Secondary CTA -->
                        <a href="#"
                            class="group relative overflow-hidden inline-flex items-center justify-center px-8 py-4 rounded-xl bg-white/80 backdrop-blur-sm border-2 border-blue-600/30 text-blue-600 font-semibold hover:border-blue-600 hover:bg-blue-50/50 transition-all duration-500 hover:scale-105 shadow-lg hover:shadow-2xl">
                            <span class="relative z-10 flex items-center">
                                Pelajari Fitur
                                <svg class="w-5 h-5 ml-2 transform transition-all duration-500 opacity-0 -translate-y-1 group-hover:opacity-100 group-hover:translate-y-0"
                                    fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                        d="M19 9l-7 7-7-7" />
                                </svg>
                            </span>
                            <div
                                class="absolute inset-0 bg-gradient-to-r from-blue-600/5 to-transparent opacity-0 group-hover:opacity-100 transition-opacity duration-500">
                            </div>
                        </a>
                    </div>
                    <!-- Stats Section -->
                    <div class="pt-8 border-t border-gray-200">
                        <div class="grid grid-cols-3 gap-8">
                            <div class="stat-item">
                                <span class="stat-value">1000+</span>
                                <span class="stat-label">Mahasiswa</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">50+</span>
                                <span class="stat-label">Dosen</span>
                            </div>
                            <div class="stat-item">
                                <span class="stat-value">95%</span>
                                <span class="stat-label">Kepuasan</span>
                            </div>
                        </div>
                    </div>
                </div>

                <!-- Image Section -->
                <div class="hidden lg:block relative perspective-1000">
                    <div class="relative z-10 transform-3d rotate-y-12 hover:rotate-y-0 transition-transform duration-500">
                        <div class="absolute inset-0 bg-gradient-to-r from-blue-500 to-indigo-500 opacity-10 rounded-2xl">
                        </div>
                        <img src="{{ asset('assets/images/hero.png') }}" alt="Ilustrasi Bimbingan Skripsi Online"
                            class="w-full h-auto max-w-lg mx-auto rounded-2xl shadow-2xl">
                    </div>
                </div>
            </div>
        </div>
    </div>


    <div id="fitur" class="relative py-24 bg-gradient-to-b from-white to-blue-50 overflow-hidden">
        <!-- Background Pattern -->
        <div class="absolute inset-0 opacity-10">
            <div class="absolute inset-0" style="background-image: url('data:image/svg+xml,%3Csvg width="60" height="60"
                viewBox="0 0 60 60" xmlns="http://www.w3.org/2000/svg"%3E%3Cg fill="none" fill-rule="evenodd"%3E%3Cg
                fill="%239C92AC" fill-opacity="0.2"%3E%3Cpath
                d="M36 34v-4h-2v4h-4v2h4v4h2v-4h4v-2h-4zm0-30V0h-2v4h-4v2h4v4h2V6h4V4h-4zM6 34v-4H4v4H0v2h4v4h2v-4h4v-2H6zM6 4V0H4v4H0v2h4v4h2V6h4V4H6z"
                /%3E%3C/g%3E%3C/g%3E%3C/svg%3E');"></div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Section Header -->
            <div class="text-center mb-16">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm">Fitur Unggulan</span>
                <h2
                    class="text-4xl md:text-5xl font-bold mt-4 bg-gradient-to-r from-gray-900 via-blue-800 to-gray-900 bg-clip-text text-transparent">
                    Tingkatkan Efektivitas Bimbingan
                </h2>
                <p class="mt-4 text-gray-600 max-w-2xl mx-auto text-lg">
                    Platform modern untuk memudahkan proses bimbingan skripsi dari awal hingga akhir
                </p>
            </div>

            <!-- Features Grid -->
            <div class="grid grid-cols-1 md:grid-cols-2 lg:grid-cols-3 gap-8">
                <!-- Feature Card 1 -->
                <div class="group">
                    <div
                        class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute top-0 right-0 -mt-4 mr-4">
                            <span
                                class="bg-blue-100 text-blue-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">Popular</span>
                        </div>

                        <div class="text-blue-600 mb-6 transform transition-transform group-hover:scale-110 duration-300">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M9 5H7a2 2 0 00-2 2v12a2 2 0 002 2h10a2 2 0 002-2V7a2 2 0 00-2-2h-2M9 5a2 2 0 002 2h2a2 2 0 002-2M9 5a2 2 0 012-2h2a2 2 0 012 2m-3 7h3m-3 4h3m-6-4h.01M9 16h.01">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold mb-4 text-gray-900">Manajemen Progres Skripsi</h3>
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            Pantau dan kelola kemajuan skripsi Anda dengan mudah melalui dashboard interaktif yang intuitif.
                        </p>

                        <a href="#"
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                            Learn More
                            <svg class="w-4 h-4 ml-2 transform transition-transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Feature Card 2 -->
                <div class="group">
                    <div
                        class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="text-blue-600 mb-6 transform transition-transform group-hover:scale-110 duration-300">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M8 7V3m8 4V3m-9 8h10M5 21h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v12a2 2 0 002 2z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold mb-4 text-gray-900">Penjadwalan Bimbingan</h3>
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            Atur jadwal bimbingan dengan dosen pembimbing secara online tanpa kerumitan dan konflik jadwal.
                        </p>

                        <a href="#"
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                            Learn More
                            <svg class="w-4 h-4 ml-2 transform transition-transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>

                <!-- Feature Card 3 -->
                <div class="group">
                    <div
                        class="relative bg-white p-8 rounded-2xl shadow-lg hover:shadow-2xl transition-all duration-300 transform hover:-translate-y-2">
                        <div class="absolute top-0 right-0 -mt-4 mr-4">
                            <span
                                class="bg-green-100 text-green-800 text-xs font-semibold px-2.5 py-0.5 rounded-full">New</span>
                        </div>

                        <div class="text-blue-600 mb-6 transform transition-transform group-hover:scale-110 duration-300">
                            <svg class="w-14 h-14" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="1.5"
                                    d="M7 8h10M7 12h4m1 8l-4-4H5a2 2 0 01-2-2V6a2 2 0 012-2h14a2 2 0 012 2v8a2 2 0 01-2 2h-3l-4 4z">
                                </path>
                            </svg>
                        </div>

                        <h3 class="text-xl font-bold mb-4 text-gray-900">Komunikasi Terintegrasi</h3>
                        <p class="text-gray-600 mb-6 line-clamp-3">
                            Berkomunikasi dengan dosen pembimbing melalui platform terintegrasi untuk diskusi yang efektif
                            dan terstruktur.
                        </p>

                        <a href="#"
                            class="inline-flex items-center text-blue-600 font-semibold hover:text-blue-700 transition-colors">
                            Learn More
                            <svg class="w-4 h-4 ml-2 transform transition-transform group-hover:translate-x-1"
                                fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M9 5l7 7-7 7">
                                </path>
                            </svg>
                        </a>
                    </div>
                </div>
            </div>
        </div>
    </div>
    <section class="relative py-24 bg-gradient-to-br from-blue-50 via-white to-indigo-50 overflow-hidden">
        <!-- Decorative Elements -->
        <div
            class="absolute top-0 left-0 w-64 h-64 bg-gradient-to-br from-blue-100 to-blue-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob">
        </div>
        <div
            class="absolute bottom-0 right-0 w-64 h-64 bg-gradient-to-br from-indigo-100 to-indigo-200 rounded-full mix-blend-multiply filter blur-xl opacity-70 animate-blob animation-delay-2000">
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <!-- Header -->
            <div class="max-w-4xl mx-auto text-center mb-16">
                <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm mb-4 block">Tentang Kami</span>
                <h2
                    class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-6">
                    Revolusi Bimbingan Skripsi Digital
                </h2>
                <p class="text-xl text-gray-600 leading-relaxed">
                    Platform inovatif yang menghadirkan pengalaman bimbingan skripsi yang lebih efektif dan terstruktur
                </p>
            </div>

            <div class="grid lg:grid-cols-2 gap-16 items-center">
                <!-- Content Column -->
                <div class="space-y-8">
                    <div
                        class="bg-white/80 backdrop-blur-sm rounded-2xl p-8 shadow-lg hover:shadow-xl transition-shadow duration-300">
                        <h3 class="text-2xl font-bold text-gray-800 mb-4">Misi Kami</h3>
                        <p class="text-gray-600 leading-relaxed mb-8">
                            Kami berkomitmen untuk memudahkan dan meningkatkan kualitas proses bimbingan skripsi melalui
                            teknologi digital yang inovatif.
                        </p>

                        <ul class="space-y-4">
                            @php
                                $features = [
                                    'Manajemen bimbingan skripsi yang terstruktur',
                                    'Komunikasi real-time antara mahasiswa dan dosen',
                                    'Penjadwalan bimbingan yang fleksibel',
                                    'Pelacakan progres skripsi yang mudah',
                                    'Penyimpanan dokumen skripsi yang aman',
                                ];
                            @endphp
                            @foreach ($features as $feature)
                                <li class="flex items-center space-x-3 group">
                                    <span
                                        class="flex-shrink-0 w-8 h-8 rounded-lg bg-blue-100 text-blue-600 flex items-center justify-center group-hover:bg-blue-600 group-hover:text-white transition-colors duration-300">
                                        <svg class="w-5 h-5" fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M5 13l4 4L19 7" />
                                        </svg>
                                    </span>
                                    <span class="text-gray-700 group-hover:text-blue-600 transition-colors duration-300">
                                        {{ $feature }}
                                    </span>
                                </li>
                            @endforeach
                        </ul>
                    </div>

                    <!-- Stats Cards -->
                    <div class="grid grid-cols-3 gap-6">
                        @foreach ([['1000+', 'Mahasiswa', 'users'], ['50+', 'Dosen', 'academic-cap'], ['95%', 'Kepuasan', 'star']] as [$value, $label, $icon])
                            <div
                                class="bg-white/80 backdrop-blur-sm rounded-xl p-6 text-center hover:shadow-lg transition-shadow duration-300">
                                <div class="text-blue-600 mb-2">
                                    <i class="fas fa-{{ $icon }} text-2xl"></i>
                                </div>
                                <div class="text-2xl font-bold text-gray-800">{{ $value }}</div>
                                <div class="text-sm text-gray-600">{{ $label }}</div>
                            </div>
                        @endforeach
                    </div>
                </div>

                <!-- Image Column -->
                <div class="relative group">
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-2xl transform rotate-6 group-hover:rotate-3 transition-transform duration-300">
                    </div>
                    <div class="relative bg-white rounded-2xl overflow-hidden shadow-lg">
                        <img src="{{ asset('images/about-us-illustration.svg') }}" alt="Ilustrasi Eduhigh"
                            class="w-full h-auto transform group-hover:scale-105 transition-transform duration-500">

                        <!-- Floating Achievement Card -->
                        <div
                            class="absolute -bottom-6 -right-6 bg-white rounded-xl shadow-xl p-4 transform group-hover:translate-y-2 transition-transform duration-300">
                            <div class="flex items-center space-x-3">
                                <div class="bg-blue-100 rounded-lg p-2">
                                    <svg class="w-8 h-8 text-blue-600" fill="none" stroke="currentColor"
                                        viewBox="0 0 24 24">
                                        <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                            d="M9 12l2 2 4-4m5.618-4.016A11.955 11.955 0 0112 2.944a11.955 11.955 0 01-8.618 3.04A12.02 12.02 0 003 9c0 5.591 3.824 10.29 9 11.622 5.176-1.332 9-6.03 9-11.622 0-1.042-.133-2.052-.382-3.016z" />
                                    </svg>
                                </div>
                                <div>
                                    <div class="text-2xl font-bold text-gray-800">1000+</div>
                                    <div class="text-sm text-gray-600">Mahasiswa Terbimbing</div>
                                </div>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            <!-- CTA Section -->
            <div class="mt-20 text-center">
                <a href="{{ route('register') }}"
                    class="group relative inline-flex items-center justify-center px-8 py-4 rounded-xl bg-gradient-to-r from-blue-600 to-indigo-600 text-white font-semibold shadow-lg hover:shadow-2xl transition-all duration-300 hover:scale-105">
                    <span class="relative z-10 flex items-center">
                        Bergabung Sekarang
                        <svg class="w-5 h-5 ml-2 transform transition-transform duration-300 group-hover:translate-x-1"
                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                        </svg>
                    </span>
                    <div
                        class="absolute inset-0 bg-gradient-to-r from-white/20 to-transparent opacity-0 group-hover:opacity-20 transition-opacity duration-300 rounded-xl">
                    </div>
                </a>
            </div>
        </div>
    </section>
    <section id="contact" class="relative py-24 bg-gradient-to-br from-blue-50 via-white to-indigo-50 overflow-hidden">
        <!-- Decorative Elements -->
        <div class="absolute inset-0 pointer-events-none">
            <div
                class="absolute right-0 top-0 w-1/3 h-1/3 bg-gradient-to-br from-blue-100/40 to-indigo-100/40 rounded-full filter blur-3xl transform translate-x-1/2 -translate-y-1/2">
            </div>
            <div
                class="absolute left-0 bottom-0 w-1/3 h-1/3 bg-gradient-to-tr from-blue-100/40 to-indigo-100/40 rounded-full filter blur-3xl transform -translate-x-1/2 translate-y-1/2">
            </div>
        </div>

        <div class="container mx-auto px-4 relative z-10">
            <div class="max-w-5xl mx-auto">
                <!-- Header -->
                <div class="text-center mb-16">
                    <span class="text-blue-600 font-semibold tracking-wider uppercase text-sm mb-4 block">Kontak</span>
                    <h2
                        class="text-4xl md:text-5xl font-bold bg-gradient-to-r from-blue-600 to-indigo-600 bg-clip-text text-transparent mb-6">
                        Hubungi Kami
                    </h2>
                    <p class="text-xl text-gray-600 max-w-2xl mx-auto">
                        Kami siap membantu Anda. Jangan ragu untuk menghubungi kami jika memiliki pertanyaan.
                    </p>
                </div>

                <!-- Contact Card -->
                <div class="bg-white/80 backdrop-blur-sm rounded-2xl shadow-xl overflow-hidden">
                    <div class="md:flex">
                        <!-- Contact Info -->
                        <div class="md:w-2/5 p-8 lg:p-12 bg-gradient-to-br from-blue-600 to-indigo-600">
                            <h3 class="text-2xl font-bold text-white mb-8">Informasi Kontak</h3>

                            <ul class="space-y-6">
                                <li class="flex items-center space-x-4 group">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors duration-300">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M17.657 16.657L13.414 20.9a1.998 1.998 0 01-2.827 0l-4.244-4.243a8 8 0 1111.314 0z" />
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M15 11a3 3 0 11-6 0 3 3 0 016 0z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-white/60 text-sm font-medium mb-1">Alamat</h4>
                                        <p class="text-white">Jl. Pendidikan No. 123, Jakarta, Indonesia</p>
                                    </div>
                                </li>

                                <li class="flex items-center space-x-4 group">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors duration-300">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 8l7.89 5.26a2 2 0 002.22 0L21 8M5 19h14a2 2 0 002-2V7a2 2 0 00-2-2H5a2 2 0 00-2 2v10a2 2 0 002 2z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-white/60 text-sm font-medium mb-1">Email</h4>
                                        <p class="text-white">info@eduhigh.com</p>
                                    </div>
                                </li>

                                <li class="flex items-center space-x-4 group">
                                    <div
                                        class="flex-shrink-0 w-12 h-12 bg-white/10 rounded-lg flex items-center justify-center group-hover:bg-white/20 transition-colors duration-300">
                                        <svg class="w-6 h-6 text-white" fill="none" stroke="currentColor"
                                            viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M3 5a2 2 0 012-2h3.28a1 1 0 01.948.684l1.498 4.493a1 1 0 01-.502 1.21l-2.257 1.13a11.042 11.042 0 005.516 5.516l1.13-2.257a1 1 0 011.21-.502l4.493 1.498a1 1 0 01.684.949V19a2 2 0 01-2 2h-1C9.716 21 3 14.284 3 6V5z" />
                                        </svg>
                                    </div>
                                    <div class="flex-1">
                                        <h4 class="text-white/60 text-sm font-medium mb-1">Telepon</h4>
                                        <p class="text-white">+62 123 4567 890</p>
                                    </div>
                                </li>
                            </ul>

                            <!-- Social Links -->
                            <div class="mt-12 flex space-x-4">
                                @foreach (['facebook', 'twitter', 'instagram'] as $social)
                                    <a href="#"
                                        class="w-10 h-10 bg-white/10 rounded-lg flex items-center justify-center hover:bg-white/20 transition-colors duration-300">
                                        <i class="fab fa-{{ $social }} text-white"></i>
                                    </a>
                                @endforeach
                            </div>
                        </div>

                        <!-- Contact Form -->
                        <div class="md:w-3/5 p-8 lg:p-12">
                            <h3 class="text-2xl font-bold text-gray-900 mb-8">Kirim Pesan</h3>

                            <form action="" method="POST" class="space-y-6">
                                @csrf
                                <div class="form-group">
                                    <label for="name" class="text-gray-700 text-sm font-semibold mb-2 block">Nama
                                        Lengkap</label>
                                    <input type="text" id="name" name="name" required
                                        class="form-input w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                        placeholder="Masukkan nama lengkap">
                                </div>

                                <div class="form-group">
                                    <label for="email"
                                        class="text-gray-700 text-sm font-semibold mb-2 block">Email</label>
                                    <input type="email" id="email" name="email" required
                                        class="form-input w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300"
                                        placeholder="Masukkan alamat email">
                                </div>

                                <div class="form-group">
                                    <label for="message"
                                        class="text-gray-700 text-sm font-semibold mb-2 block">Pesan</label>
                                    <textarea id="message" name="message" rows="4" required
                                        class="form-textarea w-full px-4 py-3 rounded-lg border border-gray-200 focus:border-blue-500 focus:ring-2 focus:ring-blue-200 transition-all duration-300 resize-none"
                                        placeholder="Tulis pesan Anda di sini..."></textarea>
                                </div>

                                <button type="submit" class="group relative w-full">
                                    <div
                                        class="absolute -inset-0.5 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg blur opacity-30 group-hover:opacity-100 transition duration-300">
                                    </div>
                                    <div
                                        class="relative w-full px-6 py-3 bg-gradient-to-r from-blue-600 to-indigo-600 rounded-lg text-white font-semibold flex items-center justify-center">
                                        <span class="mr-2">Kirim Pesan</span>
                                        <svg class="w-5 h-5 transform group-hover:translate-x-1 transition-transform"
                                            fill="none" stroke="currentColor" viewBox="0 0 24 24">
                                            <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2"
                                                d="M13 7l5 5m0 0l-5 5m5-5H6" />
                                        </svg>
                                    </div>
                                </button>
                            </form>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </section>
@endsection

@push('styles')
    <style>
        /* Animations */
        @keyframes blob {
            0% {
                transform: translate(0px, 0px) scale(1);
            }

            33% {
                transform: translate(30px, -50px) scale(1.1);
            }

            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }

            100% {
                transform: translate(0px, 0px) scale(1);
            }
        }

        .animate-blob {
            animation: blob 7s infinite;
        }

        .animation-delay-2000 {
            animation-delay: 2s;
        }

        .animation-delay-4000 {
            animation-delay: 4s;
        }

        /* Components */
        .badge-primary {
            @apply inline-flex items-center px-4 py-2 bg-blue-100 text-blue-800 rounded-full text-sm font-semibold transition-transform hover:scale-105;
        }

        .badge-secondary {
            @apply inline-flex items-center px-4 py-2 bg-purple-100 text-purple-800 rounded-full text-sm font-semibold transition-transform hover:scale-105;
        }

        .btn-primary {
            @apply group inline-flex items-center px-8 py-4 bg-gradient-to-r from-blue-600 to-indigo-600 text-white rounded-xl font-semibold shadow-lg hover:shadow-xl transition-all duration-300 hover:-translate-y-1;
        }

        .btn-secondary {
            @apply group inline-flex items-center px-8 py-4 border-2 border-blue-600 text-blue-600 rounded-xl font-semibold hover:bg-blue-50 transition-all duration-300;
        }

        .stat-item {
            @apply flex flex-col items-center space-y-1;
        }

        .stat-value {
            @apply text-2xl font-bold text-blue-600;
        }

        .stat-label {
            @apply text-sm text-gray-500;
        }

        .perspective-1000 {
            perspective: 1000px;
        }

        .transform-3d {
            transform-style: preserve-3d;
        }

        .rotate-y-12 {
            transform: rotateY(12deg);
        }

        .hover\:rotate-y-0:hover {
            transform: rotateY(0deg);
        }

        /* Fade and Slide Animations */
        .fade-in {
            animation: fadeIn 1s ease-out;
        }

        .fade-in-up {
            animation: fadeInUp 1s ease-out;
        }

        .slide-in-left {
            animation: slideInLeft 1s ease-out;
        }

        @keyframes slide-in-bottom {
            0% {
                transform: translateY(30px);
                opacity: 0;
            }

            100% {
                transform: translateY(0);
                opacity: 1;
            }
        }

        .animate-slide-in-bottom {
            animation: slide-in-bottom 0.8s cubic-bezier(0.25, 0.46, 0.45, 0.94) both;
        }

        @keyframes fadeIn {
            from {
                opacity: 0;
            }

            to {
                opacity: 1;
            }
        }

        @keyframes fadeInUp {
            from {
                opacity: 0;
                transform: translateY(20px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        @keyframes slideInLeft {
            from {
                opacity: 0;
                transform: translateX(-30px);
            }

            to {
                opacity: 1;
                transform: translateX(0);
            }
        }

        @keyframes slideInBottom {
            from {
                opacity: 0;
                transform: translateY(30px);
            }

            to {
                opacity: 1;
                transform: translateY(0);
            }
        }

        .line-clamp-3 {
            display: -webkit-box;
            -webkit-line-clamp: 3;
            -webkit-box-orient: vertical;
            overflow: hidden;
        }

        @keyframes float {
            0% {
                transform: translateY(0px);
            }

            50% {
                transform: translateY(-10px);
            }

            100% {
                transform: translateY(0px);
            }
        }

        .float-animation {
            animation: float 3s ease-in-out infinite;
        }
    </style>
@endpush
