<?php

namespace App\Http\Controllers;

use App\Http\Requests\ProductRequest;
use App\Models\Author;
use App\Models\AuthorPivot;
use App\Models\Language;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryPivot;
use App\Models\Publisher;
use App\Models\Translator;
use App\Models\Years;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;


class ProductController extends Controller
{
    public function index()
    {
        if (request()->filled('q')){
            $All = Product::where('title', 'like', '%'. request('q'). '%')
                ->orWhere('slug', 'like', '%'. request('q'). '%')
                ->orderBy('rank')
                ->paginate(75);
        }else{
            $All = Product::orderBy('rank','asc')->paginate(100);
        }
        return view('backend.product.index', compact('All'));
    }

    public function create()
    {
        $Kategori = ProductCategory::get()->toFlatTree();
        return view('backend.product.create',compact('Kategori' ));
    }

    public function store(ProductRequest $request)
    {

        DB::transaction(function () use ($request){
            $New = new Product;
            $New->title = $request->title;
            $New->shortname = $request->shortname;

            $New->price = $request->price;
            $New->old_price = $request->old_price;
            $New->campagin_price = $request->campagin_price;
            $New->sku = $request->sku;
            $New->external = $request->external;

            $New->short = $request->short;
            $New->note = $request->note;
            $New->cargo = $request->cargo;
            $New->featrues = $request->featrues;
            $New->desc = $request->desc;

            $New->freecargo = $request->freecargo;
            $New->fastkargo = $request->fastkargo;
            $New->bigopportunity = $request->bigopportunity;

            $New->opportunity = $request->opportunity;
            $New->offer = $request->offer;
            $New->bestselling = $request->bestselling;

            $New->option1 = $request->option1;
            $New->option2 = $request->option2;
            $New->option3 = $request->option3;
            $New->option4 = $request->option4;

            $New->seo_desc = $request->seo_desc;
            $New->seo_key = $request->seo_key;
            $New->seo_title = $request->seo_title;


            if ($request->hasfile('image')) {
                $New->addMedia($request->image)->toMediaCollection('page');
            }

            if ($request->hasfile('gallery')) {
                foreach ($request->gallery as $item) {
                    $New->addMedia($item)->toMediaCollection('gallery');
                }
            }

            $New->save();

            if ($request->input('category')) {
                foreach ($request->input('category') as $pc) {
                    ProductCategoryPivot::updateOrCreate(['category_id' => $pc, 'product_id' => $New->id]);
                }
            }

            if ($request->input('category')) {
                $kategoriler = ProductCategory::whereIn('id', $request->input('category'))->get();
                foreach ($kategoriler as $item) {
                    $kategori[] = $item->slug;
                }
            }

        });
        toast(SWEETALERT_MESSAGE_CREATE,'success');
        return redirect()->route('product.index');

    }

    public function show($id)
    {

    }

    public function edit($id)
    {
        $Edit = Product::with(['getCategory'])->find($id);
        $Pivot = ProductCategoryPivot::where(['product_id'=> $id])->get();

        return view('backend.product.edit', compact('Edit','Pivot'));
    }

    public function update(ProductRequest $request, $id)
    {
        //dd($request->all());
        DB::transaction(function () use ($request, $id) {

            $Update = Product::findOrFail($id);
            $Update->title = $request->title;
            $Update->shortname = $request->shortname;
            $Update->external = $request->external;

            $Update->price = $request->price;
            $Update->old_price = $request->old_price;
            $Update->campagin_price = $request->campagin_price;
            $Update->sku = $request->sku;

            $Update->short = $request->short;
            $Update->note = $request->note;
            $Update->cargo = $request->cargo;
            $Update->featrues = $request->featrues;
            $Update->desc = $request->desc;

            $Update->opportunity = $request->opportunity;
            $Update->offer = $request->offer;
            $Update->bestselling = $request->bestselling;

            $Update->freecargo = $request->freecargo;
            $Update->fastkargo = $request->fastkargo;
            $Update->bigopportunity = $request->bigopportunity;

            $Update->option1 = $request->option1;
            $Update->option2 = $request->option2;
            $Update->option3 = $request->option3;
            $Update->option4 = $request->option4;

            $Update->seo_desc = $request->seo_desc;
            $Update->seo_key = $request->seo_key;
            $Update->seo_title = $request->seo_title;


            if ($request->removeImage == "1") {
                $Update->clearMediaCollection('page');
            }

            if ($request->hasFile('image')) {
                $Update->clearMediaCollection('page');
                $Update->addMedia($request->image)->toMediaCollection('page');
            }

            if ($request->hasfile('gallery')) {
                foreach ($request->gallery as $item) {
                    $Update->addMedia($item)->toMediaCollection('gallery');
                }
            }

            $Update->save();

            if ($request->input('category')) {
                foreach ($request->input('category') as $pc) {
                    ProductCategoryPivot::where(['product_id' => $Update->id])->delete();
                }
                foreach ($request->input('category') as $pc) {
                    ProductCategoryPivot::updateOrCreate(['category_id' => $pc, 'product_id' => $Update->id]);
                }
            }

            if ($request->input('category')) {
                $kategoriler = ProductCategory::whereIn('id', $request->input('category'))->get();
                foreach ($kategoriler as $item) {
                    $kategori[] = $item->slug;
                }
            }
        });

        toast(SWEETALERT_MESSAGE_UPDATE,'success');
        return redirect()->route('product.index');

    }

    public function destroy($id)
    {
        $Delete = Product::findOrFail($id);
        $Delete->delete();
        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('product.index');
    }

    public function getTrash(){
        $Trash = Product::onlyTrashed()->orderBy('deleted_at','desc')->get();
        return view('backend.product.trash', compact('Trash'));
    }

    public function getOrder(Request $request){
        foreach($request->get('page') as  $key => $rank ){
            Product::where('id',$rank)->update(['rank'=>$key]);
        }
    }

    public function getSwitch(Request $request){
        $status = ($request->status == "true") ? 1 : 0;
        Product::where('id', $request->id)->update(['status' => $status]);
    }

    public function postUpload(Request $request)
    {

        if($request->hasFile('upload')) {
            $filenamewithextension = $request->file('upload')->getClientOriginalName();
            $filename = pathinfo($filenamewithextension, PATHINFO_FILENAME);
            $extension = $request->file('upload')->getClientOriginalExtension();
            $filenametostore = seo($filename).'_'.time().'.'.$extension;
            $request->file('upload')->storeAs('public/uploads', $filenametostore);
            $CKEditorFuncNum = $request->input('CKEditorFuncNum');
            $url = asset('storage/uploads/'.$filenametostore);
            $msg = 'Resim Yüklendi';
            $re = "<script>window.parent.CKEDITOR.tools.callFunction($CKEditorFuncNum, '$url', '$msg')</script>";
            @header('Content-type: text/html; charset=utf-8');
            echo $re;
        }
    }

    public function deleteGaleriDelete($id){

        $Delete = Product::find($id);
        $Delete->media()->where('id', \request('image_id'))->delete();

        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('product.edit', $id);
    }

}
