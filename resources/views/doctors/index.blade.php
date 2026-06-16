@extends('layouts.app')
@section('title', 'Data Dokter')

@section('content')
<div class="flex justify-between items-center mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Data Dokter</h2>
    <a href="{{ route('doctors.create') }}"
       class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700">
        + Tambah Dokter
    </a>
</div>

<div class="bg-white rounded-lg shadow overflow-hidden">
    <table class="w-full text-sm">
        <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
            <tr>
                <th class="px-4 py-3 text-left">Foto</th>
                <th class="px-4 py-3 text-left">Nama</th>
                <th class="px-4 py-3 text-left">Spesialisasi</th>
                <th class="px-4 py-3 text-left">No. HP</th>
                <th class="px-4 py-3 text-left">Status</th>
                <th class="px-4 py-3 text-left">Aksi</th>
            </tr>
        </thead>
        <tbody class="divide-y divide-gray-200">
            @forelse($doctors as $doctor)
            <tr class="hover:bg-gray-50">
                <td class="px-4 py-3">
                    @if($doctor->photo)
                        <img src="{{ asset('storage/' . $doctor->photo) }}"
                             class="w-10 h-10 rounded-full object-cover">
                    @else
                        <div class="w-10 h-10 rounded-full bg-blue-200 flex items-center justify-center text-blue-700 font-bold">
                            {{ strtoupper(substr($doctor->name, 0, 1)) }}
                        </div>
                    @endif
                </td>
                <td class="px-4 py-3 font-medium">{{ $doctor->name }}</td>
                <td class="px-4 py-3">{{ $doctor->speciality }}</td>
                <td class="px-4 py-3">{{ $doctor->phone }}</td>
                <td class="px-4 py-3">
                    <span class="px-2 py-1 rounded-full text-xs font-semibold
                        {{ $doctor->status === 'aktif' ? 'bg-green-100 text-green-700' : 'bg-red-100 text-red-700' }}">
                        {{ ucfirst($doctor->status) }}
                    </span>
                </td>
                <td class="px-4 py-3 flex gap-2">
                    <a href="{{ route('doctors.show', $doctor) }}"
                       class="text-blue-600 hover:underline text-xs">Detail</a>
                    <a href="{{ route('doctors.edit', $doctor) }}"
                       class="text-yellow-600 hover:underline text-xs">Edit</a>
                    <form action="{{ route('doctors.destroy', $doctor) }}" method="POST"
                          onsubmit="return confirm('Yakin hapus dokter ini?')">
                        @csrf @method('DELETE')
                        <button class="text-red-600 hover:underline text-xs">Hapus</button>
                    </form>
                </td>
            </tr>
            @empty
            <tr>
                <td colspan="6" class="px-4 py-6 text-center text-gray-400">
                    Belum ada data dokter.
                </td>
            </tr>
            @endforelse
        </tbody>
    </table>
    <div class="px-4 py-3">
        {{ $doctors->links() }}
    </div>
</div>
@endsection