<?php

namespace App\Http\Controllers;

use App\Models\ProposalCriteria;
use App\Http\Controllers\Controller;
use App\Http\Requests\StoreProposalCriteriaRequest;
use App\Http\Requests\UpdateProposalCriteriaRequest;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Log;

class ProposalCriteriaController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        //
        if (!Auth::user()->role == 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        $proposalCriterias = ProposalCriteria::all();

        return view('dashboard.admin.proposalCriterias.index', compact('proposalCriterias'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        //

        if (!Auth::user()->role == 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        return view('dashboard.admin.proposalCriterias.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(StoreProposalCriteriaRequest $request)
    {
        //
        $request->validated();
        try {
            ProposalCriteria::create($request->all());
            return redirect()->route('proposalCriterias.index')->with('success', ' Proposal Criteria created successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proposalCriterias.create')->with('error', $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(ProposalCriteria $proposalCriteria)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(ProposalCriteria $proposalCriteria)
    {
        //
        if (!Auth::user()->role == 'admin') {
            return redirect()->route('dashboard')->with('error', 'You are not authorized to access this page');
        }

        return view('dashboard.admin.proposalCriterias.edit', compact('proposalCriteria'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(UpdateProposalCriteriaRequest $request, ProposalCriteria $proposalCriteria)
    {
        //
        $request->validated();
        try {
            $proposalCriteria->update($request->all());
            return redirect()->route('proposalCriterias.index')->with('success', 'Proposal Criteria updated successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proposalCriterias.edit')->with('error', $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(ProposalCriteria $proposalCriteria)
    {
        //
        try {
            $proposalCriteria->delete();
            return redirect()->route('proposalCriterias.index')->with('success', 'Proposal Criteria deleted successfully');
        } catch (\Exception $e) {
            Log::error($e->getMessage());
            return redirect()->route('proposalCriterias.index')->with('error', $e->getMessage());
        }
    }
}
