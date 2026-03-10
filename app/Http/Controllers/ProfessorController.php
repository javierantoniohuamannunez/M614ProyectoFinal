<?php

namespace App\Http\Controllers;

use App\Models\Professor;
use Illuminate\Http\Request;

class ProfessorController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index()
    {
        $professors = Professor::all();
        return view('professors.index', compact('professors'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        return view('professors.create');
    }

    /**
     * Store a newly created resource in storage.
     */
    public function store(Request $request)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $validatedData = $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email',
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
        ]);

        if($request->hasFile('foto')){
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();

            $ruta = env('RUTA_FOTOS', 'uploads/fotos');
            $request->file('foto')->move(public_path($ruta), $fileName);

            $validatedData['foto'] = $fileName;
        }

        Professor::create($validatedData);

        return redirect()->route('professors.index')
                        ->with('success', 'Professor creat correctament!');
    }

    /**
     * Display the specified resource.
     */
    public function show(Professor $professor)
    {
        return view('professors.show', compact('professor'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Professor $professor)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        return view('professors.edit', compact('professor'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Professor $professor)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'email' => 'required|email|unique:professors,email,' . $professor->id,
            'foto' => 'nullable|image|mimes:jpeg,png,jpg,gif|max:2048',
            'eliminar_foto' => 'nullable|boolean',
        ]);

        if($request->has('eliminar_foto') && $request->eliminar_foto == '1'){
            if($professor->foto && file_exists(public_path('uploads/fotos/' . $professor->foto))) {
                unlink(public_path('uploads/fotos/' . $professor->foto));
            }
            $validated['foto'] = null;
        }
        elseif ($request->hasFile('foto')) {
            if ($professor->foto && file_exists(public_path(env('RUTA_FOTOS', 'uploads/fotos') . '/' . $professor->foto))) {
                unlink(public_path(env('RUTA_FOTOS', 'uploads/fotos') . '/' . $professor->foto));
            }
            $fileName = time() . '_' . $request->file('foto')->getClientOriginalName();
            $request->file('foto')->move(public_path('uploads/fotos'), $fileName);
            $validated['foto'] = $fileName;
        }
        else {
            unset($validated['foto']);
        }

        unset($validated['eliminar_foto']);

        $professor->update($validated);

        return redirect()->route('professors.show', $professor)
                        ->with('success', 'Professor actualitzat correctament!');
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Professor $professor)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }
        if ($professor->foto && file_exists(public_path(env('RUTA_FOTOS', 'uploads/fotos') . '/' . $professor->foto))) {
            unlink(public_path(env('RUTA_FOTOS', 'uploads/fotos') . '/' . $professor->foto));
        }
    
        $professor->delete();
        return redirect()->route('professors.index')
                        ->with('success', 'Professor eliminat correctament!');
    }
}
