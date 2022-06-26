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
        $this->get('mypage/posts')->assertRedirect($loginUrl);
        $this->post('mypage/posts/create')->assertRedirect($loginUrl);
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

    /** @test */
    function マイページ、ブログの新規登録画面を開ける()
    {
        $this->login();
        $this->get('mypage/posts/create')
            ->assertOk();
    }

    /** @test */
    function マイページ、ブログを新規登録できる、公開の場合()
    {
        $this->withoutExceptionHandling();
        [$taro, $me, $jiro] = User::factory(3)->create();
        $this->login($me);

        $validData = [
            'title' => '私のブログタイトル',
            'body' => '私のブログ本文',
            'status' => '1',
        ];

        $response = $this->post('mypage/posts/create', $validData);
        $post = Post::first();
        $response->assertRedirect('mypage/posts/edit/' . $post->id);
        $this->assertDatabaseHas('posts', array_merge($validData, ['user_id' => $me->id]));
    }

    /** @test  */
    function マイページ、ブログを新規登録できる、非公開の場合()
    {
    }
    /** @test  */
    function マイページ、ブログの登録時の入力チェック()
    {
    }
}
