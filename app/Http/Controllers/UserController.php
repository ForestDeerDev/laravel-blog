<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Auth;  // 引入 Auth Facade
use App\Models\User;

class UserController extends Controller
{
    // 添加文章示例方法（演示用）
    public function add(Request $request)
    {
        $title = $request->input('title');
        $content = $request->input('content');

        // 获取当前登录用户
        $user = Auth::user();

        if ($user) {
            // 假设你有 Blog 模型，可以保存文章
            // Blog::create([
            //     'title' => $title,
            //     'content' => $content,
            //     'user_id' => $user->id,
            // ]);
            return response()->json(['message' => '添加成功']);
        } else {
            return response()->json(['error' => '请先登录'], 401);
        }
    }

    // 登录逻辑
    public function login(Request $request)
{
    $request->validate([
        'account' => 'required|string',
        'password' => 'required|string',
    ]);
    $account = $request->input('account');
    $password = $request->input('password');
    $user = User::where('email', $account)->first();
    if ($user && Hash::check($password, $user->password)) {
        Auth::login($user);
        session(['userid' => $user->id, 'account' => $user->email]); // 添加 userid 和 account 到 Session
        return redirect('/index');
    } else {
        return redirect('/login')->withErrors(['msg' => '账号或密码错误']);
    }
}

    // 登出逻辑
    public function loginoff()
    {
        Auth::logout();
        return redirect('/login');
    }
}
