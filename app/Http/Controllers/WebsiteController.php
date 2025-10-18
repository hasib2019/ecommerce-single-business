<?php

namespace App\Http\Controllers;

use App\Category;
use App\Page;
use App\Product;
use App\Slider;
use App\Setting;
use Illuminate\Support\Facades\DB;
use Illuminate\Http\Request;

class WebsiteController extends Controller
{
    public function index()
    {
        // Removed debug statement
        $slug = 'offer';
        $topProducts = Product::with('media', 'categories')->whereHas('categories', function ($query) use ($slug) {
            $query->where('categories.categorySlug', 'like', $slug);
        })->inRandomOrder()->limit(12)->get();
        $slides = Slider::where('status', 'Active')->limit(3)->get();
        // Prefer DB settings for dynamic control; fallback to env
        $homeControl = Setting::get('HOME_CONTROLL') ?? env('HOME_CONTROLL', 'home_one');
        // dd($homeControl);
        if ($homeControl === 'home_two') {
            $limit = (int) (Setting::get('home_two_featured_limit') ?? 10);
            $catsCsv = (string) (Setting::get('home_two_featured_cats') ?? '');
            $catIds = array_values(array_filter(array_map('intval', explode(',', $catsCsv))));
            // Deduplicate while preserving selection order
            $seen = [];
            $orderedIds = [];
            foreach ($catIds as $cid) {
                if (!$cid) {
                    continue;
                }
                if (!isset($seen[$cid])) {
                    $seen[$cid] = true;
                    $orderedIds[] = $cid;
                }
            }

            if (count($orderedIds) === 0) {
                $featuredCats = DB::table('categories')
                    ->select('id', 'categoryName', 'categorySlug')
                    ->where('status', 'Active')
                    ->orderBy('categoryName', 'ASC')
                    ->limit(2)
                    ->get();
            } else {
                // Fetch and then reorder according to $orderedIds
                $cats = DB::table('categories')
                    ->select('id', 'categoryName', 'categorySlug')
                    ->whereIn('id', $orderedIds)
                    ->get();
                $byId = [];
                foreach ($cats as $c) {
                    $byId[$c->id] = $c;
                }
                $ordered = [];
                foreach ($orderedIds as $id) {
                    if (isset($byId[$id])) {
                        $ordered[] = $byId[$id];
                    }
                }
                $featuredCats = collect($ordered);
            }

            $initialProducts = [];
            foreach ($featuredCats as $fc) {
                $initialProducts[$fc->id] = Product::with('media', 'categories')
                    ->whereHas('categories', function ($query) use ($fc) {
                        $query->where('categories.id', $fc->id);
                    })
                    ->orderBy('products.created_at', 'DESC')
                    ->limit($limit)
                    ->get();
            }

            return view('website.home_two', compact('slug', 'topProducts', 'slides', 'featuredCats', 'initialProducts', 'limit'));
        } else if ($homeControl === 'home_three') {
            $limit = (int) (Setting::get('home_three_featured_limit') ?? 10);
            $catsCsv = (string) (Setting::get('home_three_featured_cats') ?? '');
            $catIds = array_values(array_filter(array_map('intval', explode(',', $catsCsv))));
            // Deduplicate while preserving selection order
            $seen = [];
            $orderedIds = [];
            foreach ($catIds as $cid) {
                if (!$cid) {
                    continue;
                }
                if (!isset($seen[$cid])) {
                    $seen[$cid] = true;
                    $orderedIds[] = $cid;
                }
            }

            if (count($orderedIds) === 0) {
                $featuredCats = DB::table('categories')
                    ->select('id', 'categoryName', 'categorySlug')
                    ->where('status', 'Active')
                    ->orderBy('categoryName', 'ASC')
                    ->limit(2)
                    ->get();
            } else {
                // Fetch and then reorder according to $orderedIds
                $cats = DB::table('categories')
                    ->select('id', 'categoryName', 'categorySlug')
                    ->whereIn('id', $orderedIds)
                    ->get();
                $byId = [];
                foreach ($cats as $c) {
                    $byId[$c->id] = $c;
                }
                $ordered = [];
                foreach ($orderedIds as $id) {
                    if (isset($byId[$id])) {
                        $ordered[] = $byId[$id];
                    }
                }
                $featuredCats = collect($ordered);
            }

            $initialProducts = [];
            foreach ($featuredCats as $fc) {
                $initialProducts[$fc->id] = Product::with('media', 'categories')
                    ->whereHas('categories', function ($query) use ($fc) {
                        $query->where('categories.id', $fc->id);
                    })
                    ->orderBy('products.created_at', 'DESC')
                    ->limit($limit)
                    ->get();
            }

            return view('website.home_three', compact('slug', 'topProducts', 'slides', 'featuredCats', 'initialProducts', 'limit'));
        }

        // Default: home_one
        return view('website.home_one', compact('slug', 'topProducts', 'slides'));
    }

    public function product($id)
    {
        $product = Product::with('media', 'categories')->where('products.id', 'like', $id)->first();
        $relatedProducts = Product::with('media', 'categories')->where('products.id', '!=', $product->id)->limit(30)->get();
        return view('website.product', compact('product', 'relatedProducts'));
    }

    public function category($slug)
    {
        $categoryProducts = Product::with('media', 'categories')->whereHas('categories', function ($query) use ($slug) {
            $query->where('categories.categorySlug', 'like', $slug);
        })->paginate(30);
        $category = Category::where('categories.categorySlug', $slug)->first();
        return view('website.category', compact('category', 'categoryProducts'));
    }

    public function shop()
    {
        if (isset($_REQUEST['q'])) {
            $shop = Product::with('media', 'categories')->where('products.productName', 'like', "%{$_REQUEST['q']}%")->paginate(30);
        } else {
            $shop = Product::with('media', 'categories')->paginate(30);
        }
        return view('website.shop', compact('shop'));
    }

    public function page($slug)
    {
        $page = Page::where('pageSlug', 'like', $slug)->first();
        $relatedProducts = Product::with('media', 'categories')->inRandomOrder()->limit(30)->get();
        return view('website.page', compact('page', 'relatedProducts'));
    }
    public function loadProducts()
    {

        $otherProducts = Product::with('media', 'categories')->inRandomOrder()->paginate(30);
        foreach ($otherProducts as $product) { ?>
            <div class="col-md-3 col-6 mb-4">
                <div class="card card-product-grid product-box-2 h-100">
                    <a href="<?php echo url('/product/' . $product->id) ?>" class="img-wrap">
                        <img class="img-fit lazyload" src="<?php echo asset('product/thumbnail/default.jpg') ?>" data-src="<?php echo asset('/product/thumbnail/' . $product->productImage) ?>" alt="<?php echo $product->productName ?>">
                    </a>
                    <div class="card-body info-wrap">
                        <a href="<?php echo url('/product/' . $product->id) ?>" class="title text-truncate"><?php echo $product->productName ?></a>
                        <div class="price mt-auto text-center">
                            <?php echo $product->htmlPrice() ?>
                        </div>
                        <button class="btn btn-success btn-sm btn-block mt-3" onclick="addToCart(<?php echo $product->id ?>)">
                            <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i> অর্ডার করুন
                        </button>
                    </div>
                </div>
            </div>
        <?php }
    }

    public function loadCategoryProducts(Request $request)
    {
        $catId = (int) $request->get('cat_id');
        $offset = (int) $request->get('offset', 0);
        $limit = (int) $request->get('limit', 10);

        if (!$catId) {
            return '';
        }

        $products = Product::with('media', 'categories')
            ->whereHas('categories', function ($query) use ($catId) {
                $query->where('categories.id', $catId);
            })
            ->orderBy('products.created_at', 'DESC')
            ->skip($offset)
            ->take($limit)
            ->get();

        foreach ($products as $product) { ?>
            <div class="product">
                <div class="image">
                    <a href="<?php echo url('/product/' . $product->id) ?>" id="product_show" data-productid="{{ $product->id }}" data-categoryid="{{ $fc->categoryName }}" data-productname="{{ $product->productName }}">
                        <img class="img-fit lazyload first" src="<?php echo asset('/product/thumbnail/' . $product->productImage) ?>" data-src="<?php echo asset('/product/thumbnail/' . $product->productImage) ?>" alt="<?php echo $product->productName ?>">
                        <img class="img-fit lazyload second" src="<?php echo asset('product/thumbnail/default.jpg') ?>" data-src="<?php echo asset('/product/thumbnail/' . $product->productImage) ?>" alt="<?php echo $product->productName ?>">
                    </a>
                </div>
                <div class="labels"></div>
                <div class="content px-2 text-center pb-2">
                    <a href="<?php echo url('/product/' . $product->id) ?>" id="product_show" data-productid="{{ $product->id }}" data-categoryid="{{ $fc->categoryName }}" data-productname="{{ $product->productName }}">
                        <div class="title"><?php echo $product->productName ?></div>
                    </a>
                    <div class="stars d-flex justify-content-center py-2">
                        <div class="d-flex align-items-center text-warning">
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                            <i class="fas fa-star"></i>
                        </div>
                    </div>
                    <div class="price"><?php echo $product->htmlPrice() ?></div>
                    <button class="submit_button btn btnLight d-block w-100 border cart_btn ord_bt" style="border-radius: 5px;" onclick="addToCart(<?php echo $product->id ?>)">
                        <i class="fa fa-shopping-cart me-2" aria-hidden="true"></i><span class="bold"> অর্ডার করুন</span>
                    </button>
                </div>
            </div>
        <?php }
    }
}
