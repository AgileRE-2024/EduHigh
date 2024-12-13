<?php

namespace App\Http\Controllers;

use App\Models\Logbook;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreLogbookRequest;
use App\Http\Requests\UpdateLogbookRequest;
use App\Models\SuperVision;
use Barryvdh\DomPDF\Facade\Pdf;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class LogbookController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == "dosen") {
            $logbooks = Logbook::whereHas('superVision', function ($query) {
                $query->where('dosen_id', Auth::user()->dosen->id);
            })->where('status', 'pending')->paginate(10);

            return view("dashboard.dosen.logbooks.index", compact("logbooks"));
        } else if (Auth::user()->role == "mahasiswa") {
            $logbooks = Logbook::whereHas('superVision', function ($query) {
                $query->where('mahasiswa_id', Auth::user()->mahasiswa->id);
            })->paginate(10);
            return view("dashboard.mahasiswa.logbooks.index", compact("logbooks"));
        }
    }


    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //
        if (Auth::user()->role == "admin") {
            return view("dashboard.dosen.logbooks.create");
        } else if (Auth::user()->role == "mahasiswa") {

            return view("dashboard.mahasiswa.logbooks.create");
        }
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreLogbookRequest $request)
    {
        //
        $request->validated();

        try {
            $superVision = SuperVision::where('dosen_id', $request->dosen_id)
                ->where('mahasiswa_id', Auth::user()->mahasiswa->id)
                ->first();

            Logbook::create([
                "super_vision_id" => $superVision->id,
                "notes" => $request->notes,
                "status" => "pending",
                "date" => $request->date,
                "percentage" => $request->percentage,
            ]);
            return redirect()->route("logbooks.index")->with("success", "Logbook created successfully");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route("logbooks.create")->with("error", "Logbook created successfully");
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Logbook $logbook)
    {
        //
        return view("dashboard.mahasiswa.logbooks.show", compact("logbook"));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Logbook $logbook)
    {
        //
        if (Auth::user()->role == "admin") {
            return view("dashboard.dosen.logbooks.create");
        } else if (Auth::user()->role == "mahasiswa") {
            return view("dashboard.mahasiswa.logbooks.edit", compact("logbook"));
        }
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateLogbookRequest $request, Logbook $logbook)
    {
        //
        if ($logbook->status == "approved") {
            return redirect()->route("logbooks.index")->with("error", "Logbook has been approved");
        }

        $request->validated();

        try {
            $logbook->update([
                "dosen_id" => $request->dosen_id,
                "notes" => $request->notes,
                "date" => $request->date,
                "status" => "pending",
                "percentage" => $request->percentage,
            ]);
            return redirect()->route("logbooks.index")->with("success", "Logbook updated successfully");
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route("logbooks.edit", $logbook->id)->with("error", "Logbook updated failed");
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Logbook $logbook)
    {
        //
    }

    public function confirmLogbook(Request $request, Logbook $logbook)
    {
        $logbook = Logbook::findOrFail($logbook->id);

        // Update status based on input
        $logbook->status = $request->input('status');
        $logbook->comments = $request->input('comments', null);
        $logbook->save();

        return redirect()->route('logbooks.index')->with('success', 'Logbook status berhasil diperbarui.');
    }

    public function export()
    {
        $mahasiswa = Auth::user()->mahasiswa;
        $logbooks = Logbook::whereHas('superVision', function ($query) use ($mahasiswa) {
            $query->where('mahasiswa_id', $mahasiswa->id)
                ->where('status', 'approved');
        })->where('status', 'confirmed')
            ->get();

        $pdf = Pdf::loadView('dashboard.mahasiswa.logbooks.export', compact('logbooks', 'mahasiswa'));
        return $pdf->download('logbook.pdf');
    }
}
