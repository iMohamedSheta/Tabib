<div x-data="copyClipboardComponent" class="relative">
    <button @click="copyToClipboard('{{ $slot }}'); copied = true; setTimeout(() => copied = false, 2000)"
        class="btn align-middle select-none font-sans font-bold text-center transition-all 
        disabled:opacity-50 disabled:shadow-none disabled:pointer-events-none text-xs rounded-lg 
        bg-gray-800 text-white shadow-md shadow-gray-900/10 hover:shadow-lg 
        hover:shadow-gray-900/20 focus:opacity-[0.85] focus:shadow-none 
        active:opacity-[0.85] active:shadow-none flex items-center gap-x-3 px-4 py-2.5 lowercase"
        type="button" :aria-label="copied ? 'Copied!' : 'Copy to clipboard'">
        <p
            class="block pr-3 font-sans text-sm antialiased font-normal leading-normal border-r text-inherit border-gray-400/50">
            {{ $slot }}
        </p>
        <i x-show="!copied" class="fa fa-copy"></i>
        <i x-show="copied" class="fa fa-check"></i>
    </button>
    <div x-show="copied"
        class="absolute z-50 top-[3px] right-[140px] rounded-lg bg-gray-800 py-2 px-3 w-[75px] text-white focus:outline-none">
        تم النسخ!
    </div>
</div>
@push('scripts')
    <script>
        function copyClipboardComponent() {
            return {
                copied: false,
                copyToClipboard(textToCopy) {
                    navigator.clipboard.writeText(textToCopy).then(() => {
                        console.log('Text copied to clipboard:', textToCopy);
                    }).catch(err => {
                        console.error('Error copying text to clipboard:', err);
                    });
                }
            }
        }
    </script>
@endpush
