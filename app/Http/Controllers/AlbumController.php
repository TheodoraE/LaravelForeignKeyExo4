<?php

namespace App\Http\Controllers;

use App\Models\Album;
use App\Models\Photo;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Storage;

class AlbumController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        //
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return \Illuminate\Http\Response
     */
    public function store(Request $request)
    {
        $store = new Photo;
        $store->url = $request->file('url')->hashName();
        Storage::put('public/img', $request->file('url'));
        $store->save();

        $store1 = new Album;
        $store1->name = $request->name;
        $store1->author = $request->author;
        $store1->photo_id = $store->id;
        $store1->save();

        return redirect()->back();
    }

    /**
     * Display the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function show(Album $album)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        $edit = Photo::find($id);
        return view('pages.edit', compact('edit'));
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        $update = Photo::find($id);
        Storage::delete('public/img/'.$update->url);
        $update->url = $request->file('url')->hashName();
        Storage::put('public/img', $request->file('url'));
        $update->save();

        return redirect('/');
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  \App\Models\Album  $album
     * @return \Illuminate\Http\Response
     */
    public function destroy($id)
    {
        $destroy = Album::find($id);
        $destroy1 = Photo::find($id);
        Storage::delete('public/img/'.$destroy1->url);
        $destroy->delete();
        $destroy1->delete();
        return redirect('/');
    }
}
