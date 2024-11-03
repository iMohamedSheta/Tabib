@extends('layouts.guest')


@section('main')
<div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-c-gray-800">
    <main>
        <livewire:auth.register.register />
    </main>
</div>
@endsection
