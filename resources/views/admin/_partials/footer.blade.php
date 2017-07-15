<footer class="footer bg-faded">
    <div class="container">
        <div class="row justify-content-end no-gutters">
            <span class="text-muted">&copy; {{ date('Y') }} - Zeitzone: {{ config('app.timezone') }}, Autor: Kevin Kaiser</span>
        </div>
    </div>
</footer>

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- daterangepicker -->
<script type="text/javascript">
    $(function() {
        var beginDate = $("input[name=begin]").val();

        $('input[id="singledatepicker"]').daterangepicker({
            singleDatePicker: true,
            showDropdowns: true,
            startDate: beginDate,
            locale: {
                "format": "YYYY-MM-DD",
                "separator": " - ",
                "applyLabel": "Anwenden",
                "cancelLabel": "Abbrechen",
                "fromLabel": "Von",
                "toLabel": "Bis",
                "customRangeLabel": "Custom",
                "weekLabel": "W",
                "daysOfWeek": [
                    "So",
                    "Mo",
                    "Di",
                    "Mi",
                    "Do",
                    "Fr",
                    "Sa"
                ],
                "monthNames": [
                    "Januar",
                    "Februar",
                    "März",
                    "April",
                    "Mai",
                    "Juni",
                    "Juli",
                    "August",
                    "September",
                    "Oktober",
                    "November",
                    "Dezember"
                ],
                "firstDay": 1
            }
        });
    });
</script>
</body>
</html>