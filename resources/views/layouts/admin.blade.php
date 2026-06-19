<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>@yield('title', 'Admin Dashboard - PrediksiRumah')</title>
    
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex flex-col">

    <!-- TopNavBar -->
    <header class="w-full sticky top-0 z-50 bg-background shadow-[16px_16px_32px_#D1D9E6,-16px_-16px_32px_#FFFFFF]">
        <nav class="flex justify-between items-center px-margin-desktop py-4 w-full max-w-container-max mx-auto">
            <!-- Brand -->
            <div class="flex items-center gap-6 lg:gap-8">
                <a href="{{ url('/dashboard') }}" class="font-headline-md text-headline-md font-bold text-primary">PrediksiRumah Admin</a>
                
                <!-- Desktop Navigation Links -->
                <div class="hidden md:flex items-center gap-3 lg:gap-6">
                    <a href="{{ url('/dashboard') }}"
                        class="flex items-center gap-1.5 px-3 lg:px-4 py-2 rounded-xl text-label-md font-medium transition-all {{ request()->is('dashboard') ? 'neumorphic-inset text-primary font-bold' : 'text-on-surface-variant hover:text-primary hover:scale-105 active:scale-95' }}">
                        <span class="material-symbols-outlined text-body-md">dashboard</span> Overview
                    </a>
                    <a href="{{ url('/dataset') }}"
                        class="flex items-center gap-1.5 px-3 lg:px-4 py-2 rounded-xl text-label-md font-medium transition-all {{ request()->is('dataset') ? 'neumorphic-inset text-primary font-bold' : 'text-on-surface-variant hover:text-primary hover:scale-105 active:scale-95' }}">
                        <span class="material-symbols-outlined text-body-md">database</span> Dataset
                    </a>
                    <a href="{{ url('/settings') }}"
                        class="flex items-center gap-1.5 px-3 lg:px-4 py-2 rounded-xl text-label-md font-medium transition-all {{ request()->is('settings') ? 'neumorphic-inset text-primary font-bold' : 'text-on-surface-variant hover:text-primary hover:scale-105 active:scale-95' }}">
                        <span class="material-symbols-outlined text-body-md">settings_suggest</span> Settings
                    </a>
                    <a href="{{ url('/guide') }}"
                        class="flex items-center gap-1.5 px-3 lg:px-4 py-2 rounded-xl text-label-md font-medium transition-all {{ request()->is('guide') ? 'neumorphic-inset text-primary font-bold' : 'text-on-surface-variant hover:text-primary hover:scale-105 active:scale-95' }}">
                        <span class="material-symbols-outlined text-body-md">help</span> Panduan
                    </a>
                </div>
            </div>

            <!-- Right Actions -->
            <div class="hidden md:flex items-center gap-element-gap">
                <a class="text-on-surface-variant font-medium hover:text-primary transition-all duration-300 cursor-pointer active:scale-95 flex items-center gap-1 text-label-md"
                    href="{{ url('/logout') }}" onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin keluar dari Dashboard Admin?')) { document.getElementById('logout-form').submit(); }">
                    <span class="material-symbols-outlined text-body-md">logout</span> Logout
                </a>
                <form id="logout-form" action="{{ url('/logout') }}" method="POST" class="hidden">
                    @csrf
                </form>
            </div>
            <!-- Mobile Menu Toggle -->
            <button class="md:hidden neumorphic-outset p-2 rounded-lg flex items-center justify-center active:scale-95 transition-transform z-50 relative" id="mobile-menu-toggle">
                <span class="material-symbols-outlined" id="mobile-menu-icon">menu</span>
            </button>
        </nav>
        
        <!-- Mobile Dropdown Menu -->
        <div id="mobile-menu" class="absolute top-full left-0 right-0 mx-margin-mobile mt-2 p-6 rounded-3xl neumorphic-outset bg-background/95 backdrop-blur-md z-40 flex flex-col gap-3 opacity-0 pointer-events-none transform -translate-y-2 transition-all duration-300 md:hidden">
            <a class="{{ request()->is('dashboard') ? 'text-primary font-bold neumorphic-inset' : 'text-on-surface hover:text-primary' }} p-3 rounded-xl transition-all duration-200 font-body-md text-body-md flex items-center gap-2" href="{{ url('/dashboard') }}">
                <span class="material-symbols-outlined text-body-md">dashboard</span> Overview
            </a>
            <a class="{{ request()->is('dataset') ? 'text-primary font-bold neumorphic-inset' : 'text-on-surface hover:text-primary' }} p-3 rounded-xl transition-all duration-200 font-body-md text-body-md flex items-center gap-2" href="{{ url('/dataset') }}">
                <span class="material-symbols-outlined text-body-md">database</span> Dataset Management
            </a>
            <a class="{{ request()->is('settings') ? 'text-primary font-bold neumorphic-inset' : 'text-on-surface hover:text-primary' }} p-3 rounded-xl transition-all duration-200 font-body-md text-body-md flex items-center gap-2" href="{{ url('/settings') }}">
                <span class="material-symbols-outlined text-body-md">settings_suggest</span> Model Settings
            </a>
            <a class="{{ request()->is('guide') ? 'text-primary font-bold neumorphic-inset' : 'text-on-surface hover:text-primary' }} p-3 rounded-xl transition-all duration-200 font-body-md text-body-md flex items-center gap-2" href="{{ url('/guide') }}">
                <span class="material-symbols-outlined text-body-md">help</span> Panduan Penggunaan
            </a>
            <a class="text-on-surface hover:text-primary p-3 rounded-xl transition-colors font-body-md text-body-md flex items-center gap-2" href="{{ url('/logout') }}" onclick="event.preventDefault(); if (confirm('Apakah Anda yakin ingin keluar dari Dashboard Admin?')) { document.getElementById('logout-form').submit(); }">
                <span class="material-symbols-outlined text-body-md">logout</span> Logout
            </a>
        </div>
    </header>

    <main class="flex-grow w-full max-w-container-max mx-auto px-margin-desktop py-base md:py-10">
        @yield('content')
    </main>

    <!-- Footer -->
    <footer class="w-full mt-auto bg-background shadow-[16px_16px_32px_#D1D9E6,-16px_-16px_32px_#FFFFFF]">
        <div class="flex flex-col md:flex-row justify-between items-center px-margin-desktop py-8 w-full max-w-container-max mx-auto gap-gutter">
            <div class="flex flex-col items-center md:items-start">
                <span class="font-headline-md text-headline-md text-primary font-bold mb-2">PrediksiRumah</span>
                <span class="font-label-sm text-label-sm text-secondary">© {{ date('Y') }} PrediksiRumah - Universitas Muhammadiyah Cirebon (UMC)</span>
            </div>
            <div class="flex gap-8 items-center">
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">Privacy Policy</a>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">Terms of Service</a>
                <a class="font-label-sm text-label-sm text-on-surface-variant hover:text-secondary transition-colors" href="#">Contact</a>
            </div>
        </div>
    </footer>

    <!-- Global Scripts -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            // Micro-interactions for Neumorphic buttons
            document.querySelectorAll('button, a.neumorphic-outset').forEach(button => {
                button.addEventListener('mousedown', () => {
                    if (button.classList.contains('neumorphic-outset')) {
                        button.style.transform = 'scale(0.97)';
                    }
                });
                button.addEventListener('mouseup', () => {
                    button.style.transform = 'scale(1)';
                });
            });

            // Mobile menu logic
            const mobileMenuToggle = document.getElementById('mobile-menu-toggle');
            const mobileMenu = document.getElementById('mobile-menu');
            const mobileMenuIcon = document.getElementById('mobile-menu-icon');
            
            if (mobileMenuToggle && mobileMenu) {
                mobileMenuToggle.addEventListener('click', () => {
                    const isOpen = mobileMenu.classList.contains('opacity-100');
                    if (isOpen) {
                        mobileMenu.classList.remove('opacity-100', 'pointer-events-auto', 'translate-y-0');
                        mobileMenu.classList.add('opacity-0', 'pointer-events-none', '-translate-y-2');
                        mobileMenuIcon.textContent = 'menu';
                    } else {
                        mobileMenu.classList.remove('opacity-0', 'pointer-events-none', '-translate-y-2');
                        mobileMenu.classList.add('opacity-100', 'pointer-events-auto', 'translate-y-0');
                        mobileMenuIcon.textContent = 'close';
                    }
                });
            }
        });
    </script>
    @stack('scripts')
</body>
</html>
