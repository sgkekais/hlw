<!-- TODO: blocks view <footer class="footer bg-faded">
    <div class="container">
        <div class="row justify-content-end no-gutters">
            <span class="text-muted">&copy; {{ date('Y') }} - Zeitzone: {{ config('app.timezone') }}, Autor: Kevin Kaiser</span>
        </div>
    </div>
</footer>-->

<!-- Scripts -->
<script src="{{ asset('js/app.js') }}"></script>
<!-- daterangepicker -->
@if( Route::is('seasons.create') || Route::is('seasons.edit') || Route::is('seasons.matchweeks.create') || Route::is('seasons.matchweeks.edit') )
    <script type="text/javascript">
        $(function() {
            var beginDate = $("input[name=begin]").val();
            if ( !beginDate ) {
                beginDate = new Date().getDate();
            }

            var endDate   = $("input[name=end]").val();
            if ( !endDate ) {
                endDate = new Date().getDate();
            }

            $('input[id="singledatepickerfrom"]').daterangepicker({
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
            $('input[id="singledatepickerto"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: endDate,
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
@endif
@if ( Route::is('matchweeks.fixtures.create') || Route::is('matchweeks.fixtures.edit') )
    <script type="text/javascript">
        $(function() {
            var beginDate = $("input[name=datetime]").val();
            if ( !beginDate ) {
                beginDate = new Date();
            }

            $('input[id="singledatetimepicker"]').daterangepicker({
                singleDatePicker: true,
                showDropdowns: true,
                startDate: beginDate,
                timePicker: true,
                timePicker24Hour: true,
                timePickerSeconds: true,
                locale: {
                    "format": "YYYY-MM-DD HH:mm:ss",
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
@endif
</body>
</html>