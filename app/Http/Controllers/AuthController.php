<?php

namespace App\Http\Controllers;

use App\Models\Exam;
use App\Models\User;
use Illuminate\Support\Str;
use Illuminate\Http\Request;
use Illuminate\Support\Carbon;

use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\URL;
use App\Http\Controllers\Controller;
use App\Models\ExamAttempt;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Mail;

class AuthController extends Controller
{
    //
    public function loadRegister()
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        } elseif (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        } else {
            return view('register');
        }
    }

    public function studentRegister(Request $request)
    {
        $request->validate([
            'name' => 'string|required|min:2',
            'email' => 'string|required|email|max:100|unique:users',
            'password' => 'string|required|confirmed|min:6'
        ]);

        $user = new User;
        $user->name = $request->name;
        $user->email = $request->email;
        $user->password = Hash::make($request->password);
        $user->save();

        $notification = [
            'title' => "Congratulation!!",
            'desc' => "Your account has created successfully"
        ];
        return back()->with('success', $notification);
    }

    public function loadLogin()
    {
        if (Auth::user() && Auth::user()->is_admin == 1) {
            return redirect('/admin/dashboard');
        } elseif (Auth::user() && Auth::user()->is_admin == 0) {
            return redirect('/dashboard');
        } else {
            return view('login');
        }
    }

    public function userLogin(Request $request)
    {
        $request->validate([
            'email' => 'string|required|email',
            'password' => 'string|required'
        ]);

        $userCredential = $request->only('email', 'password');
        if (Auth::attempt($userCredential)) {
            if (Auth::user()->is_admin == 1) {
                return redirect('admin/dashboard');
            } else {
                return redirect('/dashboard');
               
            }
        } else {
            return back()->with('error', 'Username & password is incorrect');
        }
    }

    public function studentDashboard()
    {
        $exams= Auth::user()->exams->where('is_active', 1);
        $examAttempts = ExamAttempt::where('user_id', Auth::id())->where('exam_status', 'pending');

        $attemptedExams = $exams->filter(function($exam) {
            return $exam->examAttempts()->where('user_id', Auth::id())->exists();
        });
        
        //return compact('exams', 'attemptedExams');
        return view('student.dashboard', compact('exams', 'attemptedExams', 'examAttempts'));
       
        
    }
    public function adminDashboard()
    {
        $exams = Exam::with('questions')->get();
        //return $exams;
        return view('admin.exams', compact('exams'));
    }

    public function logout(Request $request)
    {
        $request->session()->flush();
        Auth::logout();
        return redirect('/');
    }

    public function loadForgotPassword()
    {
        return view('forgot-password');
    }

    public function forgotPassword(Request $request)
    {
        $request->validate([
            'email' => 'string|required|email',
        ]);
        try {
            $user = User::where('email', $request->email)->get();

            if (count($user) > 0) {
                $token = Str::random(40);
                $domain = URL::to('/');
                $url = $domain . '/reset-password?token=' . $token;
                $data['url'] = $url;
                $data['email'] = $request->email;
                $data['title'] = 'Password Reset';
                $data['body'] = 'Please click on the below link to reset password.';

                Mail::send('forgetPasswordMail', ['data' => $data], function ($message) use ($data) {
                    $message->to($data['email'])->subject($data['title']);
                });

                $dateTime = Carbon::now()->format('y-m-d H:i:s');

                DB::table('password_reset_tokens')->where('email', $request->email)->delete();
                DB::table('password_reset_tokens')->insert([
                    'email' => $request->email,
                    'token' => $token,
                    'created_at' => $dateTime
                ]);

                return back()->with('success', 'Please check your mail to reset password');
            } else {
                return back()->with('error', 'Email is not registered!');
            }
        } catch (\Exception $e) {
            return back()->with('error', $e->getMessage());
        }
    }

    public function loadResetPassword(Request $request)
    {
        $resetData = DB::table('password_reset_tokens')->where('token', $request->token)->first();

        if (isset($request->token) && $resetData !== null) {
            $user = User::where('email', $resetData->email)->first();


            return view('reset-password', compact('user'));
        } else {
            return view('404');
        }
    }

    public function resetPassword(Request $request)
    {
        $request->validate([
            'password' => 'string|required|confirmed|min:6'
        ]);

        $user = User::find($request->id);
        $user->password = Hash::make($request->password);
        $user->save();

        DB::table('password_reset_tokens')->where('email', $user->email)->delete();

        $notification = [
            'title' => "Congratulation!!",
            'desc' => "Your password updated successfully!"
        ];
        return redirect('/')->with('success', $notification);
    }
}
