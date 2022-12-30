@extends(config('app.tema').'/frontend.layout.app')
@section('title', 'Arama Sonuçları | '.config('app.name'))
@section('content')


    <div class="page-content mb-10 mt-5">
        <div class="container">

            <div class="product-wrapper row cols-md-3 cols-sm-2 cols-2">
                @foreach($Result as $item)
                    <div class="product-wrap">
                        <x-shop.product-item :item="$item"/>
                    </div>
                @endforeach
            </div>

            <div class="row ">
                <div class="col-12 d-flex align-items-center justify-content-center">
                    {{ $Result->appends(['siralama' => 'urunler' ]) }}
                </div>
            </div>

        </div>
    </div>


@endsection
