@extends('client.user.dashboard')

@section('dashboard-content')

<div class="max-w-5xl mx-auto px-4 py-6">

    <h3 class="text-2xl font-bold mb-6">📦 Chi tiết đơn hàng</h3>

    <div class="bg-white rounded-2xl shadow-md overflow-hidden">

        {{-- HEADER --}}
        <div class="bg-gradient-to-r from-blue-500 to-cyan-500 text-white p-6 space-y-2">
            <div>
                <strong>Trạng thái đơn hàng:</strong>
                <span class="text-yellow-200 font-semibold">
                    {{ $order->orderStatus->status_name ?? 'Không rõ' }}
                </span>
            </div>

            <div>
                <strong>Ngày đặt hàng:</strong>
                {{ $order->created_at->format('d/m/Y H:i') }}
            </div>

            @if ($order->cancel_reason)
            <div>
                <strong>Lý do huỷ:</strong>
                <span class="text-yellow-200">{{ $order->cancel_reason }}</span>
            </div>
            @endif

            @if ($order->order_status_id == 7)
            <div>
                <strong>Ngày huỷ:</strong>
                <span class="text-red-200">
                    {{ $order->updated_at->format('d/m/Y H:i') }}
                </span>
            </div>
            @endif
        </div>

        {{-- BODY --}}
        <div class="p-6 space-y-6">

            {{-- DANH SÁCH SẢN PHẨM --}}
            @foreach ($order->orderDetails as $item)
                @php
                    $variant = $item->productVariant;
                    $product = $variant?->product;
                    $image = $product?->image ? asset('storage/' . $product->image) : asset('images/default.jpg');

                    $price = ($variant?->discount_price && $variant->discount_price > 0)
                        ? $variant->discount_price
                        : $variant->price;

                    $totalPrice = $price * $item->quantity;

                    $ram = $variant?->ram?->value;
                    $storage = $variant?->storage?->value;
                    $color = $variant?->color?->value;
                    $colorCode = $variant?->color?->code;
                @endphp

                <div class="flex gap-4 border-b pb-4">

                    <img src="{{ $image }}"
                         class="w-24 h-24 rounded-xl border object-cover">

                    <div class="flex-1 space-y-1">
                        <h4 class="font-semibold text-lg">
                            {{ $product->product_name ?? 'Không rõ sản phẩm' }}
                        </h4>

                        <p>Số lượng: <strong>{{ $item->quantity }}</strong></p>

                        <p>
                            Giá:
                            @if ($variant?->discount_price && $variant->discount_price > 0)
                                <span class="text-red-600 font-semibold">
                                    {{ number_format($variant->discount_price, 0, ',', '.') }}₫
                                </span>
                                <span class="line-through text-gray-400 ml-2">
                                    {{ number_format($variant->price, 0, ',', '.') }}₫
                                </span>
                            @else
                                <span class="font-semibold">
                                    {{ number_format($variant->price, 0, ',', '.') }}₫
                                </span>
                            @endif
                        </p>

                        <p>
                            Tổng:
                            <span class="font-bold text-red-600">
                                {{ number_format($totalPrice, 0, ',', '.') }}₫
                            </span>
                        </p>

                        @if ($ram || $storage || $color)
                        <div class="text-sm text-gray-600">
                            Biến thể:
                            @if ($ram)
                                RAM: <strong>{{ $ram }}</strong>
                            @endif
                            @if ($storage)
                                , Storage: <strong>{{ $storage }}</strong>
                            @endif
                            @if ($color)
                                , Màu: <strong>{{ $color }}</strong>
                                <span class="inline-block w-4 h-4 border ml-2 align-middle"
                                      style="background: {{ $colorCode }}"></span>
                            @endif
                        </div>
                        @endif
                    </div>
                </div>
            @endforeach


            {{-- GIAO HÀNG --}}
            <div>
                <h4 class="font-semibold text-lg mb-2">🚚 Thông tin giao hàng</h4>
                <div class="space-y-1 text-sm">
                    <p><strong>Người nhận:</strong> {{ $order->recipient_name }}</p>
                    <p><strong>SĐT:</strong> {{ $order->recipient_phone }}</p>
                    <p><strong>Địa chỉ:</strong> {{ $order->recipient_address }}</p>

                    @if ($order->tracking_number)
                        <p>
                            <strong>Mã vận chuyển:</strong>
                            <span class="text-blue-600 font-semibold">
                                {{ $order->tracking_number }}
                            </span>
                        </p>
                    @endif
                </div>
            </div>


            {{-- THANH TOÁN --}}
            <div>
                <h4 class="font-semibold text-lg mb-2">💳 Thông tin thanh toán</h4>

                @php
                    $statusColor = match ($order->payment_status_id) {
                        1 => 'text-yellow-500',
                        2 => 'text-green-600',
                        3 => 'text-red-600',
                        4 => 'text-blue-600',
                        default => 'text-gray-500',
                    };

                    $subtotal = $order->orderDetails->sum(function ($item) {
                        $variant = $item->productVariant;
                        $price = ($variant && $variant->discount_price > 0)
                            ? $variant->discount_price
                            : ($variant->price ?? 0);
                        return $price * $item->quantity;
                    });

                    $promotion = $order->voucher;
                    $discountAmount = 0;

                    if ($promotion) {
                        $discountAmount = $promotion->discount_type === 'percentage'
                            ? $subtotal * ($promotion->discount_value / 100)
                            : $promotion->discount_value;
                    }
                @endphp

                <div class="space-y-1 text-sm">

                    <p>
                        <strong>Phương thức:</strong>
                        {{ $order->paymentMethod->method_name ?? 'Không rõ' }}
                    </p>

                    <p>
                        <strong>Trạng thái:</strong>
                        <span class="{{ $statusColor }} font-semibold">
                            {{ $order->paymentStatus->name ?? 'Không xác định' }}
                        </span>
                    </p>

                    <p>
                        <strong>Tổng tiền hàng:</strong>
                        {{ number_format($subtotal, 0, ',', '.') }}₫
                    </p>

                    @if ($promotion)
                        <p>
                            <strong>Mã giảm giá:</strong> {{ $promotion->code }}
                        </p>

                        <p>
                            <strong>Giảm giá:</strong>
                            <span class="text-green-600 font-semibold">
                                -{{ number_format($discountAmount, 0, ',', '.') }}₫
                            </span>
                        </p>
                    @endif

                    <p>
                        <strong>Phí vận chuyển:</strong>
                        {{ number_format($order->shipping_fee, 0, ',', '.') }}₫
                    </p>

                    <p class="text-lg font-bold text-red-600">
                        Tổng thanh toán:
                        {{ number_format($order->total_amount, 0, ',', '.') }}₫
                    </p>
                </div>
            </div>


            @if ($order->note)
            <div>
                <h4 class="font-semibold text-lg mb-2">📝 Ghi chú</h4>
                <p class="text-sm text-gray-600">{{ $order->note }}</p>
            </div>
            @endif


        </div>
    </div>

    <div class="mt-6">
        <a href="{{ route('user.orders') }}"
           class="inline-block px-5 py-2 bg-gray-200 rounded-lg hover:bg-gray-300 transition">
            ← Quay lại danh sách đơn hàng
        </a>
    </div>

</div>

@endsection
