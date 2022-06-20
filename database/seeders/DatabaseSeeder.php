<?php

namespace Database\Seeders;

use Illuminate\Database\Console\Seeds\WithoutModelEvents;
use Illuminate\Database\Seeder;
use App\Models\Post;
use App\Models\User;
use App\Models\Comment;
use Illuminate\Support\Facades\Hash;

class DatabaseSeeder extends Seeder
{
    /**
     * Seed the application's database.
     *
     * @return void
     */
    public function run()
    {
        // \App\Models\User::factory(10)->create();

        //Post::factory(30)->create();
        //各ユーザーに対して、ポストを2~5件作成する場合。
        [$first] = User::factory(15)->create()->each(function ($user) {
            Post::factory(random_int(2, 5))->random()->create(['user_id' => $user])->each(function ($post) {
                Comment::factory(random_int(1, 5))->create(['post_id' => $post]);
            });
        });

        $first->update([
            'name' => 'シロ',
            'email' => 'aaa@bbb.net',
            'password' => Hash::make('hogehoge'),
        ]);
    }
}
