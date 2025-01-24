@php
    use Carbon\Carbon;
    use App\Models\Event;
    use App\Formatters\DateFormatter;
    use App\Enums\Helpers\HelperEnum;
@endphp

<p class="px-4 pb-6">
    الحجوزات هي مكان يمكن فيه رؤية جميع المواعيد التي تم حجزها للمريض، سواء كانت مواعيد سابقة أو
    مستقبلية، مع تفاصيل مثل تاريخ ووقت الحجز، اسم الطبيب، والعيادة.
</p>

{{-- <ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical hover">
    @foreach ($this->events as $event)
        @php
            $eventIsPast = Carbon::parse($event->start_at)->isPast();
        @endphp
        <li>
            <div class="timeline-middle">
                @if ($eventIsPast)
                    <span class="text-green-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @else
                    <span class="text-gray-500">
                        <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor" class="h-5 w-5">
                            <path fill-rule="evenodd"
                                d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                clip-rule="evenodd" />
                        </svg>
                    </span>
                @endif
            </div>
            <div
                class="{{ $loop->index % 2 === 0 ? 'timeline-start hover:-rotate-1' : 'timeline-end hover:rotate-1' }}  mb-10 md:text-end bg-c-gray-700 w-full p-8 shadow-xl group transform transition-transform duration-300  hover:shadow-2xl">
                <time class="font-mono italic {{ $eventIsPast ? 'text-red-400' : 'text-green-400' }}">
                    {{ Carbon::parse($event->start_at)->translatedFormat('jS F, Y') }}
                </time>
                <div class="pr-4 bg-c-gray-800 p-4 mt-2 rounded-lg text-center flex justify-between">
                    <!-- Time Range -->
                    <div class="uppercase tracking-wide text-sm  flex items-center justify-center pt-4 ">
                        <span class="py-2 px-4 bg-c-gray-700 rounded-full">
                            {{ DateFormatter::eventTimeRange($event->start_at, $event->end_at) }}
                        </span>
                        <p class="px-2 {{ $eventIsPast ? 'text-red-400' : 'text-green-400' }}">
                            ({{ Carbon::parse($event->start_at)->diffForHumans() }})
                        </p>
                    </div>
                    <div class="px-4">
                        <p class="text-4xl font-bold text-white">
                            {{ Carbon::parse($event->start_at)->translatedFormat('jS') }}
                        </p>
                        <p class="text-sm text-white">
                            {{ Carbon::parse($event->start_at)->translatedFormat('F، Y') }}
                        </p>
                    </div>

                </div>
                <!-- Date -->
                <!-- Event Title -->
                <div class="text-lg  my-4 text-center bg-c-gray-800 font-bold text-gray-200 p-4">
                    [
                    {{ $event->clinicService->name ?? HelperEnum::NOT_AVAILABLE->label() }}
                    ]
                </div>
                <div class="text-lg  my-4 text-center bg-c-gray-800 font-bold text-gray-200 p-4">
                    المريض/
                    {{ $event->patient->user->fullname ?? HelperEnum::NOT_AVAILABLE->label() }}
                </div>
                <div class="flex justify-between mt-6">
                    <!-- Doctor's Name -->
                    <div class="text-gray-300 text-sm  text-center">
                        دكتور/
                        {{ $event->decoded_data->doctor_name ?? HelperEnum::NOT_AVAILABLE->label() }}
                        <p class="text-gray-400 text-xs pt-2 ">
                            {{ $event->doctor->specialization ?? HelperEnum::NOT_AVAILABLE->label() }}
                        </p>
                        <p class="text-gray-400 text-xs pt-2">
                            {{ $event->doctor->user->phone ?? HelperEnum::NOT_AVAILABLE->label() }}
                        </p>
                    </div>
                </div>
            </div>
            <hr />
        </li>
    @endforeach
</ul> --}}



<div class="w-full mx-auto">

    <!-- Vertical Timeline -->
    <div class="my-6">
        @foreach ($this->events as $event)
            @php
                $eventIsPast = Carbon::parse($event->start_at)->isPast();
            @endphp

            <!-- Timeline Item -->
            <div class="relative pr-8 sm:pr-32 py-6 group">
                <!-- Indicator and Date -->
                <div
                    class="flex flex-col sm:flex-row items-end mb-1 group-last:before:hidden before:absolute before:right-2 sm:before:right-0 before:h-full before:px-px 
                    before:bg-gray-600 sm:before:mr-[6.5rem] before:self-start before:-translate-x-1/2 before:translate-y-3 
                    ">

                    <time
                        class="sm:absolute
                    right-0 top-[-0.5rem] translate-y-0.5 inline-flex items-center justify-center text-xs font-semibold uppercase w-20
                    h-6 mb-3 sm:mb-0 {{ $eventIsPast ? 'text-emerald-50 bg-emerald-600' : 'text-gray-300 bg-gray-600' }}
                    rounded-full">
                        {{ Carbon::parse($event->start_at)->translatedFormat('jS F, Y') }}
                    </time>
                    <div
                        class="text-xl font-bold absolute top-50 right-0 md:right-[6rem] z-10 bg-c-gray-800 py-2 rounded-full ">
                        {{-- [{{ $event->clinicService->name ?? HelperEnum::NOT_AVAILABLE->label() }}] --}}
                        @if ($eventIsPast)
                            <span class="text-green-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-5 w-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @else
                            <span class="text-gray-500">
                                <svg xmlns="http://www.w3.org/2000/svg" viewBox="0 0 20 20" fill="currentColor"
                                    class="h-5 w-5">
                                    <path fill-rule="evenodd"
                                        d="M10 18a8 8 0 100-16 8 8 0 000 16zm3.857-9.809a.75.75 0 00-1.214-.882l-3.483 4.79-1.88-1.88a.75.75 0 10-1.06 1.061l2.5 2.5a.75.75 0 001.137-.089l4-5.5z"
                                        clip-rule="evenodd" />
                                </svg>
                            </span>
                        @endif
                    </div>
                </div>

                <!-- Event Content -->
                <div class="bg-purple-500/60 rounded-lg">
                    <div
                        class="bg-c-gray-700 w-full  p-8 shadow-xl group transform transition-transform duration-300 hover:shadow-2xl rounded-lg hover:-translate-x-1 hover:-translate-y-1 ">
                        <time
                            class="font-mono italic rounded-full {{ $eventIsPast ? 'text-emerald-500' : 'text-gray-300 ' }}">
                            {{ Carbon::parse($event->start_at)->translatedFormat('jS F, Y') }}
                        </time>
                        <div class="pr-4 bg-c-gray-800 p-4 mt-2 rounded-lg text-center flex justify-between">
                            <!-- Time Range -->
                            <div class="uppercase tracking-wide text-sm flex items-center justify-center pt-4">
                                <span class="py-2 px-4 bg-c-gray-700 rounded-full">
                                    {{ DateFormatter::eventTimeRange($event->start_at, $event->end_at) }}
                                </span>
                                <p
                                    class="py-2 px-4 mx-2 text-xs rounded-full {{ $eventIsPast ? 'text-emerald-50 bg-emerald-600' : 'text-gray-300 bg-gray-600' }}">
                                    ({{ Carbon::parse($event->start_at)->diffForHumans() }})
                                </p>
                            </div>
                            <div class="px-4">
                                <p class="text-4xl font-bold text-white">
                                    {{ Carbon::parse($event->start_at)->translatedFormat('jS') }}
                                </p>
                                <p class="text-sm text-white">
                                    {{ Carbon::parse($event->start_at)->translatedFormat('F، Y') }}
                                </p>
                            </div>
                        </div>
                        <!-- Event Title -->
                        <div class="text-lg my-4 text-center bg-c-gray-800 font-bold text-gray-200 p-4">
                            [{{ $event->clinicService->name ?? HelperEnum::NOT_AVAILABLE->label() }}]
                        </div>
                        <div class="text-lg my-4 text-center bg-c-gray-800 font-bold text-gray-200 p-4">
                            المريض/
                            {{ $event->patient->user->fullname ?? HelperEnum::NOT_AVAILABLE->label() }}
                        </div>
                        <!-- Doctor Details -->
                        <div class="flex justify-between mt-6">
                            <div class="text-gray-300 text-sm text-center">
                                دكتور/
                                {{ $event->decoded_data->doctor_name ?? HelperEnum::NOT_AVAILABLE->label() }}
                                <p class="text-gray-400 text-xs pt-2">
                                    {{ $event->doctor->specialization ?? HelperEnum::NOT_AVAILABLE->label() }}
                                </p>
                                <p class="text-gray-400 text-xs pt-2">
                                    {{ $event->doctor->user->phone ?? HelperEnum::NOT_AVAILABLE->label() }}
                                </p>
                            </div>
                        </div>
                    </div>
                </div>
            </div>
        @endforeach
    </div>

</div>
