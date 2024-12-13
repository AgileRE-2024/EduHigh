<?php

namespace App\Http\Controllers;

use App\Models\Schedule;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreScheduleRequest;
use App\Http\Requests\UpdateScheduleRequest;
use Hamcrest\Core\IsNot;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ScheduleController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'dosen') {
            $schedules = Schedule::where('dosen_id', Auth::user()->dosen->id)->paginate(10);
            return view('dashboard.dosen.schedules.index', compact('schedules'));
        } else if (Auth::user()->role == 'admin') {
            $schedules = Schedule::paginate(10);
            return view('dashboard.admin.schedules.index', compact('schedules'));
        } else {
            $approvedSupervisions = Auth::user()->mahasiswa->superVisions->where('status', 'approved');

            if ($approvedSupervisions->isNotEmpty()) {
                $dosenIds = $approvedSupervisions->pluck('dosen_id')->toArray();

                $schedules = Schedule::whereIn('dosen_id', $dosenIds)->paginate(10);
            } else {
                $schedules = collect();
            }

            return view('dashboard.mahasiswa.schedules.index', compact('schedules'));
        }
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Auth::user()->role == 'dosen') {
            return view('dashboard.dosen.schedules.create');
        } else {
            return view('dashboard.admin.schedules.create');
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreScheduleRequest $request)
    {
        //
        $request->validated();

        try {
            Schedule::create([
                'dosen_id' => $request->dosen_id,
                'schedule_date' => $request->schedule_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'quota' => $request->quota,
                'remaining_quota' => $request->quota,
            ]);

            return redirect()->route('schedules.index')->with('status', 'schedule-created');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'schedule-created-failed');
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Schedule $schedule)
    {
        //

        $appointments = $schedule->appointments()->get();
        if (Auth::user()->role == 'dosen') {
            return view('dashboard.dosen.schedules.show', compact('schedule', 'appointments'));
        } else {
            return view('dashboard.admin.schedules.show', compact('schedule', 'appointments'));
        }
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Schedule $schedule)
    {
        //

        if (Auth::user()->role == 'dosen') {
            return view('dashboard.dosen.schedules.edit', compact('schedule'));
        } else {
            return view('dashboard.admin.schedules.edit', compact('schedule'));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateScheduleRequest $request, Schedule $schedule)
    {
        //
        $request->validated();
        try {
            $schedule->update([
                'schedule_date' => $request->schedule_date,
                'start_time' => $request->start_time,
                'end_time' => $request->end_time,
                'location' => $request->location,
                'quota' => $request->quota,
            ]);

            return redirect()->route('schedules.index')->with('status', 'schedule-updated');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'schedule-updated-failed');
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Schedule $schedule)
    {
        //
        try {
            $schedule->appointments()->delete();
            $schedule->delete();

            return redirect()->route('schedules.index')->with('status', 'schedule-deleted');
        } catch (\Exception $e) {
            return redirect()->back()->with('status', 'schedule-deleted-failed');
        }
    }
}
