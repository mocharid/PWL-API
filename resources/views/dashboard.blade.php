<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Dashboard') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900 dark:text-gray-100 flex flex-col items-center">
                    <!-- Selamat Datang Text -->
                    <p class="mb-4 font-bold">{{ __("Selamat Datang, ".Auth()->user()->name." !") }}</p>
                    <!-- Image -->
                    <img src="{{ asset('images/b.png') }}" alt="Image Description" class="rounded-lg shadow-md">
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
