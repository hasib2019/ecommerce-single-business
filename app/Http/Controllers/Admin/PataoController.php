<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\File;
use Illuminate\Support\Facades\Http;
use Illuminate\Support\Facades\Schema;
use App\Order;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Auth;
use App\Courier;
use App\Notification;
use Yajra\Datatables\DataTables;

class PataoController extends Controller
{
    public function setup()
    {
        $data = [
            'base_url' => env('PATA0_BASE_URL'),
            'client_id' => env('PATA0_CLIENT_ID'),
            'client_secret' => env('PATA0_CLIENT_SECRET'),
            'username' => env('PATA0_USERNAME'),
            'password' => env('PATA0_PASSWORD'),
            'grant_type' => env('PATA0_GRANT_TYPE'),
            'access_token' => env('PATA0_ACCESS_TOKEN'),
            'refresh_token' => env('PATA0_REFRESH_TOKEN'),
            'token_type' => env('PATA0_TOKEN_TYPE'),
            'expires_in' => env('PATA0_EXPIRES_IN'),
        ];

        return view('admin.patao.setup', compact('data'));
    }

    public function setupSave(Request $request)
    {
        $validated = $request->validate([
            'base_url' => ['required', 'string'],
            'client_id' => ['required', 'string'],
            'client_secret' => ['required', 'string'],
            'username' => ['required', 'string'],
            'password' => ['required', 'string'],
            'grant_type' => ['required', 'string'],
        ]);

        $pairs = [
            'PATA0_BASE_URL' => $validated['base_url'],
            'PATA0_CLIENT_ID' => $validated['client_id'],
            'PATA0_CLIENT_SECRET' => $validated['client_secret'],
            'PATA0_USERNAME' => $validated['username'],
            'PATA0_PASSWORD' => $validated['password'],
            'PATA0_GRANT_TYPE' => $validated['grant_type'],
        ];

        $this->writeEnv($pairs);

        return redirect()->back()->with('success', 'Patao sandbox credentials saved to .env');
    }

    public function orderWithPatao()
    {
        // Placeholder view for order integration
        return view('admin.patao.order_with_patao');
    }

    public function checkAndSync(Request $request)
    {
        $baseUrl = env('PATA0_BASE_URL');
        $clientId = env('PATA0_CLIENT_ID');
        $clientSecret = env('PATA0_CLIENT_SECRET');
        $grantType = env('PATA0_GRANT_TYPE', 'password');
        $username = env('PATA0_USERNAME');
        $password = env('PATA0_PASSWORD');

        if (!$baseUrl || !$clientId || !$clientSecret || !$username || !$password) {
            return response()->json(['ok' => false, 'message' => 'Missing credentials in .env'], 400);
        }

        $url = rtrim($baseUrl, '/') . '/aladdin/api/v1/issue-token';

        try {
            $resp = Http::asJson()->post($url, [
                'client_id' => $clientId,
                'client_secret' => $clientSecret,
                'grant_type' => $grantType ?: 'password',
                'username' => $username,
                'password' => $password,
            ]);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => 'Request failed', 'error' => $e->getMessage()], 500);
        }
        if ($resp->successful()) {
            $json = $resp->json();

            $pairs = [];
            if (isset($json['access_token'])) {
                $pairs['PATA0_ACCESS_TOKEN'] = $json['access_token'];
            }
            if (isset($json['refresh_token'])) {
                $pairs['PATA0_REFRESH_TOKEN'] = $json['refresh_token'];
            }
            if (isset($json['token_type'])) {
                $pairs['PATA0_TOKEN_TYPE'] = $json['token_type'];
            }
            if (isset($json['expires_in'])) {
                $pairs['PATA0_EXPIRES_IN'] = (string)$json['expires_in'];
            }

            if (!empty($pairs)) {
                $this->writeEnv($pairs);
            }

            return response()->json([
                'ok' => true,
                'status' => $resp->status(),
                'data' => $json,
            ], 200);
        }

        return response()->json([
            'ok' => false,
            'status' => $resp->status(),
            'body' => $resp->body(),
        ], $resp->status());
    }

    private function writeEnv(array $data): void
    {
        $envPath = base_path('.env');
        $content = File::exists($envPath) ? File::get($envPath) : '';

        foreach ($data as $key => $value) {
            $value = $this->escapeEnvValue($value);
            $pattern = "/^" . preg_quote($key, '/') . "=.*/m";
            if (preg_match($pattern, $content)) {
                $content = preg_replace($pattern, $key . '=' . $value, $content);
            } else {
                $content .= (str_ends_with($content, "\n") ? '' : "\n") . $key . '=' . $value . "\n";
            }
        }

        File::put($envPath, $content);
    }

    private function escapeEnvValue(string $value): string
    {
        // Wrap in quotes if it contains spaces or special chars
        if (preg_match('/\s|#|=|\\"|\\n/', $value)) {
            $escaped = str_replace(['\\', '"'], ['\\\\', '\\"'], $value);
            return '"' . $escaped . '"';
        }
        return $value;
    }

    public function stores(Request $request)
    {
        $baseUrl = env('PATA0_BASE_URL');
        $accessToken = env('PATA0_ACCESS_TOKEN');

        if (!$baseUrl || !$accessToken) {
            return response()->json(['ok' => false, 'message' => 'Missing base URL or access token'], 400);
        }

        $url = rtrim($baseUrl, '/') . '/aladdin/api/v1/stores';

        try {
            $resp = Http::withHeaders([
                'Content-Type' => 'application/json; charset=UTF-8',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->get($url);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => 'Request failed', 'error' => $e->getMessage()], 500);
        }

        if ($resp->successful()) {
            $json = $resp->json();
            return response()->json([
                'ok' => true,
                'status' => $resp->status(),
                'data' => $json,
            ], 200);
        }
    }

    public function createOrder(Request $request)
    {
        $baseUrl = env('PATA0_BASE_URL');
        $accessToken = env('PATA0_ACCESS_TOKEN');

        if (!$baseUrl || !$accessToken) {
            return response()->json(['ok' => false, 'message' => 'Missing base URL or access token'], 400);
        }

        $url = rtrim($baseUrl, '/') . '/aladdin/api/v1/orders';

        $payload = [
            'store_id' => $request->input('store_id'),
            'merchant_order_id' => $request->input('order_id'),
            'recipient_name' => $request->input('recipient_name'),
            'recipient_phone' => $request->input('recipient_phone'),
            'recipient_address' => $request->input('recipient_address'),
            'delivery_type' => $request->input('delivery_type'),
            'item_type' => $request->input('item_type'),
            'special_instruction' => $request->input('special_instruction'),
            'item_quantity' => $request->input('item_quantity'),
            'item_weight' => $request->input('item_weight'),
            'item_description' => $request->input('item_description'),
            'amount_to_collect' => $request->input('amount_to_collect'),
        ];

        try {
            $resp = Http::withHeaders([
                'Content-Type' => 'application/json; charset=UTF-8',
                'Authorization' => 'Bearer ' . $accessToken,
            ])->asJson()->post($url, $payload);
        } catch (\Throwable $e) {
            return response()->json(['ok' => false, 'message' => 'Request failed', 'error' => $e->getMessage()], 500);
        }

        if ($resp->successful()) {
            $response = $resp->json();
            $data = is_array($response) && isset($response['data']) ? $response['data'] : $response;

            $orderId = $request->input('order_id');
            if ($orderId) {
                $order = Order::find($orderId);
                if ($order) {
                    // Directly update requested columns
                    $updates = [
                        'paymentAmount' => (int) $request->input('amount_to_collect'),
                        'status' => $data['order_status'],
                        'courier_name' => 'patao',
                        'courier_store_id' => $request->input('store_id'),
                        'consignment_id' => $data['consignment_id'] ?? null,
                        'merchant_order_id' => $data['merchant_order_id'] ?? null,
                        'order_status' => $data['order_status'] ?? null,
                        'courier_delivery_fee' => $data['delivery_fee'] ?? null,
                        'memo' => 'patao-' . $data['merchant_order_id'],
                    ];
                    $order->update($updates);
                }
            }

            return response()->json(['ok' => true, 'data' => $response], 200);
        }

        return response()->json(['ok' => false, 'status' => $resp->status(), 'body' => $resp->body()], $resp->status());
    }


    public function orderStatus(Request $request)
    {
        // Map simple query values to existing order status labels
        $raw = strtolower($request->query('status', 'pending'));
        $status = $raw === 'pending' ? 'Pending' : 'Processing';
        return view('admin.patao.order_status', compact('status'));
    }

    public function show(Request $request)
    {
        $columns = $request->input('columns');
        // Force Pending only, per requirement
        $status = 'Pending';
        $orders = DB::table('orders')
            ->leftJoin('customers', 'orders.id', '=', 'customers.order_id')
            ->leftJoin('users', 'orders.user_id', '=', 'users.id')
            ->leftJoin('cities', 'orders.city_id', '=', 'cities.id')
            ->leftJoin('zones', 'orders.zone_id', '=', 'zones.id')
            ->leftJoin('couriers', 'orders.courier_id', '=', 'couriers.id')
            ->select('orders.*', 'customers.customerName', 'customers.customerPhone', 'customers.customerAddress', 'couriers.courierName', 'cities.cityName', 'zones.zoneName', 'users.name');
        // Only Pending orders
        $orders = $orders->where('orders.status', '=', 'Pending');

        // Column-specific filters (keep indexes aligned with view)
        if (isset($columns[1]['search']['value']) && $columns[1]['search']['value']) {
            $orders = $orders->Where('orders.invoiceID', 'like', "%{$columns[1]['search']['value']}%")
                ->orWhere('orders.web_ID', 'like', "%{$columns[1]['search']['value']}%");
        }
        if (isset($columns[2]['search']['value']) && $columns[2]['search']['value']) {
            $orders = $orders->Where('customers.customerPhone', 'like', "%{$columns[2]['search']['value']}%");
        }
        if (isset($columns[5]['search']['value']) && $columns[5]['search']['value']) {
            $orders = $orders->Where('orders.courier_id', '=', $columns[5]['search']['value']);
        }
        if (isset($columns[6]['search']['value']) && $columns[6]['search']['value']) {
            $orders = $orders->Where('orders.orderDate', 'like', "%{$columns[6]['search']['value']}%");
        }
        if (isset($columns[8]['search']['value']) && $columns[8]['search']['value']) {
            $orders = $orders->Where('orders.memo', 'like', "%{$columns[8]['search']['value']}%");
        }
        if (isset($columns[9]['search']['value']) && $columns[9]['search']['value']) {
            $orders = $orders->Where('orders.user_id', '=', $columns[9]['search']['value']);
        }

        // Use orderBy for broad Laravel compatibility (avoids Query Builder latest() issues)
        return DataTables::of($orders->orderBy('orders.id', 'desc'))
            ->addColumn('customerInfo', function ($orders) {
                return $orders->customerName . '<br>' . $orders->customerPhone . '<br>' . $orders->customerAddress;
            })
            ->addColumn('invoice', function ($orders) {
                return $orders->invoiceID . '<br>' . $orders->web_ID;
            })
            ->addColumn('products', function ($orders) {
                return app(\App\Http\Controllers\Admin\OrderController::class)->getProductsDetails($orders->id);
            })
            ->addColumn('notification', function ($orders) {
                return app(\App\Http\Controllers\Admin\OrderController::class)->getNotificationDetails($orders->id);
            })
            ->addColumn('action', function ($orders) {
                if (Auth::user() && Auth::user()->role_id < 2) {
                    return "<a href='javascript:void(0);' data-id='" . $orders->id . "' class='action-icon btn-edit'> <i class='fas fa-1x fa-edit'></i></a>
                <a href='javascript:void(0);' data-id='" . $orders->id . "' class='action-icon btn-delete'> <i class='fas fa-trash-alt'></i></a>";
                } else {
                    return "<a href='javascript:void(0);' data-id='" . $orders->id . "' class='action-icon btn-edit'> <i class='fas fa-1x fa-edit'></i></a>";
                }
            })
            ->addColumn('statusButton', function ($orders) {
                return app(\App\Http\Controllers\Admin\OrderController::class)->statusList($orders->status, $orders->id);
            })
            ->editColumn('courierName', function ($orders) {
                if ($orders->courierName) {
                    return $orders->courierName;
                } else {
                    return 'Not Selected';
                }
            })
            ->escapeColumns([])->make();
    }
}
