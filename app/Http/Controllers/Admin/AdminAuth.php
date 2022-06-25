<?php

namespace App\Http\Controllers\Admin;

use App\Model\Admin;
use App\Http\Controllers\Controller;
use App\Http\Requests\ChangePasswordRequest;
use App\Mail\AdminResetPassword;
use Carbon\Carbon;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Mail;

// use Illuminate\Http\Request;

class AdminAuth extends Controller
{
    public function login()
    {
        return view('admin.login');
    }

    public function doLogin()
    {
        $remember_me = request('rememberme') == 1 ? true : false;
        if (admins()->attempt(['email' => request('email'), 'password' => request('password')], $remember_me)) {
            return redirect(aurl());
        } else {
            return redirect(aurl('login'))->with('error', trans('admin.incorrect_information_login'));
        }
    }

    public function logout()
    {
        admins()->logout();
        return redirect(aurl('login'));
    }

    public function forgot_password()
    {
        return view('admin.forgot_password');
    }

    public function forgot_password_post()
    {
        $admin = Admin::where('email', request('email'))->first();
        if (!empty($admin)) {
            $token = $this->createToken($admin);
            Mail::to($admin->email)->send(new AdminResetPassword(['data' => $admin, 'token' => $token]));
            session()->flash('success', trans('admin.the_link_reset_send'));
            return back();
        }
        return back();
    }

    public function createToken($admin)
    {
        $oldToken = DB::table('password_resets')->where('email', $admin->email)->first();
        if ($oldToken) {
            return $oldToken->token;
        }
        $token = app('auth.password.broker')->createToken($admin);
        $this->saveToken($admin, $token);
        return $token;
    }

    public function saveToken($admin, $token)
    {
        // Insert the data into databasepassword_resets
        $data = DB::table('password_resets')->insert([
            'email' => $admin->email,
            'token' => $token,
            'created_at' => Carbon::now()
        ]);
    }

    public function reset_password()
    {
        return view('admin.change_password');
    }

    public function change_password(ChangePasswordRequest $request, $token)
    {
        $checkToken = DB::table('password_resets')
                            ->where('token', $token)
                            ->where('created_at', '>', Carbon::now()->subHours(2))->first();

        if (!empty($checkToken)) {
            $admin = Admin::whereEmail($checkToken->email)->first();
            $admin->update(['password' => bcrypt(request('password'))]);
            // Delete The Reset Password column With His Token
            DB::table('password_resets')->where('email', request('email'))->delete();
            // Login After Change Password
            admins()->attempt(['email' => request('email'), 'password' => request('password')], true);
            return redirect(aurl());
        } else {
            session()->flash('error', 'admin.token_period_expired_time');
            return redirect(aurl('forgot/password'));
        }

    }
}
