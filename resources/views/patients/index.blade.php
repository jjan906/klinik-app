@extends('layouts.app')
@section('title', 'Data Pasien')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Pasien</h2>
    <a href="{{ route('patients.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Pasien
    </a>
</div>

{{-- Search --}}
<div class="mb-4">
    <input type="text" id="search" placeholder="Cari nama atau NIK..."
        class="border rounded px-3 py-2 text-sm w-full max-w-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm" id="patientTable">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Foto</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">NIK</th>
                <th class="px-4 py-3 text-left">Jenis Kelamin</th>
                <th class="px-4 py-3 text-left">No. HP</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($patients as $patient)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($patient->photo)
                        <img src="{{ asset('storage/' . $patient->photo) }}"
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-green-200 flex items-center justify-center text-green-700 font-bold">
                            {{ strtoupper(substr($patient->name, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium">{{ $patient->name }}</td>
                <td class="px-4 py-3 text-gray-500">{{ $patient->nik }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $patient->gender === 'L' ? 'bg-blue-100 text-blue-700' : 'bg-pink-100 text-pink-700' }}">
                        {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }}
                    </span>
                </td>
                <td class="px-4 py-3">{{ $patient->phone }}</td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('patients.show', $patient) }}"
                           class="text-blue-600 hover:underline text-xs">Detail</a>
                        <a href="{{ route('patients.edit', $patient) }}"
                           class="text-yellow-600 hover:underline text-xs">Edit</a>
                        <form action="{{ route('patients.destroy', $patient) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus pasien ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                    Belum ada data pasien.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">
        {{ $patients->links() }}
    </div>
</div>

{{-- Search Script --}}
<script>
document.getElementById('search').addEventListener('keyup', function() {
    const keyword = this.value.toLowerCase();
    const rows = document.querySelectorAll('#patientTable tbody tr');
    rows.forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>
@endsection