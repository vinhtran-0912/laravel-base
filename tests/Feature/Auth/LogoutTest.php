<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LogoutTest extends TestCase
{
    use DatabaseTransactions;

    public function testLogoutSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'tran.ngoc.vinh@sun-asterisk.com',
            'name' => 'vim',
            'password' => bcrypt('123123'),
        ]);
        $token = $user->createToken('Personal Access Token')->accessToken;
        $headers = ['Authorization' => "Bearer $token"];

        $response = $this->delete('/api/auth/logout', [], $headers);

        $response
            ->assertStatus(200)
            ->assertJson([
                'message'=> trans('auth.logoutSuccess')
            ]);
    }

}
