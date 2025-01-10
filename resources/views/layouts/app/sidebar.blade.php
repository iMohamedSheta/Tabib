<!-- Desktop sidebar -->
<aside
    class="z-20 hidden h-[100vh] overflow-y-auto opacity-90  bg-purple-800  dark:bg-c-gray-800 shadow-lg dark:shadow-lg md:block flex-shrink-0
 scrollbar-thin scrollbar-track-purple-800 scrollbar-thumb-purple-500 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800 transition-all  duration-500"
    style="z-index: 0" :class="{ 'w-64': !isAppSidebarClosed, 'w-24': isAppSidebarClosed }">
    <div class="pb-4 text-gray-500 dark:text-gray-400">
        <div class="text-center bg-c-gray-800   pb-2 pt-4 rounded transition-all duration-500"
            x-show="!isAppSidebarClosed">
            <a class="text-2xl font-extrabold text-purple-200 dark:text-purple-200 " href="#">
                {{-- طبيب<span class=" text-purple-300 dark:text-purple-600 ">.كلاود</span> --}}
                {{-- Tabib<span class="text-orange-600">Hub</span> --}}
                <img src="{{ asset('images/clinics/icon.png') }}" alt="Logo"
                    class="w-[50px] border-2 bg-c-gray-700 border-gray-400 mx-auto pointer-events-none select-none rounded-full">
                <span class="block mt-1">
                    ميدكيلنكس
                </span>
                {{-- <span
                    class=" text-xl block text-purple-300 dark:text-purple-200 dark:[text-shadow:_0_1px_0_rgb(255_255_255_/_40%)] ">MedClinux</span> --}}
            </a>
        </div>
        <div class="text-center bg-c-gray-800 dark:bg-purple-800  pb-2 pt-4 rounded transition-all duration-500"
            x-show="isAppSidebarClosed" x-cloak>
            <a class="text-2xl font-extrabold text-purple-200 dark:text-purple-200 " href="#">
                {{-- طبيب<span class=" text-purple-300 dark:text-purple-600 ">.كلاود</span> --}}
                {{-- Tabib<span class="text-orange-600">Hub</span> --}}
                <img src="{{ asset('images/clinics/icon.png') }}" alt="Logo"
                    class="w-[50px] border-2 bg-c-gray-700 border-gray-400 mx-auto pointer-events-none select-none rounded-full">
            </a>
        </div>
        <ul class="mt-1 text-xs">
            <x-theme.sidebar-link href="{{ route('app.admin.dashboard') }}" activeRoute="app.admin.dashboard">
                <x-slot:icon>
                    <i class="fa-solid fa-archway fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">الرئيسية</span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-wallet fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4 ">
                    محفظة النظام
                </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                <x-slot:icon>
                    <i class="fa-solid fa-house-chimney-medical fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">العيادات</span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.service.index') }}"
                activeRoute="app.admin.clinic.service.index">
                <x-slot:icon>
                    <i class="fa-solid fa-kit-medical fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    الخدمات الطبية
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.doctor.index') }}" activeRoute="app.admin.doctor.index">
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
            <x-theme.sidebar-link href="{{ route('app.admin.calendar.index') }}" activeRoute="app.admin.calendar.index">
                <x-slot:icon>
                    <i class="fa-solid fa-calendar fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    المواعيد والحجوزات
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.queue.index') }}" activeRoute="app.admin.queue.index">
                <x-slot:icon>
                    <i class="fa-solid fa-microphone-lines fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    طوابير الكشوفات - Queue
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-receipt fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    الفواتير والمدفوعات
                </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-newspaper fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    السجلات الطبية EMR
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-chart-line fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    الإحصائيات والتقارير
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-print fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    قسم الوثائق والنماذج
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-cubes fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    المخزون وإدارة الأدوية
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    المتجر
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    الادوية الطبية
                    {{-- الادوية النشطة ومشاركة في حالة وجود بدائل ارخص للدواء تقديم معلومات عن الوصفات أو الأدوية المتدرجة، --}}
                </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                <x-slot:icon>
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                </x-slot:icon>
                <span class="mr-4">
                    التأمين الطبي
                </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
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
            </x-theme.sidebar-link>



            <x-theme.sidebar-dropdown-link title="الاعدادات" activeRoutes="app.admin.dashboard, app.admin.clinic.index">
                <x-slot:icon>
                    <i class="fa-solid fa-cogs fa-xl px-1"></i>
                </x-slot:icon>
                <x-theme.sidebar-link href="{{ route('app.admin.dashboard') }}" activeRoute="app.admin.dashboard">
                    <x-slot:icon>
                        <i class="fa-solid fa-archway fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">الرئيسية</span>
                </x-theme.sidebar-link>

                <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}">
                    <x-slot:icon>
                        <i class="fa-solid fa-house-chimney-medical fa-xl px-1"></i>
                    </x-slot:icon>
                    <span class="mr-4">العيادات</span>
                </x-theme.sidebar-link>
            </x-theme.sidebar-dropdown-link>

        </ul>
        <div class="px-6 my-6">
            <button
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                <span :class="{ 'hidden': isAppSidebarClosed }">
                    انشاء عيادة
                </span>
                <i class="fa-solid fa-plus"></i>
            </button>
        </div>
    </div>
</aside>
