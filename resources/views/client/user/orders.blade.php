{{-- resources/views/client/user/orders.blade.php --}}
@extends('client.user.dashboard')

@section('dashboard-content')

@php
    $statusLabels = [
        'Tất cả',
        'Chờ xác nhận',
        'Đã xác nhận',
        'Đang chuẩn bị',
        'Đang giao',
        'Đã giao',
        'Trả hàng/Hoàn tiền',
        'Đã hủy',
    ];
    $statusMap = [0 => null, 1 => 1, 2 => 2, 3 => 3, 4 => 4, 5 => 5, 6 => 6, 7 => 7];
    $maxVisible = 10;
@endphp

<h3 class="text-2xl font-semibold mb-6">🍚 Quản lý đơn hàng</h3>

{{-- Tabs --}}
<div class="flex flex-wrap gap-2 border-b pb-2 mb-6">
    @foreach ($statusLabels as $index => $label)
        <a href="{{ route('user.orders', ['status' => $statusMap[$index]]) }}"
           class="px-4 py-2 rounded-t-lg text-sm font-medium transition
           {{ $statusMap[$index] == $status || ($index == 0 && !$status)
                ? 'bg-black text-white'
                : 'bg-gray-100 hover:bg-gray-200 text-gray-700' }}">
            {{ $label }}
        </a>
    @endforeach
</div>

@if ($orders->count())

    @foreach ($orders as $key => $order)

        <div class="order-item bg-white rounded-xl shadow-sm border p-6 mb-5 hover:shadow-md transition
            {{ $key >= $maxVisible ? 'hidden' : '' }}"
             data-id="{{ $order->id }}">

            {{-- Header --}}
            <div class="text-sm text-gray-600 space-y-1 mb-4">
                <div><strong>Mã đơn:</strong> #{{ $order->id }}</div>
                <div>
                    <strong>Trạng thái:</strong>
                    <span class="text-blue-600 font-medium">
                        {{ $order->orderStatus->status_name ?? 'Không rõ' }}
                    </span>
                </div>
                <div>
                    <strong>Ngày đặt:</strong>
                    {{ $order->created_at->format('d/m/Y H:i') }}
                </div>
            </div>

            {{-- Products --}}
            @foreach ($order->orderDetails as $item)
                @php
                    $variant = $item->productVariant;
                    $product = $variant?->product;
                    $image = $product?->image
                        ? asset('storage/' . $product->image)
                        : asset('images/default.jpg');
                @endphp

                <div class="flex gap-4 mb-4 pb-4 border-b">
                    <img src="{{ $image }}"
                         class="w-20 h-20 rounded-lg object-cover border">

                    <div class="flex-1">
                        <h5 class="font-medium">
                            {{ $product->product_name ?? 'Không rõ sản phẩm' }}
                        </h5>

                        <p class="text-sm text-gray-600">
                            {{ number_format($item->unit_price, 0, ',', '.') }}₫
                            x {{ $item->quantity }}
                        </p>
                    </div>
                </div>
            @endforeach

            {{-- Footer --}}
            <div class="flex justify-between items-center mt-4">

                @php
                    $paymentClass = match($order->payment_status_id) {
                        1 => 'bg-yellow-100 text-yellow-700',
                        2 => 'bg-green-100 text-green-700',
                        3 => 'bg-red-100 text-red-700',
                        default => 'bg-gray-100 text-gray-700'
                    };
                @endphp

                <span class="px-3 py-1 text-xs rounded-full {{ $paymentClass }}">
                    {{ $order->paymentStatus->name ?? 'Không rõ' }}
                </span>

                <div class="text-right">
                    <strong>Tổng tiền:</strong>
                    {{ number_format($order->total_amount, 0, ',', '.') }}₫
                </div>
            </div>

            {{-- Actions --}}
            <div class="flex flex-wrap gap-2 justify-end mt-5">

                <a href="{{ route('user.orders.detail', $order->id) }}"
                   class="px-4 py-2 bg-black text-white text-sm rounded-lg hover:opacity-90 transition">
                    Xem chi tiết
                </a>

                @if ($order->order_status_id == 1)
                    <button class="cancel-order-btn px-4 py-2 bg-red-500 text-white text-sm rounded-lg hover:bg-red-600 transition">
                        Huỷ đơn
                    </button>
                @endif

            </div>

        </div>

    @endforeach

    @if ($orders->count() > $maxVisible)
        <div class="text-center mt-6">
            <button class="btn-show-more text-sm text-gray-600 hover:underline">
                Xem thêm
            </button>
        </div>
    @endif

@else
    <p class="text-gray-500">Chưa có đơn hàng.</p>
@endif


{{-- ================= MODAL REVIEW ================= --}}
<div id="reviewModal"
     class="fixed inset-0 bg-black/40 hidden items-center justify-center z-50">

    <div class="bg-white w-full max-w-lg rounded-xl p-6 shadow-lg">

        <div class="flex justify-between items-center mb-4">
            <h5 class="text-lg font-semibold">Đánh giá sản phẩm</h5>
            <button onclick="closeReviewModal()" class="text-gray-500">✕</button>
        </div>

        <form method="POST" action="{{ route('client.reviews.store') }}">
            @csrf

            <textarea name="comment"
                      class="w-full border rounded-lg p-3 text-sm mb-4"
                      rows="4"
                      placeholder="Nội dung đánh giá..."
                      required></textarea>

            <div class="flex justify-end gap-2">
                <button type="button"
                        onclick="closeReviewModal()"
                        class="px-4 py-2 border rounded-lg text-sm">
                    Hủy
                </button>

                <button type="submit"
                        class="px-4 py-2 bg-black text-white rounded-lg text-sm">
                    Gửi đánh giá
                </button>
            </div>
        </form>

    </div>
</div>

@endsection


@push('scripts')
<script>
document.addEventListener('DOMContentLoaded', function() {

    const maxVisible = {{ $maxVisible }};

    // Toggle show more
    document.querySelector('.btn-show-more')?.addEventListener('click', function() {
        const hiddenOrders = document.querySelectorAll('.order-item.hidden');
        if (hiddenOrders.length) {
            hiddenOrders.forEach(el => el.classList.remove('hidden'));
            this.textContent = 'Ẩn bớt';
        } else {
            document.querySelectorAll('.order-item').forEach((el, index) => {
                if (index >= maxVisible) el.classList.add('hidden');
            });
            this.textContent = 'Xem thêm';
        }
    });

    // Cancel order
    document.querySelectorAll('.cancel-order-btn').forEach(button => {
        button.addEventListener('click', function() {
            const card = this.closest('.order-item');
            const orderId = card.dataset.id;

            if (confirm('Bạn có chắc muốn huỷ đơn hàng này?')) {
                fetch(`/client/orders/${orderId}/cancel`, {
                    method: 'POST',
                    headers: {
                        'X-CSRF-TOKEN': '{{ csrf_token() }}',
                        'Accept': 'application/json',
                    },
                })
                .then(res => res.json())
                .then(res => {
                    alert(res.message);
                    if (res.success) location.reload();
                });
            }
        });
    });

});

function closeReviewModal() {
    const modal = document.getElementById('reviewModal');
    modal.classList.add('hidden');
    modal.classList.remove('flex');
}
</script>
@endpush
