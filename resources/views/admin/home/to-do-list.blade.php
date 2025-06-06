<!-- TO DO List -->
<div class="card todo">
    <div class="card-header">
        <h3 class="card-title">
            <i class="fas fa-clipboard-list mr-1"></i>
            {{ trans('admin.todo-list') }}
        </h3>

        <div class="card-tools">
            <ul class="pagination pagination-sm">
                <li class="page-item"><a href="javascript:void(0)" class="page-link" id="prev" data-offset="0">&laquo;</a></li>
                <li class="page-item"><a class="page-link" id="page_number" data-page="1">1</a></li>
                <li class="page-item"><a href="javascript:void(0)" class="page-link" id="next" data-offset="5">&raquo;</a></li>
            </ul>
        </div>
    </div>
    <!-- /.card-header -->
    <div class="card-body">
        <ul class="todo-list" id="todo_list" data-widget="todo-list"></ul>
    </div>
    <!-- /.card-body -->
    <div class="card-footer clearfix">
        <button type="button" class="btn btn-info float-right" data-toggle="modal" data-target="#newToDoListItemModal"><i class="fas fa-plus"></i>
            {{trans('admin.add-item')}}</button>
    </div>

    <!-- Start Add To Do List Item Modal -->
    <div class="modal fade" id="newToDoListItemModal" tabindex="-1" role="dialog" aria-labelledby="newToDoListItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="newToDoListItemModalLabel">{{ trans('admin.new-todo-item') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body">
                    <form id="create_todo_item_form" method="POST">
                        <input type="hidden" name="_token" value="{{ csrf_token() }}">
                        <input type="hidden" name="isDone" value="0">
                        <div class="form-group">
                            <label for="content_ar">{{ trans('admin.todo_content_ar') }}</label>
                            <input type="text" name="content_ar" id="content_ar" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="content_en">{{ trans('admin.todo_content_en') }}</label>
                            <input type="text" name="content_en" id="content_en" class="form-control">
                        </div>
                        <div class="form-group">
                            <label for="description_ar">{{ trans('admin.todo_description_ar') }}</label>
                            <textarea name="description_ar" id="description_ar" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="description_en">{{ trans('admin.todo_description_en') }}</label>
                            <textarea name="description_en" id="description_en" class="form-control"></textarea>
                        </div>
                        <div class="form-group">
                            <label for="deadline">{{ trans('admin.deadline') }}</label>
                            <input type="date" name="deadline" id="deadline" class="form-control">
                        </div>
                        <div class="form-group">
                            <div class="alert alert-danger text-center todo-error-messages d-none"></div>
                        </div>
                    </form>
                </div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_button" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    <button type="button" class="btn btn-primary" id="new_todo_item">{{ trans('admin.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Add To Do List Item Modal -->

    <!-- Start Edit To Do List Item Modal -->
    <div class="modal fade" id="editToDoListItemModal" tabindex="-1" role="dialog" aria-labelledby="editToDoListItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="editToDoListItemModalLabel">{{ trans('admin.new-todo-item') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
                <div class="modal-footer">
                    <button type="button" class="btn btn-secondary close_button" data-dismiss="modal">{{ trans('admin.close') }}</button>
                    <button type="button" class="btn btn-primary" id="edit_todo_item">{{ trans('admin.save') }}</button>
                </div>
            </div>
        </div>
    </div>
    <!-- End Edit To Do List Item Modal -->

    <!-- Start Show To Do List Item Modal -->
    <div class="modal fade" id="showToDoListItemModal" tabindex="-1" role="dialog" aria-labelledby="showToDoListItemModalLabel" aria-hidden="true">
        <div class="modal-dialog modal-lg" role="document">
            <div class="modal-content">
                <div class="modal-header">
                    <h5 class="modal-title" id="showToDoListItemModalLabel">{{ trans('admin.details') }}</h5>
                    <button type="button" class="close" data-dismiss="modal" aria-label="Close">
                        <span aria-hidden="true">&times;</span>
                    </button>
                </div>
                <div class="modal-body"></div>
            </div>
        </div>
    </div>
    <!-- End Show To Do List Item Modal -->
</div>
<!-- /.card -->
@push('js')
    <script>
        todo.getList();
        todo.getPaginate();
        todo.showDetails();
        todo.addItem();
        todo.renderItemDetail();
        todo.editItem();
        todo.checkItem();
        todo.deleteItem();
    </script>
@endpush
