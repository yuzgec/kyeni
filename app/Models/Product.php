<?php

namespace App\Models;

use Illuminate\Database\Eloquent\Factories\HasFactory;
use Illuminate\Database\Eloquent\Model;
use Illuminate\Database\Eloquent\SoftDeletes;
use Spatie\Activitylog\LogOptions;
use Spatie\Activitylog\Traits\LogsActivity;
use Spatie\Image\Manipulations;
use Spatie\MediaLibrary\HasMedia;
use Spatie\MediaLibrary\InteractsWithMedia;
use Spatie\MediaLibrary\MediaCollections\Models\Media;
use CyrildeWit\EloquentViewable\InteractsWithViews;
use CyrildeWit\EloquentViewable\Contracts\Viewable;
use Spatie\Sluggable\SlugOptions;
use Spatie\Sluggable\HasSlug;

class Product extends Model implements HasMedia,Viewable
{
    use HasFactory,SoftDeletes,InteractsWithMedia,LogsActivity,InteractsWithViews,HasSlug;

    protected $guarded = [];
    protected $table = 'products';

    public function getCategory(){
        return $this->hasMany(ProductCategoryPivot::class, 'product_id', 'id');
    }

    public function getComment(){
        return $this->hasmany(Comment::class, 'product_id', 'id');
    }

    public function registerMediaConversions(Media $media = null): void
    {
        $this->addMediaConversion('img')->width(1000)->height(1000)
            ->watermark(public_path('/img/'.config('app.tema').'.png'))
            ->watermarkPosition(Manipulations::POSITION_CENTER)
            ->watermarkHeight(1000, Manipulations::UNIT_PERCENT)
            ->watermarkWidth(1000, Manipulations::UNIT_PERCENT)
            ->keepOriginalImageFormat();
        $this->addMediaConversion('imgpng')->width(1000)->height(1000)->keepOriginalImageFormat();
        $this->addMediaConversion('thumb')->width(400)->height(400)->nonOptimized();
        $this->addMediaConversion('thumbpng')->width(400)->height(400)->keepOriginalImageFormat();
        $this->addMediaConversion('small')->width(150)->height(150)->keepOriginalImageFormat();
        $this->addMediaConversion('smallpng')->width(150)->height(150)->nonOptimized();
    }

    public function getActivitylogOptions(): LogOptions
    {
        return LogOptions::defaults()->logOnly(['title', 'slug', 'price']);
    }

    public function getSlugOptions() : SlugOptions
    {
        return SlugOptions::create()->generateSlugsFrom('title')->saveSlugsTo('slug');
    }

}
