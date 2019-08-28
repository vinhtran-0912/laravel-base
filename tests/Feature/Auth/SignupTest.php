<?php

namespace Tests\Feature\Auth;

use App\User;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\DatabaseTransactions;

class SignupTest extends TestCase
{
    use DatabaseTransactions;
    public function testSignupSuccessfully()
    {
        $response = $this->post('/api/auth/signup', [
            'email' => 'tran.ngoc.vinh@sun-asterisk.com',
            'name' => 'vim',
            'password' => '123123',
            'password_confirmation' => '123123',
        ]);

        $response
            ->assertStatus(201)
            ->assertJsonStructure([
                'message',
                'user' => [
                    'email',
                    'name',
                    'created_at',
                    'updated_at'
                ]
            ]);
    }

    public function testsRequiresPasswordEmailAndName()
    {
       $response = $this->post('/api/auth/signup');

       $response
            ->assertStatus(422)
            ->assertJson([
                'error' => [
                    'name' => ['The name field is required.'],
                    'email' => ['The email field is required.'],
                    'password' => ['The password field is required.'],
                ],
                'status_code' => 422,
            ]);
    }
}
