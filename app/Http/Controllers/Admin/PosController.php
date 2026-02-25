<?php

namespace App\Http\Controllers\Admin;

use App\City;
use App\Courier;
use App\Customer;
use App\Http\Controllers\Controller;
use App\Notification;
use App\Order;
use App\OrderProducts;
use App\Payment;
use App\PaymentType;
use App\Product;
use App\Store;
use App\User;
use App\Zone;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class PosController extends Controller
{
    public function index()
    {
        $products = Product::where('status', 'Active')->orderBy('id', 'desc')->paginate(12);
        $categories = DB::table('categories')->where('status', 'Active')->get();
        $couriers = Courier::all();
        $paymentTypes = PaymentType::where('status', 'Active')->get();
        $stores = Store::where('status', 'Active')->get();
        
        return view('admin.pos.index', compact('products', 'categories', 'couriers', 'paymentTypes', 'stores'));
    }

    public function searchProducts(Request $request)
    {
        $query = $request->get('query');
        $categoryId = $request->get('category_id');

        $products = Product::where('status', 'Active');

        if ($query) {
            $products->where(function($q) use ($query) {
                $q->where('productName', 'like', "%$query%")
                  ->orWhere('productCode', 'like', "%$query%");
            });
        }

        if ($categoryId) {
            $products->whereHas('categories', function($q) use ($categoryId) {
                $q->where('categories.id', $categoryId);
            });
        }

        $products = $products->orderBy('id', 'desc')->paginate(12);

        return view('admin.pos.product_list', compact('products'))->render();
    }

    public function store(Request $request)
    {
        try {
            DB::beginTransaction();

            $order = new Order();
            $order->invoiceID = $this->uniqueID();
            $order->store_id = $request->store_id;
            $order->subTotal = $request->subtotal;
            $order->deliveryCharge = $request->delivery_charge ?? 0;
            $order->discountCharge = $request->discount ?? 0;
            $order->payment_type_id = $request->payment_type_id;
            $order->payment_id = $request->payment_id;
            $order->paymentAmount = $request->payment_amount ?? 0;
            $order->orderDate = date('Y-m-d');
            $order->courier_id = $request->courier_id;
            $order->city_id = $request->city_id;
            $order->zone_id = $request->zone_id;
            $order->user_id = Auth::id();
            $order->status = 'Processing'; // Default status for POS
            $order->save();

            $customer = new Customer();
            $customer->order_id = $order->id;
            $customer->customerName = $request->customer_name;
            $customer->customerPhone = $request->customer_phone;
            $customer->customerAddress = $request->customer_address;
            $customer->save();

            foreach ($request->items as $item) {
                $orderProducts = new OrderProducts();
                $orderProducts->order_id = $order->id;
                $orderProducts->product_id = $item['id'];
                $orderProducts->productCode = $item['code'];
                $orderProducts->productName = $item['name'];
                $orderProducts->quantity = $item['quantity'];
                $orderProducts->productPrice = $item['price'];
                $orderProducts->save();
            }

            $notification = new Notification();
            $notification->order_id = $order->id;
            $notification->notificaton = '#POS-' . $order->id . ' Order Created via POS by ' . Auth::user()->name;
            $notification->user_id = Auth::id();
            $notification->save();

            DB::commit();
            return response()->json(['status' => 'success', 'message' => 'Order placed successfully', 'order_id' => $order->id]);

        } catch (\Exception $e) {
            DB::rollBack();
            return response()->json(['status' => 'error', 'message' => $e->getMessage()], 500);
        }
    }

    private function uniqueID()
    {
        $lastOrder = Order::orderBy('id', 'desc')->first();
        if (!$lastOrder) {
            return 'BB-1001';
        }
        return 'BB-' . ($lastOrder->id + 1001);
    }
}
