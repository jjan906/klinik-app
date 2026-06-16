<?php

namespace App\Http\Controllers;

use App\Models\Doctor;
use App\Models\Patient;
use App\Models\Appointment;
use App\Models\MedicalRecord;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    public function index()
    {
        // Statistik utama
        $totalDoctors      = Doctor::count();
        $totalPatients     = Patient::count();
        $totalAppointments = Appointment::count();
        $totalRecords      = MedicalRecord::count();

        // Janji temu hari ini
        $todayAppointments = Appointment::with(['patient', 'doctor'])
            ->whereDate('date', today())
            ->orderBy('time')
            ->get();

        // Janji temu berdasarkan status
        $statusCounts = Appointment::select('status', DB::raw('count(*) as total'))
            ->groupBy('status')
            ->pluck('total', 'status');

        // Dokter paling banyak dituju (top 5)
        $topDoctors = Doctor::withCount('appointments')
            ->orderByDesc('appointments_count')
            ->take(5)
            ->get();

        // Pasien terbaru
        $latestPatients = Patient::latest()->take(5)->get();

        // Rekam medis terbaru
        $latestRecords = MedicalRecord::with(['appointment.patient', 'appointment.doctor'])
            ->latest()
            ->take(5)
            ->get();

        // Janji temu 7 hari ke depan
        $upcomingAppointments = Appointment::with(['patient', 'doctor'])
            ->where('status', 'menunggu')
            ->whereBetween('date', [today(), today()->addDays(7)])
            ->orderBy('date')
            ->orderBy('time')
            ->get();

        return view('dashboard', compact(
            'totalDoctors',
            'totalPatients',
            'totalAppointments',
            'totalRecords',
            'todayAppointments',
            'statusCounts',
            'topDoctors',
            'latestPatients',
            'latestRecords',
            'upcomingAppointments'
        ));
    }
}