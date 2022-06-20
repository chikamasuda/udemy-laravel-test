<?php

namespace Tests\Feature\Http\Controllers\Mypage;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use App\Models\post;

class PostManageControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function ゲストはブログを管理できない()
    {
        $loginUrl = 'mypage/login';
        //認証していない場合
        $this->get('mypage/posts')
            ->assertRedirect($loginUrl);
    }

    /** @test */
    function マイページ、ブログ一覧で自分のデータのみ表示される()
    {
        //認証ずみの場合
        $user = $this->login();

        $other = Post::factory()->create();
        $mypost = Post::factory()->create(['user_id' => $user->id]);

        $this->get('mypage/posts')
            ->assertOk()
            ->assertDontSee($other->title)
            ->assertSee($mypost->title);
    }
}
