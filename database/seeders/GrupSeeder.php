<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Grup;
use App\Models\Professor;

class GrupSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $professor1 = Professor::find(1);
        $professor2 = Professor::find(2);

        if(!$professor1 || !$professor2){
            $this->command->info("S'ha de executar abans ProfessorSeeder");
            return;
        }

        $grups = [
            [
                'nom' => '2DAW',
                'aula' => 'A101',
                'professor_id' => $professor1->id,
            ],
            [
                'nom' => '1DAW',
                'aula' => 'A102',
                'professor_id' => $professor2->id,
            ],
        ];

        foreach($grups as $grup){
            Grup::create($grup);
        }

        $this->command->info('2 grups creats correctament amb professors assignats');
    }
}
