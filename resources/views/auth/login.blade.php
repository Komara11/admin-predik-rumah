<!DOCTYPE html>
<html lang="id">
<head>
    <meta charset="utf-8" />
    <meta name="viewport" content="width=device-width, initial-scale=1.0" />
    <meta name="csrf-token" content="{{ csrf_token() }}">
    <title>Login Admin - PrediksiRumah Majalengka</title>
    
    <!-- Google Fonts & Icons -->
    <link href="https://fonts.googleapis.com/css2?family=Inter:wght@400;500;600;700&display=swap" rel="stylesheet" />
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined:wght,FILL@100..700,0..1&display=swap" rel="stylesheet" />
    
    <!-- Vite Assets -->
    @vite(['resources/css/app.css', 'resources/js/app.js'])
</head>
<body class="bg-background text-on-surface font-body-md min-h-screen flex items-center justify-center p-6">

    <!-- Card Wrapper -->
    <div class="w-full max-w-md neumorphic-outset rounded-[32px] p-8 md:p-12 bg-background relative overflow-hidden">
        <!-- Decorative Circle -->
        <div class="absolute -top-12 -right-12 w-32 h-32 rounded-full neumorphic-inset opacity-40 pointer-events-none"></div>

        <!-- Header -->
        <div class="text-center mb-10">
            <div class="w-16 h-16 neumorphic-outset rounded-2xl flex items-center justify-center mx-auto mb-6 text-primary">
                <span class="material-symbols-outlined text-3xl font-bold">admin_panel_settings</span>
            </div>
            <h1 class="font-headline-lg text-headline-lg text-primary font-bold mb-2">Login Admin</h1>
            <p class="text-on-surface-variant font-label-sm">Sistem Prediksi Harga Rumah Majalengka</p>
        </div>

        <!-- Session Status / Errors -->
        @if ($errors->any())
            <div class="mb-6 p-4 rounded-2xl bg-error-container text-error text-label-md neumorphic-inset">
                <ul class="list-disc list-inside space-y-1">
                    @foreach ($errors->all() as $error)
                        <li>{{ $error }}</li>
                    @endforeach
                </ul>
            </div>
        @endif

        <!-- Form -->
        <form class="space-y-8" action="{{ url('/login') }}" method="POST">
            @csrf

            <!-- Email Field -->
            <div class="space-y-2">
                <label class="font-label-md text-label-md ml-1" for="email">Email Admin</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-on-surface-variant">mail</span>
                    <input
                        id="email"
                        name="email"
                        type="email"
                        value="{{ old('email') }}"
                        required
                        autofocus
                        class="w-full pl-12 pr-4 py-3.5 rounded-2xl neumorphic-inset bg-background border-none focus:ring-1 focus:ring-primary outline-none text-body-md"
                        placeholder="admin@prediksirumah.com" />
                </div>
            </div>

            <!-- Password Field -->
            <div class="space-y-2">
                <label class="font-label-md text-label-md ml-1" for="password">Password</label>
                <div class="relative flex items-center">
                    <span class="material-symbols-outlined absolute left-4 text-on-surface-variant">lock</span>
                    <input
                        id="password"
                        name="password"
                        type="password"
                        required
                        class="w-full pl-12 pr-4 py-3.5 rounded-2xl neumorphic-inset bg-background border-none focus:ring-1 focus:ring-primary outline-none text-body-md"
                        placeholder="••••••••" />
                </div>
            </div>

            <!-- Remember Me & Forgot Password -->
            <div class="flex items-center justify-between pt-2">
                <label class="flex items-center gap-3 cursor-pointer group">
                    <input class="neumorphic-checkbox" type="checkbox" name="remember" checked />
                    <span class="font-label-sm text-label-sm text-on-surface-variant group-hover:text-primary transition-colors">Ingat Saya</span>
                </label>
                <a href="#" class="font-label-sm text-label-sm text-primary hover:underline">Lupa Password?</a>
            </div>

            <!-- Submit Button -->
            <div class="pt-4">
                <button
                    type="submit"
                    class="w-full py-4 rounded-2xl bg-background neumorphic-outset text-primary font-bold text-body-md flex items-center justify-center gap-2 transition-all duration-300 hover:scale-[1.02] active:scale-95 active:shadow-inner"
                    id="submitBtn">
                    <span class="material-symbols-outlined">login</span>
                    Masuk Dashboard
                </button>
            </div>
        </form>
    </div>

    <!-- Script to simulate submit effect -->
    <script>
        document.addEventListener('DOMContentLoaded', () => {
            const form = document.querySelector('form');
            const submitBtn = document.getElementById('submitBtn');
            if (form && submitBtn) {
                form.addEventListener('submit', () => {
                    submitBtn.style.boxShadow = 'inset 4px 4px 8px #D1D9E6, inset -4px -4px 8px #FFFFFF';
                    submitBtn.innerHTML = `
                        <span class="material-symbols-outlined animate-spin">sync</span>
                        Memverifikasi...
                    `;
                });
            }
        });
    </script>
</body>
</html>
