@extends('layouts.index')

@section('content')

<h1>マイブログ更新</h1>
<form action="" method="post">
    @csrf
    @include('inc.error')
    @include('inc.status')

    タイトル：
    <input type="text" name="title" style="width:400px" value="{{ data_get($data, 'title') }}"><br>
    本文：
    <textarea name="body" id="" cols="30" rows="10" style="width: 600px; height: 200px;">{{ data_get($data, 'body') }}</textarea><br>
    公開する：
    <input type="checkbox" name="status" value="1" {{ data_get($data, 'status') ? 'checked' : '' }}><br>
    <input type="submit" value="更新する">

</form>

@endsection