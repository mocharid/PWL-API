<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            {{ __('Manajemen Buku') }}
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <!-- Kontainer tabel dengan warna biru tua -->
            <div class="bg-white-100 overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-white">
                    <div class="flex justify-between mb-4">
                        <form action="{{ route('books.search') }}" method="GET" class="flex">
                            <input type="text" name="query" placeholder="Cari buku..." 
                                class="rounded-full shadow-sm border-gray-300 focus:border-indigo-300 focus:ring focus:ring-indigo-200 focus:ring-opacity-50 mr-2 px-4 py-2" />
                            <button type="submit" 
                                class="inline-flex items-center px-4 py-2 bg-blue-800 border border-transparent rounded-full font-semibold text-xs text-white uppercase tracking-widest hover:bg-blue-700 active:bg-blue-900 focus:outline-none focus:border-blue-900 focus:ring ring-blue-300 disabled:opacity-25 transition ease-in-out duration-150">
                                {{ __('Cari') }}
                            </button>
                        </form>

                        <div class="space-x-2">
                            <x-primary-button tag="a" href="{{ route('book.create') }}">
                                {{ __('Tambah Buku') }}
                            </x-primary-button>
                            <x-primary-button tag="a" href="{{ route('book.print') }}">
                                {{ __('Cetak PDF') }}
                            </x-primary-button>
                            <x-primary-button tag="a" href="{{ route('book.export') }}" target="_blank">
                                {{ __('Ekspor Excel') }}
                            </x-primary-button>
                            <x-primary-button 
                                x-data=""
                                x-on:click.prevent="$dispatch('open-modal', 'import-book')">
                                {{ __('Impor Excel') }}
                            </x-primary-button>
                        </div>
                    </div>

                    <div class="overflow-x-auto">
                        <table class="w-full border-separate border-spacing-0">
                            <thead>
                                <tr>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white first:rounded-tl-lg last:rounded-tr-lg">
                                        {{ __('No') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Judul') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Penulis') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Tahun') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Penerbit') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Kota') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Cover') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white">
                                        {{ __('Rak Buku') }}
                                    </th>
                                    <th scope="col" class="px-4 py-3 text-left bg-blue-800 text-white first:rounded-tl-lg last:rounded-tr-lg">
                                        {{ __('Aksi') }}
                                    </th>
                                </tr>
                            </thead>

                            <tbody class="bg-white text-black">
                                @foreach ($books as $book)
                                    <tr class="border-b border-blue-800">
                                        <td class="px-4 py-3">{{ $loop->iteration }}</td>
                                        <td class="px-4 py-3">{{ $book->title }}</td>
                                        <td class="px-4 py-3">{{ $book->author }}</td>
                                        <td class="px-4 py-3">{{ $book->year }}</td>
                                        <td class="px-4 py-3">{{ $book->publisher }}</td>
                                        <td class="px-4 py-3">{{ $book->city }}</td>
                                        <td class="px-4 py-3">
                                            <img src="{{ asset('storage/cover_buku/' . $book->cover) }}" 
                                                 alt="{{ $book->title }} cover" 
                                                 class="w-24 h-auto object-cover rounded-lg" />
                                        </td>
                                        <td class="px-4 py-3">{{ $book->bookshelf->code }}-{{ $book->bookshelf->name }}</td>
                                        <td class="px-4 py-3 space-x-2">
                                            <x-primary-button tag="a" href="{{ route('book.edit', $book->id) }}">
                                                {{ __('Ubah') }}
                                            </x-primary-button>
                                            <x-danger-button 
                                                x-data=""
                                                x-on:click.prevent="$dispatch('open-modal', 'confirm-book-deletion')"
                                                x-on:click="$dispatch('set-action', '{{ route('book.destroy', $book->id) }}')">
                                                {{ __('Hapus') }}
                                            </x-danger-button>
                                        </td>
                                    </tr>
                                @endforeach
                            </tbody>
                        </table>
                    </div>
                </div>
            </div>
        </div>
    </div>

    {{-- Deletion Confirmation Modal --}}
    <x-modal name="confirm-book-deletion" focusable maxWidth="xl">
        <form method="post" x-bind:action="action" class="p-6">
            @method('delete')
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Apakah Anda yakin ingin menghapus data ini?') }}
            </h2>
            <p class="mt-1 text-sm text-gray-600 dark:text-gray-400">
                {{ __('Setelah proses selesai, data akan dihapus secara permanen.') }}
            </p>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>
                <x-danger-button class="ml-3">
                    {{ __('Hapus') }}
                </x-danger-button>
            </div>
        </form>
    </x-modal>

    {{-- Import Modal --}}
    <x-modal name="import-book" focusable maxWidth="xl">
        <form method="post" action="{{ route('book.import') }}" class="p-6" enctype="multipart/form-data">
            @csrf
            <h2 class="text-lg font-medium text-gray-900 dark:text-gray-100">
                {{ __('Impor Data Buku') }}
            </h2>
            <div class="max-w-xl">
                <x-input-label for="import-file" class="sr-only" value="{{ __('Pilih File') }}" />
                <x-file-input id="import-file" name="file" class="mt-1 block w-full" required />
            </div>
            <div class="mt-6 flex justify-end">
                <x-secondary-button x-on:click="$dispatch('close')">
                    {{ __('Batal') }}
                </x-secondary-button>
                <x-primary-button class="ml-3">
                    {{ __('Unggah') }}
                </x-primary-button>
            </div>
        </form>
    </x-modal>
</x-app-layout>
