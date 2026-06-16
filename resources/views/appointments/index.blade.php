@extends('layouts.app')
@section('title', 'Janji Temu')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Janji Temu</h2>
    <a href="{{ route('appointments.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Janji Temu
    </a>
</div>

{{-- Filter Status --}}
<div class="flex gap-2 mb-4">
    <button onclick="filterStatus('semua')"
        class="filter-btn px-3 py-1 rounded-full text-xs font-semibold bg-gray-800 text-white">
        Semua
    </button>
    <button onclick="filterStatus('menunggu')"
        class="filter-btn px-3 py-1 rounded-full text-xs font-semibold bg-yellow-100 text-yellow-700">
        Menunggu
    </button>
    <button onclick="filterStatus('selesai')"
        class="filter-btn px-3 py-1 rounded-full text-xs font-semibold bg-green-100 text-green-700">
        Selesai
    </button>
    <button onclick="filterStatus('dibatalkan')"
        class="filter-btn px-3 py-1 rounded-full text-xs font-semibold bg-red-100 text-red-700">
        Dibatalkan
    </button>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm" id="apptTable">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Pasien</th>
                <th class="px-4 py-3 text-left">Dokter</th>
                <th class="px-4 py-3 text-left">Tanggal & Jam</th>
                <th class="px-4 py-3 text-left">Keluhan</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($appointments as $appt)
            <tr class="hover:bg-gray-50" data-status="{{ $appt->status }}">
                <td class="px-4 py-3 font-medium">{{ $appt->patient->name }}</td>
                <td class="px-4 py-3">
                    <p>{{ $appt->doctor->name }}</p>
                    <p class="text-xs text-gray-400">{{ $appt->doctor->speciality }}</p>
                </td>
                <td class="px-4 py-3">
                    <p>{{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}</p>
                    <p class="text-xs text-gray-400">{{ $appt->time }}</p>
                </td>
                <td class="px-4 py-3">{{ Str::limit($appt->complaint, 40) }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $appt->status === 'selesai' ? 'bg-green-100 text-green-700' :
                           ($appt->status === 'dibatalkan' ? 'bg-red-100 text-red-700' :
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst($appt->status) }}
                    </span>
                </td>
                <td class="px-4 py-3">
                    <div class="flex gap-2">
                        <a href="{{ route('appointments.show', $appt) }}"
                           class="text-blue-600 hover:underline text-xs">Detail</a>
                        <a href="{{ route('appointments.edit', $appt) }}"
                           class="text-yellow-600 hover:underline text-xs">Edit</a>
                        <form action="{{ route('appointments.destroy', $appt) }}" method="POST"
                              onsubmit="return confirm('Yakin hapus janji temu ini?')">
                            @csrf @method('DELETE')
                            <button class="text-red-600 hover:underline text-xs">Hapus</button>
                        </form>
                    </div>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                    Belum ada janji temu.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">
        {{ $appointments->links() }}
    </div>
</div>

<script>
function filterStatus(status) {
    const rows = document.querySelectorAll('#apptTable tbody tr');
    rows.forEach(row => {
        if (status === 'semua') {
            row.style.display = '';
        } else {
            row.style.display = row.dataset.status === status ? '' : 'none';
        }
    });
}
</script>
@endsection