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

    /**
     * A test Login Fail With Wrong Email, Name and Password.
     *
     * @dataProvider providerLoginTestRequiresPasswordEmailAndName
     * @return void
     */
    public function testsRequiresPasswordEmailAndName($originalString, $expectedResult)
    {
       $response = $this->post('/api/auth/signup', $originalString);

       $response
            ->assertStatus(400)
            ->assertJson($expectedResult);
    }

    public  function providerLoginTestRequiresPasswordEmailAndName()
    {
        return [
            [
                [
                    'email' => '',
                    'name' => 'vim',
                    'password' => '123123',
                ],
                [
                    'success' => false,
                    'error' => [
                        'code' => 622,
                        'message' => 'The email field is required.'
                    ]
                ]
            ],
            [
                [
                    'email' => 'tran.ngoc.vinh@sun-asterisk.com',
                    'name' => 'vim',
                    'password' => '',
                ],
                [
                    'success' => false,
                    'error' => [
                        'code' => 622,
                        'message' => 'The password field is required.'
                    ]
                ]
            ],
            [
                [
                    'email' => 'tran.ngoc.vinh@sun-asterisk.com',
                    'name' => '',
                    'password' => '123123',
                ],
                [
                    'success' => false,
                    'error' => [
                        'code' => 622,
                        'message' => 'The name field is required.'
                    ]
                ]
            ]
        ];
    }
}
