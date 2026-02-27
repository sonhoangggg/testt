<!DOCTYPE html>
<html lang="vi">
<head>
    <meta charset="UTF-8">
    <title>@yield('title', 'Bee Phone Admin')</title>
    <meta name="viewport" content="width=device-width, initial-scale=1.0">

    <script src="https://cdn.tailwindcss.com"></script>
    <link href="https://fonts.googleapis.com/css2?family=Material+Symbols+Outlined" rel="stylesheet" />
</head>

<body class="bg-zinc-100">

<div class="flex min-h-screen">

    {{-- SIDEBAR --}}
    <aside class="w-72 bg-white border-r border-zinc-200 flex flex-col shrink-0">

        {{-- Logo --}}
        <div class="p-6 flex items-center gap-3">
            <div class="size-8 bg-yellow-400 rounded-lg flex items-center justify-center text-black">
                <span class="material-symbols-outlined">cell_tower</span>
            </div>
            <h2 class="text-xl font-extrabold tracking-tight">Bee Phone</h2>
        </div>

        {{-- User --}}
        <div class="px-6 py-4">
            <div class="flex items-center gap-3 p-3 rounded-xl bg-zinc-100 border">
               

                <div class="overflow-hidden">
                    <p class="text-xs text-zinc-500 font-medium">Chào mừng bạn trở lại</p>
                    
                </div>
            </div>
        </div>

        {{-- MENU --}}
        <nav class="flex-1 px-4 overflow-y-auto pb-6 space-y-1 text-sm">

            {{-- Dashboard --}}
            <a href="{{ url('admin/dashboard') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/dashboard') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">dashboard</span>
                Dashboard
            </a>

            {{-- Nhân viên --}}
            <a href="{{ route('accounts.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/accounts*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">badge</span>
                Quản lý nhân viên
            </a>

            {{-- Chức vụ --}}
            <a href="{{ route('roles.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/roles*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">verified_user</span>
                Quản lý chức vụ
            </a>

            @if(auth()->user()->role->id == 1)
            <a href="{{ route('roles.permissions.assign') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/roles/assign') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">lock</span>
                Phân quyền
            </a>
            @endif

            {{-- Khách hàng --}}
            <a href="{{ route('customers.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/customers*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">group</span>
                Quản lý khách hàng
            </a>

            {{-- Sản phẩm --}}
           <div 
    x-data="{ open: {{ request()->is('admin/rams*') || request()->is('admin/storages*') || request()->is('admin/colors*') ? 'true' : 'false' }} }"
    class="space-y-1"
>

    <!-- LINK SẢN PHẨM -->
    <div class="flex items-center justify-between">

        <a href="{{ route('products.index') }}"
           class="flex items-center gap-3 px-3 py-2.5 rounded-lg flex-1 transition
           {{ request()->is('admin/products*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
            <span class="material-symbols-outlined">inventory_2</span>
            Quản lý sản phẩm
        </a>

        <!-- NÚT TOGGLE -->
        <button 
            @click="open = !open"
            class="px-2 text-zinc-500 hover:text-yellow-500 transition">
            <span 
                class="material-symbols-outlined text-sm transition-transform duration-300"
                :class="{ 'rotate-180': open }">
                expand_more
            </span>
        </button>

    </div>

    <!-- DROPDOWN -->
    <div 
        x-show="open"
        x-transition
        class="pl-8 space-y-1"
        style="display: none;"
    >

        <a href="{{ route('rams.index') }}"
           class="block px-3 py-2 rounded-lg text-sm
           {{ request()->is('admin/rams*') ? 'bg-yellow-100 text-yellow-700 font-semibold' : 'hover:bg-zinc-100 text-zinc-600' }}">
            RAM
        </a>

        <a href="{{ route('storages.index') }}"
           class="block px-3 py-2 rounded-lg text-sm
           {{ request()->is('admin/storages*') ? 'bg-yellow-100 text-yellow-700 font-semibold' : 'hover:bg-zinc-100 text-zinc-600' }}">
            Bộ nhớ
        </a>

        <a href="{{ route('colors.index') }}"
           class="block px-3 py-2 rounded-lg text-sm
           {{ request()->is('admin/colors*') ? 'bg-yellow-100 text-yellow-700 font-semibold' : 'hover:bg-zinc-100 text-zinc-600' }}">
            Màu sắc
        </a>

    </div>

</div>

            {{-- Đơn hàng --}}
            <a href="{{ url('admin/orders') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/orders*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">receipt_long</span>
                Đơn hàng
            </a>

            <a href="{{ url('admin/return-requests') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/return-requests*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">assignment_return</span>
                Hoàn hàng
            </a>

            {{-- Danh mục --}}
            <a href="{{ route('categories.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/categories*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">category</span>
                Danh mục
            </a>

            {{-- Tin tức --}}
            <a href="{{ route('news.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/news*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">rss_feed</span>
                Tin tức
            </a>

            {{-- Liên hệ --}}
            <a href="{{ route('admin.contact.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/contact*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">support_agent</span>
                Liên hệ
            </a>

            {{-- Khuyến mãi --}}
            <a href="{{ route('promotions.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/promotions*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">redeem</span>
                Khuyến mãi
            </a>

            {{-- Bình luận --}}
            <a href="{{ route('comments.index') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/comments*') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">chat</span>
                Bình luận
            </a>

            {{-- Profile --}}
            <a href="{{ route('admin.profile') }}"
               class="flex items-center gap-3 px-3 py-2.5 rounded-lg transition
               {{ request()->is('admin/accounts/show') ? 'bg-yellow-400 text-black font-bold' : 'hover:bg-zinc-100 text-zinc-600' }}">
                <span class="material-symbols-outlined">person</span>
                Thông tin cá nhân
            </a>

        </nav>

        {{-- Trang khách hàng --}}
        <div class="p-4 border-t">
            <a href="{{ route('home') }}"
               class="flex items-center gap-3 text-zinc-600 hover:text-yellow-500 font-semibold">
                <span class="material-symbols-outlined">storefront</span>
                Trang khách hàng
            </a>
        </div>

    </aside>

    {{-- CONTENT --}}
    <main class="flex-1 p-8">
        @yield('content')
    </main>

</div>

</body>
</html> 