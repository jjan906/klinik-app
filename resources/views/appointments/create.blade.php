@extends('layouts.app')
@section('title', 'Tambah Janji Temu')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Janji Temu</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('appointments.store') }}" method="POST">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pasien</label>
                <select name="patient_id"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    @error('patient_id') border-red-500 @enderror">
                    <option value="">-- Pilih Pasien --</option>
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ (old('patient_id', $selectedPatient) == $patient->id) ? 'selected' : '' }}>
                            {{ $patient->name }} ({{ $patient->nik }})
                        </option>
                    @endforeach
                </select>
                @error('patient_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                <select name="doctor_id"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    @error('doctor_id') border-red-500 @enderror">
                    <option value="">-- Pilih Dokter --</option>
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ old('doctor_id') == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} - {{ $doctor->speciality }}
                        </option>
                    @endforeach
                </select>
                @error('doctor_id') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date" value="{{ old('date') }}"
                        min="{{ date('Y-m-d') }}"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        @error('date') border-red-500 @enderror">
                    @error('date') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
                    <input type="time" name="time" value="{{ old('time') }}"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                        @error('time') border-red-500 @enderror">
                    @error('time') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                <textarea name="complaint" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500
                    @error('complaint') border-red-500 @enderror"
                    placeholder="Deskripsikan keluhan pasien...">{{ old('complaint') }}</textarea>
                @error('complaint') <p class="text-red-500 text-xs mt-1">{{ $message }}</p> @enderror
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="menunggu" {{ old('status') === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="selesai" {{ old('status') === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ old('status') === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded hover:bg-blue-700 text-sm">
                    Simpan
                </button>
                <a href="{{ route('appointments.index') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded hover:bg-gray-300 text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection