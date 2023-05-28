<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Houses\StoreRequest;
use App\Http\Requests\Houses\UpdateRequest;
use App\Models\Currency;
use App\Models\EstateType;
use App\Models\House;
use App\Models\Photo;
use App\Models\Price;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {

        $villages = Village::all();
        $estate_types = EstateType::all();
        $currencies = Currency::all();
        $houses = House::with('photos')
            ->with('default_currency')
            ->with('estate_type')
            ->with('village')
            ->get();

        return compact('villages', 'estate_types', 'currencies', 'houses');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        $currencies = Currency::all();
        $estate_types = EstateType::all();
        $villages = Village::all();

        return compact('currencies', 'estate_types', 'villages');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(StoreRequest $request)
    {
        $data = $request->validated();
        $house = new House;
        $house->fill($data);
        $currency = Currency::find($data['currency']);
        $house->default_currency_id = $currency->id;
        $estate_type = EstateType::find($data['estate_type']);
        $house->estate_type_id = $estate_type->id;
        $village = Village::find($data['village']);
        $house->village_id = $village->id;
        $house->save();
        $price = Price::create([
            'val' => $data['price'],
        ]);
        $price->currency()->associate($currency);
        $price->house()->associate($house);
        $price->save();

        $request_photos = $request->allFiles('photos');
        if (count($request_photos)) {
            $house->save();
            foreach ($request_photos['photos'] as $request_photo) {
                $original_file_name = $request_photo->getClientOriginalName();
                $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
                $ext = $request_photo->getClientOriginalExtension();
                $photo = Photo::create([
                    'path' => "storage/houses/$house->id/$filename.$ext"
                ]);
                $request_photo->storeAs(
                    "public/houses/$house->id", "$filename.$ext"
                );
                $house->photos()->attach($photo);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        return House::with('photos')
            ->with('default_currency')
            ->with('estate_type')
            ->with('village')
            ->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $house = House::findOrFail($id);
        $currencies = Currency::all();
        $estate_types = EstateType::all();
        $villages = Village::all();

        return compact('house', 'currencies', 'estate_types', 'villages');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(UpdateRequest $request, $id)
    {
        $data = $request->validated();
        $house = House::findOrFail($id);
        $house->fill($data);
        $currency = Currency::find($data['currency']);
        $house->default_currency_id = $currency->id;
        $estate_type = EstateType::find($data['estate_type']);
        $house->estate_type_id = $estate_type->id;
        $village = Village::find($data['village']);
        $house->village_id = $village->id;
        $house->save();
        $house->prices()->delete();
        $price = Price::create([
            'val' => $data['price'],
        ]);
        $price->currency()->associate($currency);
        $price->house()->associate($house);
        $price->save();

        $request_photos = $request->allFiles('photos');
        if (count($request_photos)) {
            foreach($house->photos as $photo) {
                $photo->delete();
            }
            foreach ($request_photos['photos'] as $request_photo) {
                $original_file_name = $request_photo->getClientOriginalName();
                $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
                $ext = $request_photo->getClientOriginalExtension();
                $photo = Photo::create([
                    'path' => "storage/houses/$house->id/$filename.$ext"
                ]);
                $request_photo->storeAs(
                    "public/houses/$house->id", "$filename.$ext"
                );
                $house->photos()->attach($photo);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        Storage::deleteDirectory("public/houses/$id");
        $house = House::findOrFail($id);
        $house->prices()->delete();
        $house->photos()->delete();
        $house->delete();
    }
}
