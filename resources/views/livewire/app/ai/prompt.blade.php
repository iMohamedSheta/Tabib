<div class="pb-6 md:mx-4 flex  text-gray-700 dark:text-gray-200 ">
    <div
        class="p-4 hidden sm:flex mb-6 mt-3 drop-shadow-2xl min-w-[15vw] overflow-hidden rounded-2xl backdrop-blur-sm border border-gray-700 bg-gradient-to-b to-c-gray-700 from-c-gray-800 text-gray-200">
        <div class="w-full">
            <h4 class="text-sm bloc w-full font-bold text-white mb-4">
                المحادثات
            </h4>
            <ul
                class="w-full block max-h-[82vh] overflow-auto scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600
			 dark:scrollbar-track-gray-800 scroll-smooth p-4 rounded-xl scrollbar-thumb-rounded bg-c-gray-700 shadow-inner">
                <li>
                    <button wire:click.prevent="setPromptModel()"
                        class="w-full px-4 py-3 rounded-xl transition-all duration-200
						{{ $promptModel === null ||
      ($sessionGeneratedPrompt !== null && $promptModel->id === $sessionGeneratedPrompt->id)
          ? 'bg-purple-600 text-white'
          : 'text-gray-300 hover:bg-gray-700' }}">
                        <div class="flex items-center space-x-3 text-sm">
                            <span class="mx-2">
                                💬
                            </span>
                            @if ($sessionGeneratedPrompt !== null)
                                <span class="font-medium truncate">{{ $sessionGeneratedPrompt->name }}</span>
                            @else
                                <span class="font-medium truncate">محادثة جديدة</span>
                            @endif
                        </div>
                    </button>
                </li>
                @foreach ($promptModels as $model)
                    <li>
                        <button wire:click="setPromptModel('{{ $model->id }}')"
                            class="w-full px-4 py-3 rounded-xl transition-all duration-200
							{{ $promptModel?->id === $model->id ? 'bg-purple-600 text-white' : 'text-gray-300 hover:bg-gray-700' }}">
                            <div class="flex items-center space-x-3 text-sm">
                                <span class="mx-2">
                                    💬
                                </span>
                                <span class="font-medium truncate">{{ $model->name }}</span>
                            </div>
                        </button>
                    </li>
                @endforeach
            </ul>
        </div>
    </div>
    <div class="w-[98%] mx-auto sm:max-w-[70vw]">
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
                setTimeout(() => {
                    const chatMessages = this.$refs.chatMessages;
                    chatMessages.scrollTop = chatMessages.scrollHeight;
                }, 50);
            }
        }" @prompt-generated.window="scrollToBottom"
            @generate-prompt.window="scrollToBottom" @prompt-model-changed.window="scrollToBottom"
            x-init="$nextTick(() => scrollToBottom())">
            <div :class="chatFullScreen ? 'h-screen rounded-none mb-0 mt-0 sm:mt-0 sm:mx-0 mx-0' : ' sm:mx-4 mb-8 sm:mt-4 mt-1'"
                class="min-h-[90vh] rounded-2xl drop-shadow-2xl  backdrop-blur-sm border border-gray-700 bg-gradient-to-b to-c-gray-700 from-c-gray-800 text-gray-200">
                {{-- Header --}}
                <div class="text-center pt-8 pb-4 px-4 border-b border-gray-700">
                    <h1 class="text-xl font-bold text-white mb-4">
                        مرحبا بك في المحادثة الذكية
                    </h1>
                    <div class="hidden sm:block text-gray-400 ">
                        <p class="block leading-relaxed pb-3">
                            اختر البيانات التي توافق علي حصول الذكاء الاصطناعي عليها لحل مشكلتك
                        </p>
                        <div class="grid sm:grid-cols-3 gap-2">
                            @foreach ($topics as $key => $topic)
                                <label for="checkbox-{{ $key }}"
                                    class="flex p-3 w-full bg-c-gray-700 shadow-inner  cursor-pointer  hover:bg-c-gray-600 rounded-lg checked:ring text-sm">
                                    <span class="text-sm text-gray-200 ">
                                        {{ $topic }}
                                    </span>
                                    <input type="checkbox" wire:model="topicsChecked.{{ $key }}"
                                        class="shrink-0 ms-auto mt-0.5 checked:bg-purple-600
												checked:hover:bg-purple-600 checked:focus:bg-purple-600
												disabled:opacity-50 disabled:pointer-events-none
												appearance-none w-5 h-5 bg-gray-200 rounded cursor-pointer"
                                        id="checkbox-{{ $key }}"
                                        style="appearance: none;width: 20px;height: 20px;border: none;outline: none;box-shadow: none;cursor: pointer;border-radius: 4px;">

                                </label>
                            @endforeach
                        </div>
                    </div>
                    <button type="button" x-on:click="setChatFullScreen()" class="absolute top-4 right-6">
                        <i class="fa fa-expand" x-show="!chatFullScreen"></i>
                        <i class="fa fa-compress" x-show="chatFullScreen"></i>
                    </button>
                </div>

                {{-- Messages --}}
                <div :class="chatFullScreen ? 'min-h-[73vh] max-h-[73vh]' : ''"
                    class="py-4 sm:p-4 space-y-4  min-h-[63vh] max-h-[63vh] overflow-y-auto scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800"
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
                                <div>
                                    {!! $message['message'] !!}
                                </div>
                            </div>
                        </div>
                    @endforeach

                    <div wire:loading>
                        <div class="flex items-start gap-3">
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
    </div>
</div>
