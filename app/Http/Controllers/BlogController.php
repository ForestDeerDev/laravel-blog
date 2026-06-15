<?php

namespace App\Http\Controllers;

use App\Models\Blog;
use Illuminate\Http\Request;
use Illuminate\Support\Facades\Auth;
use Illuminate\Support\Facades\DB;

class BlogController extends Controller
{
    // 搜索博客
    public function search(Request $request)
    {
        $keyword = $request->input('keyword');
        
        if (!session()->has('userid')) {
            return redirect('/login')->with('message', '请先登录');
        }
        
        $userid = session()->get('userid');
        
        if ($keyword) {
            $blogs = DB::table('blogs')
                      ->where('user_id', $userid)
                      ->where(function ($query) use ($keyword) {
                          $query->where('title', 'like', "%{$keyword}%")
                                ->orWhere('content', 'like', "%{$keyword}%");
                      })
                      ->orderBy('create_time', 'desc')
                      ->get();
        } else {
            $blogs = DB::table('blogs')
                      ->where('user_id', $userid)
                      ->orderBy('create_time', 'desc')
                      ->get();
        }
        
        return view('index', [
            'blogs' => $blogs,
            'keyword' => $keyword
        ]);
    }

    // 添加博客
    public function add(Request $request)
{
    $user = Auth::user();
    if (!$user) {
        \Log::warning('Add blog failed: User not authenticated');
        return redirect('/login')->with('message', '请先登录');
    }

    $data = $request->only(['title', 'content']);
    $data['user_id'] = $user->id;
    $data['create_time'] = now();

    try {
        $blog = Blog::create($data);
        if (!$blog) {
            \Log::error('Failed to create blog', ['data' => $data]);
            return redirect('/index')->withErrors('博客发布失败');
        }
        \Log::info('Blog created successfully', ['id' => $blog->id, 'data' => $data]);
        return redirect('/index')->with('message', '博客发布成功');
    } catch (\Exception $e) {
        \Log::error('Blog creation error: ' . $e->getMessage(), ['data' => $data]);
        return redirect('/index')->withErrors('博客发布失败: ' . $e->getMessage());
    }
}


    // 删除博客
public function del($bid)
{
    $blog = Blog::find($bid);
    if (!$blog) {
        return redirect('/blog')->withErrors('博客不存在');
    }
    $blog->delete();
    return redirect('/blog/search')->with('message', '删除成功');
}


// 获取单篇博客（用于编辑或展示）
public function get($id)
{
    $blog = Blog::where('id', $id)->first();
    return view('index', [
        'blog' => $blog,
        // 你还可以传其他数据
    ]);
}

    // 修改博客
    public function mod(Request $request)
{
    $bid = $request->input('bid');  // 获取博客ID
    $title = $request->input('title');
    $content = $request->input('content');

    $blog = Blog::where('id', $bid)->first();
    if (!$blog) {
        return redirect('/blog/search')->with('message', '博客不存在');
    }

    $blog->title = $title;
    $blog->content = $content;
    $blog->save();

    return redirect('/blog/search')->with('message', '博客修改成功');
}
}
