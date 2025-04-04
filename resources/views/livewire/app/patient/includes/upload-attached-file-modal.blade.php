<div>
    <div x-data="uploadAttachedFileModalComponent" x-cloak x-on:uploaded-file.window="{{ $show }} = false">
        <x-button class="mx-2 px-0" @click="{{ $show }} = true">
            <span class="px-2">
                <i class="fa-solid fa-upload px-1"></i>
                <span class="pl-1">
                    اضافة ملف جديد
                </span>
            </span>
        </x-button>

        @teleport('body')
            <div>
                <div x-on:updated-event.window="{{ $show }} = false">
                    <x-modals.modal @keydown.escape.window="{{ $show }} = false" show="{{ $show }}"
                        maxWidth="3xl">
                        <x-slot name="title">
                            اضافة ملف جديد
                        </x-slot>

                        <x-slot name="content">
                            <h3 class="pb-2">
                                ارفع الملف الخاص بالمريض لاضافته الي الملفات المرفقة بالمريض
                            </h3>
                            <div class="flex flex-wrap">
                                <x-fileupload.attached-files wire:model="uploadedAttachedFile"
                                    withError="uploadedAttachedFile">
                                </x-fileupload.attached-files>
                            </div>
                        </x-slot>

                        <x-slot name="footer">
                            <div class="flex justify-end items-center w-full">
                                <div>
                                    <x-button wire:click="uploadAttachedFileAction()">
                                        {{ __('اضافة') }}
                                    </x-button>
                                    <x-danger-button x-on:click="{{ $show }} = false">
                                        {{ __('اغلاق') }}
                                    </x-danger-button>
                                </div>
                            </div>
                        </x-slot>
                    </x-modals.modal>
                </div>
            </div>
        @endteleport
    </div>
</div>
@push('scripts')
    <script>
        function uploadAttachedFileModalComponent() {
            return {
                {{ $show }}: false,
            };
        }
    </script>
@endpush
