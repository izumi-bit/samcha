<x-filament::page>
    <div id="calendar"></div>

    @push('scripts')
        <script src="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.global.min.js"></script>
      <script>
    document.addEventListener('DOMContentLoaded', function () {
        const calendarEl = document.getElementById('calendar');
        const calendar = new FullCalendar.Calendar(calendarEl, {
            initialView: 'dayGridMonth',
            events: {!! $events !!} // This safely injects raw JSON from PHP
        });
        calendar.render();
    });
</script>
    @endpush

    @push('styles')
        <link href="https://cdn.jsdelivr.net/npm/fullcalendar@6.1.8/index.min.css" rel="stylesheet">
    @endpush
</x-filament::page>
