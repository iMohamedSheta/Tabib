<div x-show="step == 1" x-transition:enter>
    <h3 class="pb-3">
        يمكنك اضافة مريض جديد او اختيار مريض مسجل لحجز موعد جديد
    </h3>
    <div class="flex flex-wrap">
        <div class="w-full md:max-w-[95%]  space-y-4 mx-auto">
            <div x-on:click="step = 3"
                class="bg-purple-600 hover:bg-purple-700 text-white rounded-lg shadow-2xl overflow-hidden cursor-pointer transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105">
                <div class="p-4 flex items-center space-x-4">
                    <!-- Icon placeholder -->
                    <div class=" w-12 text-green-500"></div>
                    <i class="fas fa-user-circle text-4xl text-purple-100"></i>
                    <div>
                        <h2 class="text-xl font-semibold "> اختيار مريض مسجل</h2>
                        <p class="text-purple-100 p-2">اختر المريض من قائمة المرضى</p>
                    </div>
                </div>
                <div
                    class="bg-gradient-to-r from-transparent via-green-200 to-transparent h-1 w-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-in-out">
                </div>
            </div>

            <!-- New Patient Card -->
            <div x-on:click="step = 2"
                class="bg-c-gray-600 hover:bg-c-gray-800 text-white rounded-lg shadow-2xl  overflow-hidden cursor-pointer transition-all duration-300 ease-in-out hover:shadow-lg hover:scale-105">
                <div class="p-4 flex items-center space-x-4">
                    <!-- Icon placeholder -->
                    <div class="w-12 text-green-500"></div>
                    <i class="fas fa-user-plus text-3xl text-green-500"></i>
                    <div>
                        <h2 class="text-xl font-semibold ">اضافة مريض جديد</h2>
                        <p class="text-purple-100 p-2">اضافة مريض جديد للنظام</p>
                    </div>
                </div>
                <div
                    class="bg-gradient-to-r from-transparent via-green-200 to-transparent h-1 w-full transform scale-x-0 group-hover:scale-x-100 transition-transform duration-300 ease-in-out">
                </div>
            </div>
        </div>
    </div>
</div>
