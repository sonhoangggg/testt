@extends('client.user.dashboard')

@section('dashboard-content')

<div class="px-4 py-6">

    <h3 class="text-2xl font-bold text-orange-600 mb-6 flex items-center gap-2">
        🎁 Mã Giảm Giá Dành Cho Bạn
    </h3>

    @forelse ($promotions as $promotion)

        <div class="flex flex-col md:flex-row md:items-center gap-4
                    border-2 border-orange-500 rounded-xl
                    bg-orange-50 p-5 mb-5
                    transition hover:shadow-md">

            {{-- Icon --}}
            <div class="text-3xl text-orange-600">
                🎟️
            </div>

            {{-- Nội dung --}}
            <div class="flex-1">

                <div class="text-xl font-bold text-orange-600">
                    {{ $promotion->code }}
                </div>

                <div class="text-sm text-gray-600 mb-2">
                    {{ $promotion->description }}
                </div>

                <div class="text-sm text-gray-700 flex flex-col md:flex-row md:gap-6 gap-1">

                    <span>
                        🔻 Giảm:
                        <strong>
                            {{ $promotion->discount_type == 'percentage'
                                ? $promotion->discount_value . '%'
                                : number_format($promotion->discount_value) . 'đ' }}
                        </strong>
                    </span>

                    <span>
                        📦 Đơn tối thiểu:
                        <strong>
                            {{ $promotion->min_order_amount
                                ? number_format($promotion->min_order_amount) . 'đ'
                                : 'Không yêu cầu' }}
                        </strong>
                    </span>

                    <span>
                        ⏳ HSD:
                        <strong>
                            {{ \Carbon\Carbon::parse($promotion->end_date)->format('d/m/Y') }}
                        </strong>
                    </span>

                </div>
            </div>

            {{-- Action --}}
            <div class="md:text-right">

                @if (in_array($promotion->id, $saved))

                    <a href="{{ route('client.promotions.unsave', $promotion->id) }}"
                       class="inline-block px-5 py-2
                              border border-gray-400
                              bg-gray-100 text-gray-700
                              rounded-full text-sm
                              hover:bg-red-100 hover:text-red-600
                              transition">
                        ❌ Bỏ lưu
                    </a>

                @else

                    <a href="{{ route('client.promotions.save', $promotion->id) }}"
                       class="inline-block px-5 py-2
                              border border-orange-500
                              text-orange-600
                              rounded-full text-sm
                              hover:bg-orange-600 hover:text-white
                              transition">
                        💾 Lưu mã
                    </a>

                @endif

            </div>

        </div>

    @empty

        <div class="text-center bg-yellow-50 border border-yellow-300
                    text-yellow-700 p-6 rounded-xl">
            😔 Hiện tại chưa có mã giảm giá nào.
        </div>

    @endforelse

</div>

@endsection
