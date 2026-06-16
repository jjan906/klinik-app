<?php

namespace App\Http\Controllers;

use App\Models\MedicalRecord;
use App\Models\Appointment;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class MedicalRecordController extends Controller
{
    public function index()
    {
        $records = MedicalRecord::with(['appointment.patient', 'appointment.doctor'])
            ->latest()
            ->paginate(10);
        return view('medical-records.index', compact('records'));
    }

    public function create(Request $request)
    {
        $appointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'menunggu')
            ->doesntHave('medicalRecord')
            ->orderBy('date')
            ->get();
        $selectedAppointment = $request->appointment_id;
        return view('medical-records.create', compact('appointments', 'selectedAppointment'));
    }

    public function store(Request $request)
    {
        $request->validate([
            'appointment_id' => 'required|exists:appointments,id|unique:medical_records,appointment_id',
            'diagnosis'      => 'required|string',
            'prescription'   => 'required|string',
            'notes'          => 'nullable|string',
            'attachment'     => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            $data['attachment'] = $request->file('attachment')
                ->store('medical-records', 'public');
        }

        MedicalRecord::create($data);

        // Update status appointment jadi selesai
        Appointment::find($request->appointment_id)
            ->update(['status' => 'selesai']);

        return redirect()->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil disimpan!');
    }

    public function show(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['appointment.patient', 'appointment.doctor']);
        return view('medical-records.show', compact('medicalRecord'));
    }

    public function edit(MedicalRecord $medicalRecord)
    {
        $medicalRecord->load(['appointment.patient', 'appointment.doctor']);
        return view('medical-records.edit', compact('medicalRecord'));
    }

    public function update(Request $request, MedicalRecord $medicalRecord)
    {
        $request->validate([
            'diagnosis'    => 'required|string',
            'prescription' => 'required|string',
            'notes'        => 'nullable|string',
            'attachment'   => 'nullable|file|mimes:jpg,jpeg,png,pdf|max:5120',
        ]);

        $data = $request->except('attachment');

        if ($request->hasFile('attachment')) {
            if ($medicalRecord->attachment) {
                Storage::disk('public')->delete($medicalRecord->attachment);
            }
            $data['attachment'] = $request->file('attachment')
                ->store('medical-records', 'public');
        }

        $medicalRecord->update($data);

        return redirect()->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil diperbarui!');
    }

    public function destroy(MedicalRecord $medicalRecord)
    {
        if ($medicalRecord->attachment) {
            Storage::disk('public')->delete($medicalRecord->attachment);
        }

        // Kembalikan status appointment ke menunggu
        $medicalRecord->appointment->update(['status' => 'menunggu']);

        $medicalRecord->delete();

        return redirect()->route('medical-records.index')
            ->with('success', 'Rekam medis berhasil dihapus!');
    }
}