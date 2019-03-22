<?php

namespace App\Http\Controllers\Backend;

use Illuminate\Http\Request;
use App\Http\Controllers\Controller;
use Illuminate\Support\Facades\DB;

class LoginController extends Controller
{
    // 登录
    public function login(Request $request)
    {
        // 如果已经登录，跳转到首页
        if ($request->session()->has('userinfo')) {
            return redirect('welcome');
        }

        if ($request->isMethod('get')) {
            // 显示表单
            return view('backend.login.login');
        } else {
            // 登录验证
            $validatedData = $request->validate([
                'username' => 'required',
                'password' => 'required',
            ]);
            $post = $request->only(['username', 'password']);
            $password = DB::table('user')->where('username', $post['username'])->value('password');
            if ($password == md5($post['password'])) {
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

    // 欢迎界面
    public function welcome()
    {
        return view('backend.login.welcome');
    }
}
