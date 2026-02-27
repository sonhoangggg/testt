@extends('client.user.dashboard')

@section('dashboard-content')
    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/css/bootstrap.min.css" rel="stylesheet">
        <link rel="stylesheet" href="https://cdnjs.cloudflare.com/ajax/libs/font-awesome/6.5.0/css/all.min.css">

        <style>
            .nav-tabs {
                gap: 0;
                /* Xóa khoảng cách nếu dùng flex */
                margin-bottom: 0;
            }

            .nav-tabs .nav-item {
                margin-right: 2px;
                /* Giảm khoảng cách giữa các tab */
            }

            .nav-tabs .nav-link {
                font-weight: bold;
                color: #333;
                padding: 8px 12px;
                /* Giảm padding ngang */
                border: 1px solid #dee2e6;
                border-bottom: none;
                border-radius: 0.375rem 0.375rem 0 0;
                background-color: #f9f9f9;
            }

            .nav-tabs .nav-link.active {
                background-color: #337ab7;
                color: #fff !important;
                border-color: #337ab7 #337ab7 transparent;
            }

            .card.order-item {
                transition: box-shadow 0.2s ease-in-out;
            }

            .card.order-item:hover {
                box-shadow: 0 2px 10px rgba(0, 0, 0, 0.1);
            }

            .rating-stars {
                font-size: 22px;
                color: #ccc;
                cursor: pointer;
            }

            .rating-stars .star {
                margin-right: 5px;
                transition: color 0.2s;
                color: #ccc;
            }

            .rating-stars .star.hovered,
            .rating-stars .star.selected,
            .rating-stars .star.fa-star {
                color: #f5b301 !important;
            }

            .order-action-buttons .btn {
                min-width: 130px;
                /* hoặc width: 130px nếu muốn tuyệt đối */
                margin: 0 4px 6px 0;
                text-align: center;
                padding: 6px 12px;
                font-size: 14px;
            }

            .rating-stars .star {
                margin-right: 5px;
                color: #ccc;
                transition: color 0.3s, transform 0.2s ease-in-out;
            }

            .rating-stars .star.hovered,
            .rating-stars .star.selected,
            .rating-stars .star.fa-star {
                color: #f5b301 !important;
                transform: scale(1.2);
            }

            .btn:hover {
                transform: translateY(-1px);
                box-shadow: 0 3px 6px rgba(0, 0, 0, 0.15);
                transition: all 0.2s ease-in-out;
            }

            .card.order-item {
                border: 1px solid #dee2e6;
                border-radius: 0.5rem;
                overflow: hidden;
            }

            .card.order-item .card-header {
                background-color: #f1f1f1;
                font-size: 15px;
                font-weight: 500;
            }

            .nav-tabs {
                box-shadow: 0 2px 4px rgba(0, 0, 0, 0.05);
                border-bottom: none;
            }

            .nav-tabs .nav-link.active {
                border-bottom: 2px solid transparent;
                border-radius: 0.5rem 0.5rem 0 0;
            }

            .modal-content {
                border-radius: 0.75rem;
                box-shadow: 0 4px 16px rgba(0, 0, 0, 0.15);
            }
        </style>
    @endpush

    <h3 class="mb-4">🍚 Quản lý đơn hàng</h3>

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
    {{-- Tabs trạng thái --}}
    <ul class="nav nav-tabs" id="orderTabs" role="tablist">
        @foreach ($statusLabels as $index => $label)
            <li class="nav-item" role="presentation">
                <a class="nav-link {{ $statusMap[$index] == $status || ($index == 0 && !$status) ? 'active' : '' }}"
                    href="{{ route('user.orders', ['status' => $statusMap[$index]]) }}">
                    {{ $label }}
                </a>
            </li>
        @endforeach
    </ul>

    {{-- Nội dung đơn hàng --}}
    <div class="tab-content pt-3">
        <div class="tab-pane fade show active" id="orders-tab" role="tabpanel">
            @if ($orders->count())
                @foreach ($orders as $key => $order)
                    <div class="card mb-3 order-item {{ $key >= $maxVisible ? 'd-none' : '' }}"
                        data-id="{{ $order->id }}">
                        <div class="card-header">
                            <strong>Mã đơn hàng:</strong> Đơn #{{ $order->id }} |
                            <strong>Trạng thái:</strong>
                            <span class="text-primary">{{ $order->orderStatus->status_name ?? 'Không rõ' }}</span> |
                            <strong>Ngày đặt:</strong> {{ $order->created_at->format('d/m/Y H:i') }}
                            @if ($order->payment_status === 'pending' && !empty($order->payment_expires_at))
                                <div id="timer-{{ $order->id }}"
                                    style="font-size:18px; display:flex; align-items:center; gap:6px;">
                                    ⏳
                                    <span id="countdown-{{ $order->id }}">--:--:--</span>
                                </div>

                                <script>
                                    const expiresAt{{ $order->id }} = new Date(
                                        "{{ optional($order->payment_expires_at)->format('Y-m-d\\TH:i:s') }}"
                                    ).getTime();

                                    const countdownEl{{ $order->id }} = document.getElementById("countdown-{{ $order->id }}");
                                    const timerDiv{{ $order->id }} = document.getElementById("timer-{{ $order->id }}");

                                    const interval{{ $order->id }} = setInterval(() => {
                                        const now = Date.now();
                                        const distance = expiresAt{{ $order->id }} - now;

                                        if (distance <= 0) {
                                            clearInterval(interval{{ $order->id }});
                                            countdownEl{{ $order->id }}.textContent = "Hết hạn thanh toán";
                                            timerDiv{{ $order->id }}.style.color = "red";
                                            return;
                                        }

                                        const hours = Math.floor(distance / (1000 * 60 * 60));
                                        const minutes = Math.floor((distance % (1000 * 60 * 60)) / (1000 * 60));
                                        const seconds = Math.floor((distance % (1000 * 60)) / 1000);

                                        countdownEl{{ $order->id }}.textContent =
                                            String(hours).padStart(2, "0") + ":" +
                                            String(minutes).padStart(2, "0") + ":" +
                                            String(seconds).padStart(2, "0");
                                    }, 1000);
                                </script>
                            @else
                                <span>Không có thời gian hết hạn</span>
                            @endif

                        </div>

                        <div class="card-body">
                            {{-- Danh sách sản phẩm --}}
                            @foreach ($order->orderDetails as $item)
                                @php
                                    $variant = $item->productVariant;
                                    $product = $variant?->product;
                                    $image = $product?->image
                                        ? asset('storage/' . $product->image)
                                        : asset('images/default.jpg');
                                @endphp
                                <div class="d-flex mb-3 border-bottom pb-2">
                                    <img src="{{ $image }}" class="img-thumbnail me-3"
                                        style="width: 80px; height: 80px; object-fit: cover;">
                                    <div>
                                        <h5>{{ $product->product_name ?? 'Không rõ sản phẩm' }}</h5>
                                        <p>Giá: {{ number_format($item->unit_price, 0, ',', '.') }}₫ x
                                            {{ $item->quantity }}</p>

                                        {{-- Đánh giá sản phẩm --}}
                                        @if ($order->order_status_id == 5)
                                            @php
                                                $keyItem = $order->id . '-' . $item->product_variant_id;
                                                $alreadyReviewed = isset($reviewedMap[$keyItem]);
                                            @endphp
                                            @if ($alreadyReviewed)
                                                <span class="badge bg-secondary">Đã đánh giá</span>
                                            @else
                                                <button class="btn btn-success btn-sm btn-review"
                                                    data-variant-id="{{ $item->product_variant_id }}"
                                                    data-product-name="{{ $product->product_name }}"
                                                    data-order-id="{{ $order->id }}">Đánh giá</button>
                                            @endif
                                        @endif
                                    </div>
                                </div>
                            @endforeach

                            {{-- Thanh toán + tổng tiền --}}
                            <div class="d-flex justify-content-between align-items-center mb-2">
                                <span
                                    class="badge
                                @switch($order->payment_status_id)
                                    @case(1) bg-warning text-dark @break
                                    @case(2) bg-success @break
                                    @case(3) bg-danger @break
                                    @case(4) bg-info text-dark @break
                                    @default bg-secondary
                                @endswitch">
                                    {{ $order->paymentStatus->name ?? 'Không rõ' }}
                                </span>
                                <div>
                                    <strong>Tổng tiền:</strong>
                                    {{ number_format($order->total_amount, 0, ',', '.') }}₫
                                </div>
                            </div>

                            {{-- Nút hành động --}}
                            <div class="text-end order-action-buttons d-flex flex-wrap justify-content-end">
                                @php
                                    $isMomoUnpaid =
                                        $order->paymentMethod->code === 'momo' && $order->payment_status_id == 1;
                                    $isCancelled = $order->order_status_id == 7;
                                @endphp

                                {{-- Nút Xem chi tiết luôn hiển thị --}}
                                <a href="{{ route('user.orders.detail', $order->id) }}" class="btn btn-primary btn-sm">
                                    Xem chi tiết
                                </a>

                                {{-- Nếu không phải momo + chưa thanh toán + đã hủy => mới hiển thị các nút khác --}}
                                @if (!($isMomoUnpaid && $isCancelled))
                                    {{-- Thanh toán lại MOMO --}}
                                    @if ($isMomoUnpaid)
                                        <form id="retryForm" action="{{ route('client.momo.retry', $order->id) }}"
                                            method="POST">
                                            @csrf
                                            <button type="submit" class="btn btn-primary">Quay lại thanh toán</button>
                                        </form>
                                        <form method="POST" action="{{ route('client.momo.to_cod', $order->id) }}"
                                            class="d-inline">
                                            @csrf
                                            <button type="submit" class="btn btn-outline-warning btn-sm"
                                                onclick="return confirm('Bạn có chắc muốn chuyển sang thanh toán khi nhận hàng không?')">
                                                💵 Thanh toán khi nhận hàng
                                            </button>
                                        </form>
                                    @endif

                                    {{-- Huỷ đơn --}}
                                    @if ($order->order_status_id == 1)
                                        <button class="btn btn-danger btn-sm cancel-order-btn">Huỷ đơn</button>
                                    @endif

                                    {{-- Xác nhận nhận hàng / Báo chưa nhận --}}
        @if ($order->order_status_id == 5)
            @if (!$order->user_confirmed_delivery)
                <button class="btn btn-success btn-sm btn-confirm-received" data-id="{{ $order->id }}">
                    Tôi đã nhận hàng
                </button>
                @if (!isset($deliveryIssues[$order->id]))
                    <button class="btn btn-outline-danger btn-sm btn-report-issue" data-id="{{ $order->id }}">
                        Chưa nhận được hàng
                    </button>
                @else
                    <span class="text-info fw-bold">Đã gửi phản hồi</span>
                @endif
            @else
                <span class="text-success fw-bold">✅ Đơn hàng đã hoàn tất</span>
            @endif
        @endif

                                 {{-- Trả hàng / Hoàn tiền --}}
@if ($order->order_status_id == 5 || $order->order_status_id == 6 || 
    ($order->order_status_id == 7 && $order->paymentMethod->code === 'momo' && $order->payment_status_id == 2))
    @php
        $returnRequest = $returnedOrders[$order->id] ?? null;
        $latestProgress = null;
        if ($returnRequest && isset($progresses[$returnRequest->id])) {
            $latestProgress = $progresses[$returnRequest->id]->last();
        }
    @endphp

    @if ($returnRequest)
        @if ($returnRequest->status === 'pending')
            <span class="text-warning fw-bold">Đã gửi yêu cầu trả hàng</span>
            <button class="btn btn-danger btn-sm ms-2 cancel-return-request-btn"
                data-id="{{ $returnRequest->id }}">
                Hủy yêu cầu
            </button>
        @elseif ($returnRequest->status === 'rejected')
            <span class="text-danger fw-bold">Yêu cầu bị từ chối</span>
        @elseif ($returnRequest->status === 'approved' && (!$latestProgress || $latestProgress->status === 'approved'))
            <a href="{{ route('user.return.enter_tracking', $returnRequest->id) }}"
                class="btn btn-sm btn-outline-primary">
                Nhập thông tin hoàn tiền
            </a>
        @else
            @php
                $statusVN = match ($latestProgress->status ?? '') {
                    'pending' => 'Đang chờ xử lý',
                    'approved' => 'Đã duyệt',
                    'rejected' => 'Đã từ chối',
                    'shipped_back' => 'Đã gửi hàng trả lại',
                    'received' => 'Đã nhận hàng',
                    'checking' => 'Đang kiểm tra',
                    'refunded' => 'Đã hoàn tiền',
                    default => '...',
                };
            @endphp
            <span class="text-secondary">Trạng thái trả hàng: {{ $statusVN }}</span>
        @endif
    @else
        <button class="btn btn-warning btn-sm return-order-btn">
            Trả hàng/Hoàn tiền
        </button>
    @endif
@endif

                                @endif
                            </div>


                        </div>
                    </div>
                @endforeach

                {{-- Xem thêm --}}
                @if ($orders->count() > $maxVisible)
                    <div class="text-center">
                        <button class="btn btn-link btn-show-more">Xem thêm</button>
                    </div>
                @endif
            @else
                <p class="text-muted">Chưa có đơn hàng trong mục này.</p>
            @endif
        </div>
    </div>

    {{-- Modal đánh giá --}}
    <div id="reviewModal" class="modal fade" tabindex="-1" aria-labelledby="reviewModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form method="POST" action="{{ route('client.reviews.store') }}" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="product_variant_id" id="reviewVariantId">
                <input type="hidden" name="order_id" id="reviewOrderId">
                <input type="hidden" name="rating" id="selectedRating" value="0">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="reviewModalLabel">Đánh giá sản phẩm: <span
                                id="reviewProductName"></span></h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Chọn số sao</label>
                            <div id="starRating" class="rating-stars">
                                @for ($i = 1; $i <= 5; $i++)
                                    <i class="far fa-star star" data-value="{{ $i }}"
                                        style="font-size: 24px; cursor: pointer;"></i>
                                @endfor
                            </div>

                        </div>
                        <div class="mb-3">
                            <label class="form-label">Nội dung đánh giá</label>
                            <textarea name="comment" class="form-control" rows="4" placeholder="Nội dung đánh giá..." required></textarea>
                        </div>
                        <div class="mb-3">
                            <label class="form-label">Ảnh đánh giá (tùy chọn)</label>
                            <input type="file" name="image" accept="image/*" class="form-control">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-success">Gửi đánh giá</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

    {{-- Modal trả hàng --}}
    <div id="returnModal" class="modal fade" tabindex="-1" aria-labelledby="returnModalLabel" aria-hidden="true">
        <div class="modal-dialog">
            <form id="returnRefundForm" enctype="multipart/form-data">
                @csrf
                <input type="hidden" name="order_id" id="returnOrderId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="returnModalLabel">Trả hàng & Hoàn tiền</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Close"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
    <label class="form-label">Lý do trả hàng</label>
    <select name="reason" class="form-select" required>
        <option value="">-- Chọn lý do --</option>
        <option value="Sản phẩm lỗi" {{ old('reason') == 'Sản phẩm lỗi' ? 'selected' : '' }}>Sản phẩm lỗi</option>
        <option value="Giao sai sản phẩm" {{ old('reason') == 'Giao sai sản phẩm' ? 'selected' : '' }}>Giao sai sản phẩm</option>
        <option value="Không muốn mua nữa" {{ old('reason') == 'Không muốn mua nữa' ? 'selected' : '' }}>Không muốn mua nữa</option>
        <option value="Hoàn tiền do người bán hủy đơn">
    Hoàn tiền do người bán hủy đơn
</option>
    </select>
</div>

                        <div class="mb-3">
                            <label class="form-label">Ảnh sản phẩm lỗi</label>
                            <input type="file" name="images[]" multiple class="form-control" accept="image/*">
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-warning">Gửi yêu cầu</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>
    {{-- Modal báo sự cố giao hàng --}}
    <div id="deliveryIssueModal" class="modal fade" tabindex="-1" aria-labelledby="deliveryIssueModalLabel"
        aria-hidden="true">
        <div class="modal-dialog">
            <form id="deliveryIssueForm">
                @csrf
                <input type="hidden" name="order_id" id="issueOrderId">
                <div class="modal-content">
                    <div class="modal-header">
                        <h5 class="modal-title" id="deliveryIssueModalLabel">Báo sự cố giao hàng</h5>
                        <button type="button" class="btn-close" data-bs-dismiss="modal" aria-label="Đóng"></button>
                    </div>
                    <div class="modal-body">
                        <div class="mb-3">
                            <label class="form-label">Mô tả vấn đề</label>
                            <textarea name="reason" class="form-control" rows="4" placeholder="Mô tả lý do bạn chưa nhận được hàng..."
                                required></textarea>
                        </div>
                    </div>
                    <div class="modal-footer">
                        <button type="submit" class="btn btn-danger">Gửi phản hồi</button>
                        <button type="button" class="btn btn-secondary" data-bs-dismiss="modal">Hủy</button>
                    </div>
                </div>
            </form>
        </div>
    </div>

@endsection
@push('scripts')
    {{-- <!-- Bootstrap CSS 3.3.5 -->
    <link href="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/css/bootstrap.min.css" rel="stylesheet" />

    <!-- Bootstrap JS 3.3.5 -->
    <script src="https://maxcdn.bootstrapcdn.com/bootstrap/3.3.5/js/bootstrap.min.js"></script> --}}

    <script src="https://cdn.jsdelivr.net/npm/bootstrap@5.3.3/dist/js/bootstrap.bundle.min.js"></script>
    <script>
        document.addEventListener('DOMContentLoaded', function() {
            const maxVisible = {{ $maxVisible }};

            // ================================
            // Toggle "Xem thêm" đơn hàng
            // ================================
            document.querySelectorAll('.btn-show-more').forEach(button => {
                button.addEventListener('click', function() {
                    const tabPane = this.closest('.tab-pane');
                    const hiddenOrders = tabPane.querySelectorAll('.order-item.d-none');
                    if (hiddenOrders.length) {
                        hiddenOrders.forEach(el => el.classList.remove('d-none'));
                        this.textContent = 'Ẩn bớt';
                    } else {
                        tabPane.querySelectorAll('.order-item').forEach((el, index) => {
                            if (index >= maxVisible) el.classList.add('d-none');
                        });
                        this.textContent = 'Xem thêm';
                    }
                });
            });

            // ================================
            // Huỷ đơn hàng
            // ================================
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

            // ================================
            // Mở modal đánh giá
            // ================================
            document.querySelectorAll('.btn-review').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('reviewVariantId').value = this.dataset.variantId;
                    document.getElementById('reviewOrderId').value = this.dataset.orderId;
                    document.getElementById('reviewProductName').textContent = this.dataset
                        .productName;
                    new bootstrap.Modal(document.getElementById('reviewModal')).show();

                    // Reset stars
                    document.getElementById('selectedRating').value = 0;
                    document.querySelectorAll('#starRating .star').forEach(star => {
                        star.classList.remove('fas', 'selected', 'hovered');
                        star.classList.add('far');
                    });
                });
            });

            // ================================
            // Star Rating
            // ================================
            let currentRating = 0;
            const stars = document.querySelectorAll('#starRating .star');
            stars.forEach(star => {
                star.addEventListener('mouseenter', () => {
                    const val = parseInt(star.dataset.value);
                    stars.forEach(s => {
                        s.classList.toggle('fas', parseInt(s.dataset.value) <= val);
                        s.classList.toggle('far', parseInt(s.dataset.value) > val);
                    });
                });

                star.addEventListener('mouseleave', () => {
                    stars.forEach(s => {
                        s.classList.remove('hovered');
                        if (!s.classList.contains('selected')) {
                            s.classList.remove('fas');
                            s.classList.add('far');
                        }
                    });
                });

                star.addEventListener('click', () => {
                    currentRating = parseInt(star.dataset.value);
                    document.getElementById('selectedRating').value = currentRating;
                    stars.forEach(s => {
                        s.classList.toggle('selected', parseInt(s.dataset.value) <=
                            currentRating);
                        s.classList.toggle('fas', parseInt(s.dataset.value) <=
                            currentRating);
                        s.classList.toggle('far', parseInt(s.dataset.value) >
                            currentRating);
                    });
                });
            });

            // ================================
            // Mở modal Trả hàng/Hoàn tiền
            // ================================
            document.querySelectorAll('.return-order-btn').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('returnOrderId').value = this.closest('.order-item')
                        .dataset.id;
                    new bootstrap.Modal(document.getElementById('returnModal')).show();
                });
            });

            // ================================
            // Gửi yêu cầu trả hàng
            // ================================
            const returnForm = document.getElementById('returnRefundForm');
            if (returnForm) {
                returnForm.addEventListener('submit', function(e) {
                    e.preventDefault();
                    const formData = new FormData(this);
                    const orderId = document.getElementById('returnOrderId').value;

                    fetch(`{{ route('orders.return_refund', ':id') }}`.replace(':id', orderId), {
                            method: 'POST',
                            headers: {
                                'X-CSRF-TOKEN': '{{ csrf_token() }}'
                            },
                            body: formData
                        })
                        .then(res => res.json())
                        .then(res => {
                            if (res.success) {
                                const returnModalEl = document.getElementById('returnModal');
                                const modalInstance = bootstrap.Modal.getInstance(returnModalEl);
                                if (modalInstance) modalInstance.hide();

                                const card = document.querySelector(
                                    `.order-item[data-id="${orderId}"]`);
                                const returnBtn = card?.querySelector('.return-order-btn');
                                if (returnBtn) {
                                    returnBtn.outerHTML = `
                            <span class="text-warning fw-bold">Đã gửi yêu cầu trả hàng</span>
                            <button class="btn btn-danger btn-sm ms-2 cancel-return-request-btn" data-id="${res.return_request_id}">
                                Hủy yêu cầu
                            </button>
                        `;

                                    // Gắn sự kiện click lại cho nút "Hủy yêu cầu" vừa tạo
                                    const cancelBtn = card.querySelector('.cancel-return-request-btn');
                                    if (cancelBtn) {
                                        cancelBtn.addEventListener('click', handleCancelReturnRequest);
                                    }
                                }
                            }

                            alert(res.message);
                        })
                        .catch(() => alert('Đã xảy ra lỗi khi gửi yêu cầu trả hàng.'));
                });
            }

            // ================================
            // Huỷ yêu cầu trả hàng (dùng lại hàm)
            // ================================
            function handleCancelReturnRequest() {
                if (!confirm('Bạn có chắc muốn hủy yêu cầu trả hàng này không?')) return;

                const id = this.dataset.id;

                fetch(`/return-request/${id}/cancel`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        }
                    })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message);
                        if (res.success) location.reload();
                    })
                    .catch(() => alert('Có lỗi xảy ra khi hủy yêu cầu.'));
            }

            // Gắn sự kiện hủy yêu cầu cho các nút đã có
            document.querySelectorAll('.cancel-return-request-btn').forEach(button => {
                button.addEventListener('click', handleCancelReturnRequest);
            });
            // Xác nhận đã nhận hàng
            document.querySelectorAll('.btn-confirm-received').forEach(button => {
                button.addEventListener('click', function() {
                    const id = this.dataset.id;
                    if (confirm('Xác nhận bạn đã nhận được hàng?')) {
                        fetch(`/orders/${id}/confirm-received`, {
                                method: 'POST',
                                headers: {
                                    'X-CSRF-TOKEN': '{{ csrf_token() }}',
                                    'Accept': 'application/json',
                                },
                            })
                            .then(res => res.json())
                            .then(res => {
                                alert(res.message);
                                location.reload();
                            });
                    }
                });
            });

            // Báo sự cố giao hàng
            document.querySelectorAll('.btn-report-issue').forEach(button => {
                button.addEventListener('click', function() {
                    document.getElementById('issueOrderId').value = this.dataset.id;
                    new bootstrap.Modal(document.getElementById('deliveryIssueModal')).show();
                });
            });

            document.getElementById('deliveryIssueForm').addEventListener('submit', function(e) {
                e.preventDefault();
                const formData = new FormData(this);

                fetch(`/orders/report-issue`, {
                        method: 'POST',
                        headers: {
                            'X-CSRF-TOKEN': '{{ csrf_token() }}',
                            'Accept': 'application/json',
                        },
                        body: formData
                    })
                    .then(res => res.json())
                    .then(res => {
                        alert(res.message);

                        // Đóng modal
                        const modalEl = document.getElementById('deliveryIssueModal');
                        const modal = bootstrap.Modal.getInstance(modalEl);
                        if (modal) modal.hide();

                        // Cập nhật UI: thay nút bằng dòng chữ "Đã phản hồi"
                        const orderId = document.getElementById('issueOrderId').value;
                        const card = document.querySelector(`.order-item[data-id="${orderId}"]`);
                        const reportBtn = card?.querySelector('.btn-report-issue');

                        if (reportBtn) {
                            reportBtn.outerHTML =
                                `<span class="text-info fw-bold">Đã gửi phản hồi</span>`;
                        }
                    })

                    .catch(() => alert('Có lỗi xảy ra khi gửi phản hồi.'));
            });

        });
    </script>
@endpush
