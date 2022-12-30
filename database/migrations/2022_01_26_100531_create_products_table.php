<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateProductsTable extends Migration
{

    public function up()
    {
        Schema::create('products', function (Blueprint $table) {
            $table->id();

            $table->string('title');
            $table->string('slug');

            $table->string('external')->nullable();
            $table->string('order_medium')->nullable();

            $table->string('bg_color')->nullable();

            $table->integer('opportunity')->nullable();
            $table->integer('offer')->nullable();
            $table->integer('bestselling')->nullable();

            $table->boolean('freecargo')->nullable();
            $table->boolean('fastkargo')->nullable();
            $table->boolean('bigopportunity')->nullable();

            $table->integer('option1')->nullable();
            $table->integer('option2')->nullable();
            $table->integer('option3')->nullable();
            $table->integer('option4')->nullable();

            $table->double('price', 2);
            $table->double('old_price',2)->nullable();
            $table->double('campagin_price',2)->nullable();
            $table->string('sku');

            $table->longText('short')->nullable();
            $table->string('note')->nullable();
            $table->string('cargo')->nullable();
            $table->longText('featrues')->nullable();
            $table->longText('desc')->nullable();

            $table->string('seo_title', 250)->nullable();
            $table->string('seo_desc', 250)->nullable();
            $table->string('seo_key', 250)->nullable();

            $table->boolean('status')->default(1);
            $table->integer('rank')->nullable();

            $table->softDeletes();
            $table->timestamps();

        });
    }

    public function down()
    {
        Schema::dropIfExists('products');
    }
}
