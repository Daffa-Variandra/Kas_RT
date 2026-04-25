<x-guest-layout>
    <div class="mb-4 text-sm text-gray-600">
        <div class="flex flex-col items-center justify-center p-6 text-center">
            <div class="w-16 h-16 bg-green-100 text-green-600 rounded-full flex items-center justify-center mb-4">
                <svg xmlns="http://www.w3.org/2000/svg" class="h-8 w-8" fill="none" viewBox="0 0 24 24" stroke="currentColor">
                    <path stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="M5 13l4 4L19 7" />
                </svg>
            </div>

            <h2 class="text-2xl font-bold text-gray-800 mb-2">Berhasil Keluar!</h2>
            <p class="text-gray-500 mb-6">Anda telah keluar dari sistem Sistem KAS RT dengan aman.</p>

            <a href="{{ route('login') }}" class="inline-flex items-center px-4 py-2 bg-amber-800 border border-transparent rounded-md font-semibold text-xs text-white uppercase tracking-widest hover:bg-amber-950 active:bg-amber-900 focus:outline-none focus:border-indigo-900 focus:ring ring-indigo-300 disabled:opacity-25 transition ease-in-out duration-150">
                Kembali ke Login
            </a>
        </div>
    </div>
</x-guest-layout>