@props([
    'withError' => false,
    'defaultImage' => 'https://www.gravatar.com/avatar/00000000000000000000000000000000?d=mp&f=y',
])

<div x-data="fileUpload()" class="mt-4 w-full px-2">
    <div class="w-full py-6 bg-gray-50 rounded-2xl border border-gray-300 border-dashed"
        :class="{ 'border-purple-600 bg-indigo-50': isDragging }" @dragover.prevent="isDragging = true"
        @dragleave.prevent="isDragging = false" @drop.prevent="handleDrop">

        <div class="grid gap-3">
            <div>
                <!-- Default Image or Preview -->
                <template x-if="!imagePreview">
                    <img src="{{ $defaultImage }}" class="mx-auto mb-1 w-20 h-20 rounded-full object-cover">
                </template>
                <template x-if="imagePreview">
                    <img :src="imagePreview" class="mx-auto mb-1 w-20 h-20 rounded-full object-cover">
                </template>

                <h2 class="text-center text-gray-400 text-xs font-light leading-4">
                    PNG, JPG, JPEG, اصغر من 2MB
                </h2>
            </div>

            <div class="grid gap-2">
                <h4 class="text-center text-gray-900 text-sm font-medium leading-snug">
                    اسحب وادرج الصورة هنا او اضغط
                </h4>
                <div class="flex items-center justify-center">
                    <label>
                        <input type="file" {{ $attributes->except('class') }} hidden x-ref="fileInput"
                            @change="showPreview">
                        <div
                            class="flex w-32 h-9 px-2 flex-col bg-purple-600 rounded-full shadow text-white text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                            اختيار صورة شخصية
                        </div>
                        @if ($withError)
                            @error($withError)
                                <h6 class="text-sm text-red-500 p-1">
                                    {{ $message }}
                                </h6>
                            @enderror
                        @endif
                    </label>
                </div>
            </div>
        </div>
    </div>
</div>
