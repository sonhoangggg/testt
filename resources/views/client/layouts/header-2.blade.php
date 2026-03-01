<header
    class="sticky top-0 z-50 bg-white/80 dark:bg-background-dark/80 backdrop-blur-md border-b border-solid border-[#f5f3f0] dark:border-white/10 px-4 md:px-10 lg:px-20 py-3">
    <div class="max-w-[1440px] mx-auto flex items-center justify-between gap-4">
        <a href="{{ route('home') }}">
            <div class="flex items-center gap-2">

                <div class="size-8 bg-primary rounded-lg flex items-center justify-center text-black">
                    <span class="material-symbols-outlined">rocket_launch</span>
                </div>
                <h2 class="text-xl font-bold leading-tight tracking-tight hidden md:block">Bee Phone</h2>
            </div>
        </a>
        <nav class="hidden lg:flex items-center gap-8">
            <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Sản phẩm</a>
            <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Danh mục</a>
            <a class="text-sm font-medium hover:text-primary transition-colors"
                href="{{ route('client.introduce') }}">Giới thiệu</a>
            <a class="text-sm font-medium hover:text-primary transition-colors" href="{{route('client.news.index')}}">Tin tức</a>
            <a class="text-sm font-medium hover:text-primary transition-colors" href="#">Liên hệ</a>
        </nav>
        <div class="flex flex-1 justify-end items-center gap-4 max-w-xl">
            <div class="relative w-full max-w-md hidden sm:block">
                <span
                    class="material-symbols-outlined absolute left-3 top-1/2 -translate-y-1/2 text-gray-400">search</span>
                <input
                    class="w-full h-10 pl-10 pr-4 rounded-lg border-none bg-[#f5f3f0] dark:bg-white/5 focus:ring-2 focus:ring-primary text-sm"
                    placeholder="Tìm kiếm sản phẩm..." type="text" />
            </div>
            <div class="flex gap-2">
                <div class="relative inline-block">
                    <!-- Button -->

                    <button id="userBtn"
                        class="flex items-center justify-center rounded-lg h-10 w-10 bg-[#f5f3f0] dark:bg-white/5 hover:bg-primary transition-colors group">
                        <span class="material-symbols-outlined text-[#181611] dark:text-white group-hover:text-black">
                            person
                        </span>
                    </button>

                    <!-- Dropdown -->

                    <div id="userMenu"
                        class="hidden absolute right-0 mt-2 w-40 bg-white dark:bg-gray-800 rounded-lg shadow-lg p-2 space-y-2">
                        @if (Auth::guard('account')->check())
                            <a href="{{route('user.dashboard')}}">
                                <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                Hồ sơ
                            </button>
                            </a>

                            <button class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                Cài đặt
                            </button>

                            @if (Auth::guard('account')->user()->role_id === 1 || Auth::guard('account')->user()->role_id === 2)
                                <a href="{{ route('admin.dashboard') }}" class="nav-link text-success"> <button
                                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700">
                                        Trang quản trị
                                    </button></a>
                                <form action="{{ route('admin.logout') }}" method="POST">
                                    @csrf
                                    <button
                                        class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500">
                                        Đăng xuất
                                    </button>
                                </form>

                            @else
                            <form action="{{ route('taikhoan.logout') }}" method="POST">
                                @csrf
                                <button
                                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500">
                                    Đăng xuất
                                </button>
                            </form>
                             @endif
                        @else
                            <a href="{{ route('taikhoan.login') }}"><button
                                    class="w-full text-left px-3 py-2 rounded hover:bg-gray-100 dark:hover:bg-gray-700 text-red-500">
                                    Đăng Nhập
                                </button></a>
                        @endif
                    </div>



                </div>
                <button
                    class="flex items-center justify-center rounded-lg h-10 w-10 bg-[#f5f3f0] dark:bg-white/5 hover:bg-primary transition-colors group relative">
                    <span
                        class="material-symbols-outlined text-[#181611] dark:text-white group-hover:text-black">shopping_cart</span>
                    <span
                        class="absolute -top-1 -right-1 bg-primary text-[10px] font-bold px-1 rounded-full text-black">3</span>
                </button>
            </div>
            <script>
                const btn = document.getElementById("userBtn");
                const menu = document.getElementById("userMenu");

                btn.addEventListener("click", () => {
                    menu.classList.toggle("hidden");
                });

                // Click ra ngoài thì ẩn menu
                document.addEventListener("click", function(e) {
                    if (!btn.contains(e.target) && !menu.contains(e.target)) {
                        menu.classList.add("hidden");
                    }
                });
            </script>
        </div>
    </div>
</header>
