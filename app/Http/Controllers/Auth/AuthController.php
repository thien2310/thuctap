<?php

namespace App\Http\Controllers\Auth;

use App\Http\Controllers\Controller;
use App\Model\auth\User;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Session;

class AuthController extends Controller
{
    //
    protected $user;
    public function __construct(User $user)
    {
        $this->user = $user;
    }
    public function index()
    {
        if (Auth::check()) {
            return view('layouts.main');
        } else {
            return view('auth.Login');
        };
    }

    public function logout(){
        Session::flush();
        Auth::logout();
        return redirect()->route('auth.login');

    }

    public function Handlelogin(Request $request)
    {
        $credentials = $request->only('email', 'password');

        $request->validate([
            'email' => 'required|email',
            'password' => 'required',

        ], [
            'email.required' => 'Vui lòng nhập email ',
            'email.email' => 'Email không đúng định dạng',
            'password.required' => 'Vui lòng nhập đúng mật khẩu',
        ]);

        if (Auth::attempt($credentials)) {
            return redirect()->route('dash')->with('mgs', 'Đăng nhập thành công');
        } else {
            return redirect()->back()->with('mgs', 'Đăng nhập không thành công , vui lòng thử lại');
        }
    }
    public function signup()
    {
        return view('auth.Signup');
    }
    public function HandleSingup(Request $request)
    {


        $request->validate(
            [
                'name' => 'required',
                'email' => 'required|email|unique:users',
                'pass' => 'required',
                'Repass' => 'required'

            ],
            [
                'name.required' => 'Vui lòng nhập tên người dùng',
                'email.required' => 'Vui lòng nhập email ',
                'email.email' => 'Email không đúng định dạng',
                'pass.required' => 'Vui lòng nhập mật khẩu',
                'Repass.required' => 'Vui lòng nhập lại mật khẩu',
                'email.unique' => 'Đã tồn tại email trên hệ thống'
            ]
        );

        if ($request->pass == $request->Repass) {
            $dataInsert = [
                $request->name,
                $request->email,
                Hash::make($request->pass),
                $request->session()->token(),
                date('Y-m-d H:i:s')

            ];
            $this->user->addUser($dataInsert);
            return redirect()->back()->with('msg1', 'Đăng nhập thành công');
        } else {
            return redirect()->back()->with('msg', 'Mật khẩu phải trùng nhau, vui lòng nhập lại');
        }
    }
}
