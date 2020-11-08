<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegisterAndLogin()
    {
        $email = "testreglogin" . time() . "@sample.com";
        $password = "samplepassword";
        $name = "Test User";

        $response = $this->post('/api/register',
            [
                'name' => $name,
                'email' => $email,
                'password' => $password,
                'c_password' => $password
            ]);
        $response->assertStatus(200);

        $response = $this->post('/api/login',
            [
                'email' => $email,
                'password' => $password,
            ]);
        $response->assertStatus(200);

        $output = json_decode($response->getContent());
        $token = $output->data->token;
        $this->assertNotEmpty($token, 'Token was empty');
        $this->assertIsObject($output->data);
        $this->assertEquals($name, $output->data->name);
        
    }
}
