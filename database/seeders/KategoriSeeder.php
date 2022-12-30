<?php

namespace Database\Seeders;

use App\Models\BlogCategory;
use App\Models\GalleryCategory;
use App\Models\PageCategory;
use App\Models\ProductCategory;
use Illuminate\Database\Seeder;


class KategoriSeeder extends Seeder
{

    public function run()
    {
        PageCategory::create(['title' => 'Kurumsal', 'slug' => 'kurumsal']);
        PageCategory::create(['title' => 'Bilgilendirme', 'slug' => 'bilgilendirme']);
        PageCategory::create(['title' => 'Sözleşmeler', 'slug' => 'sozlesmeler']);
        BlogCategory::create(['title' => 'Duyurular', 'slug' => 'duyurular']);
        BlogCategory::create(['title' => 'Haberler', 'slug' => 'haberler']);
        BlogCategory::create(['title' => 'Etkinlikler', 'slug' => 'etkinlikler']);
        GalleryCategory::create(['title' => 'Genel Kategori', 'slug' => 'genel-kategori']);
        ProductCategory::create(['title' => 'Kategori 1', 'slug' => 'kategori-1']);
        ProductCategory::create(['title' => 'Kategori 2', 'slug' => 'kategori-2']);
        ProductCategory::create(['title' => 'Kategori 3', 'slug' => 'kategori-3']);
    }
}
