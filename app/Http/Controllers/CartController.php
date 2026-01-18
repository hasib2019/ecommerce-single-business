<?php

namespace App\Http\Controllers;

use App\Customer;
use App\Notification;
use App\Order;
use App\OrderProducts;
use App\Product;
use App\User;
use Illuminate\Http\Request;
use Gloudemans\Shoppingcart\Facades\Cart;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class CartController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Contracts\Foundation\Application|\Illuminate\Contracts\View\Factory|\Illuminate\Http\Response|\Illuminate\View\View
     */
    public function index()
    {
        session_start();
        error_reporting(0);
        if(!$_SESSION['delivery']){
            $_SESSION['delivery'] = 60;
        }

        return view('website.checkout');
    }

    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        //
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @return Request
     */
    public function store(Request $request)
    {
        $product = Product::find($request->id);
        Cart::add($product->id,$product->productName, 1, $product->price() )->associate('App\Product');
        return $request;
    }

    /**
     * Display the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function show($id)
    {
        //
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit($id)
    {
        //
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(Request $request, $id)
    {
        //
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\JsonResponse
     */
    public function destroy($id)
    {
        Cart::remove($id);
        $response['reload'] = 'true';
        if (Cart::count() > 0 ){
            $response['reload'] = 'false';
        }
        $response['status'] = 'success';
        $response['message'] = 'Successfully Add Product';
        return response()->json($response, 201);
    }

    public function mini_cart()
    {
        $response['count'] = Cart::count();
        $response['data'] = Cart::content();
        return response()->json($response, 200);
    }
    public function miniCart()
    {
        $total = Cart::subtotal('0','','');
        $count = Cart::count();
        $content = Cart::content();
        ?>
        <!-- Floating Button -->
        <div class="floating-cart-btn" onclick="toggleCartDrawer()">
            <i class="fa fa-shopping-cart"></i>
            <span class="cart-total">TK <?php echo $total; ?></span>
            <span class="cart-count"><?php echo $count; ?> Items</span>
        </div>

        <!-- Drawer -->
        <div class="cart-drawer" id="cartDrawer">
            <div class="drawer-header">
                <h5 class="mb-0">Shopping Cart <span class="badge badge-danger rounded-pill ml-2"><?php echo $count; ?></span></h5>
                <button type="button" onclick="toggleCartDrawer()" style="background: none; border: none; font-size: 24px; color: #333;">&times;</button>
            </div>
            <div class="drawer-body">
                <?php if($count > 0) { ?>
                    <?php foreach($content as $item) { ?>
                        <div class="dc-item">
                            <div class="dc-image">
                                <a href="<?php echo url('/product/'.$item->model->productSlug) ;?>">
                                    <img src="<?php echo url('/product/thumbnail/'.$item->model->productImage)?>" alt="">
                                </a>
                            </div>
                            <div class="dc-content">
                                <a href="<?php echo url('/product/'.$item->model->productSlug) ;?>" class="d-block text-dark mb-1" style="font-size: 14px; font-weight: 600;">
                                    <?php echo $item->model->productName ?>
                                </a>
                                <div class="text-muted" style="font-size: 13px;">
                                    <?php echo $item->qty ?> x TK <?php echo $item->model->price() ?>
                                </div>
                            </div>
                            <div class="dc-actions">
                                <button onclick="removeFromCart('<?php echo $item->rowId; ?>')">
                                    <i class="fa fa-times"></i>
                                </button>
                            </div>
                        </div>
                    <?php } ?>
                <?php } else { ?>
                    <div class="text-center py-5">
                        <i class="fa fa-shopping-basket fa-3x text-muted mb-3"></i>
                        <p class="text-muted">Your cart is empty</p>
                        <p class="small text-muted">Add items to get started</p>
                    </div>
                <?php } ?>
            </div>
            <div class="drawer-footer">
                <div class="d-flex justify-content-between mb-3">
                    <span class="text-muted">Subtotal:</span>
                    <strong class="text-dark">TK <?php echo $total; ?></strong>
                </div>
                <div class="d-grid gap-2">
                    <a href="<?php echo url('/checkout'); ?>" class="btn btn-dark btn-block">Place Order</a>
                    <a href="<?php echo url('/shop'); ?>" class="btn btn-outline-dark btn-block mt-2">Continue Shopping</a>
                </div>
            </div>
        </div>
        <?php
    }

    public function updateQuantity(Request $request)
    {
        session_start();
        if($request->quantity > 0){
            Cart::update($request->key, $request->quantity);
        }
        ?>
        <aside class="card">
            <article class="card-body">
                <header class="mb-4">
                    <h4 class="card-title" style="font-size: 16px;">আপনার অর্ডার</h4>
                </header>
                <div class="row">
                    <div class="table-responsive bg-white">
                        <table class="table border-bottom">
                            <thead>
                            <tr>
                                <th class="product-image">Image</th>
                                <th class="product-name">Product</th>
                                <th class="product-price">Price</th>
                                <th class="product-quanity">Quantity</th>
                                <th class="product-total">Total</th>
                            </tr>
                            </thead>
                            <tbody>
                            <?php foreach(Cart::content() as $item) {  ?>
                                <tr class="cart-item">
                                    <td class="product-image" style="display: flex; flex-direction: row-reverse;">
                                        <a href="#" >
                                            <img class="lazyload" src="<?php echo url('/product/thumbnail/'.$item->model->productImage) ?>" style="max-width: 50px">
                                        </a>
                                        <button href="#"  onclick="removeFromCart('<?php echo $item->rowId ?>')" class="btn btn-danger btn-sm">
                                            <i class="fa fa-trash"></i>
                                        </button>
                                    </td>

                                    <td class="product-name">
                                        <span class="d-block"><?php echo $item->model->productName ?></span>
                                    </td>

                                    <td class="product-price">
                                        <span class="d-block">TK <?php echo $item->model->price() ?></span>
                                    </td>

                                    <td class="product-quantity">
                                        <div class="input-group input-spinner">
                                            <div class="input-group-prepend">
                                                <button class="btn btn-light btn-number" type="button" data-type="plus" data-field="quantity[<?php echo $item->id ?>]"> + </button>
                                            </div>
                                            <input type="text" name="quantity[<?php echo $item->id ?>]" class="form-control input-number" placeholder="1" value="<?php echo $item->qty ?>" min="1" max="10" onchange="updateQuantity('<?php echo $item->rowId ?>', this)">
                                            <div class="input-group-append">
                                                <button class="btn btn-light btn-number" type="button" data-type="minus"  data-field="quantity[<?php echo $item->id ?>]"> − </button>
                                            </div>
                                        </div>
                                    </td>
                                    <td class="product-total">
                                        <span>TK <?php echo Cart::subtotal('0','','')?></span>
                                    </td>

                                </tr>
                            <?php } ?>
                            </tbody>
                        </table>
                    </div>
                </div>
            </article>
            <article class="card-body border-top">
                <dl class="row">
                    <dt class="col-sm-8">Subtotal: </dt>
                    <dd class="col-sm-4 text-right"><strong>TK <?php echo Cart::total('0') ?></strong></dd>

                    <dt class="col-sm-8">Delivery charge: </dt>
                    <dd class="col-sm-4 text-danger text-right"><strong>TK <?php echo $_SESSION['delivery'] ?></strong></dd>

                    <dt class="col-sm-8">Total:</dt>
                    <dd class="col-sm-4 text-right"><strong class="h5 text-dark">TK <?php echo Cart::subtotal('0','','')+$_SESSION['delivery']; ?></strong></dd>
                </dl>

            </article>
            <script type="text/javascript">
                cartQuantityInitialize();
            </script>

        </aside>
    <?php }

    public function updateDeliveryCharge(Request $request)
    {
        session_start();
        $_SESSION['delivery'] = $request->selectCourier;

    }

    public function placeOrder(Request $request)
    {

        $user = DB::table('users')->where([
            ['status', 'like', 'Active'],
            ['role_id', '=', '3']
        ])->inRandomOrder()->first();
        if (!$user) {
            $user = User::find(1);
        }
        $order = new Order();



        $order->invoiceID = $this->uniqueID();
        $order->store_id = 1;
        $order->deliveryCharge = $request->selectCourier;
        $order->orderDate = date('Y-m-d');
        $order->subTotal = Cart::subtotal('0','','')+$request->selectCourier;
        $order->user_id = $user->id;
        $order->save();
        if($order->id){
            $customer = new Customer();
            $customer->order_id = $order->id;
            $customer->customerName = $request->customerName;
            $customer->customerPhone = $request->customerAddress;
            $customer->customerAddress = $request->customerPhone;
            $customer->save();
            foreach(Cart::content() as $item) {

                $orderProducts = new OrderProducts();
                $orderProducts->order_id = $order->id;
                $orderProducts->product_id = $item->model->id;
                $orderProducts->productCode = $item->model->productCode;
                $orderProducts->productName = $item->model->productName;
                $orderProducts->quantity = $item->qty;
                $orderProducts->productPrice = $item->model->price();
                $orderProducts->save();

                $response['link'] = url('/checkout/order-received/'.$order->id);
                $response['status'] = 'success';
                $response['message'] = 'Successfully Placed Order';
            }
            $notification = new Notification();
            $notification->order_id = $order->id;
            $notification->notificaton = '#SD' . $order->id . ' Order Has Been Created by ' . $user->name;
            $notification->user_id = $user->id;
            $notification->save();
        } else{
            Customer::where('order_id', '=', $order->id)->delete();
            OrderProducts::where('order_id', '=', $order->id)->delete();
            Notification::where('order_id', '=', $order->id)->delete();
            Order::where('id', '=', $order->id)->delete();
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Add Order';
            $response['status'] = 'failed';
            $response['message'] = 'Unsuccessful to Placed Order';
        }
        Cart::destroy();
        return response()->json($response, 201);
    }

    public function orderRecived()
    {
        return view('website.thankyou');

    }
    public function uniqueID()
    {
        $lastOrder = Order::latest('id')->first();
        if ($lastOrder) {
            $orderID = $lastOrder->id + 1;
        } else {
            $orderID = 1;
        }

        return 'BB-' . $orderID;
    }
}
