@extends('client.layouts.app-2')
@section('content')
    <div class="flex justify-center mt-16 px-4">
    <div class="w-full max-w-md bg-white rounded-2xl shadow-lg p-8">

        <!-- Tabs -->
        <div class="flex justify-center space-x-10 text-sm font-semibold mb-8 border-b">
            <button id="tab-login" class="pb-3 border-b-2 border-black">
                ĐĂNG NHẬP
            </button>
            <button id="tab-register" class="pb-3 text-gray-400">
                ĐĂNG KÝ
            </button>
        </div>

        <!-- LOGIN FORM -->
        <form id="form-login" action="{{ route('taikhoan.login') }}" method="POST" class="space-y-4">
            @csrf

            @if (session('success'))
                <div class="p-3 bg-green-100 text-green-700 rounded-lg text-sm">
                    {{ session('success') }}
                </div>
            @endif

            @if (session('error'))
                <div class="p-3 bg-red-100 text-red-700 rounded-lg text-sm">
                    {{ session('error') }}
                </div>
            @endif

            <div>
                <input type="text" name="email"
                       value="{{ old('email') }}"
                       placeholder="Email hoặc Tên đăng nhập"
                       class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-black focus:outline-none">
                @error('email')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="password" name="password"
                       placeholder="Mật khẩu"
                       class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-black focus:outline-none">
                @error('password')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <button type="submit"
                class="w-full bg-black text-white py-3 rounded-xl text-sm font-semibold hover:bg-gray-800 transition">
                ĐĂNG NHẬP
            </button>

            <div class="text-right">
                <a href="{{ route('password.request') }}"
                   class="text-sm text-gray-500 hover:text-black">
                    Quên mật khẩu?
                </a>
            </div>

            <div class="text-center text-gray-400 text-sm">Hoặc đăng nhập với</div>

            <div class="flex gap-3">
                <a href="#" class="flex-1 bg-blue-600 hover:bg-blue-700 text-white py-2 rounded-xl flex items-center justify-center text-sm transition">
                    <i class="mdi mdi-facebook text-lg mr-2"></i> Facebook
                </a>
                <a href="#" class="flex-1 bg-black hover:bg-gray-800 text-white py-2 rounded-xl flex items-center justify-center text-sm transition">
                    <i class="mdi mdi-google text-lg mr-2"></i> Google
                </a>
            </div>
        </form>

        <!-- REGISTER FORM -->
        <form id="form-register"
              action="{{ route('taikhoan.register') }}"
              method="POST"
              class="space-y-4 hidden">
            @csrf
            <input type="hidden" name="_tab" value="register">

            <div>
                <input type="text" name="full_name"
                       value="{{ old('full_name') }}"
                       placeholder="Họ và tên"
                       class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-black focus:outline-none">
                @error('full_name')
                    <p class="text-sm text-red-500 mt-1">{{ $message }}</p>
                @enderror
            </div>

            <div>
                <input type="email" name="email"
                       value="{{ old('email') }}"
                       placeholder="Email"
                       class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            <div>
                <input type="password" name="password"
                       placeholder="Mật khẩu"
                       class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            <div>
                <input type="password" name="password_confirmation"
                       placeholder="Nhập lại mật khẩu"
                       class="w-full border rounded-xl px-4 py-3 text-sm focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            <button type="submit"
                class="w-full bg-black text-white py-3 rounded-xl text-sm font-semibold hover:bg-gray-800 transition">
                ĐĂNG KÝ
            </button>
        </form>

    </div>
</div>

<!-- Toggle Script -->
<script>
    const loginBtn = document.getElementById('tab-login');
    const registerBtn = document.getElementById('tab-register');
    const formLogin = document.getElementById('form-login');
    const formRegister = document.getElementById('form-register');

    const oldTab = "{{ old('_tab') }}";

    function showTab(tab) {

        // Reset style
        loginBtn.classList.remove('border-b-2','border-black','text-gray-400');
        registerBtn.classList.remove('border-b-2','border-black','text-gray-400');

        if (tab === 'register') {
            registerBtn.classList.add('border-b-2','border-black');
            loginBtn.classList.add('text-gray-400');

            formRegister.classList.remove('hidden');
            formLogin.classList.add('hidden');
        } else {
            loginBtn.classList.add('border-b-2','border-black');
            registerBtn.classList.add('text-gray-400');

            formLogin.classList.remove('hidden');
            formRegister.classList.add('hidden');
        }
    }

    loginBtn.addEventListener('click', () => showTab('login'));
    registerBtn.addEventListener('click', () => showTab('register'));

    document.addEventListener('DOMContentLoaded', function () {
        if (oldTab === 'register') {
            showTab('register');
        } else {
            showTab('login');
        }
    });
</script>
@endsection
