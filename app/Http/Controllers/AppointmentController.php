<?php

namespace App\Http\Controllers;

use App\Models\Appointment;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreAppointmentRequest;
use App\Http\Requests\UpdateAppointmentRequest;
use Illuminate\Support\Facades\Auth;

class AppointmentController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'dosen' || Auth::user()->role == 'admin') {
            // Mengambil seluruh appointment dengan status pending untuk schedule yang dibuat oleh dosen yang login
            $appointments = Appointment::whereHas('schedule', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id);
            })->where('status', 'pending')->get();

            return view('dashboard.dosen.appointments.index', compact('appointments'));
        } else {
            $appointments = Auth::user()->mahasiswa->appointments()->where('status', 'approved')->get();
            return view('dashboard.mahasiswa.appointments.index', compact('appointments'));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreAppointmentRequest $request)
    {
        $request->validated();

        try {
            // Cek apakah ada appointment yang sudah ada dengan jadwal dan mahasiswa yang sama
            $appointment = Appointment::where('schedule_id', $request->schedule_id)
                ->where('mahasiswa_id', $request->mahasiswa_id)
                ->first();

            if ($appointment) {
                // Jika ada, dan statusnya 'rejected', update menjadi 'pending' dan kosongkan alasan
                if ($appointment->status === 'rejected') {
                    $appointment->update([
                        'status' => 'pending',
                        'reason' => null, // kosongkan alasan
                    ]);
                }
                // Jika sudah dalam status 'pending' atau 'approved', tidak lakukan apa-apa
                else {
                    return redirect()->route('schedules.index')->with('info', 'Appointment already exists and cannot be re-submitted.');
                }
            } else {
                // Jika tidak ada appointment, buat data baru
                Appointment::create([
                    'schedule_id' => $request->schedule_id,
                    'mahasiswa_id' => $request->mahasiswa_id,
                    'status' => 'pending',
                ]);
            }

            return redirect()->route('appointments.index')->with('success', 'Appointment submitted successfully');
        } catch (\Exception $e) {
            return redirect()->route('appointments.index')->with('error', 'Appointment failed to submit');
        }
    }


    /**
     * Display the specified resource.
     */
    public function show(Appointment $appointment)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Appointment $appointment)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateAppointmentRequest $request, Appointment $appointment)
    {
        //
        $request->validated();

        try {
            $appointment->update([
                'status' => $request->status,
                'reason' => $request->reason,
            ]);

            return redirect()->route('appointments.index')->with('success', 'Appointment updated successfully');
        } catch (\Exception $e) {
            return redirect()->route('appointments.index')->with('error', 'Appointment failed to update');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Appointment $appointment)
    {
        //
    }
}
