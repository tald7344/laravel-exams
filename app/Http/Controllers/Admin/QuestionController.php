<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\ExamDatatable;
use App\Http\Controllers\Controller;
use App\Http\Requests\ExamRequest;
use App\Http\Requests\QuestionRequest;
use App\Model\Exam;
use App\Model\Question;
use Illuminate\Http\Request;

class QuestionController extends Controller
{
    public function index()
    {
        return back();
    }
    /**
     * Show the form for creating a new resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function create()
    {
        return view('admin.questions.create', ['title' => trans('admin.new_exam')]);
    }

    /**
     * Store a newly created resource in storage.
     *
     * @param  \Illuminate\Http\Request $request
     * @return \Illuminate\Http\Response
     */
    public function store(QuestionRequest $request)
    {
        Question::create($request->all());
        return redirect(aurl('exam/' . $request->examId))->with('success', trans('admin.create_success'));
    }

    /**
     * Show the form for editing the specified resource.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function edit(Question $question)
    {
        return view('admin.questions.edit', ['title' => trans('admin.edit_question_page'), 'question' => $question]);
    }

    /**
     * Update the specified resource in storage.
     *
     * @param  \Illuminate\Http\Request  $request
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function update(QuestionRequest $request, Question $question)
    {
        $question->update($request->all());
        return redirect(aurl('exam/' . $request->examId))->with('success', trans('admin.update_success'));
    }

    /**
     * Remove the specified resource from storage.
     *
     * @param  int  $id
     * @return \Illuminate\Http\Response
     */
    public function destroy(Question $question)
    {
        $question->delete();
        return back()->with('success', trans('admin.delete_success'));
    }

}
