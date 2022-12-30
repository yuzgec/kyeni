<?php

namespace App\Http\Controllers;

use App\Models\Background;
use Illuminate\Http\Request;

class BackgroundController extends Controller
{
    public function index()
    {
        $All = Background::all();
        return view('backend.background.index');
    }

    public function create()
    {
        return view('backend.background.create');
    }


    public function store(Request $request)
    {
        $New = new Background;
        $New->title = $request->title;

        if($request->hasfile('image')){
            $New->addMedia($request->image)->toMediaCollection('page');
        }

        $New->save();

        toast(SWEETALERT_MESSAGE_CREATE,'success');
        return redirect()->route('background.index');
    }

    public function show($id)
    {
        $Show = Background::findOrFail($id);
        return view('frontend.background.index', compact('Show'));
    }

    public function edit($id)
    {
        $Edit = Background::findOrFail($id);
        return view('backend.background.edit', compact('Edit'));
    }

    public function update(Request $request, $id)
    {

        $Update = Background::findOrFail($id);
        $Update->title = $request->title;

        if ($request->hasFile('image')) {
            $Update->media()->where('collection_name', 'page')->delete();
            $Update->addMedia($request->image)->toMediaCollection('page');
        }

        $Update->save();

        toast(SWEETALERT_MESSAGE_UPDATE,'success');
        return redirect()->route('background.index');

    }

    public function destroy($id)
    {
        $Delete = Background::findOrFail($id);
        $Delete->delete();

        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('background.index');
    }

    public function getSwitch(Request $request){
        $update=Background::findOrFail($request->id);
        $update->status = $request->status == "true" ? 1 : 0 ;
        $update->save();
    }

    public function deleteGaleriDelete($id){

        $Delete = Background::find($id);
        $Delete->media()->where('id', \request('image_id'))->delete();

        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('background.edit', $id);

    }
}
