<?php

namespace App\Http\Controllers;

use App\Http\Requests\Houses\StoreRequest;
use App\Http\Requests\Houses\UpdateRequest;
use App\Models\Currency;
use App\Models\EstateType;
use App\Models\Photo;
use App\Models\House;
use App\Models\Price;
use App\Models\Village;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class HouseController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $houses = House::query();
        $conditions = [];

        $query = $request->get('q');
        if ($query) {
            $conditions[] = ['name', 'like', '%'.$query.'%'];
        }

        $currency = $request->get('currency');
        if ($currency) {
            $conditions[] = ['name', 'like', '%'.$query.'%'];
        }

        $floors = $request->get('floors');
        if ($floors) {
            $conditions[] = ['floors',  $floors];
        }

        $bedrooms = $request->get('bedrooms');
        if ($bedrooms) {
            $conditions[] = ['bedrooms',  $bedrooms];
        }

        $square = $request->get('square');
        if ($square) {
            $conditions[] = ['square',  $square];
        }

        $estate_type = $request->get('estate_type');
        if ($estate_type) {
            $conditions[] = ['estate_type_id',  $estate_type];
        }

        $village = $request->get('village');
        if ($village) {
            $conditions[] = ['village_id',  $village];
        }

        $houses = $houses->where($conditions);


        $sort_param = $request->get('sort_param');
        $sort_direction = $request->get('sort_direction');
        if ($sort_param) {
            switch ($sort_param) {
                case 'estate_type':
                    $houses = $houses->join('estate_types', 'houses.estate_type_id', '=', 'estate_types.id')
                        ->orderBy('estate_types.name', $sort_direction)
                        ->select('houses.*');
                    break;
                case 'village':
                    $houses = $houses->join('villages', 'houses.village_id', '=', 'villages.id')
                        ->orderBy('villages.name', $sort_direction)
                        ->select('houses.*');
                    break;
                default:
                    $houses = $houses->orderBy($sort_param, $sort_direction);
            }
        }

        $houses = $houses->paginate(5);

        $villages = Village::all();
        $estate_types = EstateType::all();
        $currencies = Currency::all();

        return view('houses.index', compact('houses', 'villages', 'estate_types', 'currencies'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        $currencies = Currency::all();
        $estate_types = EstateType::all();
        $villages = Village::all();
        return view('houses.create', compact('currencies', 'estate_types', 'villages'));
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
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

        return redirect()->route('houses.index')
            ->with('success', 'Дом успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @int $house_id
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|View
     */
    public function show(int $house_id)
    {
        $house = House::findOrFail($house_id);
        return view('houses.show', compact('house'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $house_id
     * @return View
     */
    public function edit(int $house_id)
    {
        $house = House::findOrFail($house_id);
        $currencies = Currency::all();
        $estate_types = EstateType::all();
        $villages = Village::all();

        return view('houses.edit', compact('house', 'currencies', 'estate_types', 'villages'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $house_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $house_id)
    {
        $data = $request->validated();
        $house = House::findOrFail($house_id);
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

        return redirect()->route('houses.index')
            ->with('success', 'Дом успешно обновлён.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $house_id
     * @return RedirectResponse
     */
    public function destroy(int $house_id)
    {
        Storage::deleteDirectory("public/houses/$house_id");
        $house = House::findOrFail($house_id);
        $house->prices()->delete();
        $house->photos()->delete();
        $house->delete();


        return redirect()->route('houses.index')
            ->with('success', 'Дом успешно удалён.');
    }
}
