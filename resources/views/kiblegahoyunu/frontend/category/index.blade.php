@extends(config('app.tema').'/frontend.layout.app')
@section('content')
    @include('backend.layout.alert')
    <div class="container">
        <div class="row mb-8">
            <div class="col-md-12">

                <div class="flex-center-between mb-3">
                    <h3 class="font-size-25 mb-0">{{ $Detay->title }}</h3>
                </div>

                <div class="bg-gray-1 flex-center-between borders-radius-9 py-1">
                    <p class="font-size-14 text-gray-90 mb-0 ml-2">Showing 1–25 of 56 results</p>
                    <div class="d-flex">
                        <form method="get">

                            <select name="sortby" id="sortby" class=js-select selectpicker dropdown-select max-width-200 max-width-160-sm right-dropdown-0 px-2 px-xl-0" data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0" onchange="location = this.options[this.selectedIndex].value">
                                <option value="">Sıralama</option>
                                <option value="{{ url()->current() }}?id={{ $Detay->id }}&fiyat=asc" {{ (request('fiyat') == 'asc') ? 'selected' : null }}>Fiyat Artan</option>
                                <option value="{{ url()->current() }}?id={{ $Detay->id }}&fiyat=desc" {{ (request('fiyat') == 'desc') ? 'selected' : null }}>Fiyat Azalan</option>
                                <option value="{{ url()->current() }}?id={{ $Detay->id }}&yeni=asc" {{ (request('basimtarihi') == 'asc') ? 'selected' : null }}>Yeni Eklenenler</option>
                                <option value="{{ url()->current() }}?id={{ $Detay->id }}&coksatan=1" {{ (request('basimtarihi') == 'asc') ? 'selected' : null }}>Çok Satanlar</option>
                                <option value="{{ url()->current() }}?id={{ $Detay->id }}&indirim=1" {{ (request('indirim') == 1) ? 'selected' : null }}>İndirimdeki Ürünler</option>
                            </select>
                        </form>
                        <form method="POST" class="ml-2 d-none d-xl-block">
                            <select class="js-select selectpicker dropdown-select max-width-120"
                                    data-style="btn-sm bg-white font-weight-normal py-2 border text-gray-20 bg-lg-down-transparent border-lg-down-0">
                                <option value="one" selected>Show 20</option>
                                <option value="two">Show 40</option>
                                <option value="three">Show All</option>
                            </select>
                        </form>
                    </div>
                    <nav class="px-3 flex-horizontal-center text-gray-20 d-none d-xl-flex">
                        <form method="post" class="min-width-50 mr-1">
                            <input size="2" min="1" max="3" step="1" type="number" class="form-control text-center px-2 height-35" value="1">
                        </form> of 3
                        <a class="text-gray-30 font-size-20 ml-2" href="#">→</a>
                    </nav>
                </div>

                <div class="tab-content" id="pills-tabContent">
                    <div class="tab-pane fade pt-2 show active" id="pills-one-example1" role="tabpanel" aria-labelledby="pills-one-example1-tab" data-target-group="groups">
                        <ul class="row list-unstyled products-group no-gutters">
                            @foreach($ProductList as $item)

                            <li class="col-6 col-md-4 product-item remove-divider">
                                <div class="product-item__outer h-100 w-100">
                                    <div class="product-item__inner px-xl-4 p-3">
                                        <div class="product-item__body pb-xl-2">
                                            <div class="mb-2"><a href="../shop/product-categories-7-column-full-width.html" class="font-size-12 text-gray-5">{{ $Detay->title }}</a></div>
                                            <h5 class="mb-1 product-item__title"><a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="text-blue font-weight-bold">
                                                    {{ $item->title }}
                                                </a>
                                            </h5>
                                            <div class="mb-2">

                                                <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="d-block">
                                                    <img class="img-fluid"
                                                         src="{{ (!$item->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg' : $item->getFirstMediaUrl('page', 'img') }}"
                                                         alt="{{ $item->title }}"
                                                    >
                                                </a>
                                            </div>
                                            <div class="flex-center-between mb-1">
                                                <div class="prodcut-price">
                                                    <div class="text-gray-100 font-weight-bold">@convert($item->price)₺ <del>@convert($item->old_price)₺</del></div>
                                                </div>
                                                <div class="d-none d-xl-block prodcut-add-cart">
                                                    <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="btn btn-primary "><i class="ec ec-add-to-cart"></i> İncele</a>
                                                </div>
                                            </div>
                                        </div>

                                    </div>
                                </div>
                            </li>

                            @endforeach
                        </ul>
                    </div>

                    {{ $ProductList->appends(['id'=> $Detay->id,'siralama' => 'urunler' ]) }}

                </div>

            </div>
        </div>

    </div>

@endsection


