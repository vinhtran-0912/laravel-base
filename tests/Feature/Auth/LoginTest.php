<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class LoginTest extends TestCase
{
    use DatabaseTransactions;

    public function testLoginSuccessfully()
    {
        $user = factory(User::class)->create([
            'email' => 'tran.ngoc.vinh@sun-asterisk.com',
            'name' => 'vim',
            'password' => bcrypt('123123'),
        ]);

        $response = $this->post('/api/auth/login', [
            'email' => 'tran.ngoc.vinh@sun-asterisk.com',
            'password' => '123123'
        ]);

        $response
            ->assertStatus(200)
            ->assertJsonStructure([
                'original'=> [
                    'access_token',
                    'token_type',
                    'expires_at',
                    'user'=> [
                        'id',
                        'name',
                        'email',
                        'created_at',
                        'updated_at',
                        'email_verified_at',
                    ]
                ]
            ]);
    }

    public function testLoginFail()
    {
        $response = $this->post('/api/auth/login', [
            'email' => 'tran.ngoc.vinh@sun-asterisk.com',
            'password' => '123123'
        ]);

        $response
            ->assertStatus(401)
            ->assertJson([
                'original' =>[
                    'message' => 'Unauthorized'
                ]
            ]);
    }

    public function testsRequiresPasswordEmail()
    {
       $response = $this->post('/api/auth/login');

       $response
            ->assertStatus(422)
            ->assertJson([
                'error' => [
                'email' => ['The email field is required.'],
                'password' => ['The password field is required.'],
                ],
                'status_code' => 422,
            ]);
    }
}
