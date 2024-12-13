<?php

namespace App\Http\Controllers;

use App\Http\Controllers\Controller;
use App\Models\Appointment;
use App\Models\Logbook;
use App\Models\Schedule;
use App\Models\SeminarProposal;
use App\Models\SuperVision;
use Illuminate\Http\Request;
use Carbon\Carbon;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class DashboardController extends Controller
{
    //
    public function index()
    {
        $user = Auth::user();

        if ($user->role == 'admin') {
            return view('dashboard.admin.index');
        } elseif ($user->role == 'dosen') {
            $dosenId = $user->dosen->id;

            $studentsSupervised = SuperVision::where('dosen_id', $dosenId)->count();

            $consultationsCount = Logbook::whereHas('superVision', function ($query) use ($dosenId) {
                $query->where('dosen_id', $dosenId);
            })->count();

            $pendingApprovals = SuperVision::where('dosen_id', $dosenId)
                ->where('status', 'pending')
                ->count();

            $completedSupervisions = SuperVision::where('dosen_id', $dosenId)
                ->where('status', 'completed')
                ->count();

            $upcomingSchedules = Schedule::where('dosen_id', $dosenId)
                ->where('schedule_date', '>=', now())
                ->orderBy('schedule_date')
                ->orderBy('start_time')
                ->take(5)
                ->get();

            $upcomingAppointments = Appointment::whereHas('schedule', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id)
                    ->where('schedule_date', '>=', now())
                    ->orderBy('schedule_date', 'asc')
                    ->orderBy('start_time', 'asc');
            })->with(['mahasiswa.user', 'schedule'])
                ->take(5)
                ->get();


            return view('dashboard.dosen.index', compact(
                'studentsSupervised',
                'consultationsCount',
                'pendingApprovals',
                'completedSupervisions',
                'upcomingSchedules',
                "upcomingAppointments"
            ));
        } else {
            return view('dashboard.mahasiswa.index');
        }
    }
}
