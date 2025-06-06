<?php

namespace App\DataTables;

use App\Model\Admin;
use App\Model\Exam;
use Illuminate\Support\Facades\URL;
use Yajra\DataTables\Html\Button;
use Yajra\DataTables\Html\Column;
use Yajra\DataTables\Html\Editor\Editor;
use Yajra\DataTables\Html\Editor\Fields;
use Yajra\DataTables\Services\DataTable;

class ExamDatatable extends DataTable
{
    /**
     * Build DataTable class.
     *
     * @param mixed $query Results from query() method.
     * @return \Yajra\DataTables\DataTableAbstract
     */
    public function dataTable($query)
    {
        return datatables()
            ->eloquent($query)
            ->addColumn('checkbox', 'admin.exams.actions.checkbox')
            ->addColumn('edit', 'admin.exams.actions.edit')
            ->addColumn('delete', 'admin.exams.actions.delete')
            ->addColumn('view', 'admin.exams.actions.view')
            ->editColumn('created_at', function ($admin) {
                return \Carbon\Carbon::parse($admin->created_at)->format('d M Y, h:i A'); // Format the date as needed
            })
            ->editColumn('updated_at', function ($admin) {
                return \Carbon\Carbon::parse($admin->updated_at)->format('d M Y, h:i A'); // Format the date as needed
            })
            ->rawColumns([
                'checkbox', 'edit', 'delete', 'view'
            ]);
    }

    /**
     * Get query source of dataTable.
     *
     * @param \App\Model\Exam $model
     * @return \Illuminate\Database\Eloquent\Builder
     */
    public function query(Exam $model)
    {
        return $model->newQuery();
    }

    public static function lang()
    {
        $langJson = [
            'sProcessing'           => trans('admin.processing'),
            'sLengthMenu'           => trans('admin.lengthMenu'),
            'sZeroRecords'          => trans('admin.zeroRecords'),
            'sEmptyTable'           => trans('admin.emptyTable'),
            'sInfo'                 => trans('admin.info'),
            'sInfoEmpty'            => trans('admin.infoEmpty'),
            'sInfoFiltered'         => trans('admin.infoFiltered'),
            'sInfoPostFix'          => trans('admin.infoPostFix'),
            'sSearch'               => trans('admin.search'),
            'sUrl'                  => trans('admin.url'),
            'sInfoThousands'        => trans('admin.iInfoThousands'),
            'sLoadingRecords'       => trans('admin.loadingRecords'),
            'oPaginate' => [
                'sFirst'            => trans('admin.first'),
                'sLast'             => trans('admin.last'),
                'sNext'             => trans('admin.next'),
                'sPrevious'         => trans('admin.previous'),
            ],
            'oAria' => [
                'sSortAscending'    => trans('admin.sortAscending'),
                'sSortDescending'   => trans('admin.sortDescending')
            ]
        ] ;
        return $langJson;
    }

    /**
     * Optional method if you want to use html builder.
     *
     * @return \Yajra\DataTables\Html\Builder
     */
    public function html()
    {
        return $this->builder()
        ->setTableId('examdatatable-table')
        ->columns($this->getColumns())
        ->minifiedAjax()
        ->parameters([
            'dom' =>'Blfrtip', // this will make space under the lengthMenu
            'lengthMenu' => [[10, 25, 50, 100, -1], [10, 25, 50, 'All Record']],
            'buttons' => [
                [
                    'text' => '<i class="fa fa-plus mr-1"></i> ' . trans('admin.new_exam'),
                    'className' => 'btn btn-info text-white btn-sm',
                    'action' => 'function () {
                        window.location.href = "' . URL::current() . '/create";
                    }'
                ],
                ['extend' => 'print', 'className' => 'btn btn-primary text-white btn-sm mx-1', 'text' => '<i class="fa fa-print"></i>'],
                ['extend' => 'csv', 'className' => 'btn btn-info text-white btn-sm', 'text' => '<i class="fa fa-file mr-2"></i> ' . trans('admin.export_csv')],
                ['extend' => 'excel', 'className' => 'btn btn-success text-white btn-sm mx-1', 'text' => '<i class="fa fa-file mr-2"></i> ' . trans('admin.export_excel')],
                ['extend' => 'reload', 'className' => 'btn btn-outline-secondary btn-sm', 'text' => '<i class="fa fa-sync"></i>'],
                [
                    'text' => '<i class="fa fa-trash mr-1"></i> ' . trans('admin.delete_all'),
                    'className' => 'btn btn-danger text-white btn-sm delete_all mx-1',
                ],
            ],
            'initComplete' => "function () {
                this.api().columns([2, 3]).every(function () {
                    var column = this;
                    var input = document.createElement(\"input\");
                    input.style.width = '100%';
                    $(input).appendTo($(column.footer()).empty())
                    .on('keyup', function () {
                        column.search($(this).val(), false, false, true).draw();
                    });
                });
            }",
            'language' => self::lang()

        ]);
    }

    /**
     * Get columns.
     *
     * @return array
     */
    protected function getColumns()
    {
        return [
            Column::computed('checkbox')
                ->title('<input type="checkbox" class="check_all" onclick="check_all();" />')
                ->exportable(false)
                ->orderable(false)
                ->searchable(false)
                ->printable(false),
            Column::make('id'),
            Column::make('title')->title(trans('admin.column_name')),
            Column::make('totalDegree')->title(trans('admin.column_total_degree'))->className('text-center'),
            Column::make('isActive')->title(trans('admin.column_is_active'))
                ->render('function() {
                    if (this.isActive) {
                        return \'<i class="fa fa-check-circle text-success"></i>\';
                    } else {
                        return \'<i class="fa fa-times-circle text-danger"></i>\';
                    }
                }')
                ->className('text-center'),
            Column::make('created_at')->title(trans('admin.column_created_at')),
            Column::make('updated_at')->title(trans('admin.column_updated_at')),
            Column::computed('edit')
                ->title(trans('admin.edit'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(50)
                ->addClass('text-center'),
            Column::computed('view')
                ->title(trans('admin.view'))
                ->exportable(false)
                ->printable(false)
                ->orderable(false)
                ->searchable(false)
                ->width(50)
                ->addClass('text-center'),
            Column::computed('delete')
                ->title(trans('admin.delete'))
                ->exportable(false)
                ->orderable(false)
                ->searchable(false)
                ->printable(false)
                ->width(50)
                ->addClass('text-center')
        ];
    }

    /**
     * Get filename for export.
     *
     * @return string
     */
    protected function filename()
    {
        return 'Exam_' . date('YmdHis');
    }
}
