@extends('layouts.app')

@section('content')
    <div class="row">
        <div class="col-12">
            <div class="page-title-box">
                <h4 class="page-title">Fraud Checker</h4>
            </div>
        </div>
    </div>

    <div class="row">
        <div class="col-lg-6">
            <div class="card-box">
                <h4 class="header-title mb-3">Search by phone number</h4>

                <form method="get" action="{{ route('admin.fraudchecker') }}">
                    <div class="form-group mb-3">
                        <label for="phone">Phone number</label>
                        <div class="input-group">
                            <input type="text"
                                   id="phone"
                                   name="phone"
                                   class="form-control"
                                   placeholder="017XXXXXXXX"
                                   value="{{ $phone }}">
                            <div class="input-group-append">
                                <button class="btn btn-primary" type="submit">
                                    Check
                                </button>
                            </div>
                        </div>
                    </div>
                </form>
            </div>
        </div>

        @if($phone !== '')
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title mb-3">Search summary</h4>
                    <p class="mb-1"><strong>Phone:</strong> {{ $phone }}</p>

                    @if($error)
                        <span class="badge badge-danger mt-2">{{ $error }}</span>
                    @elseif($result === null)
                        <span class="badge badge-warning mt-2">No data found for this phone</span>
                    @else
                        @php
                            $summary = is_array($result) && isset($result['data']) ? $result['data'] : (is_array($result) ? $result : []);
                            $badgeClass = 'badge-secondary';
                            if (!empty($summary['riskColor'])) {
                                $badgeClass = 'badge-' . $summary['riskColor'];
                            }
                            $riskBgClass = '';
                            if (!empty($summary['riskColor'])) {
                                if ($summary['riskColor'] === 'success') {
                                    $riskBgClass = 'bg-soft-success';
                                } elseif ($summary['riskColor'] === 'warning') {
                                    $riskBgClass = 'bg-soft-warning';
                                } elseif ($summary['riskColor'] === 'danger') {
                                    $riskBgClass = 'bg-soft-danger';
                                }
                            }
                        @endphp

                        @if(is_array($summary))
                            @php
                                $heroGradient = 'linear-gradient(135deg,#4fc6e1,#6c63ff)';
                                if (!empty($summary['riskColor'])) {
                                    if ($summary['riskColor'] === 'success') {
                                        $heroGradient = 'linear-gradient(135deg,#0acf97,#4fc6e1)';
                                    } elseif ($summary['riskColor'] === 'warning') {
                                        $heroGradient = 'linear-gradient(135deg,#ffbc00,#ff7f50)';
                                    } elseif ($summary['riskColor'] === 'danger') {
                                        $heroGradient = 'linear-gradient(135deg,#f1556c,#ff6a88)';
                                    }
                                }
                            @endphp

                            <div style="border-radius:10px;padding:16px 18px;background: {{ $heroGradient }};">
                                <div class="row align-items-center">
                                    <div class="col-sm-6">
                                        <div class="d-flex align-items-center mb-2">
                                            @if(!empty($summary['riskLevel']))
                                                <span class="badge badge-pill {{ $badgeClass }} mr-2" style="background-color: rgba(255,255,255,0.16);border:1px solid rgba(255,255,255,0.4);color:#fff;">
                                                    {{ strtoupper($summary['riskLevel']) }}
                                                </span>
                                            @endif
                                            @if(isset($summary['deliveryRate']))
                                                <span style="font-size:13px;color:#fefefe;">
                                                    {{ $summary['deliveryRate'] }}% success rate
                                                </span>
                                            @endif
                                        </div>
                                        @if(!empty($summary['riskMessage']))
                                            <p class="mb-2" style="color:#fefefe;">{{ $summary['riskMessage'] }}</p>
                                        @endif
                                        <p class="mb-1" style="font-size:13px;color:#fefefe;">
                                            Phone: <strong>{{ $summary['phoneNumber'] ?? $phone }}</strong>
                                        </p>
                                        @if(isset($summary['searchDate']))
                                            <p class="mb-0" style="font-size:12px;color:rgba(255,255,255,0.85);">
                                                Last checked: {{ $summary['searchDate'] }}
                                            </p>
                                        @endif
                                    </div>
                                    <div class="col-sm-6 text-sm-right text-center mt-3 mt-sm-0">
                                        <div style="display:inline-block;padding:10px 14px;border-radius:10px;background:rgba(255,255,255,0.12);">
                                            <div class="d-flex">
                                                <div class="pr-3 border-right" style="border-color:rgba(255,255,255,0.25)!important;">
                                                    <div style="font-size:11px;color:#e5f9ff;">Total</div>
                                                    <div style="font-size:18px;font-weight:600;color:#ffffff;">
                                                        {{ $summary['totalOrders'] ?? 0 }}
                                                    </div>
                                                </div>
                                                <div class="px-3 border-right" style="border-color:rgba(255,255,255,0.25)!important;">
                                                    <div style="font-size:11px;color:#e5f9ff;">Delivered</div>
                                                    <div style="font-size:18px;font-weight:600;color:#ffffff;">
                                                        {{ $summary['totalDelivered'] ?? 0 }}
                                                    </div>
                                                </div>
                                                <div class="pl-3">
                                                    <div style="font-size:11px;color:#e5f9ff;">Cancelled</div>
                                                    <div style="font-size:18px;font-weight:600;color:#ffffff;">
                                                        {{ $summary['totalCancelled'] ?? 0 }}
                                                    </div>
                                                </div>
                                            </div>
                                        </div>
                                    </div>
                                </div>
                            </div>
                        @endif
                    @endif
                </div>
            </div>
        @endif
    </div>

    @if($phone !== '' && $result && !$error)
        @php
            $data = is_array($result) && isset($result['data']) && is_array($result['data']) ? $result['data'] : (is_array($result) ? $result : []);
            $couriers = isset($data['couriers']) && is_array($data['couriers']) ? $data['couriers'] : [];
            $reports = isset($data['reports']) && is_array($data['reports']) ? $data['reports'] : [];
            $totalOrders = (int) ($data['totalOrders'] ?? 0);
            $totalDelivered = (int) ($data['totalDelivered'] ?? 0);
            $totalCancelled = (int) ($data['totalCancelled'] ?? 0);
            $successRate = isset($data['deliveryRate']) ? (float) $data['deliveryRate'] : ($totalOrders > 0 ? round(($totalDelivered / $totalOrders) * 100, 2) : 0);
            $returnRate = $totalOrders > 0 ? round(($totalCancelled / $totalOrders) * 100, 2) : 0;
            $riskLabel = !empty($data['riskLevel']) ? ucfirst($data['riskLevel']) : null;
            $riskColor = $data['riskColor'] ?? 'secondary';
        @endphp

        <div class="row">
            <div class="col-md-3">
                <div class="card-box text-center" style="border-radius:10px;border:0;background:linear-gradient(135deg,#0acf97,#4fc6e1);color:#fff;">
                    <div style="font-size:13px;opacity:0.9;">Success rate</div>
                    <div style="font-size:28px;font-weight:600;">{{ $successRate }}%</div>
                    <div style="font-size:11px;opacity:0.85;">Delivery performance</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box text-center" style="border-radius:10px;border:1px solid #e3f2fd;background:#f5fbff;">
                    <div style="font-size:13px;color:#1c4f93;">Total orders</div>
                    <div style="font-size:24px;font-weight:600;color:#12344d;">{{ $totalOrders }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box text-center" style="border-radius:10px;border:1px solid #e6ffed;background:#f2fff7;">
                    <div style="font-size:13px;color:#0f5132;">Delivered</div>
                    <div style="font-size:24px;font-weight:600;color:#0b3b24;">{{ $totalDelivered }}</div>
                </div>
            </div>
            <div class="col-md-3">
                <div class="card-box text-center" style="border-radius:10px;border:1px solid #ffe0e0;background:#fff6f6;">
                    <div style="font-size:13px;color:#842029;">Cancelled</div>
                    <div style="font-size:24px;font-weight:600;color:#842029;">{{ $totalCancelled }}</div>
                </div>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title mb-3">Customer risk overview</h4>
                    <div class="row align-items-center">
                        <div class="col-sm-6 text-center mb-3 mb-sm-0">
                            <div style="width:150px;height:150px;border-radius:50%;margin:0 auto;background:
                                    radial-gradient(circle at center,#ffffff 55%,transparent 56%),
                                    conic-gradient(
                                        {{ $riskColor === 'success' ? '#0acf97' : ($riskColor === 'warning' ? '#ffbc00' : ($riskColor === 'danger' ? '#f1556c' : '#4fc6e1')) }} {{ max($successRate,0) }}%,
                                        #f1f5f9 {{ max($successRate,0) }}%
                                    );display:flex;align-items:center;justify-content:center;">
                                <div>
                                    <div style="font-size:12px;color:#6c757d;">Delivery score</div>
                                    <div style="font-size:26px;font-weight:600;color:#323a46;">{{ $successRate }}%</div>
                                </div>
                            </div>
                            @if($riskLabel)
                                <div class="mt-2">
                                    <span class="badge badge-pill badge-{{ $riskColor }} px-3 py-1">
                                        {{ $riskLabel }}
                                    </span>
                                </div>
                            @endif
                        </div>
                        <div class="col-sm-6">
                            <ul class="list-unstyled mb-0" style="font-size:13px;">
                                <li class="mb-2 d-flex align-items-center">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#0acf97;margin-right:8px;"></span>
                                    <span><strong>{{ $totalDelivered }}</strong> successful deliveries</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#f1556c;margin-right:8px;"></span>
                                    <span><strong>{{ $totalCancelled }}</strong> cancelled orders</span>
                                </li>
                                <li class="mb-2 d-flex align-items-center">
                                    <span style="width:8px;height:8px;border-radius:50%;background:#4fc6e1;margin-right:8px;"></span>
                                    <span>Return ratio: <strong>{{ $returnRate }}%</strong></span>
                                </li>
                                @if(!empty($data['riskMessage']))
                                    <li class="mt-2" style="color:#6c757d;">
                                        {{ $data['riskMessage'] }}
                                    </li>
                                @endif
                            </ul>
                        </div>
                    </div>
                </div>
            </div>

            <div class="col-lg-6">
                <div class="card-box">
                    <h4 class="header-title mb-3">Courier wise performance</h4>
                    @forelse($couriers as $row)
                        @php
                            $rateText = $row['delivery_rate'] ?? '0%';
                        @endphp
                        <div class="mb-3">
                            <div class="d-flex justify-content-between align-items-center mb-1">
                                <span style="font-size:13px;font-weight:500;">{{ $row['name'] ?? '-' }}</span>
                                <span style="font-size:12px;color:#6c757d;">{{ $rateText }}</span>
                            </div>
                            <div style="height:8px;border-radius:999px;background:#f1f5f9;overflow:hidden;">
                                <div style="height:100%;width:{{ $rateText }};background:linear-gradient(90deg,#0acf97,#4fc6e1);"></div>
                            </div>
                            <div class="d-flex justify-content-between mt-1" style="font-size:11px;color:#6c757d;">
                                <span>Orders: {{ $row['orders'] ?? 0 }}</span>
                                <span>Delivered: {{ $row['delivered'] ?? 0 }}</span>
                                <span>Cancelled: {{ $row['cancelled'] ?? 0 }}</span>
                            </div>
                        </div>
                    @empty
                        <p class="text-muted mb-0" style="font-size:13px;">No courier data available for this number.</p>
                    @endforelse
                </div>
            </div>
        </div>

        @if(count($reports) > 0)
            <div class="row">
                <div class="col-12">
                    <div class="card-box">
                        <h4 class="header-title mb-3">Fraud reports</h4>
                        @foreach($reports as $index => $row)
                            <div class="mb-2 d-flex">
                                <div style="width:4px;border-radius:999px;background:#f1556c;margin-right:10px;"></div>
                                <div>
                                    <div style="font-size:13px;font-weight:500;">
                                        {{ $row['note'] ?? ($row['message'] ?? 'Reported activity') }}
                                    </div>
                                    <div style="font-size:11px;color:#6c757d;">
                                        {{ $row['source'] ?? 'Unknown source' }}
                                        @if(!empty($row['date']))
                                            &nbsp;•&nbsp; {{ $row['date'] }}
                                        @endif
                                    </div>
                                </div>
                            </div>
                        @endforeach
                    </div>
                </div>
            </div>
        @endif
    @endif
@endsection
