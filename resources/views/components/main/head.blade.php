<div {{ $attributes->except('class') }} class="mb-6  bg-purple-200 text-gray-800 dark:bg-c-gray-700 dark:text-purple-200 font-bold p-6 rounded-lg shadow-lg dark:shadow-lg">
    <h2 class="text-4xl inline-flex items-center mx-6 my-4">
        <img src="{{ $icon ?? asset('images/doctors/icon.png') }}" alt="Doctor Icon" class="w-20 h-20 rounded-full object-cover border-2 border-gray-300 dark:border-gray-600 shadow-md">
        <span class="md:px-4 pr-3">
            {{ $title ?? 'title' }}
            <p class=" md:max-w-[95%] text-gray-600 dark:text-gray-300 text-sm md:px-2 pr-1 pt-3 leading-relaxed">
                {{ $body ?? 'body'}}
            </p>
        </span>
    </h2>
</div>
