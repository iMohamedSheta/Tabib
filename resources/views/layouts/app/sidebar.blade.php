<!-- Desktop sidebar -->
<aside class="z-20 hidden m-4 rounded-xl w-64 h-[97vh] overflow-y-auto opacity-90  bg-purple-700  dark:bg-c-gray-800 shadow-lg dark:shadow-lg md:block flex-shrink-0
 scrollbar-thin scrollbar-thumb-gray-400 dark:scrollbar-thumb-gray-600 dark:scrollbar-track-gray-800" style="z-index: 0">
    <div class="py-4 text-gray-500 dark:text-gray-400">
        <a class="mr-6 text-2xl font-extrabold text-white dark:text-gray-200 " href="#">
            طبيب<span class=" text-purple-300 dark:text-purple-600 ">.كلاود</span>
            {{-- Tabib<span class="text-orange-600">Hub</span> --}}
        </a>
        <ul class="mt-6 text-xs">
            <x-theme.sidebar-link href="{{ route('app.admin.dashboard') }}" activeRoute="app.admin.dashboard">
                <i class="fa-solid fa-archway fa-xl px-1"></i>
                <span class="mr-4">الرئيسية</span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-wallet fa-xl px-1"></i>
                    <span class="mr-4 ">
                        محفظة النظام
                    </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                <i class="fa-solid fa-house-chimney-medical fa-xl px-1"></i>
                <span class="mr-4">العيادات</span>
            </x-theme.sidebar-link>

                <x-theme.sidebar-link href="{{ route('app.admin.doctor.index') }}" activeRoute="app.admin.doctor.index">
                    <i class="fa-solid fa-user-md fa-xl px-1"></i>
                    <span class="mr-4">
                        الاطباء
                    </span>
                </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.patient.index') }}" activeRoute="app.admin.patient.index">
                    <i class="fa-solid fa-bed-pulse fa-xl px-1"></i>
                    <span class="mr-4">
                        المرضي
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.calendar.index') }}" activeRoute="app.admin.calendar.index">
                <i class="fa-solid fa-calendar fa-xl px-1"></i>
                <span class="mr-4">
                    المواعيد والحجوزات
                </span>
        </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.queue.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-microphone-lines fa-xl px-1"></i>
                    <span class="mr-4">
                        طوابير الكشوفات - Queue
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-receipt fa-xl px-1"></i>
                    <span class="mr-4">
                        الفواتير والمدفوعات
                    </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-newspaper fa-xl px-1"></i>
                    <span class="mr-4">
                        السجلات الطبية EMR
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                <i class="fa-solid fa-chart-line fa-xl px-1"></i>
                <span class="mr-4">
                    الإحصائيات والتقارير
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                <i class="fa-solid fa-print fa-xl px-1"></i>
                <span class="mr-4">
                    قسم الوثائق والنماذج
                </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-cubes fa-xl px-1"></i>
                    <span class="mr-4">
                        المخزون وإدارة الأدوية
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                    <span class="mr-4">
                        المتجر
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                    <span class="mr-4">
                        الادوية الطبية
                        {{-- الادوية النشطة ومشاركة في حالة وجود بدائل ارخص للدواء تقديم معلومات عن الوصفات أو الأدوية المتدرجة، --}}
                    </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                    <span class="mr-4">
                        التأمين الطبي
                    </span>
            </x-theme.sidebar-link>

            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                    <span class="mr-4">
                        نظام دعم القرار
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-store fa-xl px-1"></i>
                    <span class="mr-4">
                        الصيدلية
                    </span>
            </x-theme.sidebar-link>
            <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                    <i class="fa-solid fa-bell fa-xl px-1"></i>
                    <span class="mr-4">
                        الرسائل والإشعارات
                    </span>
            </x-theme.sidebar-link>



            <x-theme.sidebar-dropdown-link title="الاعدادات" activeRoutes="app.admin.dashboard, app.admin.clinic.index">
                <x-slot:icon>
                    <i class="fa-solid fa-cogs fa-xl px-1"></i>
                </x-slot:icon>
                <x-theme.sidebar-link href="{{ route('app.admin.dashboard') }}" activeRoute="app.admin.dashboard">
                    <i class="fa-solid fa-archway fa-xl px-1"></i>
                    <span class="mr-4">الرئيسية</span>
                </x-theme.sidebar-link>

                <x-theme.sidebar-link href="{{ route('app.admin.clinic.index') }}" activeRoute="app.admin.clinic.index">
                        <i class="fa-solid fa-house-chimney-medical fa-xl px-1"></i>
                        <span class="mr-4">العيادات</span>
                </x-theme.sidebar-link>
            </x-theme.sidebar-dropdown-link>

        </ul>
        <div class="px-6 my-6">
            <button
                class="flex items-center justify-between w-full px-4 py-2 text-sm font-medium leading-5 text-white transition-colors duration-150 bg-purple-600 border border-transparent rounded-lg active:bg-purple-600 hover:bg-purple-700 focus:outline-none focus:shadow-outline-purple">
                انشاء عيادة
                <span class="mr-2" aria-hidden="true">+</span>
            </button>
        </div>
    </div>
</aside>
