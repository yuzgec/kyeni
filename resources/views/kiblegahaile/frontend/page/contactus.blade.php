@extends(config('app.tema').'/frontend.layout.app')

@section('title', 'İletişim Bilgileri - TB Kitap')
@section('content')



    <div class="page-content contact-us mt-8">
        <div class="container">
            <section class="content-title-section mb-10">
                <h3 class="title title-center mb-3">İletişim Bilgileri</h3>
            </section>


            <section class="contact-information-section mb-10">
                <div class=" swiper-container swiper-theme " data-swiper-options="{
                            'spaceBetween': 20,
                            'slidesPerView': 1,
                            'breakpoints': {
                                '480': {
                                    'slidesPerView': 2
                                },
                                '768': {
                                    'slidesPerView': 3
                                },
                                '992': {
                                    'slidesPerView': 3
                                }
                            }
                        }">
                    <div class="swiper-wrapper row cols-xl-4 cols-md-3 cols-sm-2 cols-1">
                        <div class="swiper-slide icon-box text-center icon-box-primary">
                                    <span class="icon-box-icon icon-email">
                                        <i class="w-icon-envelop-closed"></i>
                                    </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title">E-mail Adresimiz</h4>
                                <p>{{ config('settings.email1') }}</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box text-center icon-box-primary">
                                    <span class="icon-box-icon icon-headphone">
                                        <i class="w-icon-headphone"></i>
                                    </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title">Telefon Numaramız</h4>
                                <p>{{ config('settings.telefon1') }}</p>
                            </div>
                        </div>
                        <div class="swiper-slide icon-box text-center icon-box-primary">
                                    <span class="icon-box-icon icon-map-marker">
                                        <i class="w-icon-map-marker"></i>
                                    </span>
                            <div class="icon-box-content">
                                <h4 class="icon-box-title">Adres</h4>
                                <p>{{ config('settings.adres1') }}</p>
                            </div>
                        </div>
                    </div>
                </div>
            </section>

            <hr class="divider mb-10 pb-1">

            <section class="contact-section bg-success" >
                <div class="row gutter-lg pb-3">

                    <div class="col-lg-12 mb-8">
                        <h4 class="title mb-3">MESAJ GÖNDER</h4>
                        <form class="form contact-us-form" action="#" method="post">
                            <div class="form-group">
                                <label for="username" style="color:white">Adınız Soyadınız</label>
                                <input type="text" id="username" name="username"
                                       class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="email_1" style="color:white">Email Adresiniz</label>
                                <input type="email" id="email_1" name="email_1" class="form-control">
                            </div>
                            <div class="form-group">
                                <label for="message" style="color:white">Mesajınız</label>
                                <textarea id="message" name="message" cols="30" rows="5" class="form-control"></textarea>
                            </div>
                            <button type="submit" class="btn btn-dark btn-rounded">MESAJI GÖNDER</button>
                        </form>
                    </div>
                </div>
            </section>
        </div>

    </div>
@endsection
