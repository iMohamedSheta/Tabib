<div>
    <div x-data="fileListComponent">
        <div class="flex justify-between mb-8">
            <div class="flex items-center justify-center">
                <div class="inline-flex items-center justify-center bg-gray-800 rounded-lg">
                    <!-- Icon Button -->
                    <button class="flex items-center justify-center w-8 h-8 px-1  py-3  rounded-lg"
                        @click="setViewToGrid()" :class="{ 'bg-gray-700': isViewGrid() }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <rect width="7" height="7" x="3" y="3" rx="1"></rect>
                            <rect width="7" height="7" x="14" y="3" rx="1"></rect>
                            <rect width="7" height="7" x="14" y="14" rx="1"></rect>
                            <rect width="7" height="7" x="3" y="14" rx="1"></rect>
                        </svg>
                    </button>
                    <!-- Text Button -->
                    <button class="flex items-center justify-center w-8 h-8 px-1 py-3 rounded-lg"
                        @click="setViewToList()" :class="{ 'bg-gray-700': isViewList() }">
                        <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round">
                            <line x1="3" x2="21" y1="6" y2="6"></line>
                            <line x1="3" x2="21" y1="12" y2="12"></line>
                            <line x1="3" x2="21" y1="18" y2="18"></line>
                        </svg>
                    </button>
                </div>
                <div class="inline-flex justify-center align-items-center">
                    <livewire:app.patient.includes.upload-attached-file-modal :patient="$patient"
                        :mediaType="App\Enums\Media\MediaTypeEnum::RADIOLOGY"></livewire:app.patient.includes.upload-attached-file-modal>
                </div>
            </div>
            <div>
                <span>
                    {{ $this->mediaRadioItems['total'] }}
                    اشعة ملحقة بالمريض
                </span>
            </div>
        </div>

        @if ($this->mediaRadioItems['total'] > 0)
            <ul>
                <div :class="isViewGrid() ? 'flex flex-wrap justify-center items-center' : 'block'">
                    @foreach ($this->mediaRadioItems['items'] as $media)
                        <div class="p-4">
                            <x-files.file :media="$media" :src="$media->url"></x-files.file>
                        </div>
                    @endforeach
                </div>
            </ul>
            <x-datatable.pagination :paginator="$this->mediaRadioItems['items']"></x-datatable.pagination>
        @else
            <p class="text-red-500 text-sm text-center p-8">
                لا توجد اشعة ملحقة.
            </p>
        @endif
    </div>
</div>

@push('scripts')
    <script>
        function fileListComponent() {
            return {
                view: 'grid',
                setViewToList() {
                    this.setView('list');
                },
                setViewToGrid() {
                    this.setView('grid');
                },
                setView(selected_view) {
                    this.view = selected_view;
                },
                isViewGrid() {
                    return this.view === 'grid';
                },
                isViewList() {
                    return this.view === 'list';
                }
            };
        }
    </script>
@endpush
