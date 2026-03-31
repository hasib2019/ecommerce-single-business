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
        if (in_array($homeControl, ['home_two', 'home_watch', 'home_market', 'home_modern'], true)) {
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
            if ($homeControl === 'home_watch') {
                return view('website.home_watch', compact('slug', 'topProducts', 'slides', 'featuredCats', 'initialProducts', 'limit'));
            }
            if ($homeControl === 'home_market') {
                return view('website.home_market', compact('slug', 'topProducts', 'slides', 'featuredCats', 'initialProducts', 'limit'));
            }
            if ($homeControl === 'home_modern') {
                return view('website.home_modern', compact('slug', 'topProducts', 'slides', 'featuredCats', 'initialProducts', 'limit'));
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

    public function product($slug)
    {
        $product = Product::with('media', 'categories')->where('products.productSlug', $slug)->firstOrFail();
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

    public function ajaxSearch(Request $request)
    {
        $query = $request->get('q');
        $categoryId = $request->get('category');

        if (empty($query)) {
            return response()->json([]);
        }

        $productsQuery = Product::where('productName', 'like', "%{$query}%")
            ->select('id', 'productName', 'productSlug', 'productImage', 'productRegularPrice', 'productSalePrice');

        if (!empty($categoryId)) {
            $productsQuery->whereHas('categories', function($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $products = $productsQuery->take(10)->get();

        $results = $products->map(function($product) {
            return [
                'id' => $product->id,
                'name' => $product->productName,
                'image' => asset('/product/thumbnail/' . $product->productImage),
                'price' => $product->productSalePrice > 0 ? $product->productSalePrice : $product->productRegularPrice,
                'url' => url('/product/' . $product->productSlug),
            ];
        });

        return response()->json($results);
    }

    public function shop()
    {
        $query = Product::with('media', 'categories');

        if (isset($_REQUEST['q']) && !empty($_REQUEST['q'])) {
            $query->where('products.productName', 'like', "%{$_REQUEST['q']}%");
        }

        if (isset($_REQUEST['category']) && !empty($_REQUEST['category'])) {
            $catId = $_REQUEST['category'];
            $query->whereHas('categories', function($q) use ($catId) {
                $q->where('categories.id', $catId);
            });
        } elseif (isset($_REQUEST['cat_id']) && !empty($_REQUEST['cat_id'])) {
            $catId = $_REQUEST['cat_id'];
            $query->whereHas('categories', function($q) use ($catId) {
                $q->where('categories.id', $catId);
            });
        }

        $shop = $query->paginate(30);
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
                <div class="card h-100 border-0 shadow-sm rounded-3 product-card" 
                     style="transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); cursor: pointer;"
                     onmouseover="this.style.transform='translateY(-8px)'; this.classList.remove('shadow-sm'); this.classList.add('shadow-lg');"
                     onmouseout="this.style.transform='translateY(0)'; this.classList.add('shadow-sm'); this.classList.remove('shadow-lg');">
                    <div class="position-relative overflow-hidden rounded-top-3">
                        <a href="<?php echo url('/product/' . $product->productSlug) ?>" class="d-block bg-light">
                            <img class="img-fluid w-100 lazyload" 
                                 src="<?php echo asset('product/thumbnail/default.jpg') ?>" 
                                 data-src="<?php echo asset('/product/thumbnail/' . $product->productImage) ?>" 
                                 alt="<?php echo $product->productName ?>"
                                 style="height: 220px; object-fit: cover; opacity: 0.9; filter: brightness(0.95); transition: all 0.5s ease;"
                                 onmouseover="this.style.opacity='1'; this.style.filter='brightness(1.05)'; this.style.transform='scale(1.05)';"
                                 onmouseout="this.style.opacity='0.9'; this.style.filter='brightness(0.95)'; this.style.transform='scale(1)';">
                        </a>
                        <div class="position-absolute top-0 end-0 p-2">
                            <button class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                    style="width: 35px; height: 35px; transition: all 0.2s;" title="Wishlist"
                                    onmouseover="this.classList.add('bg-danger'); this.querySelector('i').classList.remove('text-danger'); this.querySelector('i').classList.add('text-white');"
                                    onmouseout="this.classList.remove('bg-danger'); this.querySelector('i').classList.add('text-danger'); this.querySelector('i').classList.remove('text-white');">
                                <i class="far fa-heart text-danger"></i>
                            </button>
                        </div>
                    </div>
                    
                    <div class="card-body p-3 d-flex flex-column text-center">
                        <a href="<?php echo url('/product/' . $product->productSlug) ?>" class="text-decoration-none text-dark mb-2">
                            <h6 class="fw-bold text-truncate mb-0" style="font-size: 1rem; transition: color 0.2s;"
                                onmouseover="this.style.color='#17a2b8';"
                                onmouseout="this.style.color='inherit';"><?php echo $product->productName ?></h6>
                        </a>
                        
                        <div class="mb-3 text-primary fw-bold" style="font-size: 1.1rem;">
                            <?php echo $product->htmlPrice() ?>
                        </div>

                        <button class="btn btn-outline-dark w-100 mt-auto rounded-pill fw-bold py-2" 
                                style="transition: all 0.3s;"
                                onclick="addToCart(<?php echo $product->id ?>)"
                                onmouseover="this.classList.remove('btn-outline-dark'); this.classList.add('btn-dark');"
                                onmouseout="this.classList.add('btn-outline-dark'); this.classList.remove('btn-dark');">
                            <i class="fa fa-shopping-bag me-1"></i> Order Now
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
            <div class="col-lg-custom-5 col-md-4 col-6 mb-3"> 
                 <div class="card h-100 border-0 shadow-sm rounded-3 product-card" 
                      style="transition: all 0.3s cubic-bezier(0.25, 0.8, 0.25, 1); cursor: pointer;" 
                      onmouseover="this.style.transform='translateY(-8px)'; this.classList.remove('shadow-sm'); this.classList.add('shadow-lg');" 
                      onmouseout="this.style.transform='translateY(0)'; this.classList.add('shadow-sm'); this.classList.remove('shadow-lg');"> 
                     <div class="position-relative overflow-hidden rounded-top-3"> 
                         <a href="<?php echo url('/product/' . $product->productSlug) ?>" class="d-block bg-light"> 
                             <img class="img-fluid w-100 lazyload" 
                                  src="<?php echo asset('product/thumbnail/default.jpg') ?>" 
                                  data-src="<?php echo asset('/product/thumbnail/' . $product->productImage) ?>" 
                                  alt="<?php echo $product->productName ?>" 
                                  style="height: 220px; object-fit: cover; opacity: 0.9; filter: brightness(0.95); transition: all 0.5s ease;" 
                                  onmouseover="this.style.opacity='1'; this.style.filter='brightness(1.05)'; this.style.transform='scale(1.05)';" 
                                  onmouseout="this.style.opacity='0.9'; this.style.filter='brightness(0.95)'; this.style.transform='scale(1)';"> 
                         </a> 
                         <div class="position-absolute top-0 end-0 p-2"> 
                             <button class="btn btn-light rounded-circle shadow-sm d-flex align-items-center justify-content-center" 
                                     style="width: 35px; height: 35px; transition: all 0.2s;" title="Wishlist" 
                                     onmouseover="this.classList.add('bg-danger'); this.querySelector('i').classList.remove('text-danger'); this.querySelector('i').classList.add('text-white');" 
                                     onmouseout="this.classList.remove('bg-danger'); this.querySelector('i').classList.add('text-danger'); this.querySelector('i').classList.remove('text-white');"> 
                                 <i class="far fa-heart text-danger"></i> 
                             </button> 
                         </div> 
                         
                         <div class="card-body p-3 d-flex flex-column text-center"> 
                             <a href="<?php echo url('/product/' . $product->productSlug) ?>" class="text-decoration-none text-dark mb-2"> 
                                 <h6 class="fw-bold text-truncate mb-0" style="font-size: 1rem; transition: color 0.2s;" 
                                     onmouseover="this.style.color='#17a2b8';" 
                                     onmouseout="this.style.color='inherit';"><?php echo $product->productName ?></h6> 
                             </a> 
                             
                             <div class="mb-3 text-primary fw-bold" style="font-size: 1.1rem;"> 
                                 <?php echo $product->htmlPrice() ?> 
                             </div> 
 
                             <button class="btn btn-outline-dark w-100 mt-auto rounded-pill fw-bold py-2" 
                                     style="transition: all 0.3s;" 
                                     onclick="addToCart(<?php echo $product->id ?>)" 
                                     onmouseover="this.classList.remove('btn-outline-dark'); this.classList.add('btn-dark');" 
                                     onmouseout="this.classList.add('btn-outline-dark'); this.classList.remove('btn-dark');"> 
                                 <i class="fa fa-shopping-bag me-1"></i>  অর্ডার করুন 
                             </button> 
                         </div> 
                     </div> 
                 </div>
        <?php }
    }
}
