@props([
    'width' => 'min-w-80',
    'media' => null,
    'src' => null,
])
@php
    use App\Formatters\DateFormatter;
    use App\Formatters\DataSizeFormatter;
    use App\Enums\Media\MediaCollectionEnum;

    $filename =
        Str::limit(pathinfo($media->file_name, PATHINFO_FILENAME), 20, '..etc') .
        '.' .
        pathinfo($media->file_name, PATHINFO_EXTENSION);

    $mediaCollection = MediaCollectionEnum::getCollection($media->collection_name);
@endphp
<div class="bg-purple-500 rounded-lg">
    <div
        class="bg-c-gray-700 pb-4 rounded-lg {{ $width }} relative group transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl">
        <span class="bg-purple-500 opacity-5 w-full h-full absolute hidden group-hover:block"> </span>


        <!-- File Icon Placeholder -->
        <div class="h-48 bg-gray-700 rounded-md mb-4 flex items-center justify-center">
            @if (!is_null($src) && MediaCollectionEnum::IMAGES === $mediaCollection)
                <img src="{{ $src }}" alt="Image description" class="max-h-full max-w-full object-contain">
            @elseif(MediaCollectionEnum::DOCUMENTS === $mediaCollection->value)
                DOC
            @elseif(MediaCollectionEnum::VIDEOS === $mediaCollection)
                VIDEO
            @else
                <div class="text-gray-400 text-center">
                    <!-- Placeholder for file icon -->
                    <div class="w-8 h-2 bg-gray-600 mb-1 mx-auto"></div>
                    <div class="w-6 h-2 bg-gray-600 mx-auto"></div>
                </div>
            @endif
        </div>


        <!-- Action Buttons -->
        <div class="absolute top-4 right-4 hidden gap-2 group-hover:flex bg-c-gray-700 rounded-lg "
            x-data="mediaActionComponent">
            <button class="p-2 text-gray-400 rounded hover:bg-gray-600">
                <i class="fa fa-share fa-xl"></i>
            </button>
            <a href="{{ $src }}" target="__blank" class="p-2  text-gray-400 rounded hover:bg-gray-600">
                <i class="fa fa-download fa-xl"></i>
            </a>
            <button class="p-2  text-red-400 rounded hover:bg-red-500 hover:text-gray-100"
                @click="confirmedDelete('{{ $filename }}', '{{ $media->id }}')">
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
                    {{ $filename }}
                </p>
                <p class="text-gray-400">
                    {{ DateFormatter::detailed($media->created_at) }}
                    ·
                    {{ DataSizeFormatter::size($media->size) }}
                </p>
            </div>
        </div>
    </div>
</div>

@push('scripts')
    <script>
        function mediaActionComponent() {
            return {
                confirmedDelete(filename, mediaId) {
                    let title = "هل أنت متأكد من حذف الملف " + filename + " ؟";
                    let text = "سوف يتم حذف هذه الملف نهائياً!";
                    confirmDelete(title, text).then((result) => {

                        if (result.isConfirmed) {
                            @this.call('deleteMediaAction', mediaId)
                        }
                    });
                }
            }
        }
    </script>
@endpush
