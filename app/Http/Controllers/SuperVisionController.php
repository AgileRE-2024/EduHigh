<?php

namespace App\Http\Controllers;

use App\Models\SuperVision;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreSuperVisionRequest;
use App\Http\Requests\UpdateSuperVisionRequest;
use App\Models\Dosen;
use App\Models\Mahasiswa;
use Illuminate\Support\Facades\Auth;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Log;

class SuperVisionController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        if (Auth::user()->role == 'mahasiswa') {
            $proposal = Auth::user()->proposal;

            // Get approved supervisions for student
            $approvedSupervision = Auth::user()->mahasiswa->superVisions()
                ->where('status', 'approved')
                ->get();

            if ($proposal) {
                $kbkId = $proposal->subkbk->kbk_id;

                $dosens = Dosen::where('kbk_id', $kbkId)
                    ->withCount('supervisions')
                    ->orderByDesc('supervisions_count')
                    ->get();

                return view('dashboard.mahasiswa.supervisions.index', [
                    'dosens' => $dosens,
                    'approvedSupervision' => $approvedSupervision
                ]);
            }

            return view('dashboard.mahasiswa.supervisions.index', [
                'dosens' => collect(),
                'approvedSupervision' => $approvedSupervision
            ]);
        }

        // For dosen role
        $dosenId = Auth::user()->dosen->id;
        $students = Mahasiswa::whereHas('supervisions', function ($query) use ($dosenId) {
            $query->where('dosen_id', $dosenId)
                ->where('status', 'approved');
        })
            ->with(['user', 'supervisions.dosen'])
            ->get();

        return view('dashboard.dosen.supervisions.index', compact('students'));
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
    public function store(StoreSuperVisionRequest $request)
    {
        $request->validated();

        try {
            // Mencari atau membuat data supervisi baru
            $superVision = SuperVision::firstOrCreate(
                [
                    'mahasiswa_id' => $request->mahasiswa_id,
                    'dosen_id' => $request->dosen_id,
                ],
                [
                    'status' => 'pending',
                    'dosen_pembimbing' => 'pembimbing_1'
                ]
            );

            // Jika data sudah ada, perbarui statusnya menjadi 'pending'
            if (!$superVision->wasRecentlyCreated) {
                $superVision->status = 'pending';
                $superVision->comment = null;
                $superVision->save();
            }

            return redirect()->route('supervisions.index')->with('success', 'Supervisi berhasil ditambahkan');
        } catch (\Exception $e) {
            return redirect()->route('supervisions.index')->with('error', 'Supervisi gagal ditambahkan');
        }
    }

    public function showKoordinasiPembimbing()
    {
        $mahasiswas = Mahasiswa::whereHas('superVisions', function ($query) {
            $query->where('dosen_pembimbing', 'pembimbing_1')
                ->where('status', 'approved');
        })->whereDoesntHave('superVisions', function ($query) {
            $query->where('dosen_pembimbing', 'pembimbing_2');
        })->with('user.proposal.subkbk.kbk.dosen.user')->get();

        return view('dashboard.dosen.supervisions.showKoordinasiPembimbing', compact('mahasiswas'));
    }


    /**
     * Display the specified resource.
     */
    public function show(SuperVision $superVision)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(SuperVision $superVision)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateSuperVisionRequest $request, SuperVision $superVision)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(SuperVision $superVision)
    {
        //
    }

    public function showDosen(Dosen $dosen)
    {
        //dd
        return view('dashboard.mahasiswa.supervisions.showDosen', compact('dosen'));
    }

    public function showMahasiswa(Mahasiswa $mahasiswa)
    {
        $mahasiswa = Mahasiswa::with([
            'user',
            'user.proposal.subkbk.kbk',
            'user.proposal.titles',
            'user.proposal.researchQuestions.reasons',
            'user.proposal.previousResearches',
            'user.proposal.outputs',
            'user.proposal.backgroundReasons'
        ])->findOrFail($mahasiswa->id);

        return view('dashboard.dosen.supervisions.showMahasiswa', compact('mahasiswa'));
    }

    public function request()
    {



        $students = Auth::user()->dosen->superVisions->where('status', 'pending');
        return view('dashboard.dosen.supervisions.request', compact('students'));
    }

    public function updateStatus(Request $request, $id, $action)
    {
        $request->validate([
            'supervision_id' => 'required|exists:super_visions,id',
            'comment' => 'nullable|string',
        ]);

        try {
            $supervision = SuperVision::findOrFail($id);

            if ($action === 'approve') {
                $supervision->status = 'approved';
                $supervision->dosen_pembimbing = 'pembimbing_1';

                SuperVision::where('mahasiswa_id', $supervision->mahasiswa_id)
                    ->where('status', 'pending')
                    ->where('id', '!=', $supervision->id)
                    ->delete();

                $message = 'Supervisi berhasil diterima';
            } elseif ($action === 'reject') {
                $supervision->status = 'rejected';
                $supervision->comment = $request->comment;
                $message = 'Supervisi berhasil ditolak';
            } else {
                return response()->json(['success' => false, 'message' => 'Invalid action'], 400);
            }

            $supervision->save();

            return response()->json(['success' => true, 'message' => $message]);
        } catch (\Exception $e) {
            Log::error('Error : ' . $e->getMessage());
            return response()->json(['success' => false, 'message' => 'Terjadi kesalahan saat memproses permintaan'], 500);
        }
    }

    public function assignPembimbing2(Request $request)
    {
        $request->validate([
            'mahasiswa_id' => 'required|exists:mahasiswas,id',
            'dosen_id' => 'required|exists:dosens,id',
        ]);

        $mahasiswa = Mahasiswa::find($request->mahasiswa_id);
        $mahasiswa->superVisions()->create([
            'dosen_id' => $request->dosen_id,
            'dosen_pembimbing' => 'pembimbing_2',
            'status' => 'approved',
        ]);

        return redirect()->route('supervisions.showKoordinasiPembimbing')->with('success', 'Pembimbing 2 berhasil ditetapkan.');
    }
}
