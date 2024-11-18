@extends('layouts.guest')


@section('main')
<div class="flex-1 h-full max-w-4xl mx-auto overflow-hidden bg-white rounded-lg shadow-xl dark:bg-gray-800">
    <main>
        <livewire:auth.register.steps.o-auth-callback :userData="$userData" >
    </main>
</div>
@endsection
