<!DOCTYPE html>
<html lang="en">
<head>
    <meta charset="UTF-8">
    <title>个人博客</title>
    <link rel="stylesheet" href="{{ URL::asset('css/blog.css') }}">
</head>
<body>
    <h1>个人博客</h1>
    <form class="log" action="{{ route('login.post') }}" method="post">
    @csrf
    <input type="text" name="account" placeholder="输入账号">
    <input type="password" name="password" placeholder="输入密码">

    @if ($errors->any())
        <div style="color:red; text-align:center;">
            {{ $errors->first() }}
        </div>
    @endif

    <input type="submit" value="登录">
</form>

</body>
</html>