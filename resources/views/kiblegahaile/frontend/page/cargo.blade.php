@extends(config('app.tema').'/frontend.layout.app')

@section('title', 'Detaylı Arama | '.config('app.name'))
@section('content')

    <form method="GET">
        <div class="container">
            <div class="row mt-5 mb-5">
                <small><b>Telefon numaranızı başında 0 olmadan giriniz...</b></small>
                <div class="col-md-6">
                    <input type="text" name="har_kod" class="form-control form-control-lg " placeholder="10 Haneli Telefon Numarası Giriniz..." required>
                </div>
                <div class="col-md-6">
                    <button class="btn btn-primary btn-block" type="submit" name="action">Kargo Sorgula</button>
                </div>
            </div>
        </div>
    </form>


@endsection
