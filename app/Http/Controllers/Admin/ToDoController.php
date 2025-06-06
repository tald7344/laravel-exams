<?php

namespace App\Http\Controllers\Admin;

use App\Http\Controllers\Controller;
use App\Model\ToDo;
use Carbon\Carbon;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Validator;

class ToDoController extends Controller
{
    public function index(Request $request)
    {
        $data = ToDo::orderBy('deadline', 'asc')->offset(0)->limit(5)->get()->map(function ($item, $key) {
            return [
                'id' => $item->getAttribute('id'),
                'content_ar' => $item->getAttribute('content_ar'),
                'content_en' => $item->getAttribute('content_en'),
                'description_ar' => $item->getAttribute('description_ar'),
                'description_en' => $item->getAttribute('description_en'),
                'isDone' => $item->getAttribute('isDone'),
                'deadline' => Carbon::parse($item->getAttribute('deadline'))->diffForHumans()
            ];
        });
        if ($data->isEmpty()) {
            return response()->json(['error' => true, 'data' => trans('admin.todo-list-empty-msg')]);
        }
        return response()->json(['error' => false, 'data' => $data]);
    }

    public function show(Request $request) {
        if ($request->ajax()) {
            $item = ToDo::find($request->id);
            if (!is_null($item)) {
                $htmlResult = '<div class="p-3">
                           <h5>' . $item->{'content_' . lang()} . '</h5>
                           <span class="text-info text-sm"><i class="far fa-calendar-alt"></i> ' . Carbon::parse($item->deadline)->diffForHumans() . '</span>
                           <p class="mt-3">' . $item->{'description_'.lang()} . '</p>
                       </div>';
                return response()->json(['error' => false, 'result' => $htmlResult]);
            }
            return response()->json(['error' => true, 'result' => 'Invalid Item Id, Please Try Again']);
        }
        return 'Server Error, Method Not Allowed';
    }

    public function addOrEditItem(Request $request)
    {
        if ($request->ajax()) {
            $validator = Validator::make($request->all(), [
                'content_ar' => 'required|max:100',
                'content_en' => 'required|max:100',
                'isDone' => 'sometimes|nullable|in:0,1',
            ]);
            if ($validator->fails()) {
                $errors = $validator->errors();
                $errorMsg = '';
                if (!empty($errors)) {
                    foreach ($errors->all() as $message) {
                        $errorMsg .= '<p class="mb-0">' . $message . '</p>';
                    }
                }
                return response()->json(['error' => true, 'result' => $errorMsg]);
            }
            if ($request->getMethod() == 'POST') {
                $todo = ToDo::create($request->all());
            }
            if ($request->getMethod() == 'PATCH') {
                $todo = ToDo::find($request->id);
                $data = $request->all();
                $todo = $todo->update($data);
            }
            if (!is_null($todo)) {
                if ($request->getMethod() == 'POST') {
                    return response()->json(['error' => false, 'result' => trans('admin.create_success'), 'data' => $todo]);
                }
                if ($request->getMethod() == 'PATCH') {
                    return response()->json(['error' => false, 'result' => trans('admin.update_success'), 'data' => $todo]);
                }
            }
            return response()->json(['error' => true, 'result' => trans('admin.server-error')]);
        }
        return 'Server Error, Method Not Allowed';
    }

    public function paginateList(Request $request)
    {
        if ($request->ajax()) {
//        dd($request->all());
            $data = ToDo::orderBy('deadline', 'asc')->offset($request->offset)->limit($request->limit)->get()->map(function ($item, $key) {
                return [
                    'id' => $item->getAttribute('id'),
                    'content_ar' => $item->getAttribute('content_ar'),
                    'content_en' => $item->getAttribute('content_en'),
                    'description_ar' => $item->getAttribute('description_ar'),
                    'description_en' => $item->getAttribute('description_en'),
                    'isDone' => $item->getAttribute('isDone'),
                    'deadline' => Carbon::parse($item->getAttribute('deadline'))->diffForHumans()
                ];
            });
//      dd($request->all(), $data);
            $isLast = $data->isEmpty() ? true : false;
            $page = $request->type == 'next' ? ((int) $request->page + 1) : ($request->page == 1 ? $request->page : (int) $request->page - 1);
            $offset = $request->type == 'next' ? (int) $request->offset + $request->limit : ($request->offset != 0 ? (int)$request->offset : 0);
            return response()->json(['data' => $data, 'offset' => $offset, 'page' => $page, 'isLast' => $isLast]);
        }
        return 'Server Error, Method Not Allowed';
    }

    public function renderItemDetails(Request $request)
    {
        if ($request->ajax()) {
            $item = ToDo::find($request->id);
            if (!is_null($item)) {
                $htmlResult = '<form id="edit_todo_item_form" method="POST">'.
                    '<input type="hidden" name="_token" value="' . csrf_token() . '">'.
                    '<input type="hidden" name="_method" value="PUT">'.
                    '<input type="hidden" name="id" value="' . $item->id . '">'.
                    '<input type="hidden" name="isDone" value="0">'.
                    '<div class="form-group">'.
                    '<label for="content_ar">' . trans('admin.todo_content_ar') . '</label>'.
                    '<input type="text" name="content_ar" class="form-control" value="'.$item->content_ar.'">'.
                    '</div>'.
                    '<div class="form-group">'.
                    '<label for="content_en">' . trans('admin.todo_content_en') . '</label>'.
                    '<input type="text" name="content_en" class="form-control" value="'.$item->content_en.'">'.
                    '</div>'.
                    '<div class="form-group">'.
                    '<label for="description_ar">' . trans('admin.todo_description_ar') . '</label>'.
                    '<textarea name="description_ar" class="form-control">' . $item->description_ar. '</textarea>'.
                    '</div>'.
                    '<div class="form-group">'.
                    '<label for="description_en">' . trans('admin.todo_description_en') . '</label>'.
                    '<textarea name="description_en" class="form-control">'. $item->description_en.'</textarea>'.
                    '</div>'.
                    '<div class="form-group">'.
                    '<label for="deadline">' . trans('admin.deadline') . '</label>'.
                    '<input type="date" name="deadline" class="form-control" value="' . Carbon::parse($item->deadline)->format('Y-m-d'). '">'.
                    '</div>'.
                    '<div class="form-group">'.
                    '<div class="alert alert-danger text-center todo-error-messages d-none"></div>'.
                    '</div>'.
                    '</form>';
                return response()->json(['error' => false, 'result' => $htmlResult]);
            }
            return response()->json(['error' => true, 'result' => 'Invalid Item Id, Please Try Again']);
        }
        return 'Server Error, Method Not Allowed';
    }

    public function checkToDoItem(Request $request)
    {
        if ($request->ajax()) {
            $todo = ToDo::find($request->id);
            if (!is_null($todo)) {
                $isDone = $todo->isDone == 0 ? 1 : 0;
                $todo->update(['isDone' => $isDone]);
                $message = $todo->isDone == 1 ? trans('admin.checked') : trans('admin.unchecked');
                return response()->json(['error' => false, 'result' => $todo->isDone, 'message' => $message]);
            }
            return response()->json(['error' => true, 'result' => trans('admin.server-error')]);
        }
        return 'Server Error, Method Not Allowed';
    }

    public function deleteToDoItem(Request $request)
    {
        if ($request->ajax()) {
            $todo = ToDo::find($request->id);
            if (!is_null($todo)) {
                $todo->delete();
                return response()->json(['error' => false, 'result' => '', 'message' => trans('admin.delete_success')]);
            }
            return response()->json(['error' => true, 'result' => trans('admin.server-error')]);
        }
        return 'Server Error, Method Not Allowed';
    }

}
