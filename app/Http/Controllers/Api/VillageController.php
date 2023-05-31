<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Filters\VillageFilter;
use App\Http\Requests\Villages\{FilterRequest, StoreRequest, UpdateRequest};
use App\Http\Resources\VillageResource;
use App\Models\{Photo, Presentation, Village};
use Illuminate\Support\Facades\{App, Storage};
use Illuminate\Support\Str;

class VillageController extends Controller
{
    /**
     * Display a filtered listing of the resource.
     *
     * @return \Illuminate\Http\Resources\Json\AnonymousResourceCollection
     */
    public function filter(FilterRequest $request)
    {
        $filter = App::make(VillageFilter::class, ['queryParams' => array_filter($request->validated())]);
        $villages = Village::filter($filter);
        if ($request->order_by && $request->order_dir) {
            $villages = $villages->orderBy($request->order_by, $request->order_dir);
        }
        $villages = $villages->paginate(5, ['*'], 'page', $request->page);

        return VillageResource::collection($villages);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return void
     */
    public function store(StoreRequest $request)
    {
        $village = Village::create($request->validated());

        $request_photo = $request->file('photo');
        if ($request_photo) {
            $original_file_name = $request_photo->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_photo->getClientOriginalExtension();

            $photo = Photo::create(['path' => "storage/villages/$village->id/$filename.$ext"]);
            $request_photo->storeAs("public/villages/$village->id", "$filename.$ext");
            $village->photo_id = $photo->id;
        }

        $request_presentation = $request->file('presentation');
        if ($request_presentation) {
            $encoded_name = Str::slug($request_presentation->getClientOriginalName());
            $presentation = Presentation::create(['path' => 'storage/villages/'.$village->id.'/'.$encoded_name]);
            $request_presentation->storeAs('public/villages/'.$village->id, $encoded_name);

            $village->presentation_id = $presentation->id;
        }
        $village->save();
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return VillageResource
     */
    public function show(int $id)
    {
        return VillageResource::make(Village::find($id));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return VillageResource
     */
    public function edit(int $id)
    {
        return VillageResource::make(Village::find($id));
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
        $village = Village::findOrFail($id);
        $village->update($request->validated());
        $request_photo = $request->file('photo');
        if ($request_photo) {
            if ($village->photo) {
                $village->photo->delete();
            }
            $original_file_name = $request_photo->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_photo->getClientOriginalExtension();

            $photo = Photo::create(['path' => "storage/villages/$village->id/$filename.$ext"]);
            $request_photo->storeAs("public/villages/$village->id", "$filename.$ext");
            $village->photo_id = $photo->id;
        }

        $request_presentation = $request->file('presentation');
        if ($request_presentation) {
            if ($village->presentation) {
                $village->presentation->delete();
            }
            $original_file_name = $request_presentation->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_presentation->getClientOriginalExtension();

            $presentation = Presentation::create(['path' => "storage/villages/$village->id/$filename.$ext"]);
            $request_presentation->storeAs("public/villages/$village->id", "$filename.$ext");
            $village->presentation_id = $presentation->id;
        }

        $village->save();
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse|void
     */
    public function destroy(int $id)
    {
        Storage::deleteDirectory("public/villages/$id");
        $village = Village::findOrFail($id);
        if (count($village->houses)) {
            return response()->json(['error' => 'К данному посёлку привязаны дома. Пожалуйста, сначала удалите их.']);
        }

        $village->delete();
    }
}
