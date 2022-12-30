@extends(config('app.tema').'/frontend.layout.app')
@section('content')

    <div class="container">
        <div class="row">
            <div class="mb-6 row border rounded-lg mx-0 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                <div class="media col px-6 px-xl-4 px-wd-8 flex-shrink-0 flex-xl-shrink-1 min-width-270-all border-left py-3">
                    <div class="u-avatar mr-2">
                        <i class="text-primary ec ec-transport font-size-46"></i>
                    </div>
                    <div class="media-body text-center">
                        <span class="d-block font-weight-bold text-dark">Ücretsiz </span>
                        <div class=" text-secondary">Kargo</div>
                    </div>
                </div>

                <div class="media col px-6 px-xl-4 px-wd-8 flex-shrink-0 flex-xl-shrink-1 min-width-270-all border-left py-3">
                    <div class="u-avatar mr-2">
                        <i class="text-primary ec ec-customers font-size-56"></i>
                    </div>
                    <div class="media-body text-center">
                        <span class="d-block font-weight-bold text-dark">100% </span>
                        <div class=" text-secondary">Menmuniyet</div>
                    </div>
                </div>

                <div class="media col px-6 px-xl-4 px-wd-8 flex-shrink-0 flex-xl-shrink-1 min-width-270-all border-left py-3">
                    <div class="u-avatar mr-2">
                        <i class="text-primary ec ec-payment font-size-46"></i>
                    </div>
                    <div class="media-body text-center">
                        <span class="d-block font-weight-bold text-dark">Kapıda</span>
                        <div class=" text-secondary">Ödeme </div>
                    </div>
                </div>

                <div class="media col px-6 px-xl-4 px-wd-8 flex-shrink-0 flex-xl-shrink-1 min-width-270-all border-left py-3">
                    <div class="u-avatar mr-2">
                        <i class="text-primary ec ec-tag font-size-46"></i>
                    </div>
                    <div class="media-body text-center">
                        <span class="d-block font-weight-bold text-dark">Seçkin</span>
                        <div class=" text-secondary">Markalar</div>
                    </div>
                </div>


            </div>
        </div>
    </div>
    <div class="container">

        <div class="position-relative z-index-2 u-slick__tab">
                <div class=" d-flex justify-content-between border-bottom border-color-1 flex-lg-nowrap flex-wrap border-md-down-top-0 border-md-down-bottom-0">
                    <h3 class="section-title section-title__full mb-0 pb-2 font-size-22">Kıbleâh Aile Oyunları</h3>

                    <ul class="w-100 w-lg-auto nav nav-pills nav-tab-pill nav-tab-pill-fill mb-2 pt-3 pt-lg-0 border-top border-color-1 border-lg-top-0 align-items-center font-size-15 font-size-15-lg flex-nowrap flex-lg-wrap overflow-auto overflow-lg-visble pr-0" id="pills-tab-3" role="tablist">
                        <li class="nav-item flex-shrink-0 flex-lg-shrink-1">
                            <a class="nav-link rounded-pill active" id="coksatilanlar-tab" data-toggle="pill"
                               href="#coksatilanlar" role="tab" aria-controls="coksatilanlar" aria-selected="true">Çok Satılanlar</a>
                        </li>
                        <li class="nav-item flex-shrink-0 flex-lg-shrink-1">
                            <a class="nav-link rounded-pill" id="trendurunler-tab" data-toggle="pill"
                               href="#trendurunler" role="tab" aria-controls="trendurunler" aria-selected="false">Trend Ürünler</a>
                        </li>
                    </ul>


                </div>

                <div class="tab-content" id="Bpills-tabContent">
                    <div class="tab-pane fade pt-2 show active" id="coksatilanlar" role="tabpanel" aria-labelledby="coksatilanlar-tab">
                        <div class="js-slick-carousel u-slick overflow-hidden u-slick-overflow-visble pt-3 pb-6 px-1"
                             data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-4"
                             data-slides-show="4"
                             data-slides-scroll="1"
                             data-responsive='[{
                                      "breakpoint": 1400,
                                      "settings": {
                                        "slidesToShow": 4
                                      }
                                    }, {
                                        "breakpoint": 1200,
                                        "settings": {
                                          "slidesToShow": 3
                                        }
                                    }, {
                                      "breakpoint": 992,
                                      "settings": {
                                        "slidesToShow": 3
                                      }
                                    }, {
                                      "breakpoint": 768,
                                      "settings": {
                                        "slidesToShow": 2
                                      }
                                    }, {
                                      "breakpoint": 554,
                                      "settings": {
                                        "slidesToShow": 2
                                      }
                                    }]'>
                            @foreach($Product->shuffle()->take(6) as $item)
                            <div class="js-slide products-group">

                                <div class="product-item">
                                    <div class="product-item__outer h-100">
                                        <div class="product-item__inner px-wd-4 p-2 p-md-3">
                                            <div class="product-item__body pb-xl-2">
                                                <h5 class="mb-1 product-item__title">
                                                    <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="text-blue font-weight-bold">
                                                        {{ $item->title }}
                                                    </a>
                                                </h5>
                                                <div class="mb-2">

                                                    <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="d-block text-center">
                                                        <img class="img-fluid"
                                                             src="{{ (!$item->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg' : $item->getFirstMediaUrl('page', 'thumb') }}"
                                                             alt="{{ $item->title }}"
                                                        >
                                                    </a>

                                                </div>
                                                <div class="flex-center-between mb-1">
                                                    <div class="prodcut-price">
                                                        <div class="text-gray-100">@convert($item->price)₺ <del>@convert($item->old_price)₺</del></div>
                                                    </div>
                                                    <div class="d-none d-xl-block prodcut-add-cart">
                                                        <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="btn btn-primary"><i class="ec ec-add-to-cart"></i> İncele</a>
                                                    </div>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>

                            </div>
                            @endforeach

                        </div>
                    </div>
                    <div class="tab-pane fade pt-2" id="trendurunler" role="tabpanel" aria-labelledby="trendurunler-tab">
                        <div class="js-slick-carousel u-slick overflow-hidden u-slick-overflow-visble pt-3 pb-6 px-1"
                             data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-4"
                             data-slides-show="4"
                             data-slides-scroll="1"
                             data-responsive='[{
                                      "breakpoint": 1400,
                                      "settings": {
                                        "slidesToShow": 4
                                      }
                                    }, {
                                        "breakpoint": 1200,
                                        "settings": {
                                          "slidesToShow": 3
                                        }
                                    }, {
                                      "breakpoint": 992,
                                      "settings": {
                                        "slidesToShow": 3
                                      }
                                    }, {
                                      "breakpoint": 768,
                                      "settings": {
                                        "slidesToShow": 2
                                      }
                                    }, {
                                      "breakpoint": 554,
                                      "settings": {
                                        "slidesToShow": 2
                                      }
                                    }]'>
                            @foreach($Product->shuffle()->take(6) as $item)
                                <div class="js-slide products-group">

                                    <div class="product-item">
                                        <div class="product-item__outer h-100">
                                            <div class="product-item__inner px-wd-4 p-2 p-md-3">
                                                <div class="product-item__body pb-xl-2">
                                                    <h5 class="mb-1 product-item__title">
                                                        <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="text-blue font-weight-bold">
                                                            {{ $item->title }}
                                                        </a>
                                                    </h5>
                                                    <div class="mb-2">

                                                        <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="d-block text-center">
                                                            <img class="img-fluid"
                                                                 src="{{ (!$item->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg' : $item->getFirstMediaUrl('page', 'thumb') }}"
                                                                 alt="{{ $item->title }}"
                                                            >
                                                        </a>

                                                    </div>
                                                    <div class="flex-center-between mb-1">
                                                        <div class="prodcut-price">
                                                            <div class="text-gray-100">@convert($item->price)₺ <del>@convert($item->old_price)₺</del></div>
                                                        </div>
                                                        <div class="d-none d-xl-block prodcut-add-cart">
                                                            <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="btn btn-primary"><i class="ec ec-add-to-cart"></i> İncele</a>
                                                        </div>
                                                    </div>
                                                </div>

                                            </div>
                                        </div>
                                    </div>

                                </div>
                            @endforeach

                        </div>
                    </div>
                </div>
            </div>


        <div class="container">
            @foreach($Product_Categories as $row)
            <div class="mb-6 position-relative">
                <div class="d-flex justify-content-between border-bottom border-color-1 flex-md-nowrap flex-wrap border-sm-bottom-0">
                    <h3 class="section-title section-title__full mb-0 pb-2 font-size-22 text-primary">{{ $row->title }}</h3>
                    <a class="d-block text-gray-16" href="{{ route('kategori',  [$row->slug, 'id' => $row->id]) }}">Hepsini İncele <i class="ec ec-arrow-right-categproes"></i></a>

                </div>

                <div class="js-slick-carousel position-static u-slick u-slick--gutters-1 overflow-hidden u-slick-overflow-visble pt-3 pb-3"
                     data-arrows-classes="position-absolute top-0 font-size-17 u-slick__arrow-normal top-10"
                     data-arrow-left-classes="fa fa-angle-left right-1"
                     data-arrow-right-classes="fa fa-angle-right right-0"
                     data-pagi-classes="text-center right-0 bottom-1 left-0 u-slick__pagination u-slick__pagination--long mb-0 z-index-n1 mt-4">
                    <div class="js-slide">
                        <ul class="row list-unstyled products-group no-gutters mb-0 overflow-visible">

                            @php
                                $ProductList = \App\Models\Product::with(['getCategory'])
                                ->join('product_category_pivots', 'product_category_pivots.product_id', '=', 'products.id' )
                                ->join('product_categories', 'product_categories.id', '=', 'product_category_pivots.category_id')
                                ->where('product_category_pivots.category_id',  $row->id)
                                ->select('products.id','products.title','products.rank','products.slug','products.price','products.old_price','products.slug','products.sku','product_category_pivots.category_id', 'product_categories.parent_id')
                                ->where('products.status', 1)
                                ->orderBy("products.created_at", 'asc')
                                ->get();
                            @endphp
                            @foreach($ProductList->take(6) as $item)
                                <li class="col-md-4 product-item product-item__card pb-2 mb-2 pb-md-0 mb-md-0 border-bottom border-md-bottom-0">
                                <div class="product-item__outer h-100 w-100">
                                    <div class="product-item__inner p-md-3 row no-gutters">
                                        <div class="col col-lg-auto col-xl-5 col-wd-auto product-media-left">
                                            <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="max-width-150 d-block">
                                                <img class="img-fluid"
                                                     src="{{ (!$item->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg' : $item->getFirstMediaUrl('page', 'thumb') }}"
                                                     alt="{{ $item->title }}"
                                                >
                                            </a>
                                        </div>
                                        <div class="col col-xl-7 col-wd product-item__body pl-2 pl-lg-3 pl-xl-0 pl-wd-3 mr-wd-1 justify-content-center">
                                            <div class="pt-4">
                                                <h5 class="product-item__title">
                                                    <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="text-blue font-weight-bold">
                                                        {{ $item->title }}
                                                    </a>
                                                </h5>
                                            </div>
                                            <div class="flex-center-between mb-3">
                                                <div class="prodcut-price">
                                                    <div class="text-gray-100 font-weight-bold">@convert($item->price)₺ <br><del>@convert($item->old_price)₺</del></div>
                                                </div>
                                                <div class="">
                                                    <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="btn btn-primary d-flex">
                                                        <i class="ec ec-add-to-cart d-none d-xl-block pt-1"></i> İncele
                                                    </a>
                                                </div>
                                            </div>

                                        </div>
                                    </div>
                                </div>
                            </li>
                            @endforeach
                        </ul>
                    </div>
                </div>
            </div>
            @endforeach
        </div>

    </div>

@endsection
