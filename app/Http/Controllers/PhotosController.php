<?php

namespace App\Http\Controllers;

use App\Album;
use App\Http\Requests\PhotoRequest;
use App\Photo;
use App\User;
use Illuminate\Support\Facades\Storage;

class PhotosController extends Controller
{
    public function create(Album $album)
    {
        $this->authorize('create', Photo::class);
        return view('photos.create', compact('album'));
    }


    public function store(PhotoRequest $request)
    {
        $user = Auth()->user();
        $this->authorize('create', Photo::class);
        $filenameWithExtension = $request->file('photo')->getClientOriginalName();
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('photo')->getClientOriginalExtension();
        $filetoStore = $filename . "_" . time() . "." . $extension;
$album_id = $request->input('album_id');
        $request->file('photo')->storeAs("uploads/$user->id/albums/$album_id", $filetoStore);


        $photo = new Photo($request->all());
        $photo->user_id = $user->id;
        $photo->album_id = $album_id;
        $photo->photo = $filetoStore;
        $photo->size = $request->file('photo')->getSize();
        $photo->save();

        return redirect("albums/$album_id")->with('success', 'Photo uploaded successfully!');
    }

    public function show(Photo $photo)
    {
//        dd($photo);
        $this->authorize('view', $photo);
        $photos = Photo::findOrFail($photo->id);

        return view('photos.show', ['photo' => $photos]);
    }

    public function destroy(Photo $photo)
    {
        $user = Auth()->user();
        $this->authorize('delete', $photo);
//        var_dump($photo->getPhoto());
//        dd(Storage::url("uploads/$user->id/albums/" . $photo->album->id . "/". $photo->photo));
        if(Storage::delete("uploads/$user->id/albums/" . $photo->album->id . "/". $photo->photo)){
            $photo->delete();

            return redirect("albums/" . $photo->album->id )->with('success', "Photo deleted successfully!");
        }
    }
}
