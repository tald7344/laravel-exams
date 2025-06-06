<?php

namespace App\Http\Controllers\User;

use App\Http\Controllers\Controller;
use App\Http\Requests\StudentRequest;
use App\Http\Requests\UserRequest;
use App\Model\Student;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\URL;

class UserAuth extends Controller
{
    public function login()
    {
        return view('style.user.login');
    }

    public function doLogin()
    {
        $userValidate = $this->validate(request(), [
            'username' => 'required',
            'password' => 'required'
        ]);
        $remember_me = request('rememberme') == 1 ? true : false;
        if (users()->attempt(['username' => $userValidate['username'], 'password' => $userValidate['password']], $remember_me)) {
            return redirect(url('/'));
        } else {
            return redirect(route('user.login'))->with('error', trans('admin.incorrect_information_login'));
        }
    }

    public function signup()
    {
        return view('style.user.signup');
    }

    public function doSignup(StudentRequest $request)
    {
        $user = Student::create($request->all());
        return redirect(URL::to('/'))->with('success', 'Welcome ( ' . $request->name . ' ) Your Account Successfully Created');
    }

    public function logout()
    {
        users()->logout();
        return back();
    }
}
