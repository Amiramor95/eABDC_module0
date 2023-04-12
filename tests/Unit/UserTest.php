<?php

namespace Tests\Unit;

use PHPUnit\Framework\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic unit test example.
     *
     * @return void
     */

    public function test_login()
    {
        $response = $this
        ->post('http://localhost:8000/api/module0/login',[
                'client_id' => 'reg-client',
                'login_id' => 'dummy',
                'password' => '@Bcd1234'
        ]);
        $response->assertStatus(200);
    }
}
