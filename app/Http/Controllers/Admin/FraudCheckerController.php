<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Http;

class FraudCheckerController extends Controller
{
    public function index(Request $request)
    {
        $phone = trim((string) $request->query('phone', ''));
        $result = null;
        $error = null;

        if ($phone !== '') {
            $baseUrl = env('FRAUDCHECK');

            if (!$baseUrl) {
                $error = 'FRAUDCHECK url is not configured in .env';
            } else {
                $url = $baseUrl . urlencode($phone);

                try {
                    $resp = Http::timeout(10)->get($url);

                    if ($resp->successful()) {
                        $result = $resp->json();
                    } else {
                        $error = 'Fraud checker API failed with status ' . $resp->status();
                    }
                } catch (\Throwable $e) {
                    $error = 'Unable to connect to fraud checker API';
                }
            }
        }

        return view('admin.fraudchecker', [
            'phone' => $phone,
            'result' => $result,
            'error' => $error,
        ]);
    }
}

