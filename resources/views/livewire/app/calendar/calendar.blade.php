<div class="py-6 md:mx-4 grid  text-gray-700 dark:text-gray-200">
    <x-main.head :icon="asset('images/clinics/icon.png')">
        <x-slot name="title">
            المواعيد والحجوزات
        </x-slot>
        <x-slot name="body">
            صفحة المواعيد والحجوزات توفر لك إدارة شاملة للمواعيد الخاصة بالمرضى في العيادات المختلفة، بما في ذلك العيادة
            الرئيسية والفروع الأخرى. من خلال هذه الصفحة، يمكنك تحديد مواعيد جديدة للمرضى، تعديل المواعيد الحالية، أو
            إلغاء الحجوزات حسب الحاجة. كما يمكنك تتبع تاريخ المواعيد لكل مريض، مما يسهل على الأطباء متابعة الحالات بشكل
            دقيق، ويوفر تجربة تنظيمية أفضل للمرضى. تتيح لك الصفحة أيضًا استعراض الأوقات المتاحة لكل طبيب، لضمان تنظيم
            وقت العيادة وإدارة جدول العمل بكفاءة عالية.
        </x-slot>
    </x-main.head>
    <div x-data="calendarComponent()" id="calendarComponent"
        class="w-full bg-purple-200  text-gray-700 dark:bg-c-gray-800 dark:text-white font-bold p-6 rounded-lg shadow-2xl scroll-apply overflow-y-hidden overflow-x-auto">

        <livewire:app.calendar.includes.add-event-modal
            :clinics="$clinics"></livewire:app.calendar.includes.add-event-modal>

        <livewire:app.calendar.includes.update-event-modal></livewire:app.calendar.includes.update-event-modal>

        <div wire:ignore>
            <div class="max-h-[97vh] "id="calendar"></div>
        </div>
    </div>
</div>

@push('styles')
    <link data-navigate-once href="{{ css('fullcalendar/fullcalendar') }}" rel="stylesheet" />
    <link data-navigate-once href="{{ css('fullcalendar/fullcalendar_custom') }}" rel="stylesheet" />
    <script data-navigate-once src="{{ js('fullcalendar') }}"></script>
@endpush

@push('scripts')
    <script>
        function calendarComponent() {
            return {
                show: false,
                showUpdate: false,
                // showPopover: false,
                step: 1,
                start: '',
                end: '',
                allDay: false,
                update_start: '',
                update_end: '',
                update_allDay: false,
                update_event_id: null,
                flatpickrInstance: null,
                flatpickerupdateStartInstance: null,
                flatpickerupdateEndInstance: null,
                now: 0,
                slotDurationInMinutes: String({{ $config->slot_duration }}).padStart(2, '0'),
                initialView: "{{ $config->initial_view }}",
                eventsData: @json($events),
                calendar: null,
                isUpdateLoading: false,
                isBackgroundColorsOpen: false,
                backgroundColors: ['#2196F3', '#009688', '#9C27B0', '#FFEB3B', '#afbbc9', '#4CAF50', '#2d3748', '#f56565',
                    '#ed64a6'
                ],
                backgroundColorSelected: '#2196F3',
                init() {
                    const calendarEl = document.getElementById('calendar');
                    this.calendar = new FullCalendar.Calendar(calendarEl, {
                        initialView: this.initialView,
                        themeSystem: 'standard',
                        editable: true,
                        selectable: true,
                        eventDisplay: 'block',
                        eventResizableFromStart: true,
                        eventStartEditable: true,
                        eventDurationEditable: true,
                        displayEventTime: false,
                        locale: 'ar',
                        direction: 'rtl',
                        allDaySlot: true,
                        allDayText: 'طوال اليوم',
                        slotDuration: '00:' + this.slotDurationInMinutes + ':00',
                        slotLabelInterval: '00:' + this.slotDurationInMinutes + ':00',
                        defaultTimedEventDuration: '00:' + this.slotDurationInMinutes + ':00',
                        nowIndicator: true,
                        now: new Date(),
                        scrollTime: this.getScrollTime(),
                        slotLabelFormat: {
                            hour: '2-digit',
                            minute: '2-digit',
                            hour12: true,
                            hourCycle: 'h12',
                            weekday: 'short'
                        },
                        headerToolbar: {
                            right: 'fullscreen addevent prev,next today',
                            center: 'title',
                            left: 'timeGridDay,timeGridWeek,dayGridMonth dayGridWeek'
                        },
                        customButtons: {
                            fullscreen: {
                                text: '',
                                click: this.toggleFullscreen,
                                className: 'fullscreen-btn'
                            },
                            addevent: {
                                text: 'اضافة حدث',
                                click: () => {
                                    this.openAddEventModal();
                                },
                                className: 'add-event-btn'
                            }
                        },
                        buttonText: {
                            today: 'اليوم',
                            month: 'شهري',
                            week: 'اسبوعي',
                            day: 'يومي',
                            dayGridWeek: 'مهام الاسبوع'
                        },
                        dateClick: (info) => {
                            this.openAddEventModal(info);
                        },
                        eventResize: (info) => {
                            this.updateEventDate(info);
                        },
                        eventDrop: (info) => {
                            this.updateEventDate(info);
                        },
                        eventClick: (info) => {
                            this.openEditEventModal(info.event);
                        },
                        events: this.eventsData,
                    });

                    this.calendar.render();

                    Livewire.on('added', (event) => {
                        console.log('Event added:', event);
                        this.calendar.addEvent(event[0]);
                        this.calendar.refetchEvents();
                        this.calendar.render();
                        this.show = false;
                    });

                    this.flatpickrInstance = this.createFlatpickr('#datepicker');
                    this.flatpickerupdateStartInstance = this.createFlatpickr('#update-evert-start-datepicker');
                    this.flatpickerupdateEndInstance = this.createFlatpickr('#update-evert-end-datepicker');
                },
                openAddEventModal(info = null) {
                    if (!info) {
                        info = {
                            dateStr: new Date().toISOString(),
                            allDay: false,
                        };
                    }

                    if (info.allDay == true) {
                        this.calendar.changeView('timeGridDay', info.dateStr);

                        let today = new Date().toDateString();
                        let infoDate = new Date(info.date).toDateString();

                        if (infoDate != today) {
                            this.calendar.scrollToTime('00:00:00')
                        }

                        return;
                    }

                    window.dispatchEvent(new CustomEvent('update-all-day', {
                        detail: info.allDay
                    }));
                    this.start = info.dateStr;
                    this.allDay = info.allDay;
                    this.show = true;
                    this.flatpickrInstance.setDate(this.start, true);
                    console.log(info);
                },
                openEditEventModal(event) {
                    this.update_event_id = event.id;
                    this.update_title = event.title;
                    this.update_start = event.startStr;
                    this.update_end = event.endStr;
                    this.update_allDay = event.allDay;
                    this.backgroundColorSelected = event.backgroundColor;
                    this.flatpickerupdateStartInstance.setDate(this.update_start, true);
                    this.flatpickerupdateEndInstance.setDate(this.update_end, true);
                    this.showUpdate = true;

                    log('Event clicked:', event);
                },
                updateEventDate(info) {
                    @this.dispatch('updateEventDateAction', [info.event.id, info.event.startStr, info.event.endStr, info
                        .event.allDay
                    ]);
                },
                updateEventAction() {
                    const formattedStartDate = this.parseDates(this.update_start);
                    const formattedEndDate = this.parseDates(this.update_end);

                    const calendarEvent = this.calendar.getEventById(this.update_event_id);

                    if (calendarEvent) {
                        calendarEvent.setProp('title', this.update_title);
                        calendarEvent.setStart(formattedStartDate);
                        calendarEvent.setEnd(formattedEndDate);
                        calendarEvent.setProp('backgroundColor', this.backgroundColorSelected);
                    }

                    var event = {
                        id: this.update_event_id,
                        title: this.update_title,
                        start: formattedStartDate,
                        end: formattedEndDate,
                        backgroundColor: this.backgroundColorSelected
                    };

                    @this.dispatch('updateEventAction', [event]);

                    this.calendar.refetchEvents();
                    this.calendar.render();
                    // this.showUpdate = false;
                },
                deleteEventAction() {
                    let title = "هل أنت متأكد من حذف الميعاد " + this.update_title + " ؟";
                    let text = "سوف يتم حذف هذه الميعاد نهائياً!";
                    confirmDelete(title, text).then((result) => {
                        if (result.isConfirmed) {
                            @this.call('deleteEventAction', this.update_event_id)
                            const calendarEvent = this.calendar.getEventById(this.update_event_id);
                            calendarEvent.remove();
                        }
                    });
                },
                toggleFullscreen() {
                    const calendarContainer = document.getElementById('calendarComponent');
                    const isAppFullscreen = JSON.parse(sessionStorage.getItem('isAppFullscreen'));
                    sessionStorage.setItem('isAppFullscreen', JSON.stringify(!isAppFullscreen));

                    if (document.fullscreenElement) {
                        document.exitFullscreen();
                    } else {
                        if (calendarContainer.requestFullscreen) {
                            calendarContainer.requestFullscreen();
                        } else if (calendarContainer.webkitRequestFullscreen) {
                            calendarContainer.webkitRequestFullscreen();
                        } else if (calendarContainer.msRequestFullscreen) {
                            calendarContainer.msRequestFullscreen();
                        }
                    }

                    this.calendar.updateSize('auto');
                },
                getScrollTime() {
                    const now = new Date();
                    const totalMinutes = now.getHours() * 60 + now.getMinutes() - this.slotDurationInMinutes * 2;

                    let adjustedHours = Math.floor(totalMinutes / 60);
                    let adjustedMinutes = totalMinutes % 60;

                    if (adjustedMinutes < 0) {
                        adjustedMinutes += 60;
                        adjustedHours -= 1;
                    }

                    const hours = String(adjustedHours).padStart(2, '0');
                    const minutes = String(adjustedMinutes).padStart(2, '0');

                    return `${hours}:${minutes}:00`;
                },
                parseDates(dateString) { // Maybe it's too much but it works
                    if (!dateString) {
                        return null;
                    }
                    const parsedDateFromStringToDate = this.flatpickrInstance.parseDate(dateString, "Y/m/d h:iK (D)");
                    const parsedDateToStringWithAnotherFormat = this.flatpickrInstance.formatDate(
                        parsedDateFromStringToDate, "Y-m-d H:i:s");
                    const parsedDateWithDesiredFormat = this.flatpickrInstance.parseDate(
                        parsedDateToStringWithAnotherFormat);
                    return parsedDateWithDesiredFormat;
                },
                createFlatpickr(key) {
                    return flatpickr(key, {
                        locale: 'ar',
                        dateFormat: 'Y/m/d h:iK (D)',
                        time_24hr: false,
                        enableTime: true,
                        onOpen: () => {
                            let flatpickrCalendars = document.querySelectorAll('.flatpickr-calendar');
                            let calendarComponent = document.getElementById('calendarComponent');
                            if (flatpickrCalendars && calendarComponent) {
                                flatpickrCalendars.forEach(flatpickrCalendar => {
                                    calendarComponent.appendChild(flatpickrCalendar);
                                });
                            }
                        }
                    });
                }

            };
        }
    </script>
@endpush
