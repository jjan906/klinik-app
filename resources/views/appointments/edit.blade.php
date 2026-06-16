@extends('layouts.app')
@section('title', 'Edit Janji Temu')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Janji Temu</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('appointments.update', $appointment) }}" method="POST">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Pasien</label>
                <select name="patient_id"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($patients as $patient)
                        <option value="{{ $patient->id }}"
                            {{ $appointment->patient_id == $patient->id ? 'selected' : '' }}>
                            {{ $patient->name }} ({{ $patient->nik }})
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Dokter</label>
                <select name="doctor_id"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    @foreach($doctors as $doctor)
                        <option value="{{ $doctor->id }}"
                            {{ $appointment->doctor_id == $doctor->id ? 'selected' : '' }}>
                            {{ $doctor->name }} - {{ $doctor->speciality }}
                        </option>
                    @endforeach
                </select>
            </div>

            <div class="grid grid-cols-2 gap-4 mb-4">
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Tanggal</label>
                    <input type="date" name="date"
                        value="{{ old('date', $appointment->date) }}"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
                <div>
                    <label class="block text-sm font-medium text-gray-700 mb-1">Jam</label>
                    <input type="time" name="time"
                        value="{{ old('time', $appointment->time) }}"
                        class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                </div>
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Keluhan</label>
                <textarea name="complaint" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('complaint', $appointment->complaint) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Status</label>
                <select name="status"
                    class="w-full border rounded px-3 py-2 text-sm focus:outline-none focus:ring-2 focus:ring-blue-500">
                    <option value="menunggu" {{ $appointment->status === 'menunggu' ? 'selected' : '' }}>Menunggu</option>
                    <option value="selesai" {{ $appointment->status === 'selesai' ? 'selected' : '' }}>Selesai</option>
                    <option value="dibatalkan" {{ $appointment->status === 'dibatalkan' ? 'selected' : '' }}>Dibatalkan</option>
                </select>
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-yellow-500 text-white px-6 py-2 rounded hover:bg-yellow-600 text-sm">
                    Update
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