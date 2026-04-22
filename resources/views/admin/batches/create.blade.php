<x-app-layout>
    <div class="py-12">
        <div class="max-w-7xl mx-auto sm:px-6 lg:px-8">
            <div class="bg-white overflow-hidden shadow-sm sm:rounded-lg">
                <div class="p-6 text-gray-900">
                    <h2 class="text-2xl font-semibold mb-6">Tambah Batch Baru - {{ $kelas->nama_kelas }}</h2>

                    <form action="{{ route('admin.kelas.batches.store', $kelas->id) }}" method="POST">
                        @csrf
                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Nama Batch</label>
                            <input type="text" name="nama_batch" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" placeholder="Contoh: Batch April 2026" required>
                        </div>

                        <div class="mb-4">
                            <label class="block text-sm font-medium text-gray-700">Tanggal Buka (Materi Dapat Diakses)</label>
                            <input type="date" name="start_date" class="mt-1 block w-full rounded-md border-gray-300 shadow-sm" required>
                        </div>

                        <div class="mb-4 form-check form-switch">
                            <input class="form-check-input" type="checkbox" name="is_active" id="isActiveCheck" value="1" checked>
                            <label class="form-check-label" for="isActiveCheck">
                                Aktifkan Pendaftaran untuk Batch ini (Otomatis menonaktifkan batch lain)
                            </label>
                        </div>

                        <div class="mt-6">
                            <button type="submit" class="btn bg-gradient-primary">Simpan</button>
                            <a href="{{ route('admin.kelas.batches.index', $kelas->id) }}" class="btn btn-light ms-2">Batal</a>
                        </div>
                    </form>
                </div>
            </div>
        </div>
    </div>
</x-app-layout>
