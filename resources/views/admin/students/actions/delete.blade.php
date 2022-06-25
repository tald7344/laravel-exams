{!! Form::open(['route' => ['student.destroy', $id], 'method' => 'POST']) !!}
    {{ Form::hidden('_method', 'DELETE') }}
    {{ Form::button(
        '<i class="fa fa-trash"></i>', [
            'type' => 'submit',
            'class' => 'btn btn-danger btn-sm',
            'onclick' => "if(!confirm('". trans('admin.alert_delete_msg') . "')) return false;"
        ])
    }}
{!! Form::close() !!}
