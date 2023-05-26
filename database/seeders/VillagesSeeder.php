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
        $village = Village::create([
            'name' => 'Отличное начало',
            'address' => 'Проспект Ларавела',
            'square' => '24',
            'phone' => '79263543523',
//            'youtube_link' => '',
        ]);
        $photo = Photo::create(['path' => 'build/assets/seed_images/villages/1.jpg']);
        $village->photo()->associate($photo);
        $village->save();
        Village::create([
            'name' => 'Перспективное будущее',
            'address' => 'Фалконовая набережная',
            'square' => '15',
            'phone' => '79544634545',
            'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
        ]);
        Village::create([
            'name' => 'Прекрасная жизнь',
            'address' => 'Симфоническая область',
            'square' => '80',
            'phone' => '79055467351',
//            'youtube_link' => '',
        ]);
        Village::create([
            'name' => 'Несчастный случай',
            'address' => 'Кохановское кладбище',
            'square' => '10',
            'phone' => '79055467351',
            'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
        ]);
        Village::create([
            'name' => 'Отчаяние',
            'address' => 'Прерия джанго',
            'square' => '35',
            'phone' => '79055467351',
            'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
        ]);
        Village::create([
            'name' => 'Джаваево',
            'address' => 'Спринговая долина',
            'square' => '67',
            'phone' => '79055467351',
//            'youtube_link' => '',
        ]);
        Village::create([
            'name' => 'Новое шарпово',
            'address' => 'Дотнет парк',
            'square' => '46',
            'phone' => '79055467351',
            'youtube_link' => 'https://www.youtube.com/watch?v=GFq6wH5JR2A',
        ]);
    }
}
