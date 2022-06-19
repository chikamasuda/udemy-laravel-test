<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class UserLoginControllerTest extends TestCase
{
    use RefreshDatabase;
    /** @test */
    function ログイン画面を開ける()
    {
        $this->get('mypage/login')
            ->assertOk();
    }

    /** @test */
    function ログイン時の入力チェック()
    {
        $url = "mypage/login";

        $this->from($url)->post($url, [])
            ->assertRedirect($url);

        $this->post($url, ['email' => ''])
            ->assertInvalid(['email' => 'emailは必ず指定してください。']);

        $this->post($url, ['email' => 'aa@bb@cc'])
            ->assertInvalid(['email' => 'emailには、有効なメールアドレスを指定してください。']);

        $this->post($url, ['email' => 'aa@ああ.いい'])
            ->assertInvalid(['email' => 'emailには、有効なメールアドレスを指定してください。']);

        $this->post($url, ['password' => ''])
            ->assertInvalid(['password' => 'passwordは必ず指定してください。']);
    }

    /** @test */
    function ログインできる()
    {
        $user = User::factory()->create([
            'email' => 'aaa@bbb.net',
            'password' => Hash::make('abcd1234'),
        ]);

        $this->post('mypage/login', [
            'email' => 'aaa@bbb.net',
            'password' => 'abcd1234',
        ])->assertRedirect('mypage/posts');

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function パスワードを間違えているのでログインできず、適切なエラーメッセージが表示される()
    {
        $url = "mypage/login";
        $user = User::factory()->create([
            'email' => 'aaa@bbb.net',
            'password' => Hash::make('abcd1234'),
        ]);

        $this->from($url)->post('mypage/login', [
            'email' => 'aaa@bbb.net',
            'password' => '11112222',
        ])->assertRedirect($url);

        $this->get($url)
            ->assertOk()
            ->assertSee('メールアドレスかパスワードが間違っています。');

        $this->from($url)->followingRedirects()
            ->post($url, [
                'email' => 'aaa@bbb.net',
                'password' => '11112222',
            ])
            ->assertOk()
            ->assertSee('メールアドレスかパスワードが間違っています。')
            ->assertSee('<h1>ログイン画面</h1>', false)
            ->assertSeetext('ログイン画面');
    }
}
