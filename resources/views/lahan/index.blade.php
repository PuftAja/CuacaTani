<x-app-layout>
    <x-slot name="header">
        <h2 class="font-semibold text-xl text-gray-800 dark:text-gray-200 leading-tight">
            Data Lahan Saya
        </h2>
    </x-slot>

    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white dark:bg-gray-800 overflow-hidden shadow-sm sm:rounded-lg p-6">

                {{-- Pesan sukses setelah tambah/edit/hapus --}}
                @if (session('success'))
                    <div class="mb-4 p-3 bg-green-100 text-green-800 rounded">
                        {{ session('success') }}
                    </div>
                @endif

                <div class="mb-4">
                    <a href="{{ route('lahan.create') }}"
                       class="px-4 py-2 bg-blue-600 text-white rounded hover:bg-blue-700">
                        + Tambah Lahan
                    </a>
                </div>

                @if ($lahans->isEmpty())
                    <p class="text-gray-500">Belum ada data lahan. Silakan tambahkan lahan pertama Anda.</p>
                @else
                    <table border="1" cellpadding="8" cellspacing="0" style="width:100%; border-collapse:collapse;">
                        <thead>
                            <tr>
                                <th>Kota</th>
                                <th>Komoditas</th>
                                <th>Luas Lahan (Ha)</th>
                                <th>Aksi</th>
                            </tr>
                        </thead>
                        <tbody>
                            @foreach ($lahans as $lahan)
                            <tr>
                                <td>{{ $lahan->kota }}</td>
                                <td>{{ ucfirst($lahan->komoditas) }}</td>
                                <td>{{ $lahan->luas_lahan }}</td>
                                <td>
                                    <a href="{{ route('lahan.edit', $lahan->id) }}">Edit</a>
                                    &nbsp;|&nbsp;
                                    <form action="{{ route('lahan.destroy', $lahan->id) }}" method="POST"
                                          style="display:inline;"
                                          onsubmit="return confirm('Yakin hapus lahan ini?')">
                                        @csrf
                                        @method('DELETE')
                                        <button type="submit">Hapus</button>
                                    </form>
                                </td>
                            </tr>
                            @endforeach
                        </tbody>
                    </table>
                @endif

            </div>
        </div>
    </div>
</x-app-layout>