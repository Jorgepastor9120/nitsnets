<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Sport;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class CourtController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        return view('courts.index', [
            'courts' => Court::orderBy('id', 'desc')
                                ->paginate(5)
        ]);
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create(Court $court)
    {
        return view('courts.court_create', [
            'court' => $court,
            'sports' => Sport::all()
        ]);
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        $request->validate([
            'name' => 'required|unique:courts,name',
            'sport_id' => 'required'
        ]);
        
        $createCourt = Court::create(
            [
                'name' => $request->name,
                'sport_id' => $request->sport_id
            ]);

        return view('courts.court_edit', [
                'court' => $createCourt,
                'sports' => Sport::all(),
                'btnNewCourt' => true
            ]);
    }

    /**
     * Display the specified resource.
     */
    public function show(Court $court)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Court $court)
    {
        return view('courts.court_edit', [
            'court' => $court,
            'sports' => Sport::all()
        ]);
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Court $court)
    {
        $request->validate([
            'name' => [
                'required',
                 Rule::unique('courts', 'name')->ignore($court->id)
            ],
            'sport_id' => 'required'
        ]);

        $court->update(
            [
                'name' => $request->name,
                'sport_id' => $request->sport_id
            ]);

        return view('courts.court_edit', [
            'court' => $court,
            'sports' => Sport::all()
        ]);
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Court $court)
    {
        $court->delete();

        return back();
    }
}
