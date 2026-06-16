@extends('layouts.app')
@section('title', 'Detail Janji Temu')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Janji Temu</h2>
        <a href="{{ route('appointments.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Kembali
        </a>
    </div>

    {{-- Info Janji Temu --}}
    <div class="bg-white rounded-lg shadow p-6 mb-6">
        <div class="grid grid-cols-2 gap-6 text-sm">
            <div>
                <p class="text-gray-400 mb-1">Pasien</p>
                <p class="font-semibold text-lg">{{ $appointment->patient->name }}</p>
                <p class="text-gray-500">NIK: {{ $appointment->patient->nik }}</p>
            </div>
            <div>
                <p class="text-gray-400 mb-1">Dokter</p>
                <p class="font-semibold text-lg">{{ $appointment->doctor->name }}</p>
                <p class="text-gray-500">{{ $appointment->doctor->speciality }}</p>
            </div>
            <div>
                <p class="text-gray-400 mb-1">Tanggal & Jam</p>
                <p class="font-medium">
                    {{ \Carbon\Carbon::parse($appointment->date)->format('d M Y') }}
                    pukul {{ $appointment->time }}
                </p>
            </div>
            <div>
                <p class="text-gray-400 mb-1">Status</p>
                <span class="px-3 py-1 rounded-full text-xs font-semibold
                    {{ $appointment->status === 'selesai' ? 'bg-green-100 text-green-700' :
                       ($appointment->status === 'dibatalkan' ? 'bg-red-100 text-red-700' :
                       'bg-yellow-100 text-yellow-700') }}">
                    {{ ucfirst($appointment->status) }}
                </span>
            </div>
            <div class="col-span-2">
                <p class="text-gray-400 mb-1">Keluhan</p>
                <p class="font-medium">{{ $appointment->complaint }}</p>
            </div>
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('appointments.edit', $appointment) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded hover:bg-yellow-600 text-sm">
                Edit Janji Temu
            </a>
            @if(!$appointment->medicalRecord)
                <a href="{{ route('medical-records.create', ['appointment_id' => $appointment->id]) }}"
                   class="bg-green-600 text-white px-4 py-2 rounded hover:bg-green-700 text-sm">
                    + Tambah Rekam Medis
                </a>
            @else
                <a href="{{ route('medical-records.show', $appointment->medicalRecord) }}"
                   class="bg-blue-600 text-white px-4 py-2 rounded hover:bg-blue-700 text-sm">
                    Lihat Rekam Medis
                </a>
            @endif
        </div>
    </div>

    {{-- Rekam Medis --}}
    @if($appointment->medicalRecord)
    <div class="bg-white rounded-lg shadow p-6">
        <h3 class="font-semibold text-gray-700 mb-4">Rekam Medis</h3>
        <div class="grid grid-cols-2 gap-4 text-sm">
            <div>
                <p class="text-gray-400 mb-1">Diagnosis</p>
                <p class="font-medium">{{ $appointment->medicalRecord->diagnosis }}</p>
            </div>
            <div>
                <p class="text-gray-400 mb-1">Resep Obat</p>
                <p class="font-medium">{{ $appointment->medicalRecord->prescription }}</p>
            </div>
            @if($appointment->medicalRecord->notes)
            <div class="col-span-2">
                <p class="text-gray-400 mb-1">Catatan</p>
                <p class="font-medium">{{ $appointment->medicalRecord->notes }}</p>
            </div>
            @endif
            @if($appointment->medicalRecord->attachment)
            <div class="col-span-2">
                <p class="text-gray-400 mb-1">Lampiran</p>
                <a href="{{ asset('storage/' . $appointment->medicalRecord->attachment) }}"
                   target="_blank"
                   class="text-blue-600 hover:underline text-sm">
                    📎 Lihat Lampiran
                </a>
            </div>
            @endif
        </div>
    </div>
    @endif
</div>
@endsection