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

<ul class="timeline timeline-snap-icon max-md:timeline-compact timeline-vertical hover">
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
                class="{{ $loop->index % 2 === 0 ? 'timeline-start hover:-rotate-2' : 'timeline-end hover:rotate-2' }}  mb-10 md:text-end bg-c-gray-700 w-full p-8 shadow-xl group transform transition-transform duration-300  hover:shadow-2xl">
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
</ul>
