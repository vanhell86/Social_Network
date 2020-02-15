<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Auth\VerifiesEmails;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Illuminate\Support\Facades\Notification;
use Tests\TestCase;

class RegistrationTest extends TestCase
{
    use RefreshDatabase;

    public function testRouteExists():void
    {
        $response = $this->get('/register');
        $response->assertStatus(200);
    }

    public function testLogedUser():void
    {
        $this->actingAs(factory(User::class)->create());
        $response = $this->post('/register');
        $response->assertStatus(302);
    }

    public function testInvalidPayload():void
    {
        /*$this->followingRedirects()
            ->from('/register')
            ->post('/register')
            ->assertOk()
            ->assertSessionHasErrors()
            //->assertSeeText('The name field is required.')*/

        $this->from('/register')
            ->post('/register')
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'name'=> 'The name field is required.',
                'email' => 'The email field is required.',
                'password'=> 'The password field is required.'
            ]);
    }

    public function testInvalidEmail():void
    {

        $this->from('/register')
            ->post('/register',[
                'email'=>'invalid_email'
                ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email must be a valid email address.'
            ]);
    }


    public function testPasswordConfirm():void
    {
        $this->from('/register')
            ->post('/register',[
                'email'=>'tests@test.com',
                'name' => 'Māris',
                'password'=> '12345678',
                'password_confirmation'=> '98745632',

            ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password confirmation does not match.'
            ]);
    }

    public function testEmailExists():void
    {
        $user = factory(User::class)->create();

        $this->from('/register')
            ->post('/register',[
                'email'=>$user->email,
                'name' => 'Māris',
                'password'=> '12345678',
                'password_confirmation'=> '12345678',

            ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email has already been taken.'
            ]);
    }

    public function testRegister():void
    {
        //Notification::fake();
        $user = factory(User::class)->make();

        $this->followingRedirects()
        ->from('/register')
            ->post('/register',[
                'email'=>'vards@epasts.com',                    //$user->email
                'name' => 'vards',                              //$user->name
                'password'=> '12345678',
                'password_confirmation'=> '12345678',

            ])
            ->assertOk();
            $this->assertDatabaseHas('users', [
                'email'=>'vards@epasts.com'                      // 'email' => $user->email
                                                                // 'name' => $user->name
            ]);

            $this->assertTrue(auth()->check());
            //Notification::assertSentTo([$user],VerifiesEmails::class);
    }


}
