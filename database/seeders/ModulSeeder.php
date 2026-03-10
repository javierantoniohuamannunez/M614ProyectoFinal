<?php

namespace Database\Seeders;

use App\Models\Modul;
use App\Models\Professor;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class ModulSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        // Obtener todos los profesores
        $professors = Professor::all();
        
        // Si no hay profesores, crear algunos
        if ($professors->isEmpty()) {
            $this->command->warn('⚠️ No hi ha professors. Crea alguns professors primer.');
            return;
        }

        $moduls = [
            // CFGS DAW (Desarrollo de Aplicaciones Web)
            [
                'nom' => 'Desenvolupament Web en Entorn Client',
                'hores' => 128,
                'professor_id' => $professors->first()->id,
            ],
            [
                'nom' => 'Desenvolupament Web en Entorn Servidor',
                'hores' => 128,
                'professor_id' => $professors->count() > 1 ? $professors[1]->id : $professors->first()->id,
            ],
            [
                'nom' => 'Desplegament d\'Aplicacions Web',
                'hores' => 64,
                'professor_id' => $professors->first()->id,
            ],
            [
                'nom' => 'Disseny d\'Interfícies Web',
                'hores' => 96,
                'professor_id' => $professors->count() > 2 ? $professors[2]->id : null,
            ],
            [
                'nom' => 'Empresa i Iniciativa Emprenedora',
                'hores' => 64,
                'professor_id' => null, // Opcional
            ],
            // CFGS ASIX (Administración de Sistemas Informáticos en Red)
            [
                'nom' => 'Implantació de Sistemes Operatius',
                'hores' => 96,
                'professor_id' => $professors->first()->id,
            ],
            [
                'nom' => 'Gestió de Bases de Dades',
                'hores' => 96,
                'professor_id' => $professors->count() > 1 ? $professors[1]->id : null,
            ],
            [
                'nom' => 'Programació Bàsica',
                'hores' => 96,
                'professor_id' => null, // Sin asignar
            ],
            [
                'nom' => 'Llenguatge de Marques i Sistemes de Gestió d\'Informació',
                'hores' => 96,
                'professor_id' => null,
            ],
        ];

        foreach ($moduls as $modul) {
            Modul::create($modul);
        }

        $this->command->info(sprintf('✅ Creats %d mòduls', count($moduls)));
    }
}