<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class SportController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('sports.index', [
            'sports' => Sport::orderBy('id', 'desc')
                                ->addSelect([
                                    'courts' => Court::selectRaw('count(id)')
                                    ->wherecolumn('sport_id', 'sports.id')
                                ])
                                ->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Sport $sport)
    {
        return view('sports.sport_create', [
            'sport' => $sport
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:sports,name'
        ]);
        
        $createSport = Sport::create(
            [
                'name' => $request->name
            ]);

        return view('sports.sport_edit', [
                'sport' => $createSport,
                'btnNewSport' => true
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Sport $sport)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Sport $sport)
    {
        return view('sports.sport_edit', [
            'sport' => $sport
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Sport $sport)
    {
        $request->validate([
            'name' => [
                'required',
                 Rule::unique('sports', 'name')->ignore($sport->id)
             ]
        ]);

        $sport->update(
            [
                'name' => $request->name
            ]);

        return view('sports.sport_edit', [
            'sport' => $sport
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Sport $sport)
    {
        $sport->delete();

        return back();
    }
}
