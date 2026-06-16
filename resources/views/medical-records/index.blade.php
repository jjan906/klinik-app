@extends('layouts.app')
@section('title', 'Rekam Medis')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Rekam Medis</h2>
    <a href="{{ route('medical-records.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Rekam Medis
    </a>
</div>

{{-- Search --}}
<div class="mb-4">
    <input type="text" id="search" placeholder="Cari nama pasien atau diagnosis..."
        class="border rounded px-3 py-2 text-sm w-full max-w-sm
               focus:outline-none focus:ring-2 focus:ring-blue-500">
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm" id="recordTable">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Pasien</th>
                <th class="px-4 py-3 text-left">Dokter</th>
                <th class="px-4 py-3 text-left">Tanggal</th>
                <th class="px-4 py-3 text-left">Diagnosis</th>
                <th class="px-4 py-3 text-left">Lampiran</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($records as $record)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3 font-medium">
                    {{ $record->appointment->patient->name }}
                </td>
                <td class="px-4 py-3">
                    <p>{{ $record->appointment->doctor->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $record->appointment->doctor->speciality }}
                    </p>
                </td>
                <td class="px-4 py-3">
                    {{ \Carbon\Carbon::parse($record->appointment->date)->format('d M Y') }}
                </td>
                <td class="px-4 py-3">
                    {{ Str::limit($record->diagnosis, 40) }}
                </td>
                <td class="px-4 py-3">
                    @if($record->attachment)
                        @php $ext = pathinfo($record->attachment, PATHINFO_EXTENSION); @endphp
                        <a href="{{ asset('storage/' . $record->attachment) }}"
                           target="_blank"
                           class="text-blue-600 hover:underline text-xs">
                            {{ $ext === 'pdf' ? '📄 PDF' : '🖼️ Gambar' }}
                        </a>
                    @else
                        <span class="text-gray-400 text-xs">Tidak ada</span>
                    @endif
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('medical-records.show', $record) }}"
                           class="text-blue-600 hover:underline text-xs">Detail</a>
                        <a href="{{ route('medical-records.edit', $record) }}"
                           class="text-yellow-600 hover:underline text-xs">Edit</a>
                        <form action="{{ route('medical-records.destroy', $record) }}"
                              method="POST"
                              onsubmit="return confirm('Yakin hapus rekam medis ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                    Belum ada rekam medis.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">
        {{ $records->links() }}
    </div>
</div>

<script>
document.getElementById('search').addEventListener('keyup', function () {
    const keyword = this.value.toLowerCase();
    document.querySelectorAll('#recordTable tbody tr').forEach(row => {
        row.style.display = row.innerText.toLowerCase().includes(keyword) ? '' : 'none';
    });
});
</script>
@endsection