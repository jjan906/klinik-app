@extends('layouts.app')
@section('title', 'Edit Rekam Medis')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Edit Rekam Medis</h2>

    <div class="bg-white rounded-lg shadow p-6">

        {{-- Info Janji Temu (readonly) --}}
        <div class="bg-gray-50 rounded-lg p-4 mb-6 text-sm">
            <p class="text-gray-400 mb-1">Janji Temu</p>
            <p class="font-semibold">
                {{ $medicalRecord->appointment->patient->name }} →
                Dr. {{ $medicalRecord->appointment->doctor->name }}
            </p>
            <p class="text-gray-500">
                {{ \Carbon\Carbon::parse($medicalRecord->appointment->date)->format('d M Y') }}
                pukul {{ $medicalRecord->appointment->time }}
            </p>
        </div>

        <form action="{{ route('medical-records.update', $medicalRecord) }}"
              method="POST" enctype="multipart/form-data">
            @csrf @method('PUT')

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Diagnosis</label>
                <textarea name="diagnosis" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('diagnosis', $medicalRecord->diagnosis) }}</textarea>
                @error('diagnosis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">Resep Obat</label>
                <textarea name="prescription" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('prescription', $medicalRecord->prescription) }}</textarea>
                @error('prescription')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan Tambahan
                </label>
                <textarea name="notes" rows="2"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500">{{ old('notes', $medicalRecord->notes) }}</textarea>
            </div>

            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">Lampiran</label>
                @if($medicalRecord->attachment)
                    @php $ext = pathinfo($medicalRecord->attachment, PATHINFO_EXTENSION); @endphp
                    <div class="flex items-center gap-3 mb-2">
                        <a href="{{ asset('storage/' . $medicalRecord->attachment) }}"
                           target="_blank"
                           class="text-blue-600 hover:underline text-sm">
                            {{ $ext === 'pdf' ? '📄 Lihat PDF' : '🖼️ Lihat Gambar' }}
                        </a>
                        <span class="text-gray-400 text-xs">
                            (Upload baru untuk mengganti)
                        </span>
                    </div>
                @endif
                <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf"
                    class="w-full border rounded px-3 py-2 text-sm">
                @error('attachment')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-yellow-500 text-white px-6 py-2 rounded
                           hover:bg-yellow-600 text-sm">
                    Update
                </button>
                <a href="{{ route('medical-records.index') }}"
                    class="bg-gray-200 text-gray-700 px-6 py-2 rounded
                           hover:bg-gray-300 text-sm">
                    Batal
                </a>
            </div>
        </form>
    </div>
</div>
@endsection