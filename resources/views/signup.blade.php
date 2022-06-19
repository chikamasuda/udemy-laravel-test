@extends('layouts.index')

@section('content')

<h1>ユーザー登録</h1>

<form action="" method="post">
  @csrf

  @include('inc.error')
  名前：
  <input type="text" name="name" value="{{ old('name') }}">
  <br><br>
  メルアド：
  <input type="text" name="email" value="{{ old('email') }}">
  <br><br>
  パスワード：
  <input type="password" name="password">
  <br><br>
  <input type="submit" value="送信する">
</form>

@endsection