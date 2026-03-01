{{-- resources/views/client/user/profile.blade.php --}}
@extends('client.user.dashboard')

@section('dashboard-content')

<div class="max-w-2xl mx-auto">

    <div class="bg-white rounded-2xl shadow p-8">

        <h2 class="text-2xl font-semibold text-center mb-8">
            ✏️ Chỉnh sửa thông tin cá nhân
        </h2>

        {{-- SUCCESS MESSAGE --}}
        @if (session('success'))
            <div class="mb-6 p-4 rounded-xl bg-green-100 text-green-700 text-sm">
                {{ session('success') }}
            </div>
        @endif

        <form id="profile-form"
              action="{{ route('user.profile.update') }}"
              method="POST"
              class="space-y-6">

            @csrf

            {{-- HỌ TÊN --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Họ tên
                </label>
                <input type="text"
                       name="full_name"
                       value="{{ old('full_name', Auth::user()->full_name) }}"
                       class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            {{-- PHONE --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Số điện thoại
                </label>
                <input type="text"
                       name="phone"
                       value="{{ old('phone', Auth::user()->phone) }}"
                       class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            {{-- GENDER --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Giới tính
                </label>

                @php
                    $gender = Auth::user()->gender;
                    $genderValue = $gender === 1 ? 'male' : ($gender === 0 ? 'female' : '');
                @endphp

                <select name="gender"
                        class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none">
                    <option value="">-- Chọn --</option>
                    <option value="male" {{ $genderValue === 'male' ? 'selected' : '' }}>Nam</option>
                    <option value="female" {{ $genderValue === 'female' ? 'selected' : '' }}>Nữ</option>
                </select>
            </div>

            {{-- DATE OF BIRTH --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Ngày sinh
                </label>
                <input type="date"
                       name="date_of_birth"
                       value="{{ old('date_of_birth', Auth::user()->date_of_birth) }}"
                       class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            {{-- ADDRESS --}}
            <div>
                <label class="block text-sm font-medium mb-2">
                    Địa chỉ
                </label>
                <input type="text"
                       name="address"
                       value="{{ old('address', Auth::user()->address) }}"
                       class="w-full border rounded-xl px-4 py-2 focus:ring-2 focus:ring-black focus:outline-none">
            </div>

            {{-- BUTTONS --}}
            <div class="flex justify-between items-center pt-6 border-t">

                <button type="submit"
                        id="submit-btn"
                        class="px-6 py-2 bg-black text-white rounded-xl hover:opacity-90 transition text-sm">
                    ✔️ Xác nhận
                </button>

                @if (session('user_return_url'))
                    <a href="{{ session('user_return_url') }}"
                       class="px-6 py-2 border rounded-xl hover:bg-gray-100 transition text-sm">
                        ← Quay lại
                    </a>
                @else
                    <a href="{{ url()->previous() }}"
                       class="px-6 py-2 border rounded-xl hover:bg-gray-100 transition text-sm">
                        ← Quay lại
                    </a>
                @endif

            </div>

        </form>

    </div>

</div>

@endsection


@push('scripts')
<script>
document.addEventListener("DOMContentLoaded", function () {
    const form = document.getElementById('profile-form');
    const submitBtn = document.getElementById('submit-btn');
    const originalValues = {};

    Array.from(form.elements).forEach(el => {
        if (el.name) originalValues[el.name] = el.value;
    });

    form.addEventListener('input', function () {
        let changed = false;
        for (const name in originalValues) {
            const input = form.elements[name];
            if (input && input.value !== originalValues[name]) {
                changed = true;
                break;
            }
        }
        submitBtn.innerHTML = changed ? '✅ Cập nhật' : '✔️ Xác nhận';
    });
});
</script>
@endpush
