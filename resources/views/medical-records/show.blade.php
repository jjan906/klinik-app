@extends('layouts.app')
@section('title', 'Detail Rekam Medis')

@section('content')
<div class="max-w-3xl mx-auto">
    <div class="flex justify-between items-center mb-6">
        <h2 class="text-2xl font-bold text-gray-800">Detail Rekam Medis</h2>
        <a href="{{ route('medical-records.index') }}"
           class="bg-gray-200 text-gray-700 px-4 py-2 rounded hover:bg-gray-300 text-sm">
            ← Kembali
        </a>
    </div>

    {{-- Info Pasien & Dokter --}}
    <div class="grid grid-cols-2 gap-4 mb-4">
        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs text-gray-400 uppercase mb-2">Pasien</p>
            <div class="flex items-center gap-3">
                @if($medicalRecord->appointment->patient->photo)
                    <img src="{{ asset('storage/' . $medicalRecord->appointment->patient->photo) }}"
                         class="w-12 h-12 rounded-full object-cover">
                @else
                    <div class="w-12 h-12 rounded-full bg-green-200 flex items-center
                                justify-center text-green-700 font-bold text-lg">
                        {{ strtoupper(substr($medicalRecord->appointment->patient->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="font-semibold">
                        {{ $medicalRecord->appointment->patient->name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        NIK: {{ $medicalRecord->appointment->patient->nik }}
                    </p>
                </div>
            </div>
        </div>

        <div class="bg-white rounded-lg shadow p-5">
            <p class="text-xs text-gray-400 uppercase mb-2">Dokter</p>
            <div class="flex items-center gap-3">
                @if($medicalRecord->appointment->doctor->photo)
                    <img src="{{ asset('storage/' . $medicalRecord->appointment->doctor->photo) }}"
                         class="w-12 h-12 rounded-full object-cover">
                @else
                    <div class="w-12 h-12 rounded-full bg-blue-200 flex items-center
                                justify-center text-blue-700 font-bold text-lg">
                        {{ strtoupper(substr($medicalRecord->appointment->doctor->name, 0, 1)) }}
                    </div>
                @endif
                <div>
                    <p class="font-semibold">
                        {{ $medicalRecord->appointment->doctor->name }}
                    </p>
                    <p class="text-xs text-gray-400">
                        {{ $medicalRecord->appointment->doctor->speciality }}
                    </p>
                </div>
            </div>
        </div>
    </div>

    {{-- Detail Rekam Medis --}}
    <div class="bg-white rounded-lg shadow p-6">
        <div class="flex justify-between items-start mb-4">
            <h3 class="font-semibold text-gray-700">Hasil Pemeriksaan</h3>
            <p class="text-xs text-gray-400">
                {{ \Carbon\Carbon::parse($medicalRecord->appointment->date)->format('d M Y') }}
                pukul {{ $medicalRecord->appointment->time }}
            </p>
        </div>

        <div class="space-y-4 text-sm">
            <div class="bg-gray-50 rounded p-4">
                <p class="text-gray-400 text-xs uppercase mb-1">Keluhan</p>
                <p class="font-medium">{{ $medicalRecord->appointment->complaint }}</p>
            </div>

            <div class="bg-blue-50 rounded p-4">
                <p class="text-blue-400 text-xs uppercase mb-1">Diagnosis</p>
                <p class="font-medium text-blue-900">{{ $medicalRecord->diagnosis }}</p>
            </div>

            <div class="bg-green-50 rounded p-4">
                <p class="text-green-400 text-xs uppercase mb-1">Resep Obat</p>
                <p class="font-medium text-green-900">{{ $medicalRecord->prescription }}</p>
            </div>

            @if($medicalRecord->notes)
            <div class="bg-yellow-50 rounded p-4">
                <p class="text-yellow-400 text-xs uppercase mb-1">Catatan</p>
                <p class="font-medium text-yellow-900">{{ $medicalRecord->notes }}</p>
            </div>
            @endif

            @if($medicalRecord->attachment)
            <div class="border rounded p-4">
                <p class="text-gray-400 text-xs uppercase mb-2">Lampiran</p>
                @php $ext = pathinfo($medicalRecord->attachment, PATHINFO_EXTENSION); @endphp
                @if(in_array($ext, ['jpg', 'jpeg', 'png']))
                    <img src="{{ asset('storage/' . $medicalRecord->attachment) }}"
                         class="max-w-sm rounded shadow">
                @else
                    <a href="{{ asset('storage/' . $medicalRecord->attachment) }}"
                       target="_blank"
                       class="inline-flex items-center gap-2 bg-red-50 text-red-700
                              px-4 py-2 rounded hover:bg-red-100 text-sm">
                        📄 Download PDF
                    </a>
                @endif
            </div>
            @endif
        </div>

        <div class="flex gap-3 mt-6">
            <a href="{{ route('medical-records.edit', $medicalRecord) }}"
               class="bg-yellow-500 text-white px-4 py-2 rounded
                      hover:bg-yellow-600 text-sm">
                Edit Rekam Medis
            </a>
            <form action="{{ route('medical-records.destroy', $medicalRecord) }}"
                  method="POST"
                  onsubmit="return confirm('Yakin hapus rekam medis ini?')">
                @csrf @method('DELETE')
                <button class="bg-red-500 text-white px-4 py-2 rounded
                               hover:bg-red-600 text-sm">
                    Hapus
                </button>
            </form>
        </div>
    </div>
</div>
@endsection