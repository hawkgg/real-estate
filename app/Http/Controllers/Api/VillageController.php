<?php

namespace App\Http\Controllers\Api;

use App\Http\Controllers\Controller;
use App\Http\Requests\Villages\StoreRequest;
use App\Http\Requests\Villages\UpdateRequest;
use App\Models\Photo;
use App\Models\Presentation;
use App\Models\Village;
use Illuminate\Http\Request;
use Illuminate\Http\Response;
use Illuminate\Support\Facades\Storage;
use Illuminate\Support\Str;

class VillageController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Database\Eloquent\Builder[]|\Illuminate\Database\Eloquent\Collection
     */
    public function index()
    {
        return Village::with('photo')->get();
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param StoreRequest $request
     * @return \Illuminate\Http\RedirectResponse
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
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function show(int $id)
    {
        return Village::with('photo')->find($id);
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Database\Eloquent\Collection|\Illuminate\Database\Eloquent\Model|null
     */
    public function edit(int $id)
    {
        return Village::with('photo')->find($id);
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
            if ($village->presentation) {
                $village->presentation->delete();
            }
            $original_file_name = $request_presentation->getClientOriginalName();
            $filename = Str::slug(pathinfo($original_file_name, PATHINFO_FILENAME));
            $ext = $request_presentation->getClientOriginalExtension();
            $presentation = Presentation::create([
                'path' => "storage/villages/$village->id/$filename.$ext"
            ]);
            $request_presentation->storeAs(
                "public/villages/$village->id", "$filename.$ext"
            );

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
    public function destroy($id)
    {
        Storage::deleteDirectory("public/villages/$id");
        $village = Village::findOrFail($id);
        if (count($village->houses)) {
            return response()->json(['error' => 'К данному посёлку привязаны дома. Пожалуйста, сначала удалите их.']);
        }

        $village->delete();
    }
}
