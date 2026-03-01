{{-- resources/views/client/user/dashboard.blade.php --}}
@extends('client.layouts.app')

@section('content')
<script src="https://cdn.tailwindcss.com"></script>

<div class="max-w-7xl mx-auto px-4 py-10">

    <div class="grid md:grid-cols-4 gap-8">

        {{-- ================= SIDEBAR ================= --}}
        <div class="md:col-span-1">
            <div class="bg-white rounded-2xl shadow overflow-hidden">

                {{-- HEADER --}}
                <div class="bg-black text-white px-6 py-5">
                    <p class="text-sm">Xin chào,</p>
                    <p class="font-semibold text-lg">
                        {{ Auth::check() ? Auth::user()->full_name : 'Khách' }}
                    </p>
                </div>

                {{-- MENU --}}
                <div class="flex flex-col text-sm">

                    <a href="{{ route('user.profile') }}"
                       class="px-6 py-3 border-b hover:bg-gray-100 transition">
                        👉 Thông tin cá nhân
                    </a>

                    <a href="{{ route('user.orders') }}"
                       class="px-6 py-3 border-b hover:bg-gray-100 transition">
                        👉 Quản lý đơn hàng
                    </a>

                    <a href="{{ route('client.promotions.index') }}"
                       class="px-6 py-3 border-b hover:bg-gray-100 transition">
                        👉 Mã giảm giá
                    </a>

                    <a href="#"
                       onclick="event.preventDefault(); document.getElementById('logout-form').submit();"
                       class="px-6 py-3 text-red-500 hover:bg-red-50 transition">
                        👉 Đăng xuất
                    </a>

                    <form id="logout-form"
                          action="{{ route('taikhoan.logout') }}"
                          method="POST"
                          class="hidden">
                        @csrf
                    </form>

                </div>

            </div>
        </div>


        {{-- ================= CONTENT ================= --}}
        <div class="md:col-span-3">
            <div class="bg-white rounded-2xl shadow p-6">
                @yield('dashboard-content')
            </div>
        </div>

    </div>

</div>
@endsection
