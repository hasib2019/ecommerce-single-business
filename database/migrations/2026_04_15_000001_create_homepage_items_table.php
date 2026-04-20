<?php

use Illuminate\Database\Migrations\Migration;
use Illuminate\Database\Schema\Blueprint;
use Illuminate\Support\Facades\Schema;

class CreateHomepageItemsTable extends Migration
{
    public function up()
    {
        Schema::create('homepage_items', function (Blueprint $table) {
            $table->id();
            // section keys: slider, today_deal, banner_1, flash_deal, featured_product,
            //                banner_2, best_selling, new_product, banner_3, coupon,
            //                category_wise, classified, top_seller, top_brand
            $table->string('section', 50)->index();
            $table->string('title')->nullable();
            $table->string('image')->nullable();
            $table->string('link')->nullable();
            $table->text('description')->nullable();
            $table->string('coupon_code')->nullable();
            $table->timestamp('countdown_end')->nullable();
            $table->unsignedBigInteger('product_id')->nullable();
            $table->unsignedBigInteger('category_id')->nullable();
            $table->integer('sort_order')->default(0);
            $table->string('status', 20)->default('Active');
            $table->timestamps();
        });
    }

    public function down()
    {
        Schema::dropIfExists('homepage_items');
    }
}
