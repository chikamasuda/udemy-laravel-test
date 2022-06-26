<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;

class PostManageController extends Controller
{
    public function index()
    {
        $posts = auth()->user()->posts;
        return view('mypage.posts.index', compact('posts'));
    }

    public function create()
    {
        return view('mypage.posts.create');
    }

    public function store(Request $request)
    {
        $data = $request->only('title', 'body', 'status');

        $post = auth()->user()->posts()->create($data);

        return redirect('mypage/posts/edit/' . $post->id);
    }
}
