<?php

namespace Database\Seeders;

use App\Models\EstateType;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class EstateTypesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $estate_types = [
            EstateType::create([
                'name' => 'Дом',
            ]),
            EstateType::create([
                'name' => 'Коттедж',
            ]),
            EstateType::create([
                'name' => 'Таунхаус',
            ]),
            EstateType::create([
                'name' => 'Квартира',
            ]),
        ];
    }
}
