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

     /**
     * A test Login Fail With Wrong Email and Password.
     *
     * @dataProvider providerLoginTestFail
     * @return void
     */
    public function testLoginFail($originalString, $expectedResult)
    {
        $response = $this->post('/api/auth/login', $originalString);
        $response
            ->assertStatus(400)
            ->assertJson($expectedResult);
    }

     /**
     * A test Login Fail With requires Email and Password.
     *
     * @dataProvider providerLoginTestRequiresEmailPassword
     * @return void
     */
    public function testsRequiresEmailPassword($originalString, $expectedResult)
    {
       $response = $this->post('/api/auth/login', $originalString);

       $response
            ->assertStatus(400)
            ->assertJson($expectedResult);
    }

    public  function providerLoginTestFail()
    {
        return [
            [
                [
                    'email' => 'tran.ngoc.vinh@sun-asterisk.com1',
                    'password' => '123123',
                ],
                [
                    'success' => false,
                    'error' => [
                        'code' => 601,
                        'message' => 'Unauthorized, please check your credentials.'
                    ]
                ]
            ],
            [
                [
                    'email' => 'tran.ngoc.vinh@sun-asterisk.com',
                    'password' => '123123123',
                ],
                [
                    'success' => false,
                    'error' => [
                        'code' => 601,
                        'message' => 'Unauthorized, please check your credentials.'
                    ]
                ]
            ]
        ];
    }

    public  function providerLoginTestRequiresEmailPassword()
    {
        return [
            [
                [
                    'email' => '',
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
                    'password' => '',
                ],
                [
                    'success' => false,
                    'error' => [
                        'code' => 622,
                        'message' => 'The password field is required.'
                    ]
                ]
            ]
        ];
    }
}
