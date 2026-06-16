<?php

namespace App\Http\Controllers;

use App\Models\Patient;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class PatientController extends Controller
{
    public function index()
    {
        $patients = Patient::latest()->paginate(10);
        return view('patients.index', compact('patients'));
    }

    public function create()
    {
        return view('patients.create');
    }

    public function store(Request $request)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'nik'        => 'required|string|size:16|unique:patients,nik',
            'birth_date' => 'required|date',
            'gender'     => 'required|in:L,P',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            $data['photo'] = $request->file('photo')->store('patients', 'public');
        }

        Patient::create($data);

        return redirect()->route('patients.index')
            ->with('success', 'Pasien berhasil ditambahkan!');
    }

    public function show(Patient $patient)
    {
        $appointments = $patient->appointments()
            ->with('doctor')
            ->latest()
            ->get();
        return view('patients.show', compact('patient', 'appointments'));
    }

    public function edit(Patient $patient)
    {
        return view('patients.edit', compact('patient'));
    }

    public function update(Request $request, Patient $patient)
    {
        $request->validate([
            'name'       => 'required|string|max:255',
            'nik'        => 'required|string|size:16|unique:patients,nik,' . $patient->id,
            'birth_date' => 'required|date',
            'gender'     => 'required|in:L,P',
            'phone'      => 'required|string|max:20',
            'address'    => 'required|string',
            'photo'      => 'nullable|image|mimes:jpg,jpeg,png|max:2048',
        ]);

        $data = $request->except('photo');

        if ($request->hasFile('photo')) {
            if ($patient->photo) {
                Storage::disk('public')->delete($patient->photo);
            }
            $data['photo'] = $request->file('photo')->store('patients', 'public');
        }

        $patient->update($data);

        return redirect()->route('patients.index')
            ->with('success', 'Data pasien berhasil diperbarui!');
    }

    public function destroy(Patient $patient)
    {
        if ($patient->photo) {
            Storage::disk('public')->delete($patient->photo);
        }

        $patient->delete();

        return redirect()->route('patients.index')
            ->with('success', 'Pasien berhasil dihapus!');
    }
}