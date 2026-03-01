@extends('client.layouts.app')

@section('content')

    <script src="https://cdn.tailwindcss.com"></script>
    {{-- SUCCESS TOAST --}}
    <div id="successToast"
        class="fixed top-5 right-5 bg-[#F4C430] text-black px-6 py-3 rounded-xl shadow-lg
            transform translate-x-full opacity-0 transition-all duration-300 z-50 font-semibold">
        🛒 Thêm vào giỏ hàng thành công!
    </div>
    <div class="max-w-7xl mx-auto px-4 py-10">

        {{-- PRODUCT SECTION --}}
        <div class="grid md:grid-cols-2 gap-12 bg-white p-8 rounded-2xl shadow-xl">

            {{-- LEFT IMAGE --}}
            <div>
                <div class="w-full h-[450px] overflow-hidden rounded-xl border">
                    <img id="mainImage" src="{{ asset('storage/' . $product->image) }}"
                        class="w-full h-full object-cover hover:scale-105 transition duration-300">
                </div>

                <div id="albumWrapper" class="flex flex-wrap gap-3 mt-4">
                    @foreach ($product->variants as $variant)
                        @foreach ($variant->images as $img)
                            <div class="w-20 h-20 border rounded-lg overflow-hidden cursor-pointer hidden"
                                data-variant="{{ $variant->id }}">
                                <img src="{{ asset('storage/' . $img->image) }}"
                                    class="w-full h-full object-cover variant-album-img"
                                    data-image="{{ asset('storage/' . $img->image) }}">
                            </div>
                        @endforeach
                    @endforeach
                </div>
            </div>

            {{-- RIGHT INFO --}}
            <div>

                <h1 class="text-3xl font-bold mb-4">
                    {{ $product->product_name }}
                </h1>

                {{-- PRICE --}}
                <div id="priceBlock" class="mb-4">
                    @if ($product->discount_price)
                        <span class="text-3xl font-bold text-red-600">
                            {{ number_format($product->discount_price, 0, ',', '.') }} đ
                        </span>
                        <span class="text-lg text-gray-400 line-through ml-3">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </span>
                    @else
                        <span class="text-3xl font-bold text-red-600">
                            {{ number_format($product->price, 0, ',', '.') }} đ
                        </span>
                    @endif
                </div>

                {{-- STOCK --}}
                <div class="mb-6">
                    <span class="text-gray-600">Tồn kho:</span>
                    <span id="stock" class="font-semibold text-green-600">
                        {{ $product->quantity }}
                    </span>
                </div>

                {{-- SPEC --}}
                <div class="bg-gray-50 rounded-xl p-4 mb-6 text-sm">
                    <div class="grid grid-cols-2 gap-y-2">
                        <span class="font-semibold">RAM:</span>
                        <span id="ram">-</span>

                        <span class="font-semibold">Bộ nhớ:</span>
                        <span id="storage">-</span>

                        <span class="font-semibold">Màu:</span>
                        <span id="color">-</span>
                    </div>
                </div>

                {{-- VARIANTS --}}
                @if ($product->variants->count())
                    <div class="mb-6">
                        <h4 class="font-semibold mb-3">Chọn phiên bản</h4>
                        <div class="flex flex-wrap gap-3">
                            @foreach ($product->variants as $variant)
                                <button type="button"
                                    class="variant-option px-4 py-2 border rounded-full text-sm hover:bg-black hover:text-white transition"
                                    data-id="{{ $variant->id }}"
                                    data-image="{{ asset('storage/' . ($variant->image ?? $product->image)) }}"
                                    data-price="{{ $variant->price }}"
                                    data-discount-price="{{ $variant->discount_price }}"
                                    data-ram="{{ $variant->ram->value ?? '-' }}"
                                    data-storage="{{ $variant->storage->value ?? '-' }}"
                                    data-color="{{ $variant->color->value ?? '-' }}"
                                    data-quantity="{{ $variant->quantity }}">
                                    {{ $variant->ram->value ?? '?' }}
                                    /
                                    {{ $variant->storage->value ?? '?' }}
                                    /
                                    {{ $variant->color->value ?? '?' }}
                                </button>
                            @endforeach
                        </div>
                    </div>
                @endif

                {{-- ACTION --}}
                <div class="flex items-center gap-4 mt-6">

                    <div class="flex border rounded-lg overflow-hidden">
                        <button onclick="changeQty(-1)" class="px-4 bg-gray-100">-</button>
                        <input type="number" id="quantityInput" value="1" min="1"
                            class="w-16 text-center outline-none">
                        <button onclick="changeQty(1)" class="px-4 bg-gray-100">+</button>
                    </div>

                    <form action="{{ route('cart.add') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="product_variant_id" id="addToCartVariantId">
                        <input type="hidden" name="quantity" id="cartQty">

                        <button
                            class="bg-[#F4C430] text-black px-8 py-3 rounded-2xl
                                 hover:bg-[#e0b020] transition font-semibold shadow-md hover:shadow-lg">
                            🛒 Thêm vào giỏ
                        </button>
                    </form>

                    <form action="{{ route('cart.buyNow') }}" method="POST">
                        @csrf
                        <input type="hidden" name="product_id" value="{{ $product->id }}">
                        <input type="hidden" name="variant_id" id="selectedVariantId">
                        <input type="hidden" name="quantity" id="buyNowQuantity">

                        <button class="bg-black text-white px-6 py-3 rounded-lg hover:opacity-80 transition">
                            Mua ngay
                        </button>
                    </form>

                </div>

            </div>
        </div>

        {{-- DESCRIPTION --}}
        <div class="mt-16">
            <h2 class="text-2xl font-bold mb-4">Mô tả chi tiết</h2>
            <div class="bg-gray-50 p-6 rounded-xl leading-relaxed">
                {!! $product->description ?? 'Đang cập nhật...' !!}
            </div>
        </div>
        <hr class="my-10 border-gray-300">

@php
    $user = auth()->user();
    $comments = $comments->filter(fn($c) => !empty($c->comment));
    $ratings = $reviews->filter(fn($r) => !empty($r->rating));

    $limit = $limit ?? 6;
    $totalComments = $totalComments ?? $comments->count();

    $ratingLimit = request('rating_limit', 6);
    $totalRatings = $ratings->count();
    $displayRatings = $ratings->sortByDesc('created_at')->take($ratingLimit);
@endphp

{{-- Tabs --}}
<div class="border-b border-gray-200">
    <nav class="flex gap-6" id="reviewTab">
        <button class="tab-btn py-3 border-b-2 border-black font-semibold"
            data-tab="comments">
            Bình luận ({{ $totalComments }})
        </button>

        <button class="tab-btn py-3 border-b-2 border-transparent text-gray-500"
            data-tab="ratings">
            Đánh giá ({{ $totalRatings }})
        </button>
    </nav>
</div>

<div class="mt-6">

    {{-- Tab Bình luận --}}
    <div class="tab-content" id="comments">

        <h5 class="text-lg font-semibold mb-6">Danh sách bình luận</h5>

        @if ($comments->count() > 0)

            <ul class="space-y-4">
                @foreach ($comments as $comment)
                    <li class="bg-white border rounded-xl shadow-sm p-4">

                        <div class="flex justify-between mb-2">
                            <strong class="text-blue-600">
                                {{ $comment->account->full_name ?? 'Người dùng ẩn danh' }}
                            </strong>

                            <small class="text-gray-500">
                                {{ $comment->created_at->format('H:i d/m/Y') }}
                            </small>
                        </div>

                        <p class="mb-2 text-sm text-gray-700">
                            {{ $comment->comment }}
                        </p>

                        @if ($comment->image)
                            <img src="{{ asset('storage/' . $comment->image) }}"
                                class="border rounded-lg max-w-[130px] max-h-[130px]">
                        @endif

                    </li>
                @endforeach
            </ul>

            <div class="text-center mt-4 space-x-2">
                @if ($totalComments > $limit)
                    <a href="{{ request()->fullUrlWithQuery(['limit' => $limit + 6]) }}"
                        class="inline-block px-4 py-2 border border-blue-500 text-blue-600 rounded-lg text-sm hover:bg-blue-500 hover:text-white transition">
                        Xem thêm
                    </a>
                @endif

                @if ($limit > 6)
                    <a href="{{ request()->fullUrlWithQuery(['limit' => 6]) }}"
                        class="inline-block px-4 py-2 border border-gray-400 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">
                        Ẩn bớt
                    </a>
                @endif
            </div>

        @else
            <p class="text-gray-500 italic">Chưa có bình luận nào.</p>
        @endif

        <hr class="my-8">

        {{-- Form gửi bình luận --}}
        @if ($user)

            <form action="{{ route('client.comments.store') }}"
                method="POST"
                enctype="multipart/form-data"
                class="space-y-4">
                @csrf

                <input type="hidden" name="product_id" value="{{ $product->id }}">

                <div>
                    <label class="block font-semibold mb-2">
                        Nội dung bình luận:
                    </label>
                    <textarea name="comment"
                        rows="4"
                        required
                        class="w-full border rounded-lg p-3 focus:ring-2 focus:ring-black focus:outline-none"
                        placeholder="Viết bình luận của bạn..."></textarea>
                </div>

                <div>
                    <label class="block font-semibold mb-2">
                        Ảnh đính kèm (nếu có):
                    </label>
                    <input type="file"
                        name="image"
                        accept="image/*"
                        class="w-full border rounded-lg p-2">
                </div>

                <button type="submit"
                    class="px-6 py-2 bg-black text-white rounded-lg hover:bg-gray-800 transition">
                    Gửi bình luận
                </button>
            </form>

        @else
            <p class="mt-4">
                Vui lòng
                <a href="{{ route('taikhoan.login') }}"
                    class="text-blue-600 hover:underline">
                    đăng nhập
                </a>
                để bình luận.
            </p>
        @endif

    </div>

    {{-- Tab Đánh giá --}}
    <div class="tab-content hidden" id="ratings">

        @if ($totalRatings > 0)

            <ul class="space-y-4">
                @foreach ($displayRatings as $rating)

                    <li class="bg-white border rounded-xl shadow-sm p-4">

                        <div class="flex justify-between mb-2">
                            <strong class="text-green-600">
                                {{ $rating->account->full_name ?? 'Người dùng ẩn danh' }}
                            </strong>

                            <small class="text-gray-500">
                                {{ $rating->created_at->format('H:i d/m/Y') }}
                            </small>
                        </div>

                        <div class="mb-2 text-sm">
                            <span class="font-semibold">Sản phẩm:</span>
                            {{ $rating->product->product_name ?? 'N/A' }}
                            <span class="ml-3 text-gray-600">
                                {{ $rating->variant->ram->value ?? '' }} /
                                {{ $rating->variant->storage->value ?? '' }} /
                                {{ $rating->variant->color->value ?? '' }}
                            </span>
                        </div>

                        <div class="mb-2">
                            @for ($i = 1; $i <= 5; $i++)
                                @if ($i <= $rating->rating)
                                    <span class="text-yellow-400">&#9733;</span>
                                @else
                                    <span class="text-gray-300">&#9733;</span>
                                @endif
                            @endfor
                            <span class="ml-2 font-bold">
                                {{ $rating->rating }} sao
                            </span>
                        </div>

                        @if (!empty($rating->comment))
                            <p class="mb-2 text-sm">
                                <strong>Nội dung:</strong>
                                {{ $rating->comment }}
                            </p>
                        @endif

                        @if (!empty($rating->image))
                            <img src="{{ asset('storage/' . $rating->image) }}"
                                class="border rounded-lg max-w-[130px] max-h-[130px]">
                        @endif

                    </li>

                @endforeach
            </ul>

            <div class="text-center mt-4 space-x-2">
                @if ($totalRatings > $ratingLimit)
                    <a href="{{ request()->fullUrlWithQuery(['rating_limit' => $ratingLimit + 6]) }}"
                        class="inline-block px-4 py-2 border border-blue-500 text-blue-600 rounded-lg text-sm hover:bg-blue-500 hover:text-white transition">
                        Xem thêm
                    </a>
                @endif

                @if ($ratingLimit > 6)
                    <a href="{{ request()->fullUrlWithQuery(['rating_limit' => 6]) }}"
                        class="inline-block px-4 py-2 border border-gray-400 text-gray-600 rounded-lg text-sm hover:bg-gray-200 transition">
                        Ẩn bớt
                    </a>
                @endif
            </div>

        @else
            <p class="text-gray-500 italic">Chưa có đánh giá nào.</p>
        @endif

    </div>
</div>

{{-- JS chuyển tab --}}
<script>
document.querySelectorAll('.tab-btn').forEach(btn => {
    btn.addEventListener('click', function () {

        document.querySelectorAll('.tab-btn').forEach(b => {
            b.classList.remove('border-black','font-semibold');
            b.classList.add('border-transparent','text-gray-500');
        });

        this.classList.remove('text-gray-500');
        this.classList.add('border-black','font-semibold');

        document.querySelectorAll('.tab-content').forEach(tab => {
            tab.classList.add('hidden');
        });

        document.getElementById(this.dataset.tab).classList.remove('hidden');
    });
});
</script>
        {{-- RELATED --}}
        @if ($relatedProducts->count())
            <hr class="my-10 border-gray-300">

            <h4 class="text-xl font-bold mb-6">Sản phẩm liên quan</h4>

            <div class="grid grid-cols-1 sm:grid-cols-2 md:grid-cols-4 gap-6">
                @foreach ($relatedProducts as $item)
                    <div>
                        <div class="bg-white rounded-xl shadow-sm hover:shadow-md transition h-full">

                            <a href="{{ route('product.show', $item->id) }}">
                                <img src="{{ asset('storage/' . $item->image) }}" alt="{{ $item->product_name }}"
                                    class="w-full h-[200px] object-cover rounded-t-xl">
                            </a>

                            <div class="p-3">
                                <h6 class="mb-2">
                                    <a href="{{ route('product.show', $item->id) }}"
                                        class="text-gray-800 hover:text-blue-600 font-medium line-clamp-2">
                                        {{ $item->product_name }}
                                    </a>
                                </h6>

                                <p class="mb-0 text-red-600 font-semibold">
                                    @if ($item->discount_price)
                                        {{ number_format($item->discount_price, 0, ',', '.') }} đ

                                        <span class="block text-sm text-gray-400 line-through font-normal">
                                            {{ number_format($item->price, 0, ',', '.') }} đ
                                        </span>
                                    @else
                                        {{ number_format($item->price, 0, ',', '.') }} đ
                                    @endif
                                </p>
                            </div>

                        </div>
                    </div>
                @endforeach
            </div>
            </form>
        @endif

    </div>

    {{-- SCRIPT --}}
    <script>
        document.addEventListener('DOMContentLoaded', function() {

            const qtyInput = document.getElementById('quantityInput');
            const buyNowQty = document.getElementById('buyNowQuantity');
            const cartQty = document.getElementById('cartQty');
            const variantButtons = document.querySelectorAll('.variant-option');
            const selectedVariantInput = document.getElementById('selectedVariantId');
            const addToCartVariantInput = document.getElementById('addToCartVariantId');
            const albumImages = document.querySelectorAll('[data-variant]');
            const mainImage = document.getElementById('mainImage');
            const stockElement = document.getElementById('stock');

            function syncQty() {
                let value = parseInt(qtyInput.value) || 1;
                if (value < 1) value = 1;
                qtyInput.value = value;
                buyNowQty.value = value;
                cartQty.value = value;
            }

            window.changeQty = function(change) {
                qtyInput.value = parseInt(qtyInput.value || 1) + change;
                syncQty();
            };

            syncQty();

            variantButtons.forEach(button => {
                button.addEventListener('click', function() {

                    const variantId = this.dataset.id;
                    const price = parseInt(this.dataset.price || 0);
                    const discountPrice = parseInt(this.dataset.discountPrice || 0);
                    const ram = this.dataset.ram;
                    const storage = this.dataset.storage;
                    const color = this.dataset.color;
                    const quantity = parseInt(this.dataset.quantity || 0);

                    mainImage.src = this.dataset.image;

                    const priceBlock = document.getElementById('priceBlock');
                    if (discountPrice && discountPrice < price) {
                        priceBlock.innerHTML =
                            `<span class="text-3xl font-bold text-red-600">${discountPrice.toLocaleString('vi-VN')} đ</span>
                     <span class="text-lg text-gray-400 line-through ml-3">${price.toLocaleString('vi-VN')} đ</span>`;
                    } else {
                        priceBlock.innerHTML =
                            `<span class="text-3xl font-bold text-red-600">${price.toLocaleString('vi-VN')} đ</span>`;
                    }

                    document.getElementById('ram').innerText = ram;
                    document.getElementById('storage').innerText = storage;
                    document.getElementById('color').innerText = color;

                    stockElement.innerText = quantity;

                    selectedVariantInput.value = variantId;
                    addToCartVariantInput.value = variantId;

                    variantButtons.forEach(btn => btn.classList.remove('bg-black', 'text-white'));
                    this.classList.add('bg-black', 'text-white');

                    albumImages.forEach(img => {
                        img.classList.toggle('hidden', img.dataset.variant !== variantId);
                    });

                });
            });

            if (variantButtons.length > 0) {
                variantButtons[0].click();
            }

            document.addEventListener('click', function(e) {
                if (e.target.classList.contains('variant-album-img')) {
                    mainImage.src = e.target.dataset.image;
                }
            });

        });
    </script>

@endsection
