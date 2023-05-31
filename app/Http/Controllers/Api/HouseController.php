<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\HouseFilter;
use App\Http\Requests\Houses\{FilterRequest, StoreRequest, UpdateRequest};
use App\Http\Resources\{CurrencyResource, EstateTypeResource, HouseResource, VillageResource};
use App\Models\{Currency, EstateType, House, Photo, Price, Rate, Village};
use Illuminate\Support\Facades\{App, Storage};
use Illuminate\Support\Str;

class HouseController extends Controller
{
    public function getFilterAdditionalResources() {
        $villages = VillageResource::collection(Village::all());
        $estate_types = EstateTypeResource::collection(EstateType::all());
        $currencies = CurrencyResource::collection(Currency::all());
        $prices = [Price::min('val'), Price::max('val')];

        return compact('villages', 'estate_types', 'currencies', 'prices');
    }

    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function filter(FilterRequest $request) {
        $data = $request->validated();
        if (isset($data['price_min']) && isset($data['price_max'])) {
            $data['prices'] = [$data['price_min'], $data['price_max']];
            unset($data['price_min']); unset($data['price_max']);
        }
        $filter = App::make(HouseFilter::class, ['queryParams' => array_filter($data)]);
        $houses = House::filter($filter);

        if ($request->order_by && $request->order_dir) {
            if ($request->order_by === 'estate_type') {
                $houses = $houses->orderBy(EstateType::select('name')
                    ->whereColumn('estate_types.id', 'houses.estate_type_id'), $request->order_dir);
            } else if ($request->order_by === 'village') {
                $houses = $houses->orderBy(Village::select('name')
                    ->whereColumn('villages.id', 'houses.village_id'), $request->order_dir);
            } else if ($request->order_by === 'price') {
                $houses = $houses->orderBy(Price::select('val')
                    ->whereColumn('prices.house_id', 'houses.id')
                    ->whereColumn('prices.currency_id', 'houses.default_currency_id'), $request->order_dir);
            } else {
                $houses = $houses->orderBy($request->order_by, $request->order_dir);
            }
        }
        $houses = $houses->paginate(2, ['*'], 'page', $request->page);

        return HouseResource::collection($houses);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return array
     */
    public function create()
    {
        $currencies = CurrencyResource::collection(Currency::all());
        $estate_types = CurrencyResource::collection(EstateType::all());
        $villages = CurrencyResource::collection(Village::all());

        return compact('currencies', 'estate_types', 'villages');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return void
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

        $rates = Rate::all();
        $default_rate = $rates->where('currency_id', $house->default_currency->id)->first();
        foreach($rates as $rate) {
            if ($rate === $default_rate) continue;
            $price = Price::create([
                'val' => $rate->val / $default_rate->val * $house->default_price->val,
            ]);
            $price->currency()->associate($rate->currency);
            $price->house()->associate($house);
            $price->save();
        }

        $request_photos = $request->allFiles('photos');
        if (count($request_photos)) {
            foreach ($request_photos['photos'] as $request_photo) {
                $original_file_name = $request_photo->getClientOriginalName();
                $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
                $ext = $request_photo->getClientOriginalExtension();

                $photo = Photo::create(['path' => "storage/houses/$house->id/$filename.$ext"]);
                $request_photo->storeAs("public/houses/$house->id", "$filename.$ext");
                $house->photos()->attach($photo);
            }
        }
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return HouseResource
     */
    public function show(int $id)
    {
        return HouseResource::make(House::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return array
     */
    public function edit(int $id)
    {
        $house = HouseResource::make(House::find($id));
        $currencies = CurrencyResource::collection(Currency::all());
        $estate_types = CurrencyResource::collection(EstateType::all());
        $villages = CurrencyResource::collection(Village::all());

        return compact('house', 'currencies', 'estate_types', 'villages');
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $id
     * @return void
     */
    public function update(UpdateRequest $request, int $id)
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

        $rates = Rate::all();
        $default_rate = $rates->where('currency_id', $house->default_currency->id)->first();
        foreach($rates as $rate) {
            if ($rate === $default_rate) continue;
            $price = Price::create([
                'val' => $rate->val / $default_rate->val * $house->default_price->val,
            ]);
            $price->currency()->associate($rate->currency);
            $price->house()->associate($house);
            $price->save();
        }

        $request_photos = $request->allFiles('photos');
        if (count($request_photos)) {
            foreach($house->photos as $photo) {
                $photo->delete();
            }
            foreach ($request_photos['photos'] as $request_photo) {
                $original_file_name = $request_photo->getClientOriginalName();
                $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
                $ext = $request_photo->getClientOriginalExtension();

                $photo = Photo::create(['path' => "storage/houses/$house->id/$filename.$ext"]);
                $request_photo->storeAs("public/houses/$house->id", "$filename.$ext");
                $house->photos()->attach($photo);
            }
        }
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return void
     */
    public function destroy(int $id)
    {
        Storage::deleteDirectory("public/houses/$id");
        $house = House::findOrFail($id);
        $house->prices()->delete();
        $house->photos()->delete();
        $house->delete();
    }
}
