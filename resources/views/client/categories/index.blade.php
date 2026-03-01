@extends('client.layouts.app')
@section('content')

<div class="min-h-screen bg-gray-100">

    {{-- TOP BAR --}}
    <div class="bg-white shadow-sm border-b">
        <div class="max-w-7xl mx-auto px-6 py-6">
            <h1 class="text-3xl font-bold text-gray-900">Cửa hàng</h1>
            <p class="text-gray-500 text-sm mt-1">
                {{ $products->total() }} sản phẩm được tìm thấy
            </p>
        </div>
    </div>

    <div class="max-w-7xl mx-auto px-6 py-10">

        <div class="grid grid-cols-1 lg:grid-cols-4 gap-8">

            {{-- SIDEBAR FILTER --}}
            <div class="lg:col-span-1 space-y-6">

                {{-- CATEGORY CARD --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border">
                    <h3 class="font-semibold text-gray-900 mb-4">Danh mục</h3>

                    <ul class="space-y-2 text-sm">

                        <li>
                            <a href="{{ route('client.categories') }}"
                               class="block px-3 py-2 rounded-lg transition
                               {{ !$selectedCategory ? 'bg-[#F4C430] text-black font-semibold' : 'hover:bg-gray-100' }}">
                                Tất cả sản phẩm
                            </a>
                        </li>

                        @foreach($categories as $category)
                            <li>
                                <a href="{{ route('client.categories.filter', $category->id) }}"
                                   class="block px-3 py-2 rounded-lg transition
                                   {{ $selectedCategory == $category->id ? 'bg-[#F4C430] text-black font-semibold' : 'hover:bg-gray-100' }}">
                                    {{ $category->category_name }}
                                </a>
                            </li>
                        @endforeach

                    </ul>
                </div>

                {{-- FILTER CARD --}}
                <div class="bg-white rounded-2xl shadow-sm p-6 border">
                    <h3 class="font-semibold text-gray-900 mb-4">Tìm kiếm</h3>

                    <form method="GET" class="space-y-4">

                        <input type="text"
                               name="search"
                               placeholder="Nhập tên sản phẩm..."
                               value="{{ request('search') }}"
                               class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#F4C430] outline-none">

                        <select name="sort_price"
                                class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-[#F4C430] outline-none">
                            <option value="">Sắp xếp theo giá</option>
                            <option value="asc" {{ request('sort_price') == 'asc' ? 'selected' : '' }}>
                                Giá thấp → cao
                            </option>
                            <option value="desc" {{ request('sort_price') == 'desc' ? 'selected' : '' }}>
                                Giá cao → thấp
                            </option>
                        </select>

                        <button type="submit"
                                class="w-full bg-black text-white py-2 rounded-xl font-semibold hover:bg-gray-900 transition">
                            Áp dụng
                        </button>

                    </form>
                </div>

            </div>

            {{-- PRODUCT AREA --}}
            <div class="lg:col-span-3">

                @if($products->count() > 0)

                    <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-3 gap-6">

                        @foreach($products as $product)

                            <div class="bg-white rounded-2xl shadow-sm hover:shadow-xl transition relative group flex flex-col overflow-hidden border">

                                {{-- IMAGE --}}
                                <div class="h-52 bg-gray-50 flex items-center justify-center relative">

                                    @if($product->discount_price)
                                        <span class="absolute top-3 left-3 bg-[#F4C430] text-black text-xs px-3 py-1 rounded-full font-semibold">
                                            -{{ number_format((($product->price - $product->discount_price) / $product->price) * 100, 0) }}%
                                        </span>
                                    @endif

                                    <img src="{{ asset('storage/' . $product->image) }}"
                                         class="h-full object-contain p-4 group-hover:scale-105 transition duration-300"
                                         alt="{{ $product->product_name }}">
                                </div>

                                {{-- INFO --}}
                                <div class="p-4 flex flex-col flex-1">

                                    <h4 class="font-medium text-gray-900 mb-2 line-clamp-2 min-h-[40px]">
                                        {{ $product->product_name }}
                                    </h4>

                                    <div class="mb-4">
                                        <span class="text-lg font-bold text-black">
                                            {{ number_format($product->discount_price ?? $product->price, 0, ',', '.') }} ₫
                                        </span>

                                        @if($product->discount_price)
                                            <span class="text-sm line-through text-gray-400 ml-2">
                                                {{ number_format($product->price, 0, ',', '.') }} ₫
                                            </span>
                                        @endif
                                    </div>

                                    <div class="mt-auto flex gap-2">

                                        <a href="{{ route('product.show', $product->id) }}"
                                           class="flex-1 text-center border border-black text-black py-2 rounded-xl text-sm hover:bg-black hover:text-white transition">
                                            Chi tiết
                                        </a>

                                        <button type="button"
                                                onclick="toggleCartForm(this)"
                                                class="flex-1 bg-[#F4C430] hover:bg-[#e0b020] text-black py-2 rounded-xl text-sm font-semibold transition">
                                            Thêm
                                        </button>

                                    </div>
                                </div>

                                {{-- CART POPUP --}}
                                <form action="{{ route('cart.add') }}"
                                      method="POST"
                                      class="cart-popup hidden absolute inset-0 bg-black/50 backdrop-blur-sm flex items-center justify-center p-4 z-20">
                                    @csrf

                                    <div class="bg-white rounded-2xl shadow-2xl p-5 w-full max-w-xs">

                                        <input type="hidden" name="product_id" value="{{ $product->id }}">

                                        @if ($product->variants->count() > 1)
                                            <select name="product_variant_id"
                                                    class="w-full border rounded-lg p-2 mb-3 text-sm focus:ring-2 focus:ring-[#F4C430]"
                                                    required>
                                                <option value="">-- Chọn phiên bản --</option>
                                                @foreach($product->variants as $variant)
                                                    <option value="{{ $variant->id }}">
                                                        {{ $variant->ram->value ?? '' }} /
                                                        {{ $variant->storage->value ?? '' }} /
                                                        {{ $variant->color->value ?? '' }}
                                                    </option>
                                                @endforeach
                                            </select>
                                        @else
                                            <input type="hidden"
                                                   name="product_variant_id"
                                                   value="{{ $product->variants->first()->id ?? '' }}">
                                        @endif

                                        <div class="flex items-center mb-4 border rounded-lg overflow-hidden">
                                            <button type="button"
                                                    onclick="this.nextElementSibling.stepDown()"
                                                    class="px-3 bg-gray-100">-</button>

                                            <input type="number"
                                                   name="quantity"
                                                   value="1"
                                                   min="1"
                                                   max="99"
                                                   class="w-full text-center outline-none">

                                            <button type="button"
                                                    onclick="this.previousElementSibling.stepUp()"
                                                    class="px-3 bg-gray-100">+</button>
                                        </div>

                                        <div class="flex gap-2">
                                            <button type="button"
                                                    onclick="this.closest('.cart-popup').classList.add('hidden')"
                                                    class="flex-1 bg-gray-200 py-2 rounded-lg text-sm">
                                                Huỷ
                                            </button>

                                            <button type="submit"
                                                    class="flex-1 bg-black text-white py-2 rounded-lg text-sm hover:bg-gray-900 transition">
                                                Xác nhận
                                            </button>
                                        </div>
                                    </div>
                                </form>

                            </div>

                        @endforeach

                    </div>

                    <div class="mt-10">
                        {{ $products->withQueryString()->links() }}
                    </div>

                @else
                    <div class="bg-white rounded-2xl shadow-sm p-10 text-center text-gray-500 border">
                        Không tìm thấy sản phẩm phù hợp.
                    </div>
                @endif

            </div>

        </div>

    </div>

</div>
<script>
    function toggleCartForm(button) {
        // Lấy card cha
        const card = button.closest('.group');

        // Tìm popup trong card đó
        const popup = card.querySelector('.cart-popup');

        // Hiện popup
        popup.classList.remove('hidden');
    }

    // Đóng popup khi click ra ngoài vùng trắng
    document.addEventListener('click', function (e) {
        const popups = document.querySelectorAll('.cart-popup');

        popups.forEach(function (popup) {
            if (!popup.classList.contains('hidden')) {
                const content = popup.querySelector('.bg-white');

                if (!content.contains(e.target) && !e.target.closest('button[onclick="toggleCartForm(this)"]')) {
                    popup.classList.add('hidden');
                }
            }
        });
    });
</script>
@endsection
