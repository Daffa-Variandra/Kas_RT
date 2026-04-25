<x-guest-layout>
    <div class="fixed inset-0 w-screen h-screen flex overflow-hidden">
        <!-- Sisi Kiri: Background -->
        <div style="background-image: url('img/bg.png');" class="hidden lg:flex lg:w-1/2 bg-gradient-to-br from-indigo-600 via-indigo-500 to-blue-600 relative overflow-hidden items-center justify-center">
            
        </div>

        <!-- Sisi Kanan: Form Login -->
        <div class="w-full lg:w-1/2 flex items-center justify-center px-6 py-12 bg-gray-50 lg:bg-white overflow-y-auto">
            <div class="w-full max-w-md">
                <!-- Logo Mobile -->
                <div class="lg:hidden flex flex-col items-center mb-8">
                    <img src="{{ asset('img/logo.png') }}" class="w-20 h-20 object-contain mb-3" alt="Logo RT">
                    <h2 class="text-2xl font-bold text-gray-900">Sistem KAS RT</h2>
                </div>
                
                <img src="{{ asset('img/logo.png') }}" class="sm:hidden md:block w-32 h-32 object-contain float-right" alt="Logo RT">
                <h1 class="text-3xl font-bold text-gray-900 mb-2">Masuk</h1>
                <p class="text-gray-600 mb-8">Silakan masuk ke akun Anda untuk melanjutkan</p>

                <x-auth-session-status class="mb-4" :status="session('status')" />

                <form method="POST" action="{{ route('login') }}" class="space-y-6">
                    @csrf

                    <!-- Email -->
                    <div>
                        <label for="email" class="block text-sm font-medium text-gray-700 mb-2">Email Address</label>
                        <input id="email" type="email" name="email" :value="old('email')" required autofocus 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                               placeholder="nama@email.com">
                        <x-input-error :messages="$errors->get('email')" class="mt-2" />
                    </div>

                    <!-- Password -->
                    <div>
                        <label for="password" class="block text-sm font-medium text-gray-700 mb-2">Password</label>
                        <input id="password" type="password" name="password" required 
                               class="w-full px-4 py-2 border border-gray-300 rounded-lg focus:ring-2 focus:ring-indigo-500 focus:border-transparent transition"
                               placeholder="••••••••">
                        <x-input-error :messages="$errors->get('password')" class="mt-2" />
                    </div>

                    <!-- Remember Me -->
                    <div class="flex items-center">
                        <input id="remember_me" type="checkbox" name="remember" class="h-4 w-4 text-indigo-600 focus:ring-indigo-500 border-gray-300 rounded">
                        <label for="remember_me" class="ml-2 block text-sm text-gray-700">Ingat saya</label>
                    </div>

                    <!-- Submit Button -->
                    <button type="submit" class="w-full flex justify-center py-3 px-4 rounded-lg shadow-md text-sm font-semibold text-white bg-amber-800 hover:bg-amber-950 focus:outline-none focus:ring-2 focus:ring-offset-2 focus:ring-indigo-500 transition duration-200">
                        MASUK SEKARANG
                    </button>
                </form>

                <!-- Forgot Password -->
                @if (Route::has('password.request'))
                    <div class="mt-6 text-center">
                        <a href="{{ route('password.request') }}" class="text-sm text-indigo-600 hover:text-indigo-500">Lupa password?</a>
                    </div>
                @endif

                <!-- Register Link -->
                @if (Route::has('register'))
                    <div class="mt-6 text-center">
                        <p class="text-sm text-gray-600">
                            Belum punya akun? 
                            <a href="{{ route('register') }}" class="text-indigo-600 hover:text-indigo-500 font-medium">Daftar di sini</a>
                        </p>
                    </div>
                @endif
            </div>
        </div>
    </div>

    <style>
        * {
            box-sizing: border-box;
        }
        html, body {
            height: 100%;
            margin: 0;
            padding: 0;
            overflow: hidden;
        }
        @keyframes blob {
            0%, 100% {
                transform: translate(0, 0) scale(1);
            }
            33% {
                transform: translate(30px, -50px) scale(1.1);
            }
            66% {
                transform: translate(-20px, 20px) scale(0.9);
            }
        }
        .animate-blob {
            animation: blob 7s infinite;
        }
        .animation-delay-2000 {
            animation-delay: 2s;
        }
    </style>
</x-guest-layout>