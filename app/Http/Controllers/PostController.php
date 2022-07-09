<?php

namespace App\Http\Controllers;

use Illuminate\Http\Request;
use App\Models\Post;
use Illuminate\Support\Str;
use App\Actions\StrRandom;
use Illuminate\Support\Facades\DB;

class PostController extends Controller
{
    public function index()
    {
        //DB::enableQueryLog();
        $posts = Post::query()
            ->onlyOpen()
            ->with('user')
            ->orderByDesc('comments_count')
            ->withCount('comments')
            ->get();

        //dd(DB::getQueryLog());

        return view('index', compact('posts'));
    }

    public function show(Post $post, StrRandom $strRandom)
    {
        if ($post->isClosed()) {
            abort(403);
        }

        $random = $strRandom->get(10);
        return view('posts.show', compact('post', 'random'));
    }
}
