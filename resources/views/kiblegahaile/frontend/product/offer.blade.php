@extends(config('app.tema').'/frontend.layout.app')
@section('content')
    <div class="page-content" style="margin-top:20px">
        <div class="container">
            <div class="row">
                <div class="product product-single row">
                    <div class="col-md-4 mb-6">
                        <div class="product-gallery product-gallery-sticky product-gallery-video">
                            <div class="swiper-container product-single-swiper swiper-theme nav-inner" data-swiper-options="{
                                        'navigation': {
                                            'nextEl': '.swiper-button-next',
                                            'prevEl': '.swiper-button-prev'
                                        }
                                    }">
                                <div class="swiper-wrapper row cols-1 gutter-no">

                                    <div class="swiper-slide">
                                        <figure class="product-image product-image-full">
                                            <img src="{{ (!$Detay->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg'  : $Detay->getFirstMediaUrl('page', 'imgpng')}}"
                                                 data-zoom-image="{{$Detay->getFirstMediaUrl('page', 'imgpng')}}"
                                                 alt="{{ $Detay->title }}">
                                        </figure>
                                    </div>
                                    @foreach($Detay->getMedia('gallery') as $item)
                                        <div class="swiper-slide">
                                            <figure class="product-image product-image-full">
                                                <img src="{{ $item->getUrl('imgpng') }}"
                                                     data-zoom-image="{{ $item->getUrl('imgpng') }}"
                                                     alt="{{ $Detay->title }}">
                                            </figure>
                                        </div>
                                    @endforeach
                                </div>

                                <a href="#" class="product-gallery-btn product-image-full">
                                    <i class="w-icon-zoom"></i>
                                </a>
{{--
                                <a href="#" class="product-gallery-btn product-video-viewer" title="Product Video Thumbnail"><i class="w-icon-movie"></i></a>
--}}
                            </div>
                            <div class="product-thumbs-wrap swiper-container" data-swiper-options="{
                                    'navigation': {
                                        'nextEl': '.swiper-button-next',
                                        'prevEl': '.swiper-button-prev'
                                    }
                                }">
                                <div class="product-thumbs swiper-wrapper row cols-4 gutter-sm">
                                    <div class="product-thumb swiper-slide">
                                        <img src="{{ (!$Detay->getFirstMediaUrl('page')) ? '/resimyok.jpg' : $Detay->getFirstMediaUrl('page', 'small')}}"
                                             alt="Product Thumb" width="150" height="150">
                                    </div>
                                    @foreach($Detay->getMedia('gallery') as $item)
                                        <div class="product-thumb swiper-slide">
                                            <img src="{{ $item->getUrl('small') }}"
                                                 alt="{{ $Detay->title }}"
                                                 width="150" height="150">
                                        </div>
                                    @endforeach
                                </div>
                                <button class="swiper-button-next"></button>
                                <button class="swiper-button-prev"></button>
                            </div>
                        </div>
                    </div>
                    <div class="col-md-4 mb-4">
                        <div class="product-details">
                            <h1 class="product-title">{{ $Detay->title }}</h1>
                            <div class="product-bm-wrapper">
                                <figure class="brand">
                                    <img src="/frontend/images/{{ config('app.tema') }}/logo.png" alt="{{ config('app.name') }}" width="105"  />
                                </figure>
                                <div class="product-meta">
                                    <div class="product-categories">
                                        Kategori:
                                        @foreach($Category as $cat)
                                            <span class="product-category"><a href="{{ route('kategori',[$cat->slug, 'id' => $cat->id]) }}">{{ $cat->title }}</a></span>
                                        @endforeach
                                    </div>
                                    <div class="product-sku">
                                        Ürün Kodu:
                                        <span>{{ $Detay->sku }}</span>
                                    </div>
                                </div>
                            </div>

                            <hr class="product-divider">

                            <div class="product-price">
                                <ins class="new-price">@convert($Detay->price)₺</ins>
                                <del>@convert($Detay->old_price)₺</del>
                                <span class="tip tip-hot" style="font-size: 16px">
                                    %{{ abs(round( $Detay->price * 100 /$Detay->old_price - 100)) }} indirim
                                </span>
                            </div>

                            <div>
                                <p><i class="w-icon-check-solid"></i> Bugün <b>({{$Count}})</b> kişi aldı<br>
                                <i class="w-icon-shipping mr-1"></i> Aynı gün kargoda<br>
                            </div>

                            <div class="product-short-desc lh-2 short">
                                {!! $Detay->short !!}
                            </div>

                            @if($Detay->get_comment_count > 0)
                                <hr class="product-divider">
                                <div class="ratings-container">
                                    <div class="ratings-full">
                                        <span class="ratings " style="width: 100%;"></span>
                                        <span class="tooltiptext tooltip-top "></span>
                                    </div>
                                    <a href="#product-tab-reviews" class="rating-reviews"><i class="w-icon-comments"></i> Ürün Yorumları - ({{ $Detay->get_comment_count }} Yorum)</a>
                                </div>

                                <div class="swiper-container shadow-swiper swiper-theme show-code-action" data-swiper-options="{
                                                'slidesPerView': 1,
                                                'spaceBetween': 20,
                                                'breakpoints': {
                                                    '576': {
                                                        'slidesPerView': 2
                                                    },
                                                    '992': {
                                                        'slidesPerView': 2
                                                    }
                                                }
                                            }">
                                    <div class="swiper-wrapper row cols-lg-3 cols-sm-2 cols-1">
                                        @foreach($Detay->getComment as $comment)
                                            <div class="swiper-slide testimonial-wrap">
                                                <div class="testimonial testimonial-centered testimonial-shadow">
                                                    <div class="testimonial-info">
                                                        <div class="ratings-container">
                                                            <div class="ratings-full">
                                                                <span class="ratings" style="width: 100%;"></span>
                                                            </div>
                                                        </div>
                                                    </div>
                                                    <blockquote>
                                                        {!! $comment->comment !!}
                                                    </blockquote>
                                                    <cite>
                                                        {{ $comment->name }}
                                                    </cite>
                                                </div>
                                            </div>
                                        @endforeach


                                    </div>
                                    <div class="swiper-pagination"></div>
                                </div>
                            @endif
                        </div>
                    </div>
                    <div class="col-md-4 col-12" id="siparis" style="border:1px solid #f4f4f4;border-radius: 5px;padding: 10px">
                        <div class="mb-2">

                            <form action="{{ route('kaydet') }}" method="POST" class="form checkout-form">
                                @csrf()
                                <input type="hidden" name="id" value="{{$Detay->id}}">
                                <input type="hidden" name="kampanya" value="1">
                                <input type="hidden" name="medium" value="{{$Detay->external}}">
                                <div class="row">
                                    <div class="col-lg-12">
                                        <div class="pb-2 mb-2">

                                            <div class="row">
                                                <div class="col-md-6">
                                                    <label class="form-label">Adınız<span class="text-danger">*</span> </label>
                                                    <input value="{{old('name')}}" type="text" class="form-control  @if($errors->has('name')) is-invalid @endif" name="name" placeholder="Adınız" autocomplete="off">
                                                    @if($errors->has('name'))
                                                        <div class="invalid-feedback">{{$errors->first('name')}}</div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label"> Soyadınız <span class="text-danger">*</span></label>
                                                    <input value="{{old('surname')}}" type="text" class="form-control @if($errors->has('surname')) is-invalid @endif" name="surname" placeholder="Soyadınız" autocomplete="off">
                                                    @if($errors->has('surname'))
                                                        <div class="invalid-feedback">{{$errors->first('surname')}}</div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label"> Email Adresiniz</label>
                                                    <input value="{{old('email')}}" type="text" class="form-control @if($errors->has('email')) is-invalid @endif"  name="email" placeholder="Email Zorunlu Değildir">
                                                    @if($errors->has('email'))
                                                        <div class="invalid-feedback">{{$errors->first('email')}}</div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label">Telefon Numaranız <span class="text-danger">*</span></label>
                                                    <input value="{{old('phone')}}" type="text" class="form-control @if($errors->has('phone')) is-invalid @endif" name="phone" placeholder="Telefon Numaranız">
                                                    @if($errors->has('phone'))
                                                        <div class="invalid-feedback">{{$errors->first('phone')}}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group">
                                                    <label class="form-label">
                                                        Açık Adresiniz<span class="text-danger">*</span>
                                                    </label>
                                                    <textarea class="form-control p-5 @if($errors->has('address')) is-invalid @endif" rows="3" name="address" placeholder="Açık Adresinizi Yazınız">{{old('address')}}</textarea>
                                                    @if($errors->has('address'))
                                                        <div class="invalid-feedback">{{$errors->first('address')}}</div>
                                                    @endif
                                                </div>

                                                <div class="col-md-6">
                                                    <label class="form-label"> İl <span class="text-danger">*</span></label>
                                                    <select class="form-control @if($errors->has('province')) is-invalid @endif" name="province">
                                                        <option value="">İl Seçiniz</option>
                                                        @foreach($Province as $item)
                                                            <option value="{{ $item->sehir_title }}" {{ (old('province') == $item->sehir_title) ? 'selected' : null }} }}>{{ $item->sehir_title }}</option>
                                                        @endforeach
                                                    </select>
                                                    @if($errors->has('province'))
                                                        <div class="invalid-feedback">{{$errors->first('province')}}</div>
                                                    @endif
                                                </div>
                                                <div class="col-md-6">
                                                    <label class="form-label">İlçe <span class="text-danger">*</span></label>
                                                    <input value="{{old('city')}}" type="text" class="form-control @if($errors->has('city')) is-invalid @endif"  name="city" placeholder="İlçe">
                                                    @if($errors->has('city'))
                                                        <div class="invalid-feedback">{{$errors->first('city')}}</div>
                                                    @endif
                                                </div>

                                                <div class="form-group place-order">
                                                    <button type="submit" class="btn btn-block btn-rounded">
                                                        {{ ($Detay->offer == 1) ? 'KAMPANYAYA KATIL' : 'SİPARİŞİ TAMAMLA' }}
                                                    </button>
                                                </div>

                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </form>
                        </div>
                    </div>
                </div>

                @if(@auth()->user()->is_admin == 1)
                    <a href="{{ route('product.edit', $Detay->id) }}" class="btn btn-primary btn-block text-white mt-2"><i class="fas fa-edit"></i> Ürün Düzenle</a>
                @endif

                <div class="tab tab-nav-boxed tab-nav-underline product-tabs mt-3">
                    <ul class="nav nav-tabs" role="tablist">
                        <li class="nav-item">
                            <a href="#product-tab-description" class="nav-link active">Ürün Açıklaması</a>
                        </li>
                    </ul>
                    <div class="tab-content">
                        <div class="tab-pane active" id="product-tab-description">
                            <div class="row mb-4">
                                <div class="col-md-8 col-12 mb-3 font-size-md">
                                    {!! $Detay->desc !!}
                                </div>

                                <div class="col-md-4 col-12 mb-5">

                                </div>
                            </div>
                        </div>
                    </div>
                </div>

                <section class="related-product-section">
                    <div class="product-wrapper row cols-md-4 cols-sm-2 cols-2">
                        @foreach($Productssss->take(30) as $item)
                            <div class="product-wrap">
                                <x-shop.product-item :item="$item"/>
                            </div>
                        @endforeach
                    </div>
                </section>

            </div>
        </div>
    </div>
    <div class="pswp" tabindex="-1" role="dialog" aria-hidden="true">
        <div class="pswp__bg"></div>
        <div class="pswp__scroll-wrap" >
            <div class="pswp__container">
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
                <div class="pswp__item"></div>
            </div>
            <div class="pswp__ui pswp__ui--hidden">
                <div class="pswp__top-bar">
                    <div class="pswp__counter"></div>
                    <button class="pswp__button pswp__button--close" aria-label="Kapat (Esc)"></button>
                    <button class="pswp__button pswp__button--zoom" aria-label="Yakınlaştır/Uzaklaştır"></button>
                    <div class="pswp__preloader">
                        <div class="loading-spin"></div>
                    </div>
                </div>
                <div class="pswp__share-modal pswp__share-modal--hidden pswp__single-tap">
                    <div class="pswp__share-tooltip"></div>
                </div>
                <button class="pswp__button--arrow--left" aria-label="Geri"></button>
                <button class="pswp__button--arrow--right" aria-label="İleri"></button>
                <div class="pswp__caption" >
                    <div class="pswp__caption__center"  ></div>
                </div>
            </div>
        </div>
    </div>
@endsection
@section('customJS')
    <script>
        $(document).ready(function() {
            $(".short ul").addClass("list-type-check list-style-none");
        })
    </script>
@endsection
