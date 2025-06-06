<?php

namespace App\Http\Controllers\Admin;

use App\DataTables\DashboardDatatable;
use App\Model\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\AdminRequest;
use App\Model\Exam;
use App\Model\Student;
use Illuminate\Http\Request;

class DashboardController extends Controller
{
    /**
     * Display a listing of the resource.
     *
     * @return \Illuminate\Http\Response
     */
    public function index()
    {
        $isActiveExamsCount = Exam::where('isActive', 1)->count();
        $totalStudents = Student::count();
        $totalPassedStudents = Student::where('isExamined', 1)->where('status', 1)->count();
        $totalPassedPercent = (int) (($totalPassedStudents / $totalStudents) * 100);
        $notExaminedStudents = Student::where('isExamined', 0)->count();
        return view('admin.home', compact('isActiveExamsCount', 'totalPassedPercent', 'totalStudents', 'notExaminedStudents'));
    }

}
