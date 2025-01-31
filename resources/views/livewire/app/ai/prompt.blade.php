<div class="pb-6 md:mx-4   text-gray-700 dark:text-gray-200 ">

    {{-- <div class="min-h-[80vh] bg-gradient-to-b to-c-gray-700 from-c-gray-800 text-gray-200"> --}}
    <div x-ref="chat" class="mx-auto " x-data="{
        chatFullScreen: false,
        setChatFullScreen() {
            if (this.chatFullScreen) {
                document.exitFullscreen();
            } else {
                this.$refs.chat.requestFullscreen();
            }
            this.chatFullScreen = !this.chatFullScreen;
        },
        scrollToBottom() {
            const chatMessages = this.$refs.chatMessages;
            chatMessages.scrollTop = chatMessages.scrollHeight;
    
            setTimeout(() => {
                const chatMessages = this.$refs.chatMessages;
                chatMessages.scrollTop = chatMessages.scrollHeight;
            }, 1000);
        }
    }" @prompt-generated.window="scrollToBottom"
        @generate-prompt.window="scrollToBottom" x-init="$nextTick(() => scrollToBottom())">
        <div :class="chatFullScreen ? 'h-screen rounded-none mb-0 mt-0 sm:mt-0 sm:mx-0 mx-0' : ' sm:mx-4 mb-8 sm:mt-4 mt-1'"
            class="min-h-[90vh] rounded-2xl shadow-xl  backdrop-blur-sm border border-gray-700 bg-gradient-to-b to-c-gray-700 from-c-gray-800 text-gray-200">
            {{-- Header --}}
            <div class="text-center py-8 px-4 border-b border-gray-700">
                <h1 class="text-xl font-bold text-white mb-4">
                    مرحبا بك في المحادثة الذكية
                </h1>
                <p class="text-gray-400">
                    أدخل سؤالك للحصول على إجابة
                </p>
                <button type="button" x-on:click="setChatFullScreen()" class="absolute top-4 right-6">
                    <i class="fa fa-expand" x-show="!chatFullScreen"></i>
                    <i class="fa fa-compress" x-show="chatFullScreen"></i>
                </button>
            </div>

            {{-- Messages --}}
            <div :class="chatFullScreen ? 'min-h-[75vh] max-h-[75vh]' : ''"
                class="py-4 sm:p-4 space-y-4  min-h-[65vh] max-h-[65vh] overflow-y-auto scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800"
                id="chat-messages" x-ref="chatMessages">
                @foreach ($messages as $message)
                    <div
                        class="flex items-start gap-3 pb-6 {{ $message['type'] === 'user' ? 'flex-row-reverse' : '' }}">
                        @if ($message['type'] === 'user')
                            <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                                class="w-8 h-8 rounded-full border-2 border-purple-500 object-cover">
                        @else
                            <div class="w-8 h-8 rounded-full bg-purple-600 flex items-center justify-center">
                                <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18"
                                    viewBox="0 0 24 24" fill="none" stroke="currentColor" stroke-width="2"
                                    stroke-linecap="round" stroke-linejoin="round">
                                    <path d="M12 8V4H8" />
                                    <rect x="4" y="8" width="16" height="12" rx="2" />
                                    <path d="M2 14h2" />
                                    <path d="M20 14h2" />
                                    <path d="M15 13v2" />
                                    <path d="M9 13v2" />
                                </svg>
                            </div>
                        @endif
                        <div
                            class="px-4 py-2 rounded-2xl text-sm/8 max-w-[80%] {{ $message['type'] === 'user'
                                ? 'bg-purple-600 text-white'
                                : ($message['type'] === 'error'
                                    ? 'bg-red-600/20 text-red-200'
                                    : 'bg-gray-700 text-white') }}">
                            <div wire:ignore>
                                {!! $message['message'] !!}
                            </div>
                        </div>
                    </div>
                @endforeach

                <div wire:loading wire:scroll>
                    <div class="flex items-start gap-3">
                        <div class="w-8 h-8 rounded-full bg-blue-600 flex items-center justify-center">
                            <svg xmlns="http://www.w3.org/2000/svg" width="18" height="18" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 8V4H8" />
                                <rect x="4" y="8" width="16" height="12" rx="2" />
                                <path d="M2 14h2" />
                                <path d="M20 14h2" />
                                <path d="M15 13v2" />
                                <path d="M9 13v2" />
                            </svg>
                        </div>
                        <div class="px-4 py-2 rounded-2xl bg-gray-700">
                            <div class="flex gap-1 text-sm">
                                <span class="animate-bounce">⚪</span>
                                <span class="animate-bounce delay-100">⚪</span>
                                <span class="animate-bounce delay-200">⚪</span>
                            </div>
                        </div>
                    </div>
                </div>
            </div>

            {{-- Input --}}
            <div class="p-4 border-t border-gray-700">
                <form wire:submit.prevent="send" class="relative">
                    <textarea wire:model="prompt" placeholder="اكتب سؤالك هنا..."
                        class="w-full rounded-lg bg-gray-700 border-gray-600 text-white placeholder-gray-400 p-4 pr-12 resize-none focus:ring-1 focus:ring-purple-400 focus:border-transparent"
                        rows="3" dir="rtl" @keydown.enter.prevent="if (!event.shiftKey) { $wire.send() }"></textarea>
                    <button type="submit"
                        class="absolute bottom-3 left-3 p-2 rounded-lg bg-purple-600 hover:bg-purple-500 transition-colors disabled:opacity-50 disabled:cursor-not-allowed"
                        wire:loading.attr="disabled">
                        <svg xmlns="http://www.w3.org/2000/svg" width="20" height="20" viewBox="0 0 24 24"
                            fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                            stroke-linejoin="round" class="text-white">
                            <path d="M22 2L11 13" />
                            <path d="M22 2l-7 20-4-9-9-4 20-7z" />
                        </svg>
                    </button>
                </form>
            </div>
        </div>
    </div>
    {{-- </div> --}}
</div>
