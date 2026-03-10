<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Alumne;
use App\Models\Grup;
use App\Models\Modul;
use Illuminate\Support\Facades\Cookie;
use Illuminate\Support\Facades\DB;
use Illuminate\Validation\Rule;

class AlumneController extends Controller
{
    /**
     * Display a listing of the resource.
     */
    public function index(Request $request)
    {
        $grups = Grup::with('professor')->get();
        $query = Alumne::with(['grup', 'moduls']);
        
        $search = $request->input('search');
        $notaMinima = $request->input('nota_minima');
        $grupSeleccionat = $request->input('grup_id');
        $operador = $request->input('operador', 'and');
        
        $hasSearch = !empty($search);
        $hasNotaMinima = $notaMinima !== null && $notaMinima !== '';
        $hasGrup = !empty($grupSeleccionat);

        if ($hasSearch && $hasNotaMinima) {
            if ($operador === 'and') {
                $query->where(function($q) use ($search) {
                    $q->where('dni', 'LIKE', "%{$search}%")
                    ->orWhere('cognoms', 'LIKE', "%{$search}%");
                })->where(function($q) use ($notaMinima) {
                    $q->whereHas('moduls', function($subq) use ($notaMinima) {
                        $subq->where('alumne_modul.nota', '>=', $notaMinima);
                    })->whereDoesntHave('moduls', function($subq) use ($notaMinima) {
                        $subq->where('alumne_modul.nota', '<', $notaMinima)
                            ->whereNotNull('alumne_modul.nota');
                    });
                });
            } else {
                $query->where(function($q) use ($search, $notaMinima) {
                    $q->where(function($subq) use ($search) {
                        $subq->where('dni', 'LIKE', "%{$search}%")
                            ->orWhere('cognoms', 'LIKE', "%{$search}%");
                    })->orWhere(function($subq) use ($notaMinima) {
                        $subq->whereHas('moduls', function($subsubq) use ($notaMinima) {
                            $subsubq->where('alumne_modul.nota', '>=', $notaMinima);
                        });
                    });
                });
            }
        } elseif ($hasSearch) {
            $query->where(function($q) use ($search) {
                $q->where('dni', 'LIKE', "%{$search}%")
                ->orWhere('cognoms', 'LIKE', "%{$search}%");
            });
        } elseif ($hasNotaMinima) {
            $query->whereHas('moduls', function($q) use ($notaMinima) {
                $q->where('alumne_modul.nota', '>=', $notaMinima);
            });
        } elseif ($hasGrup) {
            $query->where(function($q) use ($hasGrup){
                $q->where('alumnes.grup_id', '==', $hasGrup);
            });
        }
        
        $alumnes = $query->orderBy('id')->get();

        return view('alumnes.index', compact('alumnes', 'search', 'notaMinima', 'operador', 'grups'));
    }

    /**
     * Show the form for creating a new resource.
     */
    public function create()
    {
        $grups = Grup::all();
        $moduls = Modul::all();
        
        // Obtener último grupo de la cookie
        $ultimGrupId = Cookie::get('ultim_grup_id');
        $ultimGrup = $ultimGrupId ? Grup::find($ultimGrupId) : null;
        
        return view('alumnes.create', compact('grups', 'moduls', 'ultimGrup'));
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
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'dni' => 'required|string|max:9|unique:alumnes',
            'data_naixement' => 'required|date|before:today',
            'telefon' => 'nullable|string|max:15',
            'grup_id' => 'nullable|exists:grups,id',
        ]);

        $modulsData = [];
        if ($request->has('moduls')) {
            foreach ($request->input('moduls') as $modulId => $modulData) {
                if (isset($modulData['seleccionat']) && $modulData['seleccionat'] == '1') {
                    $nota = $modulData['nota'] ?? null;
                    if ($nota !== null) {
                        $request->validate([
                            "moduls.{$modulId}.nota" => 'numeric|min:0|max:10'
                        ]);
                    }
                    $modulsData[$modulId] = ['nota' => $nota];
                }
            }
        }
        
        DB::beginTransaction();
        
        try {
            $alumne = Alumne::create($validated);
            
            if (!empty($modulsData)) {
                $alumne->moduls()->sync($modulsData);
            }
            
            if ($request->has('grup_id') && $request->grup_id) {
                Cookie::queue('ultim_grup_id', $request->grup_id, 60*24*30);
            }
            
            DB::commit();
            
            return redirect()->route('alumnes.show', $alumne)
                             ->with('success', 'Alumne creat correctament!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            if ($request->has('simular_error')) {
                throw $e;
            }
            
            return back()->withInput()
                         ->with('error', 'Error al crear l\'alumne: ' . $e->getMessage());
        }
    }

    /**
     * Display the specified resource.
     */
    public function show(Alumne $alumne)
    {
        $alumne->load(['grup', 'grup.professor', 'moduls']);
        return view('alumnes.show', compact('alumne'));
    }

    /**
     * Show the form for editing the specified resource.
     */
    public function edit(Alumne $alumne)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $grups = Grup::all();
        $moduls = Modul::all();
        
        $alumne->load('moduls');
        
        return view('alumnes.edit', compact('alumne', 'grups', 'moduls'));
    }

    /**
     * Update the specified resource in storage.
     */
    public function update(Request $request, Alumne $alumne)
    {
        if (auth()->user()->rol === 'user') {
            abort(403);
        }
        $validated = $request->validate([
            'nom' => 'required|string|max:255',
            'cognoms' => 'required|string|max:255',
            'dni' => [
                'required',
                'string',
                'max:9',
                Rule::unique('alumnes')->ignore($alumne->id)
            ],
            'email' => [
                'email',
                Rule::unique('alumnes')->ignore($alumne->id)
            ],
            'data_naixement' => 'required|date|before:today',
            'telefon' => 'nullable|string|max:15',
            'grup_id' => 'nullable|exists:grups,id',
        ]);
        
        $modulsData = [];
        if ($request->has('moduls')) {
            foreach ($request->input('moduls') as $modulId => $modulData) {
                if (isset($modulData['seleccionat']) && $modulData['seleccionat'] == '1') {
                    $nota = $modulData['nota'] ?? null;
                    if ($nota !== null) {
                        $request->validate([
                            "moduls.{$modulId}.nota" => 'numeric|min:0|max:10'
                        ]);
                    }
                    $modulsData[$modulId] = ['nota' => $nota];
                }
            }
        }

        
        DB::beginTransaction();
        
        try {
            $alumne->update($validated);
            
            $alumne->moduls()->sync($modulsData);
            
            if ($request->has('grup_id') && $request->grup_id) {
                Cookie::queue('ultim_grup_id', $request->grup_id, 60*24*30);
            }
            
            DB::commit();
            
            return redirect()->route('alumnes.show', $alumne)
                             ->with('success', 'Alumne actualitzat correctament!');
            
        } catch (\Exception $e) {
            DB::rollBack();
            
            return back()->withInput()
                         ->with('error', 'Error al actualitzar l\'alumne: ' . $e->getMessage());
        }
    }

    /**
     * Remove the specified resource from storage.
     */
    public function destroy(Alumne $alumne)
    {
        if (auth()->user()->rol !== 'admin') {
            abort(403);
        }
        $alumne->delete();
        
        return redirect()->route('alumnes.index')
                         ->with('success', 'Alumne eliminat correctament!');
    }
}
