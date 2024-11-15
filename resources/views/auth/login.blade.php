@extends('layouts.guest')


@section('main')
    <div class="flex-1 h-full max-w-xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-c-gray-800">
        <div class=" overflow-y-auto md:flex-row shadow-lg p-12  mx-auto">
            <form method="POST" action="{{ route('login') }}">

                @csrf

                <x-form.input-text id="username" label="اسم المستخدم / البريد الالكتروني"
                    placeholder='اسم المستخدم مثل mohamedsheta' autofocus name="username" autocomplete="username" withError="username"
                    :value="old('username')" required>
                </x-form.input-text>

                <x-form.input-text type="password" label="الرقم السري" placeholder='**********' required
                    autocomplete="current-password" withError="password" name="password">
                </x-form.input-text>


                <div class="flex items-center justify-between mt-4">
                    @if (Route::has('password.request'))
                        <x-form.checkbox id="remember_me" name="remember">
                            <h6 class="ml-2 px-2">
                                تذكرني
                            </h6>
                        </x-form.checkbox>
                    @endif

                    <x-button class="ms-4">
                        {{ __('تسجيل الدخول') }}
                    </x-button>
            </form>
        </div>
        <div class="my-8 border-t-2 h-1 border-gray-700" > </div>
        <x-form.link href="{{ route('socialite.google.redirect') }}">
            <i class="fa-brands fa-google"></i>
            <span class="px-2">
                التسجيل عن طريق بريد جوجل
            </span>
        </x-form.link>

        <x-form.link href="{{ route('socialite.facebook.redirect') }}" class="mt-4">
            <i class="fa-brands fa-facebook"></i>
            <span class="px-2">
                التسجيل عن طريق الفيس بوك
            </span>
        </x-form.link>
    </div>
    </div>
    </div>
@endsection
