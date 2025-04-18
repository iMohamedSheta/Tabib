@extends('layouts.guest')


@section('main')
    <div class="flex min-h-screen items-center p-6 bg-gray-50 dark:bg-c-gray-900">
        <div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-c-gray-800">
            <main>
                <livewire:auth.register.register />
            </main>
        </div>
    </div>
@endsection
