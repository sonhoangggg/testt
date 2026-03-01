@extends('client.layouts.app')

@section('title', ($news->title ?? 'Tin tức') . ' - PowPow')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto px-4 py-10">

    {{-- ================= BREADCRUMB ================= --}}
    <div class="text-sm text-gray-500 mb-6 flex flex-wrap gap-2">
        <a href="{{ route('home') }}" class="hover:text-black">Trang chủ</a>
        <span>/</span>
        <a href="{{ route('client.news.index') }}" class="hover:text-black">Tin tức</a>
        <span>/</span>
        <span class="text-gray-700">
            {{ Str::limit($news->title ?? '', 40) }}
        </span>
    </div>


    <div class="grid lg:grid-cols-3 gap-10">

        {{-- ================= MAIN CONTENT ================= --}}
        <div class="lg:col-span-2">

            <article class="bg-white rounded-2xl shadow p-6">

                {{-- HEADER --}}
                <div class="flex justify-between flex-wrap gap-4 mb-6">

                    <div class="flex gap-2">
                        @if(!empty($news->is_featured))
                            <span class="bg-black text-white text-xs px-3 py-1 rounded-full">
                                Nổi bật
                            </span>
                        @endif

                        @if(!empty($news->is_hot))
                            <span class="bg-red-500 text-white text-xs px-3 py-1 rounded-full">
                                Hot
                            </span>
                        @endif
                    </div>

                    <div class="text-sm text-gray-500 text-right">
                        @if(!empty($news->published_at))
                            <div>
                                {{ \Carbon\Carbon::parse($news->published_at)->format('d/m/Y H:i') }}
                            </div>
                        @endif
                        <div>
                            👁 {{ $news->view_count ?? 0 }} lượt xem
                        </div>
                    </div>

                </div>


                <h1 class="text-3xl font-bold mb-4 leading-snug">
                    {{ $news->title }}
                </h1>

                @if(!empty($news->summary))
                <div class="text-lg text-gray-500 mb-4">
                    {{ $news->summary }}
                </div>
                @endif

                <div class="text-sm text-gray-400 mb-6">
                    Tác giả: {{ $news->author ?? 'Admin' }}
                </div>


                {{-- IMAGE --}}
                @if(!empty($news->featured_image))
                <div class="mb-6">
                    <img src="{{ asset('storage/' . $news->featured_image) }}"
                         class="w-full rounded-xl shadow"
                         alt="{{ $news->title }}">
                </div>
                @endif


                {{-- CONTENT --}}
                <div class="prose max-w-none prose-img:rounded-xl prose-headings:mt-8 prose-p:leading-8">
                    {!! $news->content !!}
                </div>


                {{-- FOOTER --}}
                <div class="mt-10 pt-6 border-t flex justify-between items-center flex-wrap gap-4">

                    <div class="flex gap-3">
                        <button onclick="shareArticle()"
                                class="px-4 py-2 border rounded-xl hover:bg-black hover:text-white transition text-sm">
                            Chia sẻ
                        </button>

                        <button onclick="window.print()"
                                class="px-4 py-2 border rounded-xl hover:bg-gray-100 transition text-sm">
                            In bài viết
                        </button>
                    </div>

                    @if(!empty($news->updated_at))
                        <div class="text-xs text-gray-400">
                            Cập nhật: {{ \Carbon\Carbon::parse($news->updated_at)->format('d/m/Y H:i') }}
                        </div>
                    @endif

                </div>

            </article>


            {{-- ================= RELATED ================= --}}
            @if(isset($relatedNews) && $relatedNews->count())
            <div class="mt-12">
                <h3 class="text-xl font-semibold mb-6">
                    Tin tức liên quan
                </h3>

                <div class="grid md:grid-cols-2 gap-6">
                    @foreach($relatedNews as $related)
                    <div class="bg-white rounded-2xl shadow hover:shadow-lg transition overflow-hidden">

                        @if(!empty($related->featured_image))
                            <img src="{{ asset('storage/' . $related->featured_image) }}"
                                 class="w-full h-40 object-cover">
                        @endif

                        <div class="p-4">
                            <a href="{{ route('client.news.show', $related->slug) }}"
                               class="font-medium hover:text-blue-600 transition">
                                {{ Str::limit($related->title, 50) }}
                            </a>

                            <div class="text-xs text-gray-400 mt-2">
                                {{ optional($related->published_at)->format('d/m/Y') }}
                            </div>
                        </div>

                    </div>
                    @endforeach
                </div>
            </div>
            @endif

        </div>


        {{-- ================= SIDEBAR ================= --}}
        <div class="space-y-8">

            @if(isset($latestNews) && $latestNews->count())
            <div class="bg-white rounded-2xl shadow p-5">
                <h4 class="font-semibold mb-4">
                    Tin mới nhất
                </h4>

                <div class="space-y-4">
                    @foreach($latestNews as $latest)
                    <div>
                        <a href="{{ route('client.news.show', $latest->slug) }}"
                           class="text-sm font-medium hover:text-blue-600 transition">
                            {{ Str::limit($latest->title, 45) }}
                        </a>
                        <div class="text-xs text-gray-400">
                            {{ optional($latest->published_at)->format('d/m/Y') }}
                        </div>
                    </div>
                    @endforeach
                </div>
            </div>
            @endif


            <div class="bg-white rounded-2xl shadow p-5 text-center">
                <a href="{{ route('client.news.index') }}"
                   class="px-4 py-2 border rounded-xl hover:bg-black hover:text-white transition text-sm">
                    ← Quay lại tin tức
                </a>
            </div>

        </div>

    </div>

</div>
@endsection


@push('scripts')
<script>
function shareArticle() {
    const url = window.location.href;

    if (navigator.clipboard) {
        navigator.clipboard.writeText(url).then(() => {
            alert('Đã sao chép link!');
        });
    } else {
        alert(url);
    }
}
</script>
@endpush
