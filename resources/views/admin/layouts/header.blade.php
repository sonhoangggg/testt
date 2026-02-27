<header class="h-16 bg-white dark:bg-zinc-900 border-b border-zinc-200 dark:border-zinc-800 flex items-center justify-between px-6">

    {{-- Left: Toggle + Logo --}}
    <div class="flex items-center gap-4">
      

        <h1 class="text-lg font-bold">Bee Phone</h1>
    </div>

    {{-- Right side --}}
    <div class="flex items-center gap-6">

        {{-- Notification icon --}}
        <button class="relative text-zinc-500 hover:text-primary">
            <span class="material-symbols-outlined">notifications</span>
            <span class="absolute -top-1 -right-1 bg-red-500 text-white text-[10px] rounded-full px-1">
                
            </span>
        </button>

        {{-- User name --}}
        <div class="hidden md:block text-sm font-semibold">
            {{ auth()->user()->full_name ?? 'Admin' }}
        </div>

        {{-- Logout button --}}
        <form action="{{ route('admin.logout') }}" method="POST">
            @csrf
            <button type="submit"
                class="flex items-center gap-2 bg-yellow-400 hover:bg-yellow-500 text-black px-4 py-2 rounded-lg text-sm font-semibold transition">
                <span class="material-symbols-outlined text-[18px]">logout</span>
                Thoát
            </button>
        </form>

    </div>

</header>