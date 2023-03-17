<?php

namespace App\Http\Controllers;

use App\Models\Court;
use App\Models\Sport;
use App\Http\Requests\SportStoreRequest;
use App\Http\Requests\SportUpdateRequest;
use Illuminate\Http\Request;

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
    public function store(SportStoreRequest $request)
    {
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
    public function update(SportUpdateRequest $request, Sport $sport)
    {
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
