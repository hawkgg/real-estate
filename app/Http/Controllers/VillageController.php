<?php

namespace App\Http\Controllers;

use App\Http\Requests\Villages\StoreRequest;
use App\Http\Requests\Villages\UpdateRequest;
use App\Models\Photo;
use App\Models\Presentation;
use App\Models\Village;
use Illuminate\Contracts\View\View;
use Illuminate\Http\RedirectResponse;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function index(Request $request)
    {
        $villages = Village::query();
        $sort_param = $request->get('sort_param');
        $sort_direction = $request->get('sort_direction');
        if ($sort_param) {
            $request->get('order');
            $villages = $villages->orderBy($sort_param, $sort_direction);
        }
        $query = $request->get('q');
        if ($query) {
            $villages = $villages->where('name', 'like', '%'.$query.'%');
        }

        $villages = $villages->paginate(5);

        return view('villages.index', compact('villages'))
            ->with('i', (request()->input('page', 1) - 1) * 5);
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Contracts\View\View
     */
    public function create()
    {
        return view('villages.create');
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return RedirectResponse
     */
    public function store(StoreRequest $request)
    {
        $village = Village::create($request->validated());

        $request_photo = $request->file('photo');
        if ($request_photo) {
            $original_file_name = $request_photo->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_photo->getClientOriginalExtension();
            $photo = Photo::create([
                'path' => "storage/villages/$village->id/$filename.$ext"
            ]);
            $request_photo->storeAs(
                "public/villages/$village->id", "$filename.$ext"
            );

            $village->photo_id = $photo->id;
        }

        $request_presentation = $request->file('presentation');
        if ($request_presentation) {
            $encoded_name = Str::slug($request_presentation->getClientOriginalName());
            $presentation = Presentation::create([
                'path' => 'storage/villages/'.$village->id.'/'.$encoded_name
            ]);
            $request_presentation->storeAs(
                'public/villages/'.$village->id, $encoded_name
            );

            $village->presentation_id = $presentation->id;
        }
        $village->save();

        return redirect()->route('villages.index')
            ->with('success', 'Посёлок успешно добавлен.');
    }

    /**
     * Display the specified resource.
     *
     * @param int $village_id
     * @return Response
     */
    public function show(int $village_id)
    {
        $village = Village::findOrFail($village_id);
        return view('villages.show', compact('village'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param int $village_id
     * @return View
     */
    public function edit(int $village_id)
    {
        $village = Village::findOrFail($village_id);
        return view('villages.edit', compact('village'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param UpdateRequest $request
     * @param int $village_id
     * @return \Illuminate\Http\RedirectResponse
     */
    public function update(UpdateRequest $request, int $village_id)
    {
        $village = Village::findOrFail($village_id);
        $village->update($request->validated());
        $request_photo = $request->file('photo');
        if ($request_photo) {
            $village->photo->delete();
            $original_file_name = $request_photo->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_photo->getClientOriginalExtension();
            $photo = Photo::create([
                'path' => "storage/villages/$village->id/$filename.$ext"
            ]);
            $request_photo->storeAs(
                "public/villages/$village->id", "$filename.$ext"
            );

            $village->photo_id = $photo->id;
        }

        $request_presentation = $request->file('presentation');
        if ($request_presentation) {
            $original_file_name = $request_presentation->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_photo->getClientOriginalExtension();
            $presentation = Presentation::create([
                'path' => "storage/villages/$village->id/$filename.$ext"
            ]);
            $request_presentation->storeAs(
                "public/villages/$village->id", "$filename.$ext"
            );

            $village->presentation_id = $presentation->id;
        }

        $village->save();


        return redirect()->route('villages.index')
            ->with('success', 'Посёлок успешно обновлён.');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param int $village_id
     * @return RedirectResponse
     */
    public function destroy(int $village_id)
    {
        Storage::deleteDirectory("public/villages/$village_id");
        $village = Village::findOrFail($village_id);
        if (count($village->houses)) {
            return back()->with(['error' => 'К данному посёлку привязаны дома. Пожалуйста, сначала удалите их.']);
        }

        $village->delete();

        return redirect()->route('villages.index')
            ->with('success', 'Посёлок успешно удалён.');
    }
}
