<?php

namespace App\Http\Controllers;

use App\Http\Requests\MailRequest;
use App\Http\Requests\OrderRequest;
use App\Http\Requests\SearchRequest;
use App\Models\Basket;
use App\Models\Favorite;
use App\Models\MailSubcribes;
use App\Models\Order;
use App\Models\Page;
use App\Models\Product;
use App\Models\ProductCategory;
use App\Models\ProductCategoryPivot;
use App\Models\Search;
use App\Models\ShopCart;
use App\Models\Slider;
use Carbon\Carbon;
use CyrildeWit\EloquentViewable\Support\Period;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;
use Artesaos\SEOTools\Facades\SEOTools;

class HomeController extends Controller
{

    public function index()
    {
        SEOTools::setTitle(config('app.name').' | Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::jsonLd()->addImage('/frontend/images/'.config('app.tema'));

        $Slider = Slider::with('getProduct')->where('status', 1)->get();
        return view(config('app.tema').'/frontend.index', compact('Slider'));
    }
    public function urun($url){

        $Detay = Product::with(['getCategory','getComment'])->withCount('getComment')
            ->where('slug', $url)
            ->firstOrFail();

        foreach ($Detay->getCategory as $item){
            $cat[] = $item->category_id;
        }

        $Category = ProductCategory::select('title', 'slug', 'id','desc', 'parent_id')
            ->whereIn('id',$cat)
            ->get();

        SEOTools::setTitle($Detay->title.' | Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::setDescription($Detay->seo_desc);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(route('urun', $Detay->slug));
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::jsonLd()->addImage($Detay->getFirstMediaUrl('page','thumb'));

        views($Detay)->cooldown(60)->record();
        $Count = views($Detay)->unique()->period(Period::create(Carbon::today()))->count();

        $Productssss = Product::with('getCategory')->where('status', 1)
                ->whereHas('getCategory', function ($query) use ($Detay, $cat){
                    $query->whereIn('category_id',$cat)->whereNotIn('product_id',[$Detay->id]);
                })
                ->orderBy('rank','ASC')
                ->get();

        $Pivot = ProductCategoryPivot::with('productCategory')->get();
        $Province = DB::table('sehir')->get();
       Cart::instance('lastLook')->add(
            [
                'id' => $Detay->id,
                'name' => $Detay->title,
                'price' => $Detay->price,
                'weight' => 0,
                'qty' => 1,
                'options' => [
                    'image' => (!$Detay->getFirstMediaUrl('page')) ? '/resimyok.jpg' : $Detay->getFirstMediaUrl('page', 'small'),
                    'cargo' => 0,
                    'campagin' => null,
                    'url' => url()->full()
                ]
            ]);
        if($Detay->offer == 1){
            $Stock = DB::table('campagin_stock')->where('product_id', 1)->first();
            return view(config('app.tema').'/frontend.product.offer', compact('Detay','Count', 'Productssss', 'Pivot', 'Category', 'Province','Stock'));
        }
        return view(config('app.tema').'/frontend.product.index', compact('Detay','Count', 'Productssss', 'Pivot', 'Category', 'Province'));
    }
    public function kategori($url){
        $Detay = ProductCategory::where('id', \request('id'))->select('id','title','slug')->first();
        SEOTools::setTitle($Detay->title.' | Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::setDescription($Detay->seo_desc);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(route('urun', $Detay->slug));
        SEOTools::opengraph()->addProperty('type', 'category');
        SEOTools::jsonLd()->addImage($Detay->getFirstMediaUrl('page','thumb'));

        $coksatan = request('coksatan')  ? request('coksatan') : 0;
        $fiyat = request('fiyat')  ? request('fiyat') : 'desc';
        $indirim = request('indirim')  ? request('indirim') : 0;

        if(request()->filled('fiyat')){
            $ProductList = Product::with(['getCategory'])
                ->join('product_category_pivots', 'product_category_pivots.product_id', '=', 'products.id' )
                ->join('product_categories', 'product_categories.id', '=', 'product_category_pivots.category_id')
                ->where('product_category_pivots.category_id',  $Detay->id)
                ->where('products.status', 1)
                ->select('products.id','products.title','products.rank','products.slug','products.price','products.old_price','products.slug', 'products.sku')
                ->orderBy("price", $fiyat )
                ->paginate(18);
            return view(config('app.tema').'/frontend.category.index', compact('Detay', 'ProductList'));
        }

        $ProductList = Product::with(['getCategory'])
            ->join('product_category_pivots', 'product_category_pivots.product_id', '=', 'products.id' )
            ->join('product_categories', 'product_categories.id', '=', 'product_category_pivots.category_id')
            ->where('product_category_pivots.category_id',  $Detay->id)
            ->where('products.status', 1)
            ->where(['category_id' => $Detay->id])
            ->select('products.id','products.title','products.rank','products.slug','products.price','products.old_price','products.slug','products.sku','product_category_pivots.category_id', 'product_categories.parent_id')
            ->orderBy('products.sku','asc')
            ->paginate(100);

        return view(config('app.tema').'/frontend.category.index', compact('Detay', 'ProductList'));
    }
    public function sepet(){
        SEOTools::setTitle("Sepetim | ". config('app.name'));
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi |  Sepetim Sayfası');

        if (Cart::instance('shopping')->content()->count() === 0){
            return redirect()->route('home');
        }

        $Province = DB::table('sehir')->get();

        return view(config('app.tema').'/frontend.shop.sepet',compact('Province'));
    }
    public function siparis(){
        $Province = DB::table('sehir')->get();
        return view(config('app.tema').'/frontend.shop.siparis',compact('Province'));
    }
    public function kaydet(OrderRequest $request){

        $p = Product::find($request->id);
        if ($request->kampanya == 1){

            Cart::instance('shopping')->destroy();

            Cart::instance('shopping')->add(
                [
                    'id' => $p->id,
                    'name' => $p->title,
                    'price' => $p->price,
                    'weight' => 0,
                    'qty' => 1,
                    'options' => [
                        'image' => (!$p->getFirstMediaUrl('page')) ? '/resimyok.jpg' : $p->getFirstMediaUrl('page', 'small'),
                        'cargo' => 0,
                        'dcs' => $p->shortname,
                        'campagin' => 0,
                    ]
                ]);
        }
        $Cart_Id = time();
        DB::transaction(function () use ($request, $Cart_Id) {

            if($request->medium){
                $medium = config('app.tema').' '.$request->medium;
            }else{
                $medium = config('app.tema').' '.config('app.tema').'.com';
            }

            $ShopCart                   = new ShopCart;
            $ShopCart->cart_id          = $Cart_Id ;
            $ShopCart->user_id          = $Cart_Id ;
            $ShopCart->basket_total     = cargoToplam(Cart::total());

            $ShopCart->name             = $request->name;
            $ShopCart->surname          = $request->surname;
            $ShopCart->email            = $request->email;
            $ShopCart->phone            = $request->phone;
            $ShopCart->address          = $request->address;
            $ShopCart->city             = $request->province;
            $ShopCart->province         = $request->city;
            $ShopCart->note             = $request->note;
            $ShopCart->order_medium     = $medium;
            $ShopCart->order_cargo      = (Cart::total() < CARGO_LIMIT) ? CARGO_PRICE : null;

            $details = [];
            foreach (Cart::instance('shopping')->content() as $c) {
                $details[] = 'Ürün : '.$c->options->dcs.' x '. $c->qty;
            }

            $ShopCart->order_details    = implode(',', $details);

            $ShopCart->save();

            foreach (Cart::instance('shopping')->content() as $c) {
                $Order                  = new Order;
                $Order->cart_id         = $Cart_Id;
                $Order->product_id      = $c->id;
                $Order->name            = $c->name;
                $Order->qty             = $c->qty;
                $Order->price           = $c->price;
                $Order->save();
            }

            $Cart = Cart::instance('shopping')->content();

      /*      Mail::send("frontend.mail.siparis",compact('Cart', 'ShopCart'),function ($message) use($ShopCart) {
                $message->to(MAIL_SEND)->subject($ShopCart->name.' '. $ShopCart->surname.' siparişiniz başarıyla oluşturmuştur.');
            });*/

            $Sms = 'Siparişiniz başarıyla oluşturulmuştur. Sipariş onayı için '.config('settings.telefon2').' nolu telefondan aranacaksınız. Hayırlı günler dileriz.';

            $curl = curl_init();
            curl_setopt_array($curl, array(
                CURLOPT_URL => 'http://panel.nac.com.tr/api/json/syncreply/SendInstantSms',
                CURLOPT_RETURNTRANSFER => true,
                CURLOPT_ENCODING => '',
                CURLOPT_MAXREDIRS => 10,
                CURLOPT_TIMEOUT => 5,
                CURLOPT_FOLLOWLOCATION => true,
                CURLOPT_HTTP_VERSION => CURL_HTTP_VERSION_1_1,
                CURLOPT_CUSTOMREQUEST => 'POST',
                CURLOPT_POSTFIELDS =>'{
                    "Credential": {
                        "Username":'.env("SMS_USER_NAME").',
                        "Password":'.env("SMS_PASSWORD").',
                        "ResellerID":'.env("SMS_RESELLER_ID").'
                    },
                    "Sms": {
                        "ToMsisdns":
                        [
                            {
                                "Msisdn": '.$ShopCart->phone.',
                                "Name": "",
                                "Surname": "",
                                "CustomField1": "[Mesaj1]:'.$Sms.'"
                            }
                        ],
                        "ToGroups":
                            [
                                0
                            ],
                        "IsCreateFromTeplate": true,
                        "SmsTitle": '.env("SMS_SENDER_NO").',
                        "SmsContent": "[Mesaj1]",
                        "SmsSendingType": "ByNumber",
                        "SmsCoding": "SmsCoding",
                        "SenderName": '.env("SMS_SENDER_NO").',
                        "DataCoding": "Default"
                    }
				}',
                CURLOPT_HTTPHEADER => array(
                    'Content-Type: application/json'
                ),
            ));
            $response = curl_exec($curl);
            curl_close($curl);

            $Stock = DB::table('campagin_stock')->decrement('stock');
            $StockUpdate = DB::table('campagin_stock')->where('stock', '<=', 10)->update(['stock' => 30]);
            Cart::instance('shopping')->destroy();

        });

        return redirect()->route('sonuc',['no'=>$Cart_Id]);
    }
    public function sonuc()
    {
        SEOTools::setTitle(config('app.name').' | Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::jsonLd()->addImage('/frontend/images/'.config('app.tema'));

        $Summary  = Order::where('cart_id',request('no') )->get();
        $Customer = ShopCart::where('cart_id',request('no'))->firstOrFail();

        return view(config('app.tema').'/frontend.shop.sonuc', compact('Customer', 'Summary'));
    }
    public function cartdelete($rowId){
        Cart::instance('shopping')->remove($rowId);
        alert()->info('Sepetinizdeki ürün çıkarıldı', 'Başarıyla '.SWEETALERT_MESSAGE_DELETE);
        return redirect()->route('sepet');
    }
    public function cartdestroy(){
        Cart::instance('shopping')->destroy();
        alert()->info('Sepetinizdeki tüm ürünler çıkarıldı', 'Başarıyla '.SWEETALERT_MESSAGE_DELETE);
        return redirect()->route('home');
    }
    public function search(SearchRequest $request){

        SEOTools::setTitle($request->q." ile ilgili arama sonuçları | ".config('app.name'));
        SEOTools::setDescription(config('app.name').' Kıblegah Aile Oyunları Online Satış Sitesi');
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(url()->current());
        SEOTools::opengraph()->addProperty('type', 'product');
        SEOTools::jsonLd()->addImage('/frontend/images/'.config('app.tema'));

        $search = $request->q;
        $Result  = Product::where('title','like','%'.$search.'%')
            ->orWhere('slug','like','%'.$search.'%')
            ->orWhere('sku','like', $search.'%')
            ->select('id', 'title', 'price', 'old_price', 'slug','bestselling','status')
            ->paginate(12);
        Search::create(['key' => $search]);
        return view(config('app.tema').'/frontend.shop.search', compact('Result'));

    }
    public function addtocart(Request $request)
    {

        $p = Product::find($request->id);
        Basket::create(['product_id' => $p->id, 'basket_name' => 'Sepet']);

        Cart::instance('shopping')->add(
            [
                'id' => $p->id,
                'name' => $p->title,
                'price' => $p->price,
                'weight' => 0,
                'qty' => 1,
                'options' => [
                    'image' => (!$p->getFirstMediaUrl('page')) ? '/resimyok.jpg' : $p->getFirstMediaUrl('page', 'small'),
                    'cargo' => 0,
                    'campagin' => null,
                    'dcs' => $p->shortname,
                    'url' => $p->slug
                ]
            ]);
        alert()->success($p->title.' sepetinize eklendi', 'Başarıyla '.SWEETALERT_MESSAGE_CREATE);
        //alert()->image('Image Title!','Image Description','Image URL','Image Width','Image Height','Image Alt');

        return redirect()->route('sepet');
    }
    public function hizlisatinal(Request $request){

        Cart::instance('shopping')->destroy();

        $p = Product::find($request->id);
        Basket::create(['product_id' => $p->id, 'basket_name' => 'Hizli Satın Al']);
        Cart::instance('shopping')->add(
            [
                'id' => $p->id,
                'name' => $p->title,
                'price' => $p->price,
                'weight' => 0,
                'qty' => 1,
                'options' => [
                    'image' => (!$p->getFirstMediaUrl('page')) ? '/resimyok.jpg' : $p->getFirstMediaUrl('page', 'small'),
                    'cargo' => 0,
                    'campagin' => null,
                    'dcs' => $p->shortname,
                    'url' => $p->slug
                ]
            ]);

        toast(SWEETALERT_MESSAGE_CREATE,'success');
        return redirect()->route('siparis');

    }
    public function favoriekle(Request $request){
        $p = Product::find($request->id);
        $New = Favorite::updateOrCreate(['user_id' => auth()->user()->id, 'product_id' => $p->id]);
        alert()->success($p->title.' favorilerinize eklendi', 'Başarıyla '.SWEETALERT_MESSAGE_CREATE);
        return redirect()->route('favori');
    }
    public function favori(){
        SEOTools::setTitle('Favori Listem | '. config('app.name'));
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi');

        $Favorite = Favorite::select('product_id')->where('user_id', auth()->user()->id)->get()->toArray();
        $FavoriteBooks = Product::select('id', 'title', 'price', 'old_price', 'slug','bestselling','status')
        ->whereIn('id', $Favorite)->get();
        return view(config('app.tema').'/frontend.shop.favori', compact('Favorite', 'FavoriteBooks'));
    }
    public function favoricikar($id){
        $Delete = Favorite::where('product_id',$id)->where('user_id', auth()->user()->id)->delete();
        toast(SWEETALERT_MESSAGE_DELETE,'success');
        return redirect()->route('favori');

    }
    public function mailsubcribes(MailRequest $request){
        MailSubcribes::create(['email_address' => $request->email, 'ip_address' => $request->ip()]);
        toast('Email Adresiz Bülten Listesine Eklendi','success');
        return redirect()->route('home');
    }
    public function kurumsal($url){

        $Detay = Page::where('slug', $url)->firstOrFail();

        SEOTools::setTitle($Detay->title);
        SEOTools::setDescription($Detay->seo_desc);
        SEOTools::opengraph()->setUrl(url()->current());
        SEOTools::setCanonical(route('urun', $Detay->slug));
        SEOTools::opengraph()->addProperty('type', 'page');
        SEOTools::jsonLd()->addImage($Detay->getFirstMediaUrl('page','thumb'));

        return view(config('app.tema').'/frontend.page.index', compact('Detay'));
    }
    public function iletisim(){

        SEOTools::setTitle("İletişim | ". config('app.name'));
        SEOTools::setDescription(config('app.name').' | İletişim Sayfası');

        return view(config('app.tema').'/frontend.page.contactus');
    }
    public function kargosorgulama(){

        SEOTools::setTitle('Kargo Soruglama | '. config('app.name'));
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi');

        return view(config('app.tema').'/frontend.page.cargo');
    }

    public function gununfirsati(){

        SEOTools::setTitle('Günün Fırsatı | '. config('app.name'));
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi');

        return view(config('app.tema').'/frontend.shop.gununfirsati');
    }

    public function profilim(){

        SEOTools::setTitle('Profilim | '. config('app.name'));
        SEOTools::setDescription('Kıblegah Aile Oyunları Online Satış Sitesi');

        if (auth()->user()->is_admin == 1){
            return redirect()->route('go');
        }
        $Favorite = Favorite::select('product_id')->where('user_id', auth()->user()->id)->get()->toArray();
        $FavoriteBooks = Product::select('id', 'title', 'price', 'old_price', 'slug','bestselling','status')
            ->whereIn('id', $Favorite)->get();

        return view(config('app.tema').'/frontend.dashboard.index', compact('FavoriteBooks'));
    }
}
