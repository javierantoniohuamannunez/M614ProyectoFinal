<?php

namespace App\Http\Controllers;

use App\Models\Alumne;
use App\Models\Professor;
use App\Models\Modul;
use App\Models\Grup;

class DashboardController extends Controller
{
    public function index()
    {
        $stats = [
            'total_alumnes' => Alumne::count(),
            'total_professors' => Professor::count(),
            'total_moduls' => Modul::count(),
            'total_grups' => Grup::count(),
            'alumnes_sense_grup' => Alumne::whereNull('grup_id')->count(),
            'moduls_sense_professor' => Modul::whereNull('professor_id')->count(),
        ];

        $alumnesRecents = Alumne::latest()->take(5)->get();
        $modulsPopulars = Modul::withCount('alumnes')->orderBy('alumnes_count', 'desc')->take(5)->get();

        return view('dashboard', compact('stats', 'alumnesRecents', 'modulsPopulars'));
    }
}