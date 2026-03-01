@extends('client.layouts.app')

@section('content')

<div class="max-w-6xl mx-auto px-4 py-10">

    <div class="bg-white rounded-2xl shadow-lg p-6">

        <h2 class="text-2xl font-bold text-center mb-6">
            🛒 Giỏ hàng của bạn
        </h2>

        @if ($cart && $cart->details->count())

        <form id="checkout-form" action="{{ route('cart.updateBeforeCheckout') }}" method="POST">
            @csrf

            <div class="overflow-x-auto">
                <table class="w-full border border-gray-200 rounded-xl overflow-hidden">
                    <thead class="bg-gray-100 text-gray-700 text-sm">
                        <tr class="text-center">
                            <th class="p-3">
                                <input type="checkbox" id="select-all" class="w-4 h-4">
                            </th>
                            <th class="p-3">Ảnh</th>
                            <th class="p-3 text-left">Sản phẩm</th>
                            <th class="p-3">Phiên bản</th>
                            <th class="p-3">Giá</th>
                            <th class="p-3">Số lượng</th>
                            <th class="p-3">Thành tiền</th>
                            <th class="p-3">Xóa</th>
                        </tr>
                    </thead>

                    <tbody class="divide-y">

                        @foreach ($cart->details as $item)
                            @php
                                $price = $item->variant
                                    ? (($item->variant->discount_price && $item->variant->discount_price < $item->variant->price)
                                        ? $item->variant->discount_price : $item->variant->price)
                                    : (($item->product->discount_price && $item->product->discount_price < $item->product->price)
                                        ? $item->product->discount_price : $item->product->price);

                                $subtotal = $item->quantity * $price;
                            @endphp

                            <tr class="text-center hover:bg-gray-50 transition"
                                data-id="{{ $item->id }}"
                                data-price="{{ $price }}">

                                <td class="p-3">
                                    <input type="checkbox"
                                           class="item-checkbox w-4 h-4"
                                           name="selected_items[]"
                                           value="{{ $item->id }}"
                                           checked>
                                </td>

                                <td class="p-3">
                                    <img src="{{ asset('storage/' . $item->product->image) }}"
                                         class="w-20 h-20 object-cover rounded-lg border mx-auto">
                                </td>

                                <td class="p-3 text-left font-medium">
                                    {{ $item->product->product_name }}
                                </td>

                                <td class="p-3 text-sm text-gray-600">
                                    @if ($item->variant)
                                        {{ $item->variant->ram->value ?? '?' }} /
                                        {{ $item->variant->storage->value ?? '?' }} /
                                        {{ $item->variant->color->value ?? '?' }}
                                    @else
                                        -
                                    @endif
                                </td>

                                <td class="p-3 font-semibold text-red-600">
                                    {{ number_format($price,0,',','.') }} đ
                                </td>

                                <td class="p-3">
                                    <input type="number"
                                           class="quantity-input w-20 text-center border rounded-lg py-1"
                                           name="quantities[{{ $item->id }}]"
                                           value="{{ $item->quantity }}"
                                           min="1"
                                           max="{{ $item->variant ? $item->variant->quantity - 1 : $item->product->quantity - 1 }}">
                                </td>

                                <td class="p-3 font-bold subtotal">
                                    {{ number_format($subtotal,0,',','.') }} đ
                                </td>

                                <td class="p-3">
                                    <button type="button"
                                            class="btn-delete-item bg-red-500 hover:bg-red-600 text-white px-3 py-1 rounded-lg text-sm transition"
                                            data-id="{{ $item->id }}">
                                        🗑
                                    </button>
                                </td>

                            </tr>

                        @endforeach

                    </tbody>
                </table>
            </div>

            {{-- Tổng tiền --}}
            <div class="mt-6 bg-gray-50 rounded-xl p-6 text-right space-y-4">

                <h4 class="text-lg font-semibold">
                    Tổng cộng:
                    <span id="total-price" class="text-red-600 text-xl font-bold">
                        0 đ
                    </span>
                </h4>

                <button type="submit"
                        class="bg-green-500 hover:bg-green-600 text-white px-8 py-3 rounded-xl font-semibold transition shadow-md">
                    💳 Tiến hành thanh toán
                </button>

            </div>

        </form>

        @else

            <div class="bg-blue-50 border border-blue-200 text-blue-600 p-6 rounded-xl text-center">
                Giỏ hàng của bạn đang trống!
            </div>

        @endif

    </div>
</div>


<script>
function formatCurrency(amount) {
    return new Intl.NumberFormat('vi-VN').format(amount) + ' đ';
}

function updateTotal() {
    let total = 0;
    document.querySelectorAll('tbody tr').forEach(row => {
        const checkbox = row.querySelector('.item-checkbox');
        if (checkbox && checkbox.checked) {
            const price = parseInt(row.dataset.price);
            const quantity = parseInt(row.querySelector('.quantity-input').value);
            const subtotal = price * quantity;
            row.querySelector('.subtotal').innerText = formatCurrency(subtotal);
            total += subtotal;
        }
    });
    document.getElementById('total-price').innerText = formatCurrency(total);
}

document.addEventListener('DOMContentLoaded', function() {

    document.querySelectorAll('.item-checkbox').forEach(cb =>
        cb.addEventListener('change', updateTotal)
    );

    document.querySelectorAll('.quantity-input').forEach(input =>
        input.addEventListener('input', updateTotal)
    );

    document.getElementById('select-all').addEventListener('change', function() {
        document.querySelectorAll('.item-checkbox').forEach(cb =>
            cb.checked = this.checked
        );
        updateTotal();
    });

    document.querySelectorAll('.btn-delete-item').forEach(button => {
        button.addEventListener('click', function () {

            const id = this.dataset.id;
            if (!confirm('Bạn có chắc chắn muốn xóa sản phẩm này?')) return;

            fetch(`/cart/${id}`, {
                method: 'DELETE',
                headers: {
                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                    'Accept': 'application/json'
                }
            })
            .then(res => res.json())
            .then(data => {
                if (data.success) {
                    const row = document.querySelector(`tr[data-id="${id}"]`);
                    if (row) row.remove();
                    updateTotal();
                    alert(data.message);
                } else {
                    alert(data.message || 'Không thể xóa sản phẩm.');
                }
            })
            .catch(() => {
                alert('Đã xảy ra lỗi khi xóa sản phẩm.');
            });

        });
    });

    updateTotal();
});
</script>

@endsection
