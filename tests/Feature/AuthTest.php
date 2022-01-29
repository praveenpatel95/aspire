<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use Tests\TestCase;

class AuthTest extends TestCase
{
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testRegister()
    {
        $response = $this->json('POST', '/api/register-customer', [
            'name' => $name = 'Test',
            'email' => $email = time() . 'test@example.com',
            'password' => $password = '123456789',
            'password_confirmation' => $password_confirmation = '123456789',
        ]);

        //Write the response in laravel.log
        \Log::info(1, [$response->json()]);

        $response->assertStatus(200);

        // Receive our token
        $this->assertArrayHasKey('result', $response->json());
    }

    public function testLogin()
    {
        // Creating Users
        $user = User::create([
            'name' => $name = 'Test',
            'email' => $email = time() . 'user@example.com',
            'password' => $password = Hash::make('123456789'),
        ]);

        // Simulated landing
        $response = $this->json('POST', '/api/login', [
            'email' => $email,
            'password' => '123456789',
        ]);

        //Write the response in laravel.log
       // \Log::info(1, [$response->getContent()]);

        // Determine whether the login is successful and receive token
        $response
            ->assertStatus(200)
            ->assertJsonStructure(['result']);
        //$this->assertExactJson('result',$response->json());
    }
}
