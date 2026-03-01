@extends('client.layouts.app-2')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-6xl mx-auto px-4 py-10">

    <h2 class="text-3xl font-bold mb-8">🛒 Xác nhận đơn hàng</h2>

    {{-- ALERT --}}
    @if (session('error'))
        <div class="mb-6 p-4 rounded-lg bg-red-100 text-red-700">
            {{ session('error') }}
        </div>
    @endif

    @if (session('success'))
        <div class="mb-6 p-4 rounded-lg bg-green-100 text-green-700">
            {{ session('success') }}
        </div>
    @endif

    @if (session('buy_now') || (isset($cartItems) && count($cartItems)))

    <form method="POST"
          action="{{ route('checkout.store') }}"
          id="checkout-form"
          data-phone="{{ Auth::user()->phone }}"
          data-address="{{ Auth::user()->address }}"
          class="space-y-8">
        @csrf

        {{-- GRID 2 CỘT --}}
        <div class="grid md:grid-cols-2 gap-8">

            {{-- USER INFO --}}
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">📌 Thông tin người nhận</h3>

                <div class="space-y-2 text-sm">
                    <p><strong>Họ tên:</strong> {{ Auth::user()->full_name }}</p>
                    <p><strong>Email:</strong> {{ Auth::user()->email }}</p>
                    <p><strong>SĐT:</strong> {{ Auth::user()->phone ?? 'Chưa có' }}</p>
                    <p><strong>Địa chỉ:</strong> {{ Auth::user()->address ?? 'Chưa có' }}</p>
                </div>

                <a href="{{ route('user.profile') }}"
                   class="inline-block mt-4 px-4 py-2 bg-yellow-500 text-white rounded-lg hover:bg-yellow-600">
                    Cập nhật thông tin
                </a>
            </div>

            {{-- PRODUCT INFO --}}
            <div class="bg-white p-6 rounded-2xl shadow">
                <h3 class="text-lg font-semibold mb-4 border-b pb-2">📦 Thông tin sản phẩm</h3>

                @if ($buyNow && isset($product))
                    <div class="space-y-2 text-sm">
                        <p><strong>Tên:</strong> {{ $product->product_name }}</p>
                        @if ($variant)
                            <p><strong>Phiên bản:</strong>
                                {{ $variant->ram->value ?? '' }} /
                                {{ $variant->storage->value ?? '' }} /
                                {{ $variant->color->value ?? '' }}
                            </p>
                        @endif
                        <p><strong>Giá:</strong> {{ number_format($price, 0, ',', '.') }} VND</p>
                        <p><strong>Số lượng:</strong> {{ $buyNow['quantity'] }}</p>
                    </div>
                @elseif(!empty($cartItems))
                    @foreach ($cartItems as $item)
                        <div class="border-b py-3 text-sm">
                            <p><strong>{{ $item['product']->product_name }}</strong></p>
                            @if ($item['variant'])
                                <p class="text-gray-600">
                                    {{ $item['variant']->ram->value ?? '' }} /
                                    {{ $item['variant']->storage->value ?? '' }} /
                                    {{ $item['variant']->color->value ?? '' }}
                                </p>
                            @endif
                            <p>SL: {{ $item['quantity'] }}</p>
                        </div>
                    @endforeach
                @endif
            </div>

        </div>

        {{-- VOUCHER --}}
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">🏷️ Chọn voucher</h3>

            <select name="voucher_id"
                    id="voucher-select"
                    class="w-full border rounded-lg px-4 py-2">
                <option value="" data-type="" data-value="0">
                    -- Không sử dụng --
                </option>
                @foreach ($vouchers as $voucher)
                    <option value="{{ $voucher->id }}"
                            data-type="{{ $voucher->discount_type }}"
                            data-value="{{ $voucher->discount_value }}">
                        {{ $voucher->name }} - {{ $voucher->code }}
                    </option>
                @endforeach
            </select>
        </div>

        {{-- TOTAL --}}
        <div class="bg-white p-6 rounded-2xl shadow space-y-3">
            <h3 class="font-semibold border-b pb-2">💰 Tổng tiền</h3>

            <div class="flex justify-between">
                <span>Tạm tính:</span>
                <span id="subtotal">{{ number_format($subtotal, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between">
                <span>Phí vận chuyển:</span>
                <span id="shipping">{{ number_format($shippingFee, 0, ',', '.') }}</span>
            </div>

            <div class="flex justify-between text-red-600">
                <span>Giảm giá:</span>
                <span id="discount">0</span>
            </div>

            <div class="border-t pt-3 flex justify-between text-lg font-bold">
                <span>Thanh toán:</span>
                <span id="total">{{ number_format($subtotal + $shippingFee, 0, ',', '.') }}</span>
            </div>
        </div>

        {{-- PAYMENT --}}
        <div class="bg-white p-6 rounded-2xl shadow">
            <h3 class="font-semibold mb-4">💳 Phương thức thanh toán</h3>

            <div class="space-y-3">
                <label class="flex items-center gap-3">
                    <input type="radio" name="payment_method" value="cod">
                    Thanh toán khi nhận hàng (COD)
                </label>

                <label class="flex items-center gap-3">
                    <input type="radio" name="payment_method" value="momo">
                    Ví MoMo
                </label>
            </div>
        </div>

        <div class="text-right">
            <button type="submit"
                class="px-8 py-3 bg-green-600 text-white rounded-xl hover:bg-green-700 text-lg font-semibold">
                Xác nhận đặt hàng
            </button>
        </div>

    </form>

    @else
        <div class="p-6 bg-yellow-100 text-yellow-800 rounded-lg">
            Không có sản phẩm nào để thanh toán.
        </div>
    @endif

</div>
@endsection
