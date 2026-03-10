<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Professor;

class ProfessorSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professors = [
            [
                'nom' => 'Anna',
                'cognoms' => 'Garcia Martinez',
                'email' => 'anna.garcia@icv.cat',
                'foto' => null,
            ],
            [
                'nom' => 'Marc',
                'cognoms' => 'Sánchez López',
                'email' => 'marc.sanchez@icv.cat',
                'foto' => null,
            ],
        ];

        foreach ($professors as $professor){
            Professor::create($professor);
        }

        $this->command->info('2 professors creats');
    }
}
