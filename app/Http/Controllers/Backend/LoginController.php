<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;
use Illuminate\Support\Facades\Hash;

class LoginController extends Controller
{
    // 登录
    public function login(Request $request)
    {
        if ($request->session()->has('userinfo')){
            return redirect('welcome');
        }

        if($request->isMethod('get')){
            $title = 'Laravel Study';
            return view('backend.login.login', compact('title'));
        } else {
            $validatedData = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            $post = $request->post();
            $password = DB::table('user')->where('username', $post['username'])->value('password');
            if ($password == md5($post['password'])){
                $request->session()->put('userinfo', $post['username']);
                return redirect('welcome');
            } else {
                return view('jump', error('用户名或密码错误'));
            }
        }
    }

    // 退出登录
    public function logout(Request $request)
    {
        $request->session()->remove('userinfo');
        return redirect('login');
    }

    public function welcome()
    {
        return view('backend.login.welcome');
    }
}
