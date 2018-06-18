<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\DatabaseTransactions;
use Tests\TestCase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Foundation\Testing\RefreshDatabase;

class UserAPITest extends TestCase
{
    // mereset database ke semula
    //use DatabaseTransactions;

    /**
     * A basic test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $data = [
            'name' => 'Dwi Randy Herdinanto',
            'email' => 'dwirandyherdinanto@gmail.com',
            'password'=> '123456',
            'c_password' => '123456'
        ];

        /*
        $response = $this->json('POST', '/api/register', $data);
        $data = $response->json();
        $response->assertStatus(200);
        */
    }

    public function testLogin(){
        $data = [
            'email' => 'dwirandyherdinanto@gmail.com',
            'password' => '123456'
        ];

        $response = $this->json('POST', '/api/login', $data);
        $data = $response->json();
        $response->assertStatus(200);
        if ($response->status() == 200){
            $this->accessToken = $data['success']['token'];
            $this->assertNotEmpty($this->accessToken);
        }
    }

    public function testDetail(){
        $accessToken = $this->json('POST', '/api/login', ['email' => 'dwirandyherdinanto@gmail.com', 'password' => '123456'])->json()['success']['token'];

        $headers = [
            'Accept' => 'application/json',
            'Authorization' => 'Bearer ' . $accessToken
        ];

        $response = $this->json('POST', '/api/details', [], $headers);
        $data = $response->json();
        $response->assertStatus(200);
    }
}
