@extends(config('app.tema').'/frontend.layout.app')
@section('title', 'Sepetim | Kıblegah Aile Oyunları Online Satış Sitesi')
@section('content')
    @include('backend.layout.alert')

    <div class="bg-gray-13 bg-md-transparent">
        <div class="container">
            <div class="my-md-3">
                <nav aria-label="breadcrumb">
                    <ol class="breadcrumb mb-3 flex-nowrap flex-xl-wrap overflow-auto overflow-xl-visble">
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1"><a href="{{ route('home') }}">Anasayfa</a></li>
                        <li class="breadcrumb-item flex-shrink-0 flex-xl-shrink-1 active" aria-current="page">Sepetim</li>
                    </ol>
                </nav>
            </div>
        </div>
    </div>

    <div class="container">

        <div class="mb-10 cart-table">
            <table class="table" cellspacing="0">
                <thead>
                <tr>
                    <th class="product-remove">&nbsp;</th>
                    <th class="product-thumbnail">&nbsp;</th>
                    <th class="product-name">Ürün</th>
                    <th class="product-price">Fiyat</th>
                    <th class="product-quantity w-lg-15">Adet</th>
                    <th class="product-subtotal">Toplam</th>
                </tr>
                </thead>
                <tbody>
                @foreach(Cart::content() as $cart)
                    <tr class="mb-1" style="border:1px solid gray;border-radius:5px">
                        <td class="text-center">
                            <form action="{{ route('sepetcikar', $cart->rowId) }}" method="POST">
                                @csrf
                                <button type="submit" class="btn btn-danger text-white-size-16">Sepetten Çıkar</button>
                            </form>
                        </td>
                        <td class="d-none d-md-table-cell">
                            <a href="{{ route('urun',$cart->options->url) }}">
                                <img class="img-fluid max-width-100 p-1 border border-color-1" src="{{ $cart->options->image }}" alt="{{ $cart->name }}">
                            </a>
                        </td>
                        <td data-title="Ürün Adı">
                            <a href="{{ route('urun', $cart->name) }}" class="text-gray-90">{{ $cart->name }}</a>
                        </td>
                        <td data-title="Fiyat">
                            <span class="">{{ money($cart->price)}}₺</span>
                        </td>

                        <td data-title="Adet">
                            <span class="sr-only">Adet</span>
                            <div class="border rounded-pill py-1 width-122 w-xl-80 px-3 border-color-1">
                                <div class="row align-items-center">
                                    <div class="col">
                                        <input class="js-result form-control h-auto border-0 rounded p-0 shadow-none" type="text" value="{{ $cart->qty }}">
                                    </div>
                                    <div class="col-auto pr-1">
                                        <form action="{{ route('sepeteekle') }}" method="POST">
                                            <input  type="hidden" name="id" value="{{ $cart->id }}">
                                            <input  type="hidden" name="update" value="1">
                                            <input  type="hidden" name="qty" value="1">
                                            @csrf
                                            <button class="js-plus btn btn-icon btn-xs btn-outline-secondary rounded-circle border-0" type="submit">
                                                <small class="fas fa-plus btn-icon__inner"></small>
                                            </button>
                                        </form>
                                    </div>
                                </div>
                            </div>
                        </td>

                        <td data-title="Total">
                            <span class="">{{ money($cart->price * $cart->qty) }}₺</span>
                        </td>
                    </tr>
                @endforeach
                <tr>
                    <td colspan="6" class="border-top space-top-2 justify-content-center">
                        <div class="pt-md-3">
                            <div class="d-block d-md-flex flex-center-between">
                                <div class="mb-3 mb-md-0 w-xl-40">
                                    <form class="js-focus-state">
                                        <label class="sr-only" for="subscribeSrEmailExample1">Kupon Kodu</label>
                                        <div class="input-group">
                                            <input type="text" class="form-control" name="text" id="subscribeSrEmailExample1" placeholder="Varsa Kupon Kodunuz" aria-label="Coupon code" aria-describedby="subscribeButtonExample2" required>
                                            <div class="input-group-append">
                                                <button class="btn btn-block btn-dark px-4" type="button" id="subscribeButtonExample2"><i class="fas fa-tags d-md-none"></i><span class="d-none d-md-inline">Kupon Uygula</span></button>
                                            </div>
                                        </div>
                                    </form>
                                </div>
                                <div class="d-md-flex">
                                    <form action="{{ route('sepetbosalt') }}" method="POST">
                                        @csrf
                                        <button type="submit" class="btn btn-soft-secondary mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto">
                                            Sepeti Boşalt
                                        </button>
                                    </form>
                                    <a href="{{ route('siparis') }}" class="btn btn-primary-dark-w mb-3 text-white mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto d-none d-md-inline-block">Siparişi Tamamla</a>
                                </div>
                            </div>
                        </div>
                    </td>
                </tr>
                </tbody>
            </table>
        </div>

        <div class="mb-8 cart-total">
            <div class="row">
                <div class="col-xl-5 col-lg-6 offset-lg-6 offset-xl-7 col-md-8 offset-md-4">
                    <div class="border-bottom border-color-1 mb-3">
                        <h3 class="d-inline-block section-title mb-0 pb-2 font-size-26">Sipariş Toplam</h3>
                    </div>
                    <table class="table mb-3 mb-md-0">
                        <tbody>
                        <tr class="cart-subtotal">
                            <th>Ara Toplam</th>
                            <td data-title="Ara Toplam"><span class="amount">{{ money(Cart::subtotal()) }}₺</span></td>
                        </tr>
                        <tr class="shipping">
                            <th>Kargo</th>
                            <td data-title="Kargo">
                                <span class="amount">{{ cargo(Cart::total()) }}</span>
                            </td>
                        </tr>
                        <tr class="order-total">
                            <th>Toplam</th>
                            <td data-title="Toplam"><strong><span class="amount">{{cargoToplam(Cart::total())}}₺</span></strong></td>
                        </tr>
                        </tbody>
                    </table>
                    <a href="{{ route('siparis') }}"  type="button" class="btn btn-dark mb-3 mb-md-0 font-weight-normal px-5 px-md-4 px-lg-5 w-100 w-md-auto d-md-none">Siparişi Tamamla</a>
                </div>
            </div>
        </div>


    </div>
@endsection
