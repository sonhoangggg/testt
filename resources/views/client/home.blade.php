@extends('client.layouts.app')
@if (session('success'))
    <div class="alert alert-success">
        {{ session('success') }}
    </div>
@endif

@if (session('error'))
    <div class="alert alert-danger">
        {{ session('error') }}
    </div>
@endif
@section('content')
    <main class="max-w-[1440px] mx-auto pb-20">
        <section class="px-4 md:px-10 lg:px-20 pt-6">
            <div class="relative rounded-xl overflow-hidden min-h-[500px] flex items-center bg-black">
                <div class="absolute inset-0 opacity-60 bg-cover bg-center"
                    style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC5kdFa3m9RUyDOq-JtvVLeftcUlBc6RuUdpkwd-5rIXy21cwcMlwnUIkUZaRfoj74ICQrqwsO7DeeuvrhgFF_x8I92BXUHwJMMRUZf-MR8fjOhUaI9Oxm8WU2eguZGf_UlhPXIrY623OqW6I1pyC1LyqeQLCOmaBjJXRvA_tqBqeuWZ9YFkhq0TXuqygePpabB11X7C97enS5EAu0DtT6mle7wJJJRXh6vPTyatcvr5OshfcRZEWITof1ivLP04JrBjdi79dY67SE');">
                </div>
                <div class="relative z-10 p-8 md:p-16 max-w-2xl text-white">
                    <span
                        class="bg-primary text-black px-3 py-1 rounded-full text-xs font-bold uppercase tracking-wider mb-4 inline-block">Flash
                        Sale</span>
                    <h1 class="text-4xl md:text-6xl font-bold leading-tight mb-6">Trải nghiệm Tương lai: iPhone 15 Pro
                    </h1>
                    <p class="text-lg text-gray-200 mb-8">Thiết kế Titan, chip A17 Pro và hệ thống camera chuyên nghiệp.
                        Ưu đãi flagship không thể bỏ lỡ trong thời gian có hạn.</p>
                    <div class="flex flex-wrap gap-4">
                        <button
                            class="bg-primary text-black px-8 py-4 rounded-lg font-bold hover:scale-105 transition-transform flex items-center gap-2">
                            Mua ngay <span class="material-symbols-outlined">arrow_forward</span>
                        </button>
                        <button
                            class="bg-white/10 backdrop-blur-md text-white border border-white/20 px-8 py-4 rounded-lg font-bold hover:bg-white/20 transition-colors">
                            Thông số
                        </button>
                    </div>
                </div>
                <div class="absolute bottom-6 left-1/2 -translate-x-1/2 flex gap-2">
                    <div class="w-8 h-1 bg-primary rounded-full"></div>
                    <div class="w-8 h-1 bg-white/30 rounded-full"></div>
                    <div class="w-8 h-1 bg-white/30 rounded-full"></div>
                </div>
            </div>
        </section>
        <section class="px-4 md:px-10 lg:px-20 mt-20">
            <div class="flex items-center gap-3 mb-8">
                <span class="material-symbols-outlined text-primary">auto_awesome</span>
                <h2 class="text-3xl font-bold">Combo Hoàn Hảo</h2>
                <span class="bg-primary/20 text-black dark:text-primary text-[10px] font-bold px-2 py-1 rounded">AI GỢI
                    Ý</span>
            </div>
            <div
                class="bg-white dark:bg-white/5 border border-[#f5f3f0] dark:border-white/10 rounded-2xl p-6 lg:p-10 flex flex-col lg:flex-row items-center gap-8">
                <div class="flex-1 grid grid-cols-3 gap-4 w-full">
                    <div class="flex flex-col items-center">
                        <div class="aspect-square w-full rounded-xl bg-gray-100 dark:bg-white/10 bg-cover bg-center mb-4"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuC5kdFa3m9RUyDOq-JtvVLeftcUlBc6RuUdpkwd-5rIXy21cwcMlwnUIkUZaRfoj74ICQrqwsO7DeeuvrhgFF_x8I92BXUHwJMMRUZf-MR8fjOhUaI9Oxm8WU2eguZGf_UlhPXIrY623OqW6I1pyC1LyqeQLCOmaBjJXRvA_tqBqeuWZ9YFkhq0TXuqygePpabB11X7C97enS5EAu0DtT6mle7wJJJRXh6vPTyatcvr5OshfcRZEWITof1ivLP04JrBjdi79dY67SE');">
                        </div>
                        <p class="text-sm font-bold text-center">iPhone 15 Pro</p>
                    </div>
                    <div class="flex items-center justify-center">
                        <span class="material-symbols-outlined text-gray-400">add</span>
                    </div>
                    <div class="grid grid-cols-1 gap-4">
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/5 rounded-xl">
                            <div class="size-16 rounded-lg bg-cover bg-center flex-shrink-0"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBZp11AcszU9PiGrp6P8pUbHSD87aNa0yxEh63Ans10gq55eeR9itxGcg47cvcN4vtjs63hWu9YYBGc6Oxeop7t9iHTJDiFMM_GCa4_Q110rUn9BpM4j1vAhw5NgoLKm418eNW_z-481DLyUQpsPTn2M3ZslkLE4Tb6O3Uz9JYIpV_dKGXJ0FXCmgYeAZHCdzTHUNt7EMGBT2oAxyFc3acmNWDmZCi6fRQLvkDRp2ldGXj3lBLigzLX-nhYvJ-jYHfW_reZMfz94ys');">
                            </div>
                            <div>
                                <p class="text-xs font-bold">Ốp lưng MagSafe</p>
                                <p class="text-xs text-gray-500">1.150.000₫</p>
                            </div>
                        </div>
                        <div class="flex items-center gap-3 p-3 bg-gray-50 dark:bg-white/5 rounded-xl">
                            <div class="size-16 rounded-lg bg-cover bg-center flex-shrink-0"
                                style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCEw9D9tBP0Y5ICsquYYtjRFOLKYTZipIrzjYOsRJc-WlAviyQnHlKmXJvWIEqykSf0SVlQcxtpmhfm2n_DK5r0XvwzzPlll3IUPSYBrw8coo4VBAIGL8c7hvMTW1AkCHuxipEm0kuT3lvTtdQif9Cj4UB-s2WBlX1H68qOONkg2o8Z6wpZwbPlCZime6_5not2J-5adjtaIzTm-vfX5CrwnGm7574ylneRYB3c9bFIYTz-mF5s3v3b6fKqTvYTy2rz47V8PvJLeLw');">
                            </div>
                            <div>
                                <p class="text-xs font-bold">Củ sạc 20W</p>
                                <p class="text-xs text-gray-500">690.000₫</p>
                            </div>
                        </div>
                    </div>
                </div>
                <div class="lg:w-80 w-full p-6 bg-primary rounded-xl text-black">
                    <div class="mb-4">
                        <p class="text-sm font-medium opacity-80 uppercase tracking-wider">Tổng giá trị combo</p>
                        <div class="flex items-end gap-2">
                            <h3 class="text-3xl font-black">28.990.000₫</h3>
                            <span class="text-sm line-through opacity-60">32.200.000₫</span>
                        </div>
                    </div>
                    <p class="text-xs mb-6 font-bold flex items-center gap-1">
                        <span class="material-symbols-outlined text-sm">verified</span>
                        Tiết kiệm ngay 10% khi mua cả bộ
                    </p>
                    <button
                        class="w-full bg-black text-white py-4 rounded-lg font-bold hover:scale-[1.02] transition-transform flex items-center justify-center gap-2">
                        <span class="material-symbols-outlined">shopping_basket</span>
                        Mua cả bộ
                    </button>
                </div>
            </div>
        </section>
        <section class="px-4 md:px-10 lg:px-20 mt-16">
            <div class="flex items-center justify-between mb-8">
                <h2 class="text-3xl font-bold">Sản phẩm mới</h2>
                <a class="text-primary font-bold flex items-center gap-1 hover:underline" href="#">Xem tất cả
                    <span class="material-symbols-outlined">chevron_right</span></a>
            </div>
            <div class="grid grid-cols-1 sm:grid-cols-2 lg:grid-cols-4 gap-6">
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
        </section>
        <section class="px-4 md:px-10 lg:px-20 mt-20">
            <div class="bg-primary/10 border-2 border-primary/20 rounded-2xl p-8">
                <div class="flex flex-col md:flex-row items-center justify-between gap-8 mb-10">
                    <div>
                        <h2 class="text-3xl font-bold mb-2">🔥 Ưu đãi cực HOT trong tuần</h2>
                        <p class="text-gray-600 dark:text-gray-300">Săn ngay deal hời từ các sản phẩm yêu thích nhất.
                            Đừng bỏ lỡ!</p>
                    </div>
                    <div class="flex items-center gap-4">
                        <div class="text-center">
                            <div
                                class="bg-primary text-black font-bold text-xl w-12 h-12 flex items-center justify-center rounded-lg">
                                02</div>
                            <span class="text-[10px] font-bold uppercase mt-1 block">NGÀY</span>
                        </div>
                        <div class="text-xl font-bold">:</div>
                        <div class="text-center">
                            <div
                                class="bg-primary text-black font-bold text-xl w-12 h-12 flex items-center justify-center rounded-lg">
                                14</div>
                            <span class="text-[10px] font-bold uppercase mt-1 block">GIỜ</span>
                        </div>
                        <div class="text-xl font-bold">:</div>
                        <div class="text-center">
                            <div
                                class="bg-primary text-black font-bold text-xl w-12 h-12 flex items-center justify-center rounded-lg">
                                25</div>
                            <span class="text-[10px] font-bold uppercase mt-1 block">PHÚT</span>
                        </div>
                    </div>
                </div>
                <div class="grid grid-cols-1 md:grid-cols-2 gap-8">
                    <div class="flex bg-white dark:bg-white/5 rounded-xl overflow-hidden items-center p-4 gap-6 group">
                        <div class="w-32 h-32 flex-shrink-0 bg-cover bg-center rounded-lg"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuAT692iQFuOuZkJYlJztHJpErp5rZ0BAO5OAwsgcs5D-z-3lhnd0LYXDEkicx50cuQUfADjS_dyoTybD2Hh2ukAK4NiTNKfM4XpOHcGt9d_cPGN6VLYFNqHTf2BMPCWvY3Ve5NUgCYrwL48OiodZZsnUbTjSf6cyUUCLgSlIf1lpk9eFNtN3KqKWKFY15iAxlU2AmD-yN6mS_8VIbqM2A4FfShaG8h4KvIyEdZojxa3X35myxGCfMEqIDAevbOnh6rWmMORitqmOSg');">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-primary text-black text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">BÁN
                                    CHẠY</span>
                            </div>
                            <h4 class="font-bold text-lg">Bee Home Hub Pro</h4>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-xl font-bold text-primary">3.200.000₫</span>
                                <span class="text-sm text-gray-400 line-through">4.990.000₫</span>
                            </div>
                            <button
                                class="bg-black dark:bg-white dark:text-black text-white text-xs font-bold px-4 py-2 rounded-lg hover:scale-105 transition-transform">Nhận
                                ưu đãi</button>
                        </div>
                    </div>
                    <div class="flex bg-white dark:bg-white/5 rounded-xl overflow-hidden items-center p-4 gap-6 group">
                        <div class="w-32 h-32 flex-shrink-0 bg-cover bg-center rounded-lg"
                            style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuDd9kLQWgl-v-WkmZynnezI1kg_FlE1X_Yttc7SchEeehjq5l55xhw0RvkqEqIn4eCoESlXE8_mW5_wo36xt2MeHTQlXnnjjJk2SZpDCZTsJ-Ox-AsyQH58dMik9rRarvKR9B2ubX-KuhRSkKhod8D-U8zdWteCZhlZBYhyT50HvQ_nzik2lP6xA9YdU58giY3FjV-PA5XMi-cz1D9vcWlARHCOjv-dIXgMly7Lku_e1ke8MqGWOJuJ1zbRVg8Br7IPjtHMH_W5d6s');">
                        </div>
                        <div class="flex-1">
                            <div class="flex items-center gap-2 mb-2">
                                <span
                                    class="bg-primary text-black text-[10px] font-bold px-2 py-0.5 rounded-full uppercase">SỐ
                                    LƯỢNG CÓ HẠN</span>
                            </div>
                            <h4 class="font-bold text-lg">Pro Game Pad X</h4>
                            <div class="flex items-center gap-2 mb-4">
                                <span class="text-xl font-bold text-primary">1.200.000₫</span>
                                <span class="text-sm text-gray-400 line-through">2.190.000₫</span>
                            </div>
                            <button
                                class="bg-black dark:bg-white dark:text-black text-white text-xs font-bold px-4 py-2 rounded-lg hover:scale-105 transition-transform">Nhận
                                ưu đãi</button>
                        </div>
                    </div>
                </div>
            </div>
        </section>
        <section class="mt-20 px-4 md:px-10 lg:px-20 overflow-hidden">
            <div class="flex items-center gap-3 mb-8">
                <span class="material-symbols-outlined text-primary">auto_awesome</span>
                <h2 class="text-3xl font-bold ai-sparkle">Đề xuất thông minh bởi Bee AI</h2>
                <div class="h-[2px] flex-1 bg-gray-200 dark:bg-white/10 ml-4"></div>
            </div>
            <div class="flex gap-6 overflow-x-auto pb-6 snap-x no-scrollbar">
                <div
                    class="min-w-[280px] snap-start bg-white dark:bg-white/5 p-4 rounded-xl border border-transparent hover:border-primary transition-all">
                    <div class="aspect-video bg-cover bg-center rounded-lg mb-4"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCu2nXMwUaxcgMFJ3DStTUgvb06MPwKj14rOq1mH0VclphFw_2M5iAvYziUuhH5QPaXNJendjAlFdCtsOwatHMj67LqKzbjz-OfDYey38KYrtb-kesCMAi8AHCDpZ2YDimjLD_38rIqPmoAtrdJJKzx7yTBSgFiAtFBPmSD3mnIXNk-ABUurpj3Fs9RoY5iygmOVMaX7EdXyxk3Cf4SxQ8Sm37r4HhW6-ckcCyFT9R7fqNCk0vx0hejVveNwJE-SZv85a4wLJ-1YNM');">
                    </div>
                    <h4 class="font-bold">Bee Book Air M3</h4>
                    <p class="text-primary font-bold mt-1">32.990.000₫</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase font-medium">Dựa trên lịch sử xem: Laptop</p>
                </div>
                <div
                    class="min-w-[280px] snap-start bg-white dark:bg-white/5 p-4 rounded-xl border border-transparent hover:border-primary transition-all">
                    <div class="aspect-video bg-cover bg-center rounded-lg mb-4"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCLsRzrbfHVM4SQlyaMcpPwVSNdAlZyIXITEh7s1-yuaJ-zcmhhoPOnGu1K3ZH10QFR0ruM-BP317eoQ2pc-xpPdM9Hgpg-3PydU6iWyBVuv-ymonHvgyW_fAbcDvfhkg-aJ76ZkHxJyOdISSJpL-CNSIXEy0QXeIBusj4EDIJRorMevTJ2ZoqeMB93iW0ZdMFHWvULSEKGwYpGFGU1NsmfUOz10oDX01RfKaBLi956F7jOLkKL_IcPELZa6tQ2C3lfm8ZOrzm6v8o');">
                    </div>
                    <h4 class="font-bold">Lumina Pro Lens Kit</h4>
                    <p class="text-primary font-bold mt-1">13.990.000₫</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase font-medium">Có thể bạn quan tâm: Nhiếp ảnh</p>
                </div>
                <div
                    class="min-w-[280px] snap-start bg-white dark:bg-white/5 p-4 rounded-xl border border-transparent hover:border-primary transition-all">
                    <div class="aspect-video bg-cover bg-center rounded-lg mb-4"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBZp11AcszU9PiGrp6P8pUbHSD87aNa0yxEh63Ans10gq55eeR9itxGcg47cvcN4vtjs63hWu9YYBGc6Oxeop7t9iHTJDiFMM_GCa4_Q110rUn9BpM4j1vAhw5NgoLKm418eNW_z-481DLyUQpsPTn2M3ZslkLE4Tb6O3Uz9JYIpV_dKGXJ0FXCmgYeAZHCdzTHUNt7EMGBT2oAxyFc3acmNWDmZCi6fRQLvkDRp2ldGXj3lBLigzLX-nhYvJ-jYHfW_reZMfz94ys');">
                    </div>
                    <h4 class="font-bold">Leather Case Series</h4>
                    <p class="text-primary font-bold mt-1">1.150.000₫</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase font-medium">Bạn vừa mua iPhone 15 Pro</p>
                </div>
                <div
                    class="min-w-[280px] snap-start bg-white dark:bg-white/5 p-4 rounded-xl border border-transparent hover:border-primary transition-all">
                    <div class="aspect-video bg-cover bg-center rounded-lg mb-4"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuBbI2RkcODivjNwLY8UdZfEV4UCcW_Wr6lwa0nGObhEPoslpANr5VLcdDHhSZhAgmePGQKmtXRVH2DJ9A-q5uOyxwtsJOXO2NhPVRh5SNoGfoy87Pluv87_IQgk86NcCZKsTJwQshHZxcj3n6PW6hO_QiqT4DguT3WKf92x3P0DgPoS2v7-ygcGooQTUTeuSS7Czk6Noc-_D4BsXe97Lq86uzlN5m3-JTWKsutd44IpjVBFzeu0l9RQm8ojiCMs3FM2x_XlWzOHodc');">
                    </div>
                    <h4 class="font-bold">Studio Beats Pro</h4>
                    <p class="text-primary font-bold mt-1">7.500.000₫</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase font-medium">Dựa trên xu hướng</p>
                </div>
                <div
                    class="min-w-[280px] snap-start bg-white dark:bg-white/5 p-4 rounded-xl border border-transparent hover:border-primary transition-all">
                    <div class="aspect-video bg-cover bg-center rounded-lg mb-4"
                        style="background-image: url('https://lh3.googleusercontent.com/aida-public/AB6AXuCEw9D9tBP0Y5ICsquYYtjRFOLKYTZipIrzjYOsRJc-WlAviyQnHlKmXJvWIEqykSf0SVlQcxtpmhfm2n_DK5r0XvwzzPlll3IUPSYBrw8coo4VBAIGL8c7hvMTW1AkCHuxipEm0kuT3lvTtdQif9Cj4UB-s2WBlX1H68qOONkg2o8Z6wpZwbPlCZime6_5not2J-5adjtaIzTm-vfX5CrwnGm7574ylneRYB3c9bFIYTz-mF5s3v3b6fKqTvYTy2rz47V8PvJLeLw');">
                    </div>
                    <h4 class="font-bold">Active ANC Buds</h4>
                    <p class="text-primary font-bold mt-1">3.990.000₫</p>
                    <p class="text-[10px] text-gray-400 mt-2 uppercase font-medium">Phụ kiện yêu thích</p>
                </div>
            </div>
        </section>
    </main>
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
