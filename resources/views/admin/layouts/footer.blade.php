
  <footer class="main-footer">
    <p class="mb-0">© {{ date('Y') }} {{ trans('admin.' . config('app.name')) }}. {{ trans('admin.all-rights-reserved') }}</p>
  </footer>

  <!-- Control Sidebar -->
  <aside class="control-sidebar control-sidebar-dark">
    <!-- Control sidebar content goes here -->
  </aside>
  <!-- /.control-sidebar -->
</div>
<!-- ./wrapper -->

<!-- jQuery -->
<script src="{{asset('/design/adminLte/plugins/jquery/jquery.min.js')}}"></script>
<!-- jQuery UI 1.11.4 -->
<script src="{{asset('/design/adminLte/plugins/jquery-ui/jquery-ui.min.js')}}"></script>
<!-- Resolve conflict in jQuery UI tooltip with Bootstrap tooltip -->
<script>
    var _todoParams = {
        token: '{{ csrf_token() }}',
        lang: '{{ lang() }}',
        paginateListToDoUrl: '{{ aurl('to-do/paginate') }}',
        listToDoUrl: '{{ aurl('to-do') }}',
        showToDoItemUrl: '{{ aurl('to-do/show') }}',
        addOrEditToDoUrl: '{{ aurl('to-do/add-edit') }}',
        renderToDoItemDetailsUrl: '{{ aurl('to-do/render-details') }}',
        checkToDoUrl: '{{ aurl('to-do/checked') }}',
        deleteToDoUrl: '{{ aurl('to-do/delete') }}',
        deleteMessageAlert: '{{ trans('admin.alert_delete_msg') }}',
    };
  $.widget.bridge('uibutton', $.ui.button)
</script>
<!--DataTable-->
<script src="{{asset('/design/adminLte/plugins/datatables/jquery.dataTables.min.js')}}"></script>
<script src="{{asset('/design/adminLte/plugins/datatables-bs4/js/dataTables.bootstrap4.min.js')}}"></script>
<script src="{{asset('/design/adminLte/plugins/datatables-responsive/js/dataTables.responsive.min.js')}}"></script>

<!-- Bootstrap 4 -->
<script src="{{asset('/design/adminLte/plugins/bootstrap/js/bootstrap.bundle.min.js')}}"></script>
<!-- ChartJS -->
<script src="{{asset('/design/adminLte/plugins/chart.js/Chart.min.js')}}"></script>
<!-- Sparkline -->
<script src="{{asset('/design/adminLte/plugins/sparklines/sparkline.js')}}"></script>
<!-- JQVMap -->
<script src="{{asset('/design/adminLte/plugins/jqvmap/jquery.vmap.min.js')}}"></script>
<script src="{{asset('/design/adminLte/plugins/jqvmap/maps/jquery.vmap.usa.js')}}"></script>
<!-- jQuery Knob Chart -->
<script src="{{asset('/design/adminLte/plugins/jquery-knob/jquery.knob.min.js')}}"></script>
<!-- daterangepicker -->
<script src="{{asset('/design/adminLte/plugins/moment/moment.min.js')}}"></script>
<script src="{{asset('/design/adminLte/plugins/daterangepicker/daterangepicker.js')}}"></script>
<!-- Tempusdominus Bootstrap 4 -->
<script src="{{asset('/design/adminLte/plugins/tempusdominus-bootstrap-4/js/tempusdominus-bootstrap-4.min.js')}}"></script>
<!-- Summernote -->
<script src="{{asset('/design/adminLte/plugins/summernote/summernote-bs4.min.js')}}"></script>
<!-- overlayScrollbars -->
<script src="{{asset('/design/adminLte/plugins/overlayScrollbars/js/jquery.overlayScrollbars.min.js')}}"></script>
<!-- AdminLTE App -->
<script src="{{asset('/design/adminLte/dist/js/adminlte.js')}}"></script>
<!-- AdminLTE dashboard demo (This is only for demo purposes) -->
<script src="{{asset('/design/adminLte/dist/js/pages/dashboard.js')}}"></script>
<!-- AdminLTE for demo purposes -->
<script src="{{asset('/design/adminLte/dist/js/demo.js')}}"></script>
<!-- Custom Js -->
<script src="{{asset('/design/adminLte/dist/js/custom.js')}}"></script>
<script src="{{asset('/design/adminLte/dist/js/todo.js')}}"></script>
<script src="{{asset('/design/adminlte/jstree/jstree.js')}}"></script>
<script src="{{asset('/design/adminlte/jstree/jstree.checkbox.js')}}"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/js/bootstrap-datepicker.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/bootstrap-datepicker/1.9.0/locales/bootstrap-datepicker.ar.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/fullcalendar/3.10.2/fullcalendar.min.js"></script>
<script src="https://cdn.jsdelivr.net/npm/select2@4.1.0-beta.1/dist/js/select2.min.js"></script>
<script src="https://cdnjs.cloudflare.com/ajax/libs/toastr.js/latest/toastr.min.js"></script>
  <script>
    $(document).ready(function () {

        var SITEURL = "{{ aurl('/') }}";
        $.ajaxSetup({
            headers: {
                'X-CSRF-TOKEN': '{{ csrf_token() }}'
            }
        });
        var calendar = $('#full_calendar_events').fullCalendar({
            editable: true,
            events: SITEURL + "/calendar-event",
            // events: event,
            displayEventTime: true,
            eventRender: function (event, element, view) {
                let elementId = 'event_details_' + event.id;
                if (event.allDay === 'true') {
                    event.allDay = true;
                } else {
                    event.allDay = false;
                }
                element[0].setAttribute('id', elementId);
                element[0].setAttribute('data-toggle', 'tooltip');
                element[0].setAttribute('data-html', 'true');
                $.ajax({
                    type: "POST",
                    url: SITEURL + '/calendar-crud-ajax',
                    data: {
                        id: event.id,
                        type: 'show'
                    },
                    success: function (response) {
                        element[0].setAttribute('title', `<div><h5>${response.title}</h5><span>start: ${response.start}</span><br><span>end: ${response.end}</span></div>`);
                        $('#' + elementId).tooltip();
                    }
                });
            },
            selectable: true,
            selectHelper: true,
            select: function (event_start, event_end, allDay) {
                var event_name = prompt('{{ trans("admin.event-name") }}:');
                if (event_name) {
                    var event_start = $.fullCalendar.formatDate(event_start, "Y-MM-DD HH:mm:ss");
                    var event_end = $.fullCalendar.formatDate(event_end, "Y-MM-DD HH:mm:ss");
                    $.ajax({
                        url: SITEURL + "/calendar-crud-ajax",
                        type: "POST",
                        data: {
                            event_name: event_name,
                            event_start: event_start,
                            event_end: event_end,
                            type: 'create'
                        },
                        success: function (data) {
                            displayMessage('{{ trans("admin.event-created") }}');
                            calendar.fullCalendar('renderEvent', {
                                id: data.id,
                                title: event_name,
                                start: event_start,
                                end: event_end,
                                allDay: allDay
                            }, true);
                            calendar.fullCalendar('unselect');
                        }
                    });
                }
            },
            eventDrop: function (event, delta) {
                console.log('event drop');
                var event_start = $.fullCalendar.formatDate(event.start, "Y-MM-DD");
                var event_end = $.fullCalendar.formatDate(event.end, "Y-MM-DD");
                $.ajax({
                    url: SITEURL + '/calendar-crud-ajax',
                    data: {
                        title: event.event_name,
                        start: event_start,
                        end: event_end,
                        id: event.id,
                        type: 'edit'
                    },
                    type: "POST",
                    success: function (response) {
                        displayMessage('{{ trans("admin.event-updated") }}');
                    }
                });
            },
            eventClick: function (event) {
                console.log('event click', event.id);
                var eventDelete = confirm('{{trans('admin.alert_delete_dep_msg')}}');
                if (eventDelete) {
                    $.ajax({
                        type: "POST",
                        url: SITEURL + '/calendar-crud-ajax',
                        data: {
                            id: event.id,
                            type: 'delete'
                        },
                        success: function (response) {
                            calendar.fullCalendar('removeEvents', event.id);
                            displayMessage('{{ trans("admin.event-removed") }}');
                        }
                    });
                }
            }
        });

        $('#delete_events').on('click', function () {
            var eventDelete = confirm('{{trans('admin.are-you-sure')}}');
            if (eventDelete) {
                $.ajax({
                    type: "POST",
                    url: '{{ aurl("calendar-crud-ajax") }}',
                    data: {
                        type: 'clear'
                    },
                    success: function (response) {
                        /*
                        *  removeEvents : Use To Removes events from the calendar :
                        *  .fullCalendar( ‘removeEvents’ [, idOrFilter ] )
                         * If idOrFilter is omitted, all events are removed.
                         * If idOrFilter is an ID, all events with the same ID will be removed.
                        * */
                        calendar.fullCalendar('removeEvents');
                        displayMessage(response.success);
                    }
                });
            }
        });
    });
    function displayMessage(message) {
        toastr.success(message, 'Event');
    }

</script>

<!--Js files that need to run first of all-->
@stack('js')

</body>
</html>
