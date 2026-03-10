<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Alumne;
use App\Models\Grup;
use Carbon\Carbon;

class AlumneSeeder extends Seeder
{
    /**
     * Run the database seeds.
     */
    public function run(): void
    {
        $grup1 = Grup::where('nom', '2DAW')->first();
        $grup2 = Grup::where('nom', '1DAW')->first();

        $alumnes = [
            [
                'nom' => 'Laura',
                'cognoms' => 'Fernández Costa',
                'dni' => '12345678A',
                'email' => 'laurafernandez@icv.cat',
                'data_naixament' => Carbon::create(2003, 5, 15),
                'telefon' => '652786598',
                'grup_id' => $grup1->id ?? null,
            ],
            [
                'nom' => 'Jordi',
                'cognoms' => 'Mártinez Roca',
                'dni' => '86742674B',
                'email' => 'jordimartinez@icv.cat',
                'data_naixament' => Carbon::create(2004, 8, 22),
                'telefon' => '624162765',
                'grup_id' => $grup1->id ?? null,
            ],
            [
                'nom' => 'Carlos',
                'cognoms' => 'Puig Soler',
                'dni' => '45268172T',
                'email' => 'carlospuig@icv.cat',
                'data_naixament' => Carbon::create(2005, 2, 10),
                'telefon' => '638968765',
                'grup_id' => $grup2->id ?? null,
            ],
        ];

        foreach($alumnes as $alumne){
            Alumne::create($alumne);
        }

        $this->command->info('3 alumnes creats');
    }
}
