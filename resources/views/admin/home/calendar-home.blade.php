<div class="card bg-gradient-success">
    <div class="card-header border-0">
        <h3 class="card-title">
{{--            <i class="far fa-calendar-alt"></i>--}}
{{--            Calendar--}}
            <i class="far fa-calendar-alt"></i> {{ trans('admin.calendar') }}
        </h3>
        <div class="card-tools">
            <!-- button with a dropdown -->
            <div class="btn-group">
                <button type="button" class="btn btn-default btn-sm dropdown-toggle" data-toggle="dropdown" data-offset="-52">
                    <i class="fas fa-bars"></i>
                </button>
                <div class="dropdown-menu" role="menu">
                    <a href="javascript:void(0)" class="dropdown-item" id="delete_events">{{ trans('admin.clear-event') }}</a>
                </div>
            </div>
            <button type="button" class="btn btn-default btn-sm" data-card-widget="collapse">
                <i class="fas fa-minus"></i>
            </button>
            <button type="button" class="btn btn-default btn-sm" data-card-widget="remove">
                <i class="fas fa-times"></i>
            </button>
        </div>
    </div>
    <div class="card-body pt-0">
        <div id='full_calendar_events' class="mt-0" style="width: 100%"></div>
    </div>
</div>
