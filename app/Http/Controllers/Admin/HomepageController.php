<?php

namespace App\Http\Controllers\Admin;

use App\Category;
use App\HomepageItem;
use App\Http\Controllers\Controller;
use App\Product;
use App\Setting;
use Carbon\Carbon;
use Illuminate\Http\Request;

class HomepageController extends Controller
{
    /**
     * Display the homepage settings management page.
     */
    public function index()
    {
        $categories = Category::where('status', 'Active')->orderBy('categoryName')->get();
        $products   = Product::orderBy('productName')->get(['id', 'productName', 'productImage']);

        $sections = HomepageItem::sectionLabels();

        // Load existing items grouped by section
        $items = HomepageItem::orderBy('sort_order')->get()->groupBy('section');

        // Load existing sliders
        $sliders = \App\Slider::where('status', 'Active')->orderBy('id')->get();

        return view('admin.homepage.index', compact('categories', 'products', 'sections', 'items', 'sliders'));
    }

    /**
     * Return DataTables JSON for a given section.
     */
    public function sectionData(Request $request)
    {
        $section = $request->get('section');
        $query   = HomepageItem::where('section', $section)->latest();

        return datatables()->of($query)
            ->addColumn('image_preview', function (HomepageItem $item) {
                if ($item->image) {
                    return '<img src="' . asset('product/thumbnail/' . $item->image) . '" class="img-fluid rounded" style="max-height:60px;" onerror="this.onerror=null;this.src=\'' . asset('product/thumbnail/default.jpg') . '\'">';
                }
                return '<span class="text-muted">—</span>';
            })
            ->addColumn('status_btn', function (HomepageItem $item) {
                if ($item->status === 'Active') {
                    return "<button class='btn btn-success btn-xs btn-toggle-status' data-id='{$item->id}' data-status='Inactive'>Active</button>";
                }
                return "<button class='btn btn-warning btn-xs btn-toggle-status' data-id='{$item->id}' data-status='Active'>Inactive</button>";
            })
            ->addColumn('actions', function (HomepageItem $item) {
                return "<button class='btn btn-sm btn-primary btn-edit-item me-1' data-id='{$item->id}'><i class='fas fa-edit'></i></button>
                        <button class='btn btn-sm btn-danger btn-delete-item' data-id='{$item->id}'><i class='fas fa-trash'></i></button>";
            })
            ->editColumn('countdown_end', function (HomepageItem $item) {
                return $item->countdown_end ? $item->countdown_end->format('Y-m-d H:i') : '—';
            })
            ->rawColumns(['image_preview', 'status_btn', 'actions'])
            ->toJson();
    }

    /**
     * Store a new homepage item.
     */
    public function store(Request $request)
    {
        $request->validate([
            'section' => 'required|string|max:50',
        ]);

        $item             = new HomepageItem();
        $item->section    = $request->section;
        $item->title      = $request->title;
        $item->image      = $request->image;
        $item->link       = $request->link;
        $item->description = $request->description;
        $item->coupon_code = $request->coupon_code;
        $item->product_id  = $request->product_id ?: null;
        $item->category_id = $request->category_id ?: null;
        $item->sort_order  = (int) ($request->sort_order ?? 0);
        $item->status      = $request->status ?? 'Active';

        if ($request->countdown_end) {
            $item->countdown_end = Carbon::parse($request->countdown_end);
        }

        if ($item->save()) {
            return response()->json(['status' => 'success', 'message' => 'Item added successfully.', 'item' => $item], 201);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to add item.'], 500);
    }

    /**
     * Return a single item for editing.
     */
    public function show($id)
    {
        $item = HomepageItem::findOrFail($id);
        return response()->json($item);
    }

    /**
     * Update an existing homepage item.
     */
    public function update(Request $request, $id)
    {
        $item = HomepageItem::findOrFail($id);

        $item->title       = $request->title;
        $item->image       = $request->image ?? $item->image;
        $item->link        = $request->link;
        $item->description = $request->description;
        $item->coupon_code = $request->coupon_code;
        $item->product_id  = $request->product_id ?: null;
        $item->category_id = $request->category_id ?: null;
        $item->sort_order  = (int) ($request->sort_order ?? $item->sort_order);
        $item->status      = $request->status ?? $item->status;

        if ($request->countdown_end) {
            $item->countdown_end = Carbon::parse($request->countdown_end);
        }

        if ($item->save()) {
            return response()->json(['status' => 'success', 'message' => 'Item updated successfully.', 'item' => $item]);
        }

        return response()->json(['status' => 'error', 'message' => 'Failed to update item.'], 500);
    }

    /**
     * Delete a homepage item.
     */
    public function destroy($id)
    {
        $item = HomepageItem::findOrFail($id);
        if ($item->delete()) {
            return response()->json(['status' => 'success', 'message' => 'Item deleted.']);
        }
        return response()->json(['status' => 'error', 'message' => 'Failed to delete item.'], 500);
    }

    /**
     * Toggle active/inactive status.
     */
    public function toggleStatus(Request $request)
    {
        $item = HomepageItem::findOrFail($request->id);
        $item->status = $request->status;
        $item->save();
        return response()->json(['status' => 'success']);
    }

    /**
     * Update sort order for multiple items (drag & drop reorder).
     */
    public function reorder(Request $request)
    {
        $order = $request->order ?? [];
        foreach ($order as $pos => $id) {
            HomepageItem::where('id', $id)->update(['sort_order' => $pos]);
        }
        return response()->json(['status' => 'success']);
    }

    public function saveTodayDeal(Request $request)
    {
        $lang = $request->input('lang', 'en');
        Setting::set("today_deal_large_{$lang}", $request->input('large_banner', ''));
        Setting::set("today_deal_small_{$lang}", $request->input('small_banner', ''));
        return response()->json(['status' => 'success', 'message' => "Today's Deal saved."]);
    }

    public function saveBanner(Request $request)
    {
        $section = $request->input('section', '');
        $lang    = $request->input('lang', 'en');
        Setting::set("{$section}_large_{$lang}", $request->input('large_banner', ''));
        Setting::set("{$section}_small_{$lang}", $request->input('small_banner', ''));
        return response()->json(['status' => 'success', 'message' => 'Banner saved.']);
    }

    public function saveSliders(Request $request)
    {
        $slides = $request->input('slides', []);
        \App\Slider::truncate();
        foreach ($slides as $i => $slide) {
            if (empty($slide['image'])) {
                continue;
            }
            \App\Slider::create([
                'name'   => $slide['name'] ?? 'Slide ' . ($i + 1),
                'image'  => $slide['image'],
                'link'   => $slide['url'] ?? '#',
                'status' => 'Active',
            ]);
        }
        return response()->json(['status' => 'success', 'message' => 'Sliders saved.']);
    }
}
