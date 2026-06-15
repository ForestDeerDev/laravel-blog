<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人博客</title>
    <link rel="stylesheet" href="{{ URL::asset('css/blog.css') }}">
</head>
<body>
    <header>
        <nav>
            <h2>Little Blog</h2>
            <!-- 搜索表单 -->
            <form action="/blog/search" method="get" class="search-form">
                <input type="text" name="keyword" placeholder="搜索博客...">
                <input type="submit" value="搜索">
            </form>
            <!-- 登录状态显示 -->
            <p id="account">
                @if(session()->has('account'))
                    <a href="/user/loginoff">
                        {{ session()->get('account') }} (退出登录)
                    </a>
                @else
                    <a href="/login">未登录</a>
                @endif
            </p>
        </nav>
    </header>

    <main class="clearfix">
        <!-- 侧边栏 - 博客标题列表 -->
        <aside>
            @if(isset($blogs))
            <h3>博客列表</h3>
            <ul>
                @foreach($blogs as $b)
    <li><a href="#blog-{{ $b->id }}">{{ $b->title }}</a></li>
@endforeach

            </ul>
            @endif
        </aside>

        <!-- 主内容区 -->
        <div class="content-wrapper">
            <!-- 博客发布表单 -->
            @if(session()->has('userid'))
            <section class="blog-form">
                <form action="{{ isset($blog) ? '/blog/mod' : '/blog/add' }}" method="post">
    <div>
        @csrf
        <input type="hidden" name="bid" value="{{ isset($blog) ? $blog->id : 0 }}">
        
        <input type="text" name="title" placeholder="博客标题" 
               value="{{ isset($blog) ? $blog->title : '' }}" required>
               
        <textarea name="content" rows="5" placeholder="博客内容" required>
            {{ isset($blog) ? $blog->content : '' }}
        </textarea>
    </div>
    <input type="submit" value="{{ isset($blog) ? '更新' : '发布' }}">
</form>
            </section>
            @endif

            <!-- 博客详细列表 -->
            <section class="blog-list">
    @if(isset($blogs))
        @foreach($blogs as $b)
        <article id="blog-{{ $b->id }}">
            <div class="b-t">
                <h3>{{ $b->title }}</h3>
                <div class="act">
                    <!-- 删除按钮 -->
                    <form action="/blog/del/{{ $b->id }}" method="POST">
    @csrf
    @method('DELETE')
    <button type="submit">删除</button>
</form>         
                    <!-- 修改按钮 -->
                    <a href="/blog/mod/{{ $b->id }}" class="btn-mod">修改</a>
                </div>
            </div>
            <p class="b-c">{{ $b->content }}</p>
        </article>
        @endforeach
    @endif
</section>
        </div>
    </main>
</body>
</html>