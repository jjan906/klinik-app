@extends('layouts.app')
@section('title', 'Dashboard')

@section('content')

{{-- Header --}}
<div class="mb-6">
    <h2 class="text-2xl font-bold text-gray-800">Dashboard</h2>
    <p class="text-gray-500 text-sm mt-1">
        Selamat datang, {{ auth()->user()->name }}! 👋
        Hari ini {{ \Carbon\Carbon::now()->locale('id')->isoFormat('dddd, D MMMM Y') }}
    </p>
</div>

{{-- Statistik Utama --}}
<div class="grid grid-cols-2 md:grid-cols-4 gap-4 mb-6">
    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-blue-100 rounded-full flex items-center justify-center text-2xl">
            👨‍⚕️
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalDoctors }}</p>
            <p class="text-xs text-gray-400">Total Dokter</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-green-100 rounded-full flex items-center justify-center text-2xl">
            🧑‍🤝‍🧑
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalPatients }}</p>
            <p class="text-xs text-gray-400">Total Pasien</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-yellow-100 rounded-full flex items-center justify-center text-2xl">
            📅
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalAppointments }}</p>
            <p class="text-xs text-gray-400">Total Janji Temu</p>
        </div>
    </div>

    <div class="bg-white rounded-lg shadow p-5 flex items-center gap-4">
        <div class="w-12 h-12 bg-purple-100 rounded-full flex items-center justify-center text-2xl">
            📋
        </div>
        <div>
            <p class="text-2xl font-bold text-gray-800">{{ $totalRecords }}</p>
            <p class="text-xs text-gray-400">Rekam Medis</p>
        </div>
    </div>
</div>

{{-- Status Janji Temu --}}
<div class="grid grid-cols-3 gap-4 mb-6">
    <div class="bg-yellow-50 border border-yellow-200 rounded-lg p-4 text-center">
        <p class="text-3xl font-bold text-yellow-600">
            {{ $statusCounts['menunggu'] ?? 0 }}
        </p>
        <p class="text-xs text-yellow-500 mt-1">⏳ Menunggu</p>
    </div>
    <div class="bg-green-50 border border-green-200 rounded-lg p-4 text-center">
        <p class="text-3xl font-bold text-green-600">
            {{ $statusCounts['selesai'] ?? 0 }}
        </p>
        <p class="text-xs text-green-500 mt-1">✅ Selesai</p>
    </div>
    <div class="bg-red-50 border border-red-200 rounded-lg p-4 text-center">
        <p class="text-3xl font-bold text-red-600">
            {{ $statusCounts['dibatalkan'] ?? 0 }}
        </p>
        <p class="text-xs text-red-500 mt-1">❌ Dibatalkan</p>
    </div>
</div>

{{-- Row: Janji Temu Hari Ini + Upcoming --}}
<div class="grid grid-cols-1 md:grid-cols-2 gap-4 mb-6">

    {{-- Janji Temu Hari Ini --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">📅 Janji Temu Hari Ini</h3>
            <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                {{ $todayAppointments->count() }} jadwal
            </span>
        </div>
        <div class="divide-y">
            @forelse($todayAppointments as $appt)
            <div class="px-5 py-3 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium text-sm">{{ $appt->patient->name }}</p>
                        <p class="text-xs text-gray-400">
                            Dr. {{ $appt->doctor->name }} • {{ $appt->time }}
                        </p>
                    </div>
                    <span class="text-xs px-2 py-1 rounded-full
                        {{ $appt->status === 'selesai' ? 'bg-green-100 text-green-700' :
                           ($appt->status === 'dibatalkan' ? 'bg-red-100 text-red-700' :
                           'bg-yellow-100 text-yellow-700') }}">
                        {{ ucfirst($appt->status) }}
                    </span>
                </div>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-gray-400 text-sm">
                Tidak ada janji temu hari ini
            </div>
            @endforelse
        </div>
        <div class="px-5 py-3 border-t">
            <a href="{{ route('appointments.index') }}"
               class="text-blue-600 text-xs hover:underline">
                Lihat semua →
            </a>
        </div>
    </div>

    {{-- Upcoming 7 Hari --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b flex justify-between items-center">
            <h3 class="font-semibold text-gray-700">🔜 7 Hari ke Depan</h3>
            <span class="text-xs bg-purple-100 text-purple-700 px-2 py-1 rounded-full">
                {{ $upcomingAppointments->count() }} jadwal
            </span>
        </div>
        <div class="divide-y">
            @forelse($upcomingAppointments as $appt)
            <div class="px-5 py-3 hover:bg-gray-50">
                <div class="flex justify-between items-start">
                    <div>
                        <p class="font-medium text-sm">{{ $appt->patient->name }}</p>
                        <p class="text-xs text-gray-400">
                            Dr. {{ $appt->doctor->name }}
                        </p>
                    </div>
                    <div class="text-right">
                        <p class="text-xs font-medium text-gray-700">
                            {{ \Carbon\Carbon::parse($appt->date)->format('d M') }}
                        </p>
                        <p class="text-xs text-gray-400">{{ $appt->time }}</p>
                    </div>
                </div>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-gray-400 text-sm">
                Tidak ada jadwal mendatang
            </div>
            @endforelse
        </div>
        <div class="px-5 py-3 border-t">
            <a href="{{ route('appointments.create') }}"
               class="text-blue-600 text-xs hover:underline">
                + Tambah janji temu →
            </a>
        </div>
    </div>
</div>

{{-- Row: Top Dokter + Pasien Terbaru + Rekam Medis Terbaru --}}
<div class="grid grid-cols-1 md:grid-cols-3 gap-4">

    {{-- Top Dokter --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="font-semibold text-gray-700">🏆 Dokter Terbanyak Pasien</h3>
        </div>
        <div class="divide-y">
            @forelse($topDoctors as $i => $doctor)
            <div class="px-5 py-3 flex items-center gap-3">
                <span class="text-sm font-bold text-gray-400 w-5">
                    {{ $i + 1 }}
                </span>
                @if($doctor->photo)
                    <img src="{{ asset('storage/' . $doctor->photo) }}"
                         class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 rounded-full bg-blue-200 flex items-center
                                justify-center text-blue-700 text-xs font-bold">
                        {{ strtoupper(substr($doctor->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ $doctor->name }}</p>
                    <p class="text-xs text-gray-400">{{ $doctor->speciality }}</p>
                </div>
                <span class="text-xs bg-blue-100 text-blue-700 px-2 py-1 rounded-full">
                    {{ $doctor->appointments_count }}
                </span>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-gray-400 text-sm">
                Belum ada data
            </div>
            @endforelse
        </div>
        <div class="px-5 py-3 border-t">
            <a href="{{ route('doctors.index') }}"
               class="text-blue-600 text-xs hover:underline">
                Lihat semua dokter →
            </a>
        </div>
    </div>

    {{-- Pasien Terbaru --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="font-semibold text-gray-700">🆕 Pasien Terbaru</h3>
        </div>
        <div class="divide-y">
            @forelse($latestPatients as $patient)
            <div class="px-5 py-3 flex items-center gap-3">
                @if($patient->photo)
                    <img src="{{ asset('storage/' . $patient->photo) }}"
                         class="w-8 h-8 rounded-full object-cover">
                @else
                    <div class="w-8 h-8 rounded-full bg-green-200 flex items-center
                                justify-center text-green-700 text-xs font-bold">
                        {{ strtoupper(substr($patient->name, 0, 1)) }}
                    </div>
                @endif
                <div class="flex-1 min-w-0">
                    <p class="text-sm font-medium truncate">{{ $patient->name }}</p>
                    <p class="text-xs text-gray-400">
                        {{ $patient->gender === 'L' ? 'Laki-laki' : 'Perempuan' }} •
                        {{ \Carbon\Carbon::parse($patient->birth_date)->age }} thn
                    </p>
                </div>
                <a href="{{ route('patients.show', $patient) }}"
                   class="text-xs text-blue-600 hover:underline">
                    Detail
                </a>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-gray-400 text-sm">
                Belum ada pasien
            </div>
            @endforelse
        </div>
        <div class="px-5 py-3 border-t">
            <a href="{{ route('patients.index') }}"
               class="text-blue-600 text-xs hover:underline">
                Lihat semua pasien →
            </a>
        </div>
    </div>

    {{-- Rekam Medis Terbaru --}}
    <div class="bg-white rounded-lg shadow overflow-hidden">
        <div class="px-5 py-4 border-b">
            <h3 class="font-semibold text-gray-700">📋 Rekam Medis Terbaru</h3>
        </div>
        <div class="divide-y">
            @forelse($latestRecords as $record)
            <div class="px-5 py-3">
                <div class="flex justify-between items-start">
                    <div class="flex-1 min-w-0">
                        <p class="text-sm font-medium truncate">
                            {{ $record->appointment->patient->name }}
                        </p>
                        <p class="text-xs text-gray-400 truncate">
                            {{ Str::limit($record->diagnosis, 30) }}
                        </p>
                    </div>
                    <p class="text-xs text-gray-400 ml-2 whitespace-nowrap">
                        {{ \Carbon\Carbon::parse($record->appointment->date)->format('d M') }}
                    </p>
                </div>
            </div>
            @empty
            <div class="px-5 py-6 text-center text-gray-400 text-sm">
                Belum ada rekam medis
            </div>
            @endforelse
        </div>
        <div class="px-5 py-3 border-t">
            <a href="{{ route('medical-records.index') }}"
               class="text-blue-600 text-xs hover:underline">
                Lihat semua rekam medis →
            </a>
        </div>
    </div>
</div>

@endsection