<?php

namespace Database\Seeders;

use App\Models\Photo;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class VillagesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $villages = [];
        array_push($villages,
            Village::create([
                'name' => 'Отличное начало',
                'address' => 'Ларавельская топь',
                'square' => '24',
                'phone' => '79263543523',
//                'youtube_link' => '',
            ]),
            Village::create([
                'name' => 'Перспективное будущее',
                'address' => 'Фалконовая набережная',
                'square' => '15',
                'phone' => '79544634545',
                'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
            ]),

            Village::create([
                'name' => 'Прекрасная жизнь',
                'address' => 'Симфоническая область',
                'square' => '80',
                'phone' => '79055467351',
//                'youtube_link' => '',
            ]),

            Village::create([
                'name' => 'Несчастный случай',
                'address' => 'Кохановское кладбище',
                'square' => '10',
                'phone' => '79265645312',
                'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
            ]),

            Village::create([
                'name' => 'Освобождение',
                'address' => 'Прерия джанго',
                'square' => '35',
                'phone' => '79043645641',
                'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
            ]),

            Village::create([
                'name' => 'Джаваево',
                'address' => 'Спринговская слобода',
                'square' => '67',
                'phone' => '79634563446',
//                'youtube_link' => '',
            ]),

            Village::create([
                'name' => 'Новое шарпово',
                'address' => 'Дотнет парк',
                'square' => '46',
                'phone' => '79643675445',
                'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
            ]),

            Village::create([
                'name' => 'Западня',
                'address' => 'Долина битрикса',
                'square' => '36',
                'phone' => '79056474666',
            ])
        );

        for($i = 0; $i < count($villages); $i++) {
            $photo = Photo::create(['path' => 'images/seed/villages/' . $i+1 . '.jpg']);
            $villages[$i]->photo()->associate($photo);
            $villages[$i]->save();
        }
    }
}
