@extends('layouts.index')

@section('content')

<h1>ログイン画面</h1>

<form action="" method="post">
  @csrf

  @include('inc.error')
  @include('inc.status')

  メールアドレス：
  <input type="text" name="email" value="{{ old('email') }}">
  <br><br>
  パスワード：
  <input type="password" name="password">
  <br><br>
  <input type="submit" value="送信する">
</form>

<p>
  <a href="/signup">新規ユーザー登録</a>
</p>

@endsection