@extends('layouts.index')

@section('content')

<h1>マイブログ新規登録</h1>
<form action="" method="post">
  @csrf
  @include('inc.error')

  タイトル：
  <input type="text" name="title" style="width:400px" value="{{ old('title') }}"><br>
  本文：
  <textarea name="body" id="" cols="30" rows="10" style="width: 600px; height: 200px;">{{ old('body') }}</textarea><br>
  公開する：
  <input type="checkbox" name="status" value="1" {{ (old('status') ? 'checked' : '')}}><br>
  <input type="submit" value="送信する">

</form>

@endsection