@extends('layouts.app')
@section('title', 'Detail Pasien')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Pasien</h2>
        <a href="{{ route('patients.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Kembali
        </a>
    </div>

    {{-- Info Pasien --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="flex items-center gap-6">
            @if($patient->photo)
                <img src="{{ asset('storage/' . $patient->photo) }}"
                     class="w-24 h-24 rounded-full object-cover">
            @else
                <div class="w-24 h-24 rounded-full bg-green-200 flex items-center justify-center text-green-700 text-3xl font-bold">
                    {{ strtoupper(substr($patient->name, 0, 1)) }}
                </div>
            @endif
            <div>
                <h3 class="text-xl font-bold text-gray-800">{{ $patient->name }}</h3>
                <p class="text-gray-500 text-sm">NIK: {{ $patient->nik }}</p>
                <p class="text-gray-500 text-sm">
                    {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} •
                    {{ \Carbon\Carbon::parse($patient->birth_date)->format('d M Y') }}
                </p>
            </div>
        </div>

        <div class="grid grid-cols-2 gap-4 mt-6 text-sm">
            <div>
                <p class="text-gray-400">No. HP</p>
                <p class="font-medium">{{ $patient->phone }}</p>
            </div>
            <div>
                <p class="text-gray-400">Alamat</p>
                <p class="font-medium">{{ $patient->address }}</p>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('patients.edit', $patient) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
                Edit Data
            </a>
            <a href="{{ route('appointments.create', ['patient_id' => $patient->id]) }}"
               class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                + Buat Janji Temu
            </a>
        </div>
    </div>

    {{-- Riwayat Janji Temu --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-6 py-4 border-b">
            <h3 class="font-semibold text-gray-700">Riwayat Janji Temu</h3>
        </div>
        <table class="w-full text-sm">
            <thead class="bg-gray-50 text-gray-600 uppercase text-xs">
                <tr>
                    <th class="px-4 py-3 text-left">Tanggal</th>
                    <th class="px-4 py-3 text-left">Dokter</th>
                    <th class="px-4 py-3 text-left">Keluhan</th>
                    <th class="px-4 py-3 text-left">Status</th>
                </tr>
            </thead>
            <tbody class="divide-y divide-gray-200">
                @forelse($appointments as $appt)
                <tr class="hover:bg-gray-50">
                    <td class="px-4 py-3">
                        {{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}
                        <span class="text-gray-400">{{ $appt->time }}</span>
                    </td>
                    <td class="px-4 py-3">{{ $appt->doctor->name }}</td>
                    <td class="px-4 py-3">{{ Str::limit($appt->complaint, 40) }}</td>
                    <td class="px-4 py-3">
                        <span class="px-2 py-1 rounded-full text-xs font-semibold
                            {{ $appt->status === 'selesai' ? 'bg-green-100 text-green-700' :
                               ($appt->status === 'dibatalkan' ? 'bg-red-100 text-red-700' :
                               'bg-yellow-100 text-yellow-700') }}">
                            {{ ucfirst($appt->status) }}
                        </span>
                    </td>
                </tr>
                @empty
                <tr>
                    <td colspan="4" class="px-4 py-6 text-center text-gray-400">
                        Belum ada riwayat janji temu.
                    </td>
                </tr>
                @endforelse
            </tbody>
        </table>
    </div>
</div>
@endsection