<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Order;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\DB;

class TrackingController extends Controller
{
    public function index()
    {
        return view('website.order_tracking');
    }

    public function track(Request $request)
    {
        $request->validate([
            'invoice_id' => 'required|string|max:255',
        ]);

        $invoiceId = $request->input('invoice_id');

        $order = Order::where('invoiceID', $invoiceId)->first();

        if (!$order) {
            return redirect()
                ->back()
                ->withInput()
                ->with('error', 'No order found for this Invoice ID.');
        }

        $customer = Customer::where('order_id', $order->id)->first();

        $products = DB::table('order_products')
            ->where('order_id', $order->id)
            ->get();

        return view('website.order_tracking', [
            'order' => $order,
            'customer' => $customer,
            'products' => $products,
            'invoiceId' => $invoiceId,
        ]);
    }
}
