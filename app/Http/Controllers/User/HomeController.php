<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Model\Answer;
use App\Model\Exam;
use App\Model\Question;
use App\Model\Result;
use App\Model\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Symfony\Component\HttpFoundation\Response;

class HomeController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $exam = Exam::all()->where('isActive', True)->first();
        return view('style.home', compact('exam'));
    }

    public function quizResult(Request $request) {
        if ($request->ajax()) {

            $collect = [];
            $dataIn = $request->all();
            $exam = Exam::find($request->examId);
            unset($dataIn['_token']);
            unset($dataIn['examId']);
            foreach($dataIn as $item) {
                // Check answers
                $answer = Answer::find($item);
                $questionDegree = $answer->question->degree;
                $answerDegree = $answer->status == true ? $questionDegree : 0 ;
                $collect[] = $answerDegree;
                // Save Results
                $result = new Result();
                $result->studentId = Auth::id();
                $result->examId = $exam->id;
                $result->questionId = $answer->question->id;
                $result->answerId = $answer->id;
                $result->degree = $answerDegree;
                $result->save();
            }
            // Save Student Degree
            $this->saveStudentDegree($collect, $exam);
            // Generate Html
            $result = $this->generateResultSnippet($exam, $dataIn, $collect);
            return response()->json(['result' => json_encode($result, JSON_INVALID_UTF8_IGNORE)], Response::HTTP_OK);
        }
    }

    private function saveStudentDegree($collect, $exam)
    {
        $student = Student::find(Auth::id());
        $student->isExamined = true;
        $student->examDegree = array_sum($collect);
        $student->status = array_sum($collect) > ($exam->totalDegree / 2) ? 1 : 0;
        $student->save();
    }

    private function generateResultSnippet($exam, $dataIn, $collect)
    {
        $result = '<h2 class="fs-title">' . $exam->title . ' ' . trans('admin.result') . '</h2>';
        foreach($exam->questions as $question):
            $result .= '<div class="result-questions"><h4>' . $question->title . '</h4><ul class="list-unstyled" style="padding-' . (lang() == 'en' ? 'left' : 'right') . ': 20px">';
            foreach($question->answers as $answer):
                if ($dataIn['questionId-' . $question->id] != $answer->id):
                    $result .= '<li class="' . ($answer->status ? 'text-success' : '') . '">' . $answer->title;
                    if ($answer->status):
                        $result .= ' <i class="fa fa-check-circle text-success"></i>';
                    endif;
                    $result .= '</li>';
                else:
                    $result .= '<li class="' . ($answer->status ? 'text-success' : 'text-danger') . '">' . $answer->title;
                    if ($answer->status):
                        $result .= ' <i class="fa fa-check-circle text-success"></i>';
                    else:
                        $result .= ' <i class="fa fa-times-circle text-danger"></i>';
                    endif;
                    $result .= '</li>';
                endif;
            endforeach;
            $result .= '</ul></div><hr>';
        endforeach;
        if (Auth::user()->status) {
            $result .= '<h3>' . trans('admin.result-is') .' : ' . array_sum($collect) . ' ' . trans('admin.out-of') . ' ' . $exam->totalDegree . ' ( ' . trans('admin.success') . ' )</h3>';
        } else {
            $result .= '<h3>' . trans('admin.result-is') .' : ' . array_sum($collect) . ' ' . trans('admin.out-of') . ' ' . $exam->totalDegree . ' ( ' . trans('admin.fail') . ' ) </h3>';
        }
        $result .= '<span data-href="' . url('result-csv') . '" id="export" class="btn btn-success btn-sm" onclick="exportTasks(event.target);">' . trans('admin.export-csv') .'</span>';
        return $result;
    }

    public function exportCsv(Request $request)
    {
        $fileName = 'results.csv';
        $results = Auth::user()->result;
        $headers = array(
            "Content-type" => "text/csv",
            "Content-Disposition" => "attachment; filename=$fileName",
            "Pragma" => "no-cache",
            "Cache-Control" => "must-revalidate, post-check=0, pre-check=0",
            "Expires" => "0"
        );

        $columns = array('Exam Title', 'Question Title', 'Answers', 'Your Answer', 'Total Degree', 'Your Degree', 'Status');

        $callback = function () use ($results, $columns) {
            $file = fopen('php://output', 'w');
            fputcsv($file, $columns);

            foreach ($results as $result) {
                $exam = Exam::find($result->examId);
                $row['Exam Title'] = $exam->title;
                $row['Question Title'] = Question::find($result->questionId)->title;
                $row['Answers'] = Answer::where('examId', $result->examId)->where('questionId', $result->questionId)->pluck('title');
                $row['Your Answer'] = Answer::find($result->answerId)->title;
                $row['Total Degree'] = $exam->totalDegree;
                $row['Your Degree'] = Auth::user()->examDegree;
                $row['Status'] = Auth::user()->status ? 'Success' : 'Fail';

                fputcsv($file, array($row['Exam Title'], $row['Question Title'], $row['Answers'], $row['Your Answer'], $row['Total Degree'], $row['Your Degree'], $row['Status']));
            }

            fclose($file);
        };

        return response()->stream($callback, 200, $headers);
    }
}
