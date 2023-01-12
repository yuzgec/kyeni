@extends(config('app.tema').'/frontend.layout.app')
@section('content')
    <div class="page-content" style="margin-top:20px">
        <div class="container">
            <div class="row deals-wrapper appear-animate mb-3">
                <div class="title-link-wrapper title-deals after-none appear-animate">
                    <h2 class="title">Günün Fırsatı </h2>
                </div>
                <div class="swiper-container swiper-theme mb-4 pg-inner animation-slider" data-swiper-options="{
                    'spaceBetween': 20,
                    'slidesPerView': 1,
                    'breakpoints': {
                        '992': {
                            'slidesPerView': 2
                        }
                    }
                    }">
                    <div class="swiper-wrapper row cols-lg-2">
                        @foreach($Product->where('opportunity', 1) as $item)
                            <div class="swiper-slide ">
                                <div class="product product-list br-sm mb-0">
                                    <figure class="product-image" style="border:1px solid #f4f4f4;">
                                        <img src="{{ (!$item->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg'  : $item->getFirstMediaUrl('page', 'thumb')}}" title="{{ $item->title }}">
                                    </figure>
                                    <div class="product-details">
                                        <h4 class="product-name">
                                            <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}">
                                                {{ $item->title }}
                                            </a>
                                        </h4>

                                        <div class="product-price">
                                            <ins class="new-price ls-50"> {{ $item->price }}₺ -
                                                <del>@convert($item->old_price)₺</del>
                                            </ins>
                                        </div>
                                        @if($item->get_comment_count > 0)
                                            <div class="ratings-container">
                                                <div class="ratings-full">
                                                    <span class="ratings" style="width: 100%;"></span>
                                                    <span class="tooltiptext tooltip-top"></span>
                                                </div>
                                                <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="rating-reviews">({{ $item->get_comment_count }} yorum)</a>
                                            </div>
                                        @endif

                                        <div class="product-short-desc lh-2 short" style="font-size: 16px">
                                            {!! $item->short !!}
                                        </div>

                                        <div class="product-form pt-4">
                                            <a href="{{ route('urun' , $item->slug)}}" class="btn btn-primary">
                                                <i class="w-icon-cart"></i>
                                                <span>Ürünü İncele</span>
                                            </a>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>

    </div>
    </div>
@endsection
