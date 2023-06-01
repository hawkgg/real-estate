<?php

namespace Database\Seeders;

use App\Models\Currency;
use App\Models\House;
use App\Models\Photo;
use App\Models\Price;
use App\Models\Village;
use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;

class HousesSeeder extends Seeder
{
    /**
     * Run the database seeds.
     *
     * @return void
     */
    public function run()
    {
        $house = House::create([
            'name' => 'Коттедж дряхлый',
            'floors' => '3',
            'bedrooms' => '2',
            'square' => '250',
        ]);
        $house->village_id = 6;
        $house->default_currency_id = 1;
        $house->estate_type_id = 2;
        $price = Price::create([
            'val' => 400000,
        ]);
        $price->currency()->associate(Currency::find(1));
        $price->house()->associate($house);
        $price->save();
        $photo = Photo::create(['path' => 'images/seed/houses/1/1.jpg']);
        $house->photos()->attach($photo);
        $house->save();


        $house = House::create([
            'name' => 'Таунхаус элитный',
            'floors' => '2',
            'bedrooms' => '3',
            'square' => '300',
        ]);
        $house->village_id = 3;
        $house->default_currency_id = 1;
        $house->estate_type_id = 3;
        $price = Price::create([
            'val' => 100500000,
        ]);
        $price->currency()->associate(Currency::find(1));
        $price->house()->associate($house);
        $price->save();
        $photo = Photo::create(['path' => 'images/seed/houses/2/1.jpg']);
        $house->photos()->attach($photo);
        $house->save();

    }
}
