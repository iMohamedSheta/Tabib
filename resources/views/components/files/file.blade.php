@props([
    'name' => 'اسم الملف.txt',
    'created_at' => 'Feb 6th, 2023',
    'created_by' => 'James',
    'width' => 'min-w-80',
])
<div class="bg-purple-500 rounded-lg">
    <div
        class="bg-c-gray-700 pb-4 rounded-lg {{ $width }} relative group transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl">
        <span class="bg-purple-500 opacity-5 w-full h-full absolute hidden group-hover:block"> </span>


        <!-- File Icon Placeholder -->
        <div class="h-48 bg-gray-700 rounded-md mb-4 flex items-center justify-center">
            <div class="text-gray-400">
                <!-- Placeholder for file icon -->
                <div class="w-8 h-2 bg-gray-600 mb-1"></div>
                <div class="w-6 h-2 bg-gray-600"></div>
            </div>
        </div>

        <!-- Action Buttons -->
        <div class="absolute top-4 right-4 hidden gap-2 group-hover:flex bg-c-gray-700 rounded-lg ">
            <button class="p-2 text-gray-400 rounded hover:bg-gray-600">
                <i class="fa fa-share fa-xl"></i>
            </button>
            <button class="p-2  text-gray-400 rounded hover:bg-gray-600">
                <i class="fa fa-download fa-xl"></i>
            </button>
            <button class="p-2  text-red-400 rounded hover:bg-red-500 hover:text-gray-100">
                <i class="fa fa-trash fa-xl"></i>
            </button>
        </div>

        <!-- File Name and Details -->
        <div class="flex items-center gap-2 px-4">
            <div class="p-2 bg-gray-700 rounded-md">
                <i class="fa fa-file-alt fa-xl"></i>
            </div>
            <div>
                <p class="text-gray-200 truncate pb-1">
                    {{ $name }}
                </p>
                <p class="text-gray-400 ">
                    {{ $created_by }} · {{ $created_at }}</p>
            </div>
        </div>
    </div>
</div>
