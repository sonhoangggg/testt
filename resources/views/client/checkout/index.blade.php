@extends('client.layouts.app')

@section('content')
<div class="max-w-6xl mx-auto px-4 py-10">
    <h3 class="text-2xl font-bold mb-6">🛒 Xác nhận đơn hàng</h3>

    @if (session('error'))
        <div class="bg-red-100 text-red-700 px-4 py-3 rounded mb-4">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="bg-green-100 text-green-700 px-4 py-3 rounded mb-4">
            {{ session('success') }}
        </div>
    @endif

    @if (session('buy_now') || (isset($cartItems) && count($cartItems)))
    <form method="POST"
          action="{{ route('checkout.store') }}"
          id="checkout-form"
          data-phone="{{ Auth::user()->phone }}"
          data-address="{{ Auth::user()->address }}">
        @csrf

        @if (!$buyNow && isset($cartItems))
            @foreach ($cartItems as $item)
                <input type="hidden" name="selected_items[]" value="{{ $item['cart_detail_id'] }}">
            @endforeach
        @endif

        <div class="grid md:grid-cols-2 gap-6">

            {{-- THÔNG TIN NGƯỜI NHẬN --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-blue-600 text-white px-4 py-3 font-semibold">
                    📌 Thông tin người nhận
                </div>
                <div class="p-4 space-y-2">
                    <p><strong>Họ tên:</strong> {{ Auth::user()->full_name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>Số điện thoại:</strong> {{ Auth::user()->phone ?? 'Chưa có' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ Auth::user()->address ?? 'Chưa có' }}</p>

                    <a href="{{ route('user.profile') }}"
                       class="inline-block mt-3 bg-yellow-500 hover:bg-yellow-600 text-white px-3 py-1.5 rounded text-sm">
                        ✏️ Cập nhật thông tin
                    </a>
                </div>
            </div>

            {{-- THÔNG TIN SẢN PHẨM --}}
            <div class="bg-white shadow rounded-xl overflow-hidden">
                <div class="bg-green-600 text-white px-4 py-3 font-semibold">
                    📦 Thông tin sản phẩm
                </div>
                <div class="p-4">

                    @if ($buyNow && isset($product))
                        @php
                            $availableQty = $variant ? $variant->quantity : $product->quantity;
                            $price = $variant
                                ? ($variant->discount_price !== null &&
                                $variant->discount_price < $variant->price
                                    ? $variant->discount_price
                                    : $variant->price)
                                : ($product->discount_price !== null &&
                                $product->discount_price < $product->price
                                    ? $product->discount_price
                                    : $product->price);

                            if ($availableQty < $buyNow['quantity']) {
                                $outOfStock = true;
                            }
                        @endphp

                        <p><strong>Tên sản phẩm:</strong> {{ $product->product_name }}</p>

                        @if ($variant)
                            <p><strong>Phiên bản:</strong>
                                {{ $variant->ram->value ?? '' }} /
                                {{ $variant->storage->value ?? '' }} /
                                {{ $variant->color->value ?? '' }}
                            </p>
                        @endif

                        <p><strong>Giá:</strong> {{ number_format($price, 0, ',', '.') }} VND</p>
                        <p><strong>Số lượng:</strong> {{ $buyNow['quantity'] }}</p>

                        @if ($availableQty < $buyNow['quantity'])
                            <div class="bg-red-100 text-red-600 p-3 rounded mt-3">
                                Sản phẩm này đã hết hàng hoặc không đủ số lượng!
                            </div>
                        @endif

                    @elseif(!empty($cartItems))

                        @php
                            $totalProducts = 0;
                            $totalItems = count($cartItems);
                        @endphp

                        @foreach ($cartItems as $item)
                            @php
                                $availableQty = $item['variant']
                                    ? $item['variant']->quantity
                                    : $item['product']->quantity;

                                $itemPrice = $item['variant']
                                    ? ($item['variant']->discount_price !== null &&
                                    $item['variant']->discount_price < $item['variant']->price
                                        ? $item['variant']->discount_price
                                        : $item['variant']->price)
                                    : ($item['product']->discount_price !== null &&
                                    $item['product']->discount_price < $item['product']->price
                                        ? $item['product']->discount_price
                                        : $item['product']->price);

                                $totalProducts += $item['quantity'];

                                if ($availableQty < $item['quantity']) {
                                    $outOfStock = true;
                                }
                            @endphp

                            <hr class="my-4">

                            <p><strong>Tên sản phẩm:</strong> {{ $item['product']->product_name }}</p>

                            @if ($item['variant'])
                                <p><strong>Phiên bản:</strong>
                                    {{ $item['variant']->ram->value ?? '' }} /
                                    {{ $item['variant']->storage->value ?? '' }} /
                                    {{ $item['variant']->color->value ?? '' }}
                                </p>
                            @endif

                            <p><strong>Giá:</strong> {{ number_format($itemPrice, 0, ',', '.') }} VND</p>
                            <p><strong>Số lượng:</strong> {{ $item['quantity'] }}</p>

                            @if ($availableQty < $item['quantity'])
                                <div class="bg-red-100 text-red-600 p-3 rounded mt-3">
                                    Sản phẩm này đã hết hàng hoặc không đủ số lượng!
                                </div>
                            @endif
                        @endforeach

                        <hr class="my-4">
                        <p><strong>🛒 Tổng loại sản phẩm:</strong> {{ $totalItems }}</p>
                        <p><strong>📦 Tổng số lượng sản phẩm:</strong> {{ $totalProducts }}</p>
                    @endif

                </div>
            </div>
        </div>

        {{-- Voucher --}}
        <div class="bg-white shadow rounded-xl mt-6">
            <div class="bg-yellow-500 text-white px-4 py-3 font-semibold">
                🎟 Chọn voucher (nếu có)
            </div>
            <div class="p-4">
                <select name="voucher_id"
                        id="voucher-select"
                        class="w-full border border-gray-300 rounded px-3 py-2 focus:outline-none focus:ring-2 focus:ring-yellow-500">
                    <option value="" data-type="" data-value="0">-- Không sử dụng --</option>
                    @foreach ($vouchers as $voucher)
                        <option value="{{ $voucher->id }}"
                                data-type="{{ $voucher->discount_type }}"
                                data-value="{{ $voucher->discount_value }}">
                            {{ $voucher->name }} - Mã: {{ $voucher->code }}
                            ({{ $voucher->discount_type == 'percentage'
                                ? $voucher->discount_value . '%'
                                : number_format($voucher->discount_value, 0, ',', '.') . ' ₫' }})
                        </option>
                    @endforeach
                </select>
            </div>
        </div>

        {{-- Tổng tiền --}}
        <div class="bg-white shadow rounded-xl mt-6">
            <div class="bg-gray-800 text-white px-4 py-3 font-semibold">
                💰 Tổng tiền
            </div>
            <div class="p-4 space-y-2">
                <p><strong>Tạm tính:</strong> <span id="subtotal">{{ number_format($subtotal, 0, ',', '.') }}</span> VND</p>
                <p><strong>Phí vận chuyển:</strong> <span id="shipping">{{ number_format($shippingFee, 0, ',', '.') }}</span> VND</p>
                <p><strong>Giảm giá:</strong> <span id="discount">0</span> VND</p>
                <hr>
                <p class="text-lg font-bold">
                    Thanh toán:
                    <span id="total">{{ number_format($subtotal + $shippingFee - $discount, 0, ',', '.') }}</span> VND
                </p>
            </div>
        </div>

        {{-- Payment --}}
        <div class="bg-white shadow rounded-xl mt-6">
            <div class="bg-cyan-600 text-white px-4 py-3 font-semibold">
                💳 Phương thức thanh toán
            </div>
            <div class="p-4 space-y-3">
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="cod">
                    Thanh toán khi nhận hàng (COD)
                </label>
                <label class="flex items-center gap-2">
                    <input type="radio" name="payment_method" value="momo">
                    Ví MoMo
                </label>
            </div>
        </div>

        <div class="text-right mt-8">
            <button type="submit"
                class="bg-green-600 hover:bg-green-700 text-white px-6 py-3 rounded-lg font-semibold transition">
                Xác nhận đặt hàng
            </button>
        </div>

    </form>
    @else
        <div class="bg-yellow-100 text-yellow-700 px-4 py-3 rounded">
            Không có sản phẩm nào để thanh toán.
        </div>
    @endif
</div>
@endsection
