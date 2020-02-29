<?php

namespace App\Http\Controllers;

use App\Album;
use App\Http\Requests\AlbumRequest;
use App\User;
use Illuminate\Support\Facades\Storage;

class AlbumsController extends Controller
{
    public function index()
    {
        $this->authorize('viewAny', Album::class);
        $albums = Auth()->user()->albums;

        return view('albums.index', compact('albums'));
    }

    public function create(User $user)
    {
        $this->authorize('create', Album::class);
        return view('albums.create', compact('user'));
    }

    public function store(AlbumRequest $request)
    {
        $user = Auth()->user();
        $this->authorize('create', Album::class);
        $filenameWithExtension = $request->file('cover_image')->getClientOriginalName();
        $filename = pathinfo($filenameWithExtension, PATHINFO_FILENAME);
        $extension = $request->file('cover_image')->getClientOriginalExtension();
        $filetoStore = $filename . "_" . time() . "." . $extension;

        $request->file('cover_image')->storeAs("uploads/$user->id/album_covers/", $filetoStore);


        $album = new Album($request->all());
        $album->user_id = $user->id;
        $album->cover_image = $filetoStore;
        $album->save();

        return redirect('albums')->with('success', 'Album created successfully!');
    }

    public function show(Album $album)
    {
        $this->authorize('view', $album);
        $albums = Album::with('photos')->findOrFail($album->id);

        return view('albums.show', ['album' => $albums]);
    }

    public function destroy(Album $album)
    {
        $user = Auth()->user();
        $this->authorize('delete', $album);

        if (Storage::delete("uploads/$user->id/album_covers/" . $album->cover_image)) {
            $album->delete();
            return redirect("albums")->with('success', "Album deleted successfully!");
        }

    }
}
