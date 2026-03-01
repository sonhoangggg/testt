@extends('client.layouts.app-2')

@section('title', 'Tin tức - PowPow')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto px-4 py-10">

    <!-- Header -->
    <div class="flex flex-col md:flex-row md:items-center md:justify-between gap-4 mb-10">
        <div>
            <h1 class="text-3xl font-bold">Tin tức</h1>
            <p class="text-gray-500">Cập nhật những tin tức mới nhất về công nghệ</p>
        </div>

        <form method="GET"
              action="{{ route('client.news.index') }}"
              class="flex">
            <input type="text"
                   name="search"
                   placeholder="Tìm kiếm tin tức..."
                   value="{{ request('search') }}"
                   class="border rounded-l-xl px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none text-sm">
            <button type="submit"
                class="bg-black text-white px-4 rounded-r-xl hover:bg-gray-800 transition">
                🔍
            </button>
        </form>
    </div>


    {{-- FEATURED --}}
    @if($featuredNews->count() > 0)
    <div class="mb-14">
        <h3 class="text-xl font-semibold mb-6">Tin tức nổi bật</h3>

        <div class="grid md:grid-cols-3 gap-6">
            @foreach($featuredNews as $featured)
            <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                @if($featured->featured_image)
                <img src="{{ asset('storage/' . $featured->featured_image) }}"
                     class="w-full h-52 object-cover"
                     alt="{{ $featured->title }}">
                @else
                <div class="w-full h-52 bg-gray-100 flex items-center justify-center text-gray-400">
                    📰
                </div>
                @endif

                <div class="p-5 space-y-3">
                    <div class="flex justify-between text-xs text-gray-500">
                        <span class="bg-black text-white px-2 py-1 rounded-full text-[10px]">
                            Nổi bật
                        </span>
                        <span>{{ $featured->published_at->format('d/m/Y') }}</span>
                    </div>

                    <h4 class="font-semibold hover:text-blue-600 transition">
                        <a href="{{ route('client.news.show', $featured->slug) }}">
                            {{ Str::limit($featured->title, 60) }}
                        </a>
                    </h4>

                    <p class="text-sm text-gray-500">
                        {{ Str::limit($featured->summary, 100) }}
                    </p>

                    <div class="flex justify-between text-xs text-gray-400 pt-2">
                        <span>{{ $featured->author ?: 'Admin' }}</span>
                        <span>👁 {{ $featured->view_count }}</span>
                    </div>
                </div>
            </div>
            @endforeach
        </div>
    </div>
    @endif


    <div class="grid lg:grid-cols-3 gap-10">

        <!-- NEWS LIST -->
        <div class="lg:col-span-2">

            @if($news->count() > 0)

            <div class="grid md:grid-cols-2 gap-6">
                @foreach($news as $item)
                <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                    @if($item->featured_image)
                    <img src="{{ asset('storage/' . $item->featured_image) }}"
                         class="w-full h-44 object-cover"
                         alt="{{ $item->title }}">
                    @else
                    <div class="w-full h-44 bg-gray-100 flex items-center justify-center text-gray-400">
                        📰
                    </div>
                    @endif

                    <div class="p-4 space-y-2">

                        <div class="flex justify-between text-xs text-gray-500">
                            @if($item->is_hot)
                            <span class="bg-red-500 text-white px-2 py-1 rounded-full text-[10px]">
                                Hot
                            </span>
                            @endif
                            <span>{{ $item->published_at->format('d/m/Y') }}</span>
                        </div>

                        <h5 class="font-medium hover:text-blue-600 transition">
                            <a href="{{ route('client.news.show', $item->slug) }}">
                                {{ Str::limit($item->title, 50) }}
                            </a>
                        </h5>

                        <p class="text-sm text-gray-500">
                            {{ Str::limit($item->summary, 80) }}
                        </p>

                        <div class="flex justify-between text-xs text-gray-400 pt-2">
                            <span>{{ $item->author ?: 'Admin' }}</span>
                            <span>👁 {{ $item->view_count }}</span>
                        </div>
                    </div>
                </div>
                @endforeach
            </div>

            <!-- PAGINATION -->
            <div class="mt-10">
                {{ $news->appends(request()->query())->links() }}
            </div>

            @else
            <div class="text-center py-16 text-gray-500">
                <div class="text-4xl mb-4">📰</div>
                <h5 class="font-medium">Không có tin tức nào</h5>
                <p>Hãy quay lại sau để xem tin tức mới nhất</p>
            </div>
            @endif

        </div>


        <!-- SIDEBAR -->
        <div class="space-y-8">

            @if($hotNews->count() > 0)
            <div class="bg-white rounded-2xl shadow p-5">
                <h5 class="font-semibold mb-4 flex items-center gap-2">
                    🔥 Tin tức hot
                </h5>

                <div class="space-y-4">
                    @foreach($hotNews as $hot)
                    <div class="flex gap-3">

                        @if($hot->featured_image)
                        <img src="{{ asset('storage/' . $hot->featured_image) }}"
                             class="w-16 h-16 object-cover rounded-lg"
                             alt="{{ $hot->title }}">
                        @else
                        <div class="w-16 h-16 bg-gray-100 rounded-lg flex items-center justify-center text-gray-400">
                            📰
                        </div>
                        @endif

                        <div>
                            <a href="{{ route('client.news.show', $hot->slug) }}"
                               class="text-sm font-medium hover:text-blue-600 transition">
                                {{ Str::limit($hot->title, 40) }}
                            </a>
                            <div class="text-xs text-gray-400">
                                {{ $hot->published_at->format('d/m/Y') }}
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
            @endif


            <!-- CATEGORIES -->
            <div class="bg-white rounded-2xl shadow p-5">
                <h5 class="font-semibold mb-4">Danh mục</h5>

                <div class="flex flex-wrap gap-2 text-xs">
                    <a href="{{ route('client.news.index') }}"
                       class="px-3 py-1 bg-black text-white rounded-full">
                        Tất cả
                    </a>
                    <a href="{{ route('client.news.index', ['category' => 'technology']) }}"
                       class="px-3 py-1 bg-gray-200 rounded-full hover:bg-gray-300">
                        Công nghệ
                    </a>
                    <a href="{{ route('client.news.index', ['category' => 'gaming']) }}"
                       class="px-3 py-1 bg-gray-200 rounded-full hover:bg-gray-300">
                        Gaming
                    </a>
                    <a href="{{ route('client.news.index', ['category' => 'reviews']) }}"
                       class="px-3 py-1 bg-gray-200 rounded-full hover:bg-gray-300">
                        Đánh giá
                    </a>
                </div>
            </div>

        </div>

    </div>
</div>
@endsection
