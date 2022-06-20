<?php

namespace Tests;

use app\Models\User;
use Illuminate\Foundation\Testing\TestCase as BaseTestCase;

abstract class TestCase extends BaseTestCase
{
    use CreatesApplication;

    public function login(User $user = null)
    {
        $user = $user ?? User::factory()->create();

        $this->actingAs($user);

        return $user;
    }
}
