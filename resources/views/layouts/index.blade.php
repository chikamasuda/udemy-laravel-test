<!DOCTYPE html>
<html lang="ja">

<head>
  <meta charset="UTF-8">
  <meta http-equiv="X-UA-Compatible" content="IE=edge">
  <meta name="viewport" content="width=device-width, initial-scale=1.0">
  <title>Laravel Test</title>
  <link rel="stylesheet" href="css/style.css">
</head>
<nav>
  <ul>
    <li><a href="/">TOP (ブログ一覧)</a></li>

  @auth
    <li><a href="{{ route('mypage.posts') }}">マイブログ一覧</a></li>
    <li>
      <form action="{{ route('logout') }}" method="post">
        @csrf
        <input type="submit" value="ログアウト">
      </form>
    </li>
  @else
    <li><a href="{{ route('login') }}">ログイン</a></li>
  @endauth
  
  </ul>
</nav>


<body>
  @yield('content')
</body>

</html>