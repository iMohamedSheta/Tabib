<div x-data="calendar()" x-init="init()" class="relative flex h-screen max-h-screen w-full flex-col gap-4 px-4 pt-4 items-center justify-center">
    <div class="relative h-full w-4/6 overflow-auto mt-20">
        <div class="no-scrollbar calendar-container max-h-full overflow-y-scroll rounded-t-2xl bg-purple-50 pb-10 text-slate-800 shadow-xl">
            <div class="sticky -top-px z-50 w-full rounded-t-2xl bg-purple-100 px-5 pt-7 sm:px-8 sm:pt-8">
                <div class="mb-4 flex w-full flex-wrap items-center justify-between gap-6">
                    <div class="flex flex-wrap gap-2 sm:gap-3">
                        <div class="relative">
                            <select x-model="month" @change="updateCalendar" class="cursor-pointer rounded-lg border border-gray-300 bg-white py-1.5 pl-2 pr-6 text-sm font-medium text-gray-900 hover:bg-gray-100 sm:rounded-xl sm:py-2.5 sm:pl-3 sm:pr-8" required="">
                                <template x-for="(m, index) in months" :key="index">
                                    <option :value="index" x-text="m"></option>
                                </template>
                            </select>
                            <span class="pointer-events-none absolute inset-y-0 right-0 ml-3 flex items-center pr-1 sm:pr-2">
                                <svg class="size-5 text-slate-600" viewBox="0 0 20 20" fill="currentColor" aria-hidden="true">
                                    <path fill-rule="evenodd" d="M10 3a.75.75 0 01.55.24l3.25 3.5a.75.75 0 11-1.1 1.02L10 4.852 7.3 7.76a.75.75 0 01-1.1-1.02l3.25-3.5A.75.75 0 0110 3zm-3.76 9.2a.75.75 0 011.06.04l2.7 2.908 2.7-2.908a.75.75 0 111.1 1.02l-3.25 3.5a.75.75 0 01-1.1 0l-3.25-3.5a.75.75 0 01.04-1.06z" clip-rule="evenodd"></path>
                                </svg>
                            </span>
                        </div>
                        <button type="button" class="rounded-lg border border-gray-300 bg-white px-3 py-1.5 text-sm font-medium text-gray-900 hover:bg-gray-100 lg:px-5 lg:py-2.5">اليوم</button>
                        <button type="button" class="whitespace-nowrap rounded-lg bg-gradient-to-r from-purple-400 to-purple-500 px-3 py-1.5 text-center text-sm font-medium text-white hover:bg-gradient-to-bl focus:outline-none focus:ring-1 focus:ring-purple-200 sm:rounded-xl lg:px-5 lg:py-2.5">+ اضافة حدث</button>
                    </div>
                    <div class="flex w-fit items-center justify-between">
                        <button class="rounded-full border border-slate-300 p-1 transition-colors hover:bg-slate-100 sm:p-2" @click="month = (month + 11) % 12; updateCalendar()">
                            <svg class="size-5 text-slate-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m15 19-7-7 7-7"></path>
                            </svg>
                        </button>
                        <h1 class="min-w-16 text-center text-lg font-semibold sm:min-w-20 sm:text-xl" x-text="year"></h1>
                        <button class="rounded-full border border-slate-300 p-1 transition-colors hover:bg-slate-100 sm:p-2" @click="month = (month + 1) % 12; updateCalendar()">
                            <svg class="size-5 text-slate-800" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="none" viewBox="0 0 24 24">
                                <path stroke="currentColor" stroke-linecap="round" stroke-linejoin="round" stroke-width="2" d="m9 5 7 7-7 7"></path>
                            </svg>
                        </button>
                    </div>
                </div>
                <div class="grid w-full grid-cols-7 justify-between text-slate-500">
                    <template x-for="day in days" :key="day">
                        <div class="w-full border-b border-slate-200 py-2 text-center font-semibold" x-text="day"></div>
                    </template>
                </div>
            </div>
            <div class="w-full px-5 pt-4 sm:px-8 sm:pt-6">
                <div class="flex w-full flex-wrap">
                    <template x-for="empty in leadingEmptyDays" :key="empty">
                        <div class="aspect-square w-full grow"></div>
                    </template>
                    <template x-for="day in daysInMonth" :key="day">
                        <div class="relative z-10 m-[-0.5px] group aspect-square w-full grow cursor-pointer rounded-xl border font-medium transition-all hover:z-20 hover:border-cyan-400 sm:-m-px sm:size-20 sm:rounded-2xl sm:border-2 lg:size-36 lg:rounded-3xl 2xl:size-40">
                            <span class="absolute left-1 top-1 flex size-5 items-center justify-center rounded-full text-xs sm:size-6 sm:text-sm lg:left-2 lg:top-2 lg:size-8 lg:text-base text-slate-800" x-text="day"></span>
                            <button type="button" class="absolute right-2 top-2 rounded-full opacity-0 transition-all focus:opacity-100 group-hover:opacity-100">
                                <svg class="size-8 scale-90 text-blue-500 transition-all hover:scale-100 group-focus:scale-100" aria-hidden="true" xmlns="http://www.w3.org/2000/svg" width="24" height="24" fill="currentColor" viewBox="0 0 24 24">
                                    <path fill-rule="evenodd" d="M2 12C2 6.477 6.477 2 12 2s10 4.477 10 10-4.477 10-10 10S2 17.523 2 12Zm11-4.243a1 1 0 1 0-2 0V11H7.757a1 1 0 1 0 0 2H11v3.243a1 1 0 1 0 2 0V13h3.243a1 1 0 1 0 0-2H13V7.757Z" clip-rule="evenodd"></path>
                                </svg>
                            </button>
                        </div>
                    </template>
                </div>
            </div>
        </div>
    </div>
</div>

@push('scripts')
<script>
    function calendar() {
        return {
            month: new Date().getMonth(),
            year: new Date().getFullYear(),
            days: ['Sun', 'Mon', 'Tue', 'Wed', 'Thu', 'Fri', 'Sat'],
            months: [
                "January", "February", "March", "April", "May", "June",
                "July", "August", "September", "October", "November", "December"
            ],
            daysInMonth: [],
            leadingEmptyDays: [],

            init() {
                this.updateCalendar();
            },

            updateCalendar() {
                const firstDayOfMonth = new Date(this.year, this.month, 1).getDay();
                const totalDaysInMonth = new Date(this.year, this.month + 1, 0).getDate();

                this.leadingEmptyDays = Array.from({ length: firstDayOfMonth });
                this.daysInMonth = Array.from({ length: totalDaysInMonth }, (_, i) => i + 1);
            }
        };
    }
</script>
@endpush
