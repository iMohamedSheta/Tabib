@props([
    'withError' => false,
    'defaultImage' => asset('images/patients/upload.png'),
])

<div x-data="fileUpload()" class="mt-4 w-full px-2">
    <div class="w-full py-12 bg-c-gray-700 rounded-2xl border border-gray-300 border-dashed"
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

                <h2 class="text-center text-gray-200 text-xs font-light leading-4">
                    اصغر من 20MB
                </h2>
            </div>

            <div class="grid gap-2">
                <h4 class="text-center text-gray-300 text-sm font-medium leading-snug">
                    اسحب وادرج الملف هنا او اضغط
                </h4>
                <div class="flex items-center justify-center">
                    <label>
                        <input type="file" {{ $attributes->except('class') }} hidden x-ref="fileInput"
                            @change="showPreview">
                        <div
                            class="flex w-40 h-9 px-2 flex-col bg-purple-600 rounded-full shadow text-gray-50 text-xs font-semibold leading-4 items-center justify-center cursor-pointer focus:outline-none">
                            رفع ملف ملحق بالمريض
                        </div>
                    </label>
                </div>
                <div class="rounded-lg w-2/3 mx-auto" x-show="fileName != null || isUploading">
                    <div class="flex items-center justify-center" x-show="fileName != null">
                        <h6 class="text-gray-300 py-2 px-4  bg-c-gray-700 rounded-lg">
                            <span x-text="fileName"></span>
                        </h6>
                    </div>
                    <div class="rounded-lg bg-gray-700 h-[2px]  mb-3 mx-auto">
                        <div class="bg-blue-500 h-[2px] mx-0 px-0"
                            :style="`width: ${progress}%;transition: width ${timeToUpload}s;`" x-show="isUploading">
                        </div>
                    </div>
                </div>

                @if ($withError)
                    @error($withError)
                        <div class="flex items-center justify-center text-center">
                            <h6 class="text-sm text-red-500 p-1">
                                {{ $message }}
                            </h6>
                        </div>
                    @enderror
                @endif
            </div>
        </div>
    </div>
</div>
