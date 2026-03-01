@extends('client.layouts.app-2')

@section('content')

<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- PRODUCT SECTION --}}
    <div class="grid md:grid-cols-2 gap-12 bg-white p-8 rounded-2xl shadow-xl">

        {{-- LEFT IMAGE --}}
        <div>
            <div class="w-full h-[450px] overflow-hidden rounded-xl border">
                <img id="mainImage"
                     src="{{ asset('storage/' . $product->image) }}"
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
            @if($product->variants->count())
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

                    <button class="bg-red-600 text-white px-6 py-3 rounded-lg hover:bg-red-700 transition">
                        Thêm vào giỏ
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

    {{-- RELATED --}}
    @if ($relatedProducts->count())
    <div class="mt-20">
        <h2 class="text-2xl font-bold mb-8">Sản phẩm liên quan</h2>

        <div class="grid sm:grid-cols-2 md:grid-cols-4 gap-6">
            @foreach ($relatedProducts as $item)
                <div class="bg-white rounded-xl shadow hover:shadow-lg transition overflow-hidden">

                    <img src="{{ asset('storage/' . $item->image) }}"
                         class="h-52 w-full object-cover">

                    <div class="p-4">
                        <h3 class="font-semibold mb-2 line-clamp-2">
                            {{ $item->product_name }}
                        </h3>

                        <div class="text-red-600 font-bold">
                            {{ number_format($item->price, 0, ',', '.') }} đ
                        </div>
                    </div>
                </div>
            @endforeach
        </div>
    </div>
    @endif

</div>

{{-- SCRIPT --}}
<script>
document.addEventListener('DOMContentLoaded', function () {

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

            variantButtons.forEach(btn => btn.classList.remove('bg-black','text-white'));
            this.classList.add('bg-black','text-white');

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
