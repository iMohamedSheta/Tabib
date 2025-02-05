<!-- Desktop sidebar -->
<aside class="z-20 hidden h-screen  opacity-95 bg-c-gray-800 duration-300  md:block flex-shrink-0
" style="z-index: 0"
    x-data="{
        userMenuOpen: false,
        toggleUserProfileDropdown() {
            if (!$store.appConfig.isAppSidebarOpen) {
                this.userMenuOpen = true;
                $store.appConfig.isAppSidebarOpen = true;
            } else {
                this.userMenuOpen = !this.userMenuOpen;
            }
        }
    }"
    :class="{ 'w-64': $store.appConfig.isAppSidebarOpen, 'w-24': !$store.appConfig.isAppSidebarOpen }">
    <div class="h-full flex flex-col flex-1 justify-space-between  text-gray-400 dark:text-gray-400">
        <div
            class="h-full overflow-y-auto  scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800 transition-all  duration-500">
            {{-- <div class="text-center bg-c-gray-800   pb-2 pt-4 rounded transition-all duration-500"
                x-show="$store.appConfig.isAppSidebarOpen">
                <a class="text-2xl font-extrabold text-purple-200 dark:text-purple-200 " href="#">
                    <img src="{{ asset('images/logo/4.png') }}" alt="Logo"
                        class="w-[50px] border-2 bg-c-gray-700 border-gray-400 mx-auto pointer-events-none select-none rounded-full">
                    <span class="block mt-1">
                        ميدكيلنكس
                    </span>
                </a>
            </div> --}}
            <!-- User Profile Section -->
            <div class=" border-b border-purple-700/40 ">
                <button class="flex items-center w-full p-4 transition-colors duration-200 hover:bg-purple-400/10 group">
                    <div class="relative">
                        <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                            class="w-10 h-10 rounded-b-full border-2 border-purple-400 object-cover">
                        <div
                            class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-purple-900 rounded-full">
                        </div>
                        <span aria-hidden="true"
                            class="absolute bottom-0 animate-ping right-0 inline-block w-3 h-3  bg-green-500 border-2 border-purple-700 rounded-full dark:border-gray-800"></span>
                    </div>
                    <div class="mr-3 text-right transition-all duration-200" x-cloak
                        :class="{ 'hidden': !$store.appConfig.isAppSidebarOpen }">
                        <h3 class="text-xl font-medium text-white">
                            {{ auth()->user()->organization->name }}</h3>
                        <p class="text-xs text-purple-300">
                            المنظمة
                        </p>
                    </div>
                </button>
            </div>
            {{-- <div class="text-center bg-c-gray-800   pb-2 pt-4 rounded transition-all duration-500"
                x-show="!$store.appConfig.isAppSidebarOpen" x-cloak>
                <a class="text-2xl font-extrabold text-purple-200 dark:text-purple-200 " href="#">
                    <img src="{{ asset('images/logo/4.png') }}" alt="Logo"
                        class="w-[50px] border-2 bg-c-gray-700 border-gray-400 mx-auto pointer-events-none select-none rounded-full">
                </a>
            </div> --}}
            <div class="flex flex-col ">
                <ul class="mt-1 text-xs">
                    <x-theme.sidebar-link href="{{ route('app.admin.dashboard') }}" activeRoute="app.admin.dashboard">
                        <x-slot:icon>
                            <i class="fa-solid fa-archway fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <span class="mr-4">الرئيسية</span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                        <x-slot:icon>
                            <i class="fa-solid fa-wallet fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <span class="mr-4 ">
                            محفظة النظام
                        </span>
                    </x-theme.sidebar-link>

                    <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}"
                        activeRoute="app.admin.clinic.index">
                        <x-slot:icon>
                            <i class="fa-solid fa-house-chimney-medical fa-xl px-1"></i>
                        </x-slot:icon>
                        <span class="mr-4">العيادات</span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.clinic.service.index') }}"
                        activeRoute="app.admin.clinic.service.index">
                        <x-slot:icon>
                            <i class="fa-solid fa-kit-medical fa-xl px-1 "></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            الخدمات الطبية
                        </span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.doctor.index') }}"
                        activeRoute="app.admin.doctor.index">
                        <x-slot:icon>
                            <i class="fa-solid fa-user-md fa-xl px-1"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            الاطباء
                        </span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.patient.index') }}"
                        activeRoute="app.admin.patient.index, app.admin.patient.show">
                        <x-slot:icon>
                            <i class="fa-solid fa-bed-pulse fa-xl px-1"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            المرضي
                        </span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.calendar.index') }}"
                        activeRoute="app.admin.calendar.index">
                        <x-slot:icon>
                            <i class="fa-solid fa-calendar fa-xl px-1"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            المواعيد والحجوزات
                        </span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.queue.index') }}"
                        activeRoute="app.admin.queue.index">
                        <x-slot:icon>
                            <i class="fa-solid fa-microphone-lines fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            طوابير الكشوفات - Queue
                        </span>
                    </x-theme.sidebar-link>
                    <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                        <x-slot:icon>
                            <i class="fa-solid fa-receipt fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            الفواتير والمدفوعات
                        </span>
                    </x-theme.sidebar-link>

                    <x-theme.sidebar-link href="{{ route('app.admin.ai.prompt.index') }}"
                        activeRoute="app.admin.ai.prompt.index">
                        <x-slot:icon>
                            <svg xmlns="http://www.w3.org/2000/svg" width="24" height="24" viewBox="0 0 24 24"
                                fill="none" stroke="currentColor" stroke-width="2" stroke-linecap="round"
                                stroke-linejoin="round">
                                <path d="M12 8V4H8" />
                                <rect x="4" y="8" width="16" height="12" rx="2" />
                                <path d="M2 14h2" />
                                <path d="M20 14h2" />
                                <path d="M15 13v2" />
                                <path d="M9 13v2" />
                            </svg>
                        </x-slot:icon>
                        <span class="mr-4">
                            محادثة ذكية
                        </span>
                    </x-theme.sidebar-link>

                    {{-- <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-newspaper fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        السجلات الطبية EMR
                    </span>
                </x-theme.sidebar-link> --}}
                    <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                        <x-slot:icon>
                            <i class="fa-solid fa-chart-line fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            الإحصائيات والتقارير
                        </span>
                    </x-theme.sidebar-link>
                    {{-- <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-print fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        قسم الوثائق والنماذج
                    </span>
                </x-theme.sidebar-link> --}}
                    <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                        <x-slot:icon>
                            <i class="fa-solid fa-cubes fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <span class="mr-4">
                            المخزون وإدارة الأدوية
                        </span>
                    </x-theme.sidebar-link>
                    {{-- <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-store fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        المتجر
                    </span>
                </x-theme.sidebar-link> --}}
                    {{-- <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-store fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        الادوية الطبية
                        <!-- الادوية النشطة ومشاركة في حالة وجود بدائل ارخص للدواء تقديم معلومات عن الوصفات أو الأدوية المتدرجة، -->
                    </span>
                </x-theme.sidebar-link> --}}

                    {{-- <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-store fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        التأمين الطبي
                    </span>
                </x-theme.sidebar-link> --}}

                    {{-- <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-store fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        نظام دعم القرار
                    </span>
                </x-theme.sidebar-link>
                <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-store fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        الصيدلية
                    </span>
                </x-theme.sidebar-link>
                <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-bell fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">
                        الرسائل والإشعارات
                    </span>
                </x-theme.sidebar-link> --}}



                    <x-theme.sidebar-dropdown-link title="الاعدادات"
                        activeRoutes="app.admin.dashboard, app.admin.clinic.index">
                        <x-slot:icon>
                            <i class="fa-solid fa-cogs fa-xl px-1 text-red-500"></i>
                        </x-slot:icon>
                        <x-theme.sidebar-link href="{{ route('app.admin.clinic.service.index') }}"
                            activeRoute="app.admin.clinic.service.index">
                            <x-slot:icon>
                                <i class="fa-solid fa-kit-medical fa-xl px-1 "></i>
                            </x-slot:icon>
                            <span class="mr-4">
                                الخدمات الطبية
                            </span>
                        </x-theme.sidebar-link>
                        <x-theme.sidebar-link href="{{ route('app.admin.patient.index') }}"
                            activeRoute="app.admin.patient.index, app.admin.patient.show">
                            <x-slot:icon>
                                <i class="fa-solid fa-bed-pulse fa-xl px-1"></i>
                            </x-slot:icon>
                            <span class="mr-4">
                                المرضي
                            </span>
                        </x-theme.sidebar-link>
                    </x-theme.sidebar-dropdown-link>

                </ul>
                <div class="px-6 my-6">
                    <button
                        class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                        <span :class="{ 'hidden': !$store.appConfig.isAppSidebarOpen }">
                            انشاء عيادة
                        </span>
                        <i class="fa-solid fa-plus"></i>
                    </button>
                </div>
            </div>
        </div>
        <!-- User Profile Section -->
        <div class=" border-t border-purple-700/40 ">
            <button @click="toggleUserProfileDropdown()"
                class="flex items-center w-full p-4 transition-colors duration-200 hover:bg-purple-400/10 group">
                <div class="relative">
                    <img src="{{ auth()->user()->profile_photo_url }}" alt="Profile"
                        class="w-10 h-10 rounded-full border-2 border-purple-400 object-cover">
                    <div class="absolute bottom-0 right-0 w-3 h-3 bg-green-500 border-2 border-purple-900 rounded-full">
                    </div>
                    <span aria-hidden="true"
                        class="absolute bottom-0 animate-ping right-0 inline-block w-3 h-3  bg-green-500 border-2 border-purple-700 rounded-full dark:border-gray-800"></span>
                </div>
                <div class="mr-3 text-right transition-all duration-200" x-cloak
                    :class="{ 'hidden': !$store.appConfig.isAppSidebarOpen }">
                    <h3 class="text-sm font-medium text-white">د.
                        {{ auth()->user()->first_name . ' ' . auth()->user()->last_name }}</h3>
                    <p class="text-xs text-purple-300">
                        {{ App\Enums\User\UserRoleEnum::from(auth()->user()->role)->label() }}</p>
                </div>
                <i class="fa-solid fa-chevron-down mr-auto text-purple-400 transition-transform duration-200" x-cloak
                    :class="{ 'rotate-180': userMenuOpen, 'hidden': !$store.appConfig.isAppSidebarOpen }"></i>
            </button>

            <!-- User Menu Dropdown -->
            <div x-show="userMenuOpen" x-collapse :class="{ 'hidden': !$store.appConfig.isAppSidebarOpen }" x-cloak
                class="mb-2  rounded-lg bg-c-gray-900/90 overflow-auto">
                <a href="#"
                    class="flex items-center px-4 py-2 text-sm  hover:bg-purple-500/10 hover:text-white transition-colors duration-200">
                    <i class="fa-solid fa-user-cog fa-lg"></i>
                    <span class="mr-3">الملف الشخصي</span>
                </a>
                <a href="#"
                    class="flex items-center justify-between px-4 py-2 text-sm  hover:bg-purple-500/10 hover:text-white transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fa-solid fa-envelope fa-lg "></i>
                        <span class="mr-3">الرسائل</span>
                    </div>
                    <span
                        class="flex items-center justify-center w-5 h-5 bg-purple-600 text-white text-xs rounded-full">4</span>
                </a>
                <a href="#"
                    class="flex items-center justify-between px-4 py-2 text-sm  hover:bg-purple-500/10 hover:text-white transition-colors duration-200">
                    <div class="flex items-center">
                        <i class="fa-solid fa-bell fa-lg "></i>
                        <span class="mr-3">الإشعارات</span>
                    </div>
                    <span
                        class="flex items-center justify-center w-5 h-5 bg-red-600 text-white text-xs rounded-full">2</span>
                </a>
                <form method="POST" action="{{ route('logout') }}" class="border-t border-purple-700/50">
                    @csrf
                    <button type="submit"
                        class="flex w-full items-center px-4 py-2  text-sm text-red-400 hover:bg-purple-500/10 transition-colors duration-200">
                        <i class="fa-solid fa-sign-out-alt fa-lg"></i>
                        <span class="mr-3">تسجيل الخروج</span>
                    </button>
                </form>
            </div>
        </div>
    </div>
</aside>
