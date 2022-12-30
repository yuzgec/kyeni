<div class="product product-image-gap product-simple">
    <figure class="product-media">
        <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}">
            <img class="img-fluid" src="{{ (!$item->getFirstMediaUrl('page')) ? '/frontend/images/'.config('app.tema').'/resimyok.jpg' : $item->getFirstMediaUrl('page', 'thumb') }}" alt="{{ $item->title }}" width="400" height="400">
            @foreach($item->getMedia('gallery')->take(1) as $img)
                {{ $img->img('thumb')->attributes(['class' => 'product-image-hover', 'alt' => $item->title]) }}
            @endforeach
        </a>
        <div class="product-label-group">
            <label class="product-label gold">%{{ abs(round( $item->price * 100 /$item->old_price - 100)) }} indirim</label>
        </div>

        <div class="product-action">
            <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}" class="btn-product gold">Ürünü İncele</a>
        </div>
    </figure>

    <div class="product-details">
        <div class="product-cat">
            @foreach($item->getCategory->take(1) as $category)
                @php $name = \App\Models\ProductCategory::select('id','title', 'slug')->find($category->category_id) @endphp
                <a href="{{ route('kategori', [$name->slug, 'id' => $name->id]) }}">{{ $name->title}}</a>
                <span class="">/ Ürün Kodu : {{$item->sku}}</span>
            @endforeach
        </div>
        <h4 class="product-name">
            <a href="{{ route('urun' , $item->slug)}}" title="{{ $item->title }}">
                {{ $item->title }}
            </a>
        </h4>
        {{--<div class="ratings-container">
            <div class="ratings-full">
                <span class="ratings" style="width: 100%;"></span>
            </div>
            <a href="{{ route('home') }}" class="rating-reviews">(3 yorum)</a>
        </div>--}}

        <div class="product-pa-wrapper">
            <div class="product-price">
                <ins class="new-price">{{ money($item->price) }}₺</ins><del class="old-price">{{ money($item->old_price) }}₺</del>
            </div>
            <div class="product-action">
                <a href="#" class="btn-cart btn-product btn btn-link btn-underline">Ürünü İncele</a>
            </div>
        </div>
    </div>
</div>
