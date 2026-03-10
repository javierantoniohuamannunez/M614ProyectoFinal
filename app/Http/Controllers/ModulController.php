<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Modul;
use App\Models\Professor;
use Illuminate\Validation\Rule;


class ModulController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $moduls = Modul::with('professor')->orderBy('id')->get();
        return view('moduls.index', compact('moduls'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $professors = Professor::all();
        return view('moduls.create', compact('professors'));
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
            'nom' => 'required|string|max:255|unique:moduls',
            'hores' => 'required|integer|min:1|max:500',
            'professor_id' => 'nullable|exists:professors,id'
        ]);

        Modul::create($validated);
        return redirect()->route('moduls.index')
                        ->with('success', 'Mòdul creat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Modul $modul)
    {
        $modul->load(['professor', 'alumnes']);
        return view('moduls.show', compact('modul'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(string $id)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $modul = Modul::findOrFail($id);
        $professors = Professor::all();

        return view('moduls.edit', compact('modul', 'professors'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, string $id)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $modul = Modul::findOrFail($id);

        $validated = $request->validate([
            'nom' => [
                'required',
                'string',
                'max:255',
                Rule::unique('moduls')->ignore($modul->$id)
            ],
            'hores' => 'required|integer|min:1|max:500',
            'professor_id' => 'nullable|exists:professor,id'
        ]);

        $modul->update($validated);

        return redirect()->route('moduls.show', $modul)
                        ->with('success', 'Mòdul actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(string $id)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }
        $modul = Modul::findOrFail($id);
        $modul->delete();

        return redirect()->route('moduls.index')
                        ->with('success', 'Mòdul eliminat correctament!');
    }
}
