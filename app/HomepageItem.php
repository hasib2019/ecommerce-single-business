<?php

namespace App;

use Illuminate\Database\Eloquent\Model;

class HomepageItem extends Model
{
    protected $fillable = [
        'section', 'title', 'image', 'link', 'description',
        'coupon_code', 'countdown_end', 'product_id', 'category_id',
        'sort_order', 'status',
    ];

    protected $dates = ['countdown_end'];

    public function product()
    {
        return $this->belongsTo(Product::class);
    }

    public function category()
    {
        return $this->belongsTo(Category::class);
    }

    /**
     * Get all active items for a given section, ordered by sort_order.
     */
    public static function activeForSection(string $section)
    {
        return static::where('section', $section)
            ->where('status', 'Active')
            ->orderBy('sort_order')
            ->get();
    }

    /**
     * Sections that display products from the products table (not images).
     */
    public static function productSections(): array
    {
        return ['featured_product', 'best_selling', 'new_product', 'top_seller'];
    }

    /**
     * Sections that hold image/link items.
     */
    public static function imageSections(): array
    {
        return ['today_deal', 'banner_1', 'flash_deal', 'banner_2', 'banner_3', 'coupon', 'classified', 'top_brand'];
    }

    /**
     * Section labels for display.
     */
    public static function sectionLabels(): array
    {
        return [
            'slider'            => 'Home Slider',
            'today_deal'        => "Today's Deal",
            'banner_1'          => 'Banner Level 1',
            'flash_deal'        => 'Flash Deals',
            'featured_product'  => 'Featured Products',
            'banner_2'          => 'Banner Level 2',
            'best_selling'      => 'Best Selling Products',
            'new_product'       => 'New Products',
            'banner_3'          => 'Banner Level 3',
            'coupon'            => 'Coupon Section',
            'category_wise'     => 'Category Wise Products',
            'classified'        => 'Classifieds',
            'top_seller'        => 'Top Sellers',
            'top_brand'         => 'Top Brands',
        ];
    }
}
