<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <div class="d-flex justify-content-between align-items-center mb-6">
                        <h2 class="text-2xl font-semibold">Kelola Batch: {{ $kelas->nama_kelas }}</h2>
                        <a href="{{ route('admin.kelas.batches.create', $kelas->id) }}" class="btn bg-gradient-primary">
                            + Tambah Batch
                        </a>
                    </div>

                    @if(session('success'))
                        <div class="alert alert-success text-white">
                            {{ session('success') }}
                        </div>
                    @endif

                    <div class="overflow-x-auto mt-4">
                        <table class="min-w-full bg-white border border-gray-200">
                            <thead>
                                <tr class="bg-gray-100">
                                    <th class="py-3 px-4 border-b text-left">Nama Batch</th>
                                    <th class="py-3 px-4 border-b text-left">Tanggal Buka</th>
                                    <th class="py-3 px-4 border-b text-left">Status</th>
                                    <th class="py-3 px-4 border-b text-left">Aksi</th>
                                </tr>
                            </thead>
                            <tbody>
                                @forelse($batches as $batch)
                                <tr>
                                    <td class="py-2 px-4 border-b">{{ $batch->nama_batch }}</td>
                                    <td class="py-2 px-4 border-b">{{ \Carbon\Carbon::parse($batch->start_date)->translatedFormat('d F Y') }}</td>
                                    <td class="py-2 px-4 border-b">
                                        @if($batch->is_active)
                                            <span class="badge bg-success">Aktif (Pendaftaran Buka)</span>
                                        @else
                                            <span class="badge bg-secondary">Tidak Aktif</span>
                                        @endif
                                    </td>
                                    <td class="py-2 px-4 border-b">
                                        <a href="{{ route('admin.kelas.batches.edit', [$kelas->id, $batch->id]) }}" class="text-info me-2">Edit</a>
                                        <form action="{{ route('admin.kelas.batches.destroy', [$kelas->id, $batch->id]) }}" method="POST" class="d-inline" onsubmit="return confirm('Hapus batch ini?');">
                                            @csrf
                                            @method('DELETE')
                                            <button type="submit" class="text-danger border-0 bg-transparent">Hapus</button>
                                        </form>
                                    </td>
                                </tr>
                                @empty
                                <tr>
                                    <td colspan="4" class="py-4 text-center text-gray-500">Belum ada batch untuk kelas ini.</td>
                                </tr>
                                @endforelse
                            </tbody>
                        </table>
                    </div>
                    <div class="mt-4">
                        <a href="{{ route('admin.kelas.index') }}" class="text-primary">&larr; Kembali ke Daftar Kelas</a>
                    </div>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
