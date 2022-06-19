<?php

namespace Tests\Feature\Http\Controllers;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;
use App\Models\User;
use Illuminate\Support\Facades\Hash;

class SignupControllerTest extends TestCase
{
    use RefreshDatabase;

    /** @test */
    function ユーザー登録画面が開ける()
    {
        $this->get('signup')
            ->assertOk();
    }

    /** @test **/
    function ユーザー登録できる()
    {
        //データ検証
        //DBに保存
        //ログインされてからマイページにリダイレクト

        $validData = [
            'name' => '太郎',
            'email' => 'aaa@bbb.net',
            'password' => 'hogehoge',
        ];

        //$validData = User::factory()->raw();
        $validData = User::factory()->validData();

        //dd($validData);

        $this->post('signup', $validData)
            ->assertRedirect('mypage/posts');

        //配列の要素を削除
        unset($validData['password']);

        $this->assertDatabaseHas('users', $validData);

        $user = User::firstWhere($validData);
        $this->assertTrue(Hash::check('hogehoge', $user->password));

        $this->assertAuthenticatedAs($user);
    }

    /** @test */
    function 不正なデータではユーザー登録できない()
    {
        $url = "signup";

        User::factory()->create(['email' => 'aaa@bbb.net']);

        $this->from('signup')->post($url, [])
            ->assertRedirect('signup');

        $this->post($url, ['name' => ''])
            ->assertInvalid(['name' => 'nameは必ず指定してください。']);

        $this->post($url, ['name' => str_repeat('あ', 21)])
            ->assertInvalid(['name' => 'nameは、20文字以下で指定してください。']);

        $this->post($url, ['name' => str_repeat('あ', 20)])
            ->assertvalid('name');

        $this->post($url, ['email' => ''])
            ->assertInvalid(['email' => 'emailは必ず指定してください。']);

        $this->post($url, ['email' => 'aa@ああ.net'])
            ->assertInvalid(['email' => 'emailには、有効なメールアドレスを指定してください。']);

        $this->post($url, ['email' => 'aaa@bbb.net'])
            ->assertInvalid(['email' => 'emailの値は既に存在しています。']);

        $this->post($url, ['password' => ''])
            ->assertInvalid(['password' => 'passwordは必ず指定してください。']);

        $this->post($url, ['password' => 'abcd123'])
            ->assertInvalid(['password' => 'passwordは、8文字以上で指定してください。']);

        $this->post($url, ['password' => 'abcd1234'])
            ->assertvalid('password');
    }
}
