<?php

namespace Tests\Feature\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class LoginTest extends TestCase
{

    use RefreshDatabase;
    /**
     * A basic feature test example.
     *
     * @return void
     */
    public function testExample()
    {
        $response = $this->get('/');
        $response->assertStatus(200);
    }

    public function testRouteExists():void
    {
        $response = $this->get('/login');
        $response->assertStatus(200);
    }

    public function testInvalidLogin():void
    {
        /*$response = $this->post('/login');
        $response->assertStatus(302);

        $this->followingRedirects(); // notiek redirects*/

        $this->followingRedirects()
            ->from('/login')
            ->post('/login')
            ->assertOk();

    }

    public function testInvalidCredentialsLogin()
    {
        $this->followingRedirects()
            ->from('/login')
            ->post('/login', [
                'email'=> 'test@test.com',
                'password'=>'123456'
            ])
            ->assertOk();
    }

    public function testLogin():void
    {
        $password = 'codelex123';
        $user = factory(User::class)->create([
            'password'=> bcrypt($password)
            ]);                                             // create uztaisa useri datubaazee, "make" uztaisa vnk lietotaju aprus db
        $this->followingRedirects()
            ->from('/login')
            ->post('/login', [
                'email'=> $user->email,
                'password'=>$password
            ])
            ->assertOk();
            $this->assertTrue(auth()->check());
    }

    public function testLogedUser():void
    {
        $this->actingAs(factory(User::class)->create());
        $response = $this->post('/login');
        $response->assertStatus(302);
    }

}
