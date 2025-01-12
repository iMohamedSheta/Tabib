@props([
    'name' => '',
])
<div x-show="selectedTab === '{{ $name }}'" id="tab-panel-{{ $name }}" role="tabpanel"
    aria-label="{{ $name }}">
    {{ $slot }}
</div>
