<?php

namespace App\Http\Controllers;

use App\Models\Grup;
use App\Models\Professor;
use Illuminate\Http\Request;
use Illuminate\Validation\Rule;

class GrupController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $grups = Grup::with('professor')->latest()->get();
        return view('grups.index', compact('grups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $professorsLliures = Professor::whereDoesntHave('grup')->get();
        return view('grups.create', compact('professorsLliures'));
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $validated = $request->validate([
            'nom' => 'required|string|max:50|unique:grups',
            'aula' => 'required|string|max:20',
            'professor_id' => [
                'required',
                'integer',
                'exists:professor,id',
                Rule::unique('grups', 'professor_id')
            ]
        ]);

        Grup::create($validated);
        return redirect()->route('grups.index')
                        ->with('success', 'Grup creat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Grup $grup)
    {
        
        $grup->load(['professor', 'alumnes']);
        return view('grups.show', compact('grup'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Grup $grup)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $professorActual = $grup->professor;
        $professorsLliures = Professor::whereDoesntHave('grup')->get();

        $professors = $professorsLliures;
        if($professorActual && !$professors->contains($professorActual)){
            $professors->push($professorActual);
        }

        return view('grups.edit', compact('grup', 'professors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $grup = Grup::findOrFail($id);
        
        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:50',
                Rule::unique('grups')->ignore($grup->id)
            ],
            'aula' => 'required|string|max:20',
            'professor_id' => [
                'required',
                'integer',
                'exists:professors,id',
                Rule::unique('grups', 'professor_id')->ignore($grup->id)
            ]
        ]);

        $grup->update($validated);
        return redirect()->route('grups.show', $grup)
                        ->with('success', 'Grup actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Grup $grup)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }
        $grup->delete();
        return redirect()->route('grups.index')
                        ->with('success', 'Grup eliminat correctament!');
    }
}
