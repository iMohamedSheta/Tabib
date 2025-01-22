@php
    use Carbon\Carbon;
    use App\Models\Event;
    use App\Enums\Calendar\CalendarTypeEnum;
    use App\Formatters\DateFormatter;
    use App\Enums\Helpers\HelperEnum;
@endphp

<p class="px-4 pb-6">
    الحجوزات هي مكان يمكن فيه رؤية جميع المواعيد التي تم حجزها للمريض، سواء كانت مواعيد سابقة أو
    مستقبلية، مع تفاصيل مثل تاريخ ووقت الحجز، اسم الطبيب، والعيادة.
</p>
<div class="flex flex-wrap">
    @foreach ($events as $event)
        <div class="bg-purple-700 w-full m-3">
            <div
                class="w-full mx-auto bg-purple-200 hover:bg-purple-300  shadow-md overflow-hidden  group transform transition-transform duration-300 hover:-translate-x-1 hover:-translate-y-1  hover:shadow-2xl">
                <div class="p-4 flex items-center">
                    <div class="pr-4 bg-c-gray-700 p-4 rounded-lg text-center">
                        <p class="text-4xl font-bold text-white">
                            {{ Carbon::parse($event->start_at)->translatedFormat('jS') }}
                        </p>
                        <p class="text-sm text-white">
                            {{ Carbon::parse($event->start_at)->translatedFormat('F، Y') }}
                        </p>
                    </div>
                    <!-- Date -->
                    <!-- Time and Details -->
                    <div class="m-4">
                        <div class="uppercase tracking-wide text-sm text-c-gray-700 flex items-center">
                            <span>
                                {{ DateFormatter::eventTimeRange($event->start_at, $event->end_at) }}
                            </span>
                            <p class="text-green-900  px-2">
                                ({{ Carbon::parse($event->start_at)->diffForHumans() }})
                            </p>
                        </div>
                        <p class=" text-c-gray-700 text-lg mt-2">
                            {{ $event->title }}
                        </p>
                        <div class="flex items-center mt-2">
                            <p class=" text-c-gray-600 text-sm">
                                دكتور/
                                {{ $event->decoded_data->doctor_name ?? HelperEnum::NOT_AVAILABLE->label() }}
                            </p>
                        </div>

                    </div>
                </div>
            </div>
        </div>
    @endforeach
</div>
