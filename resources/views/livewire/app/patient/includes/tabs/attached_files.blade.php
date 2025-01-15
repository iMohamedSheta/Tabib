<p class="p-4">
    لا توجد ملفات ملحقة.
    {{-- @if ($patient->attached_files->isEmpty())
@else
    <ul>
        @foreach ($patient->attached_files as $file)
            <li>
                <a href="{{ route('files.download', $file->id) }}"
                    class="text-blue-500 hover:underline">
                    {{ $file->name }}
                </a>
            </li>
        @endforeach
    </ul>
@endif --}}
</p>
