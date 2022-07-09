<?php

namespace App\Http\Controllers\Mypage;

use App\Http\Controllers\Controller;
use Illuminate\Http\Request;
use App\Models\Post;
use App\Models\Comment;

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
        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = $request->boolean('status');

        $post = auth()->user()->posts()->create($data);

        return redirect('mypage/posts/edit/' . $post->id)
            ->with('status', 'ブログを登録しました。');
    }

    public function edit(Post $post)
    {
        if (auth()->user()->isNot($post->user)) {
            abort(403);
        }
        $data = old() ?: $post;
        return view('mypage.posts.edit', compact('post', 'data'));
    }

    public function update(Request $request, Post $post)
    {
        //所有チェック
        if (auth()->user()->isNot($post->user)) {
            abort(403);
        }

        $data = $request->validate([
            'title' => ['required', 'max:255'],
            'body' => ['required'],
            'status' => ['nullable', 'boolean'],
        ]);

        $data['status'] = $request->boolean('status');

        $post->update($data);

        return redirect(route('mypage.posts.edit', $post))
            ->with('status', 'ブログを更新しました');
    }

    public function destroy(Post $post)
    {
        //所有チェック
        if (auth()->user()->isNot($post->user)) {
            abort(403);
        }
        //付随するコメントはDBの制約を使って削除する
        $post->delete();

        return redirect('mypage/posts');
    }
}
