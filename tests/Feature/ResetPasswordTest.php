<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Hash;
use Illuminate\Support\Facades\Password;
use Tests\TestCase;

class ResetPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testShowPasswordResetPage()
    {
        $user = factory(User::class)->create();

        $token = Password::createToken($user);

        $this->get(route('password.reset', [
            'token' => $token,
        ]))
            ->assertSuccessful()
            ->assertSee('Reset Password')
            ->assertSee('E-Mail Address')
            ->assertSee('Password')
            ->assertSee('Confirm Password');
    }

    public function testRequiredFields(): void
    {
        $user = factory(User::class)->create();
        $token = Password::createToken($user);
        $this->from('/password/reset/' . $token)
            ->post('/password/reset')
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'email' => 'The email field is required.',
                'password' => 'The password field is required.'
            ]);
    }

    public function testPasswordsDontMatch(): void
    {
        $user = factory(User::class)->create();
        $token = Password::createToken($user);
        $this->from('/password/reset/' . $token)
            ->post('/password/reset', [
                'email' => $user->email,
                'password' => '123456789',
                'password_confirmation' => '987654321'
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors([
                'password' => 'The password confirmation does not match.'
            ]);
    }

    public function testSuccessfulPasswordReset(): void
    {
        $user = factory(User::class)->create();
        $token = Password::createToken($user);

        $this->followingRedirects()
            ->from('/password/reset/' . $token)
            ->post("/password/reset", [
                'email' => $user->email,
                'password' => '123456789',
                'password_confirmation' => '123456789'
            ])
            ->assertOk();

        $this->assertDatabaseHas('users', [
            'email' => $user->email,
            'password' => Hash::check('123456789', $user->password)
        ]);
    }


}


