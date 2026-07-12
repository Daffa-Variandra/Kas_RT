<x-sidebar-layout>
    <x-slot name="header">
        Pengaturan Profil Akun
    </x-slot>

    <div class="max-w-7xl mx-auto space-y-6">
        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl border-t-4 border-emerald-500">
            <div class="max-w-xl">
                @include('profile.partials.update-profile-information-form')
            </div>
        </div>

        <div class="p-4 sm:p-8 bg-white shadow sm:rounded-xl border-t-4 border-emerald-500">
            <div class="max-w-xl">
                @include('profile.partials.update-password-form')
            </div>
        </div>
    </div>
</x-sidebar-layout>
