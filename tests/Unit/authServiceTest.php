<?php

namespace Tests\Unit;

use Tests\TestCase;
use App\Http\Requests\UserRequest;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class authServiceTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */
    public function testcreateUserSuccesss()
    {
        $request = new UserRequest();
        $request['email'] = "tran.ngoc.vinh@sun-asterisk.com";
        $request['name'] = "vim";
        $request['password'] = "123123";

    }
}
