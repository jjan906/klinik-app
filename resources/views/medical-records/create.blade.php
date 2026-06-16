@extends('layouts.app')
@section('title', 'Tambah Rekam Medis')

@section('content')
<div class="max-w-2xl mx-auto">
    <h2 class="text-2xl font-bold text-gray-800 mb-6">Tambah Rekam Medis</h2>

    <div class="bg-white rounded-lg shadow p-6">
        <form action="{{ route('medical-records.store') }}" method="POST"
              enctype="multipart/form-data">
            @csrf

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Janji Temu
                </label>
                <select name="appointment_id"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           @error('appointment_id') border-red-500 @enderror">
                    <option value="">-- Pilih Janji Temu --</option>
                    @foreach($appointments as $appt)
                        <option value="{{ $appt->id }}"
                            {{ (old('appointment_id', $selectedAppointment) == $appt->id)
                                ? 'selected' : '' }}>
                            {{ $appt->patient->name }} →
                            Dr. {{ $appt->doctor->name }} |
                            {{ \Carbon\Carbon::parse($appt->date)->format('d M Y') }}
                            {{ $appt->time }}
                        </option>
                    @endforeach
                </select>
                @error('appointment_id')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Diagnosis
                </label>
                <textarea name="diagnosis" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           @error('diagnosis') border-red-500 @enderror"
                    placeholder="Tulis diagnosis pasien...">{{ old('diagnosis') }}</textarea>
                @error('diagnosis')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Resep Obat
                </label>
                <textarea name="prescription" rows="3"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500
                           @error('prescription') border-red-500 @enderror"
                    placeholder="Tulis resep obat...">{{ old('prescription') }}</textarea>
                @error('prescription')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="mb-4">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Catatan Tambahan (opsional)
                </label>
                <textarea name="notes" rows="2"
                    class="w-full border rounded px-3 py-2 text-sm
                           focus:outline-none focus:ring-2 focus:ring-blue-500"
                    placeholder="Catatan tambahan untuk pasien...">{{ old('notes') }}</textarea>
            </div>

            {{-- Upload File --}}
            <div class="mb-6">
                <label class="block text-sm font-medium text-gray-700 mb-1">
                    Lampiran (opsional)
                </label>
                <div class="border-2 border-dashed border-gray-300 rounded-lg p-4
                            text-center hover:border-blue-400 transition"
                     id="dropzone">
                    <input type="file" name="attachment" accept=".jpg,.jpeg,.png,.pdf"
                           class="hidden" id="fileInput"
                           onchange="previewFile(this)">
                    <label for="fileInput" class="cursor-pointer">
                        <p class="text-gray-400 text-sm">
                            📎 Klik untuk upload atau drag & drop
                        </p>
                        <p class="text-gray-300 text-xs mt-1">
                            JPG, PNG, atau PDF (maks. 5MB)
                        </p>
                    </label>
                    <div id="filePreview" class="mt-3 hidden">
                        <p class="text-sm text-blue-600 font-medium" id="fileName"></p>
                    </div>
                </div>
                @error('attachment')
                    <p class="text-red-500 text-xs mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div class="flex gap-3">
                <button type="submit"
                    class="bg-blue-600 text-white px-6 py-2 rounded
                           hover:bg-blue-700 text-sm">
                    Simpan
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

<script>
function previewFile(input) {
    if (input.files && input.files[0]) {
        document.getElementById('fileName').textContent = '✅ ' + input.files[0].name;
        document.getElementById('filePreview').classList.remove('hidden');
    }
}
</script>
@endsection