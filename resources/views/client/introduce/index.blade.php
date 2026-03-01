@extends('client.layouts.app')

@section('content')
    {{-- Hero Section --}}
    <!-- ===== Bee Phone Landing Page (Tailwind CSS) ===== -->

<!-- HERO -->
<section class="py-20 text-center text-white bg-gradient-to-br from-amber-500 to-orange-600">
    <div class="max-w-6xl mx-auto px-6">
        <h1 class="text-4xl md:text-5xl font-extrabold">
            Chào mừng đến với
            <span class="text-black bg-white px-3 py-1 rounded-lg">Bee Phone</span>
        </h1>
        <p class="mt-6 text-lg max-w-2xl mx-auto text-orange-100">
            Bee Phone chuyên cung cấp điện thoại chính hãng, phụ kiện công nghệ cao cấp
            với mức giá tốt nhất. Cam kết chất lượng – Bảo hành uy tín – Hỗ trợ tận tâm.
        </p>
        <a href="{{ route('client.categories') }}"
           class="inline-block mt-8 bg-white text-orange-600 font-bold px-8 py-3 rounded-xl shadow-lg hover:bg-gray-100 transition">
            Khám phá sản phẩm
        </a>
    </div>
</section>

<!-- SỨ MỆNH - TẦM NHÌN -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold">Sứ mệnh & Tầm nhìn</h2>
            <p class="text-gray-500 mt-2">Những giá trị làm nên thương hiệu Bee Phone</p>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-8 rounded-2xl shadow hover:shadow-xl transition text-center">
                <div class="text-4xl mb-4">📱</div>
                <h5 class="font-bold text-xl mb-3">Sứ mệnh</h5>
                <p class="text-gray-600">
                    Mang đến những mẫu điện thoại mới nhất, chính hãng
                    với mức giá cạnh tranh và dịch vụ hậu mãi chuyên nghiệp.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow hover:shadow-xl transition text-center">
                <div class="text-4xl mb-4">🚀</div>
                <h5 class="font-bold text-xl mb-3">Tầm nhìn</h5>
                <p class="text-gray-600">
                    Trở thành hệ thống bán lẻ điện thoại uy tín hàng đầu Việt Nam,
                    được khách hàng tin tưởng lựa chọn.
                </p>
            </div>

            <div class="bg-white p-8 rounded-2xl shadow hover:shadow-xl transition text-center">
                <div class="text-4xl mb-4">💡</div>
                <h5 class="font-bold text-xl mb-3">Giá trị cốt lõi</h5>
                <p class="text-gray-600">
                    Chính hãng – Minh bạch – Tận tâm – Đổi mới – Lấy khách hàng làm trung tâm.
                </p>
            </div>
        </div>
    </div>
</section>

<!-- SỐ LIỆU -->
<section class="py-20">
    <div class="max-w-6xl mx-auto px-6">
        <div class="grid grid-cols-2 md:grid-cols-4 gap-8 text-center">
            <div>
                <h2 class="text-3xl font-extrabold text-orange-500">10.000+</h2>
                <p class="text-gray-600 mt-2">Khách hàng tin tưởng</p>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold text-orange-500">300+</h2>
                <p class="text-gray-600 mt-2">Mẫu điện thoại</p>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold text-orange-500">5+</h2>
                <p class="text-gray-600 mt-2">Năm kinh nghiệm</p>
            </div>
            <div>
                <h2 class="text-3xl font-extrabold text-orange-500">99%</h2>
                <p class="text-gray-600 mt-2">Khách hàng hài lòng</p>
            </div>
        </div>
    </div>
</section>

<!-- TESTIMONIAL -->
<section class="py-20 bg-gray-50">
    <div class="max-w-6xl mx-auto px-6">
        <div class="text-center mb-14">
            <h2 class="text-3xl font-bold">Khách hàng nói gì?</h2>
        </div>

        <div class="grid md:grid-cols-3 gap-8">
            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-600">
                    "Mua iPhone tại Bee Phone giá tốt hơn nhiều nơi khác,
                    bảo hành rõ ràng và giao hàng cực nhanh!"
                </p>
                <h6 class="font-bold mt-4">Nguyễn Văn A</h6>
                <span class="text-sm text-gray-400">Khách hàng thân thiết</span>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-600">
                    "Nhân viên tư vấn nhiệt tình, hỗ trợ chọn máy phù hợp nhu cầu."
                </p>
                <h6 class="font-bold mt-4">Trần Thị B</h6>
                <span class="text-sm text-gray-400">Doanh nghiệp SME</span>
            </div>

            <div class="bg-white p-6 rounded-2xl shadow hover:shadow-lg transition">
                <p class="text-gray-600">
                    "Chính hãng, uy tín, mình đã mua 3 máy tại đây và rất hài lòng."
                </p>
                <h6 class="font-bold mt-4">Lê Văn C</h6>
                <span class="text-sm text-gray-400">Khách hàng lâu năm</span>
            </div>
        </div>
    </div>
</section>

<!-- CTA -->
<section class="py-20 text-center text-white bg-gradient-to-br from-orange-600 to-amber-500">
    <div class="max-w-4xl mx-auto px-6">
        <h2 class="text-3xl md:text-4xl font-bold mb-4">
            Sẵn sàng nâng cấp chiếc điện thoại của bạn?
        </h2>
        <p class="text-orange-100 text-lg">
            Khám phá ngay những sản phẩm chính hãng tại Bee Phone
        </p>
        <a href="{{ route('client.categories') }}"
           class="inline-block mt-8 bg-white text-orange-600 font-bold px-8 py-3 rounded-xl shadow-lg hover:bg-gray-100 transition">
            Bắt đầu ngay
        </a>
    </div>
</section>
@endsection
