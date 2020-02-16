<?php

namespace Tests\Feature;

use App\User;
use Illuminate\Auth\Notifications\ResetPassword;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Support\Facades\Notification as NotificationAlias;
use Tests\TestCase;

class ForgottenPasswordTest extends TestCase
{
    use RefreshDatabase;

    public function testRouteExists(): void
    {
        $response = $this->get('/password/reset');
        $response->assertStatus(200)
            ->assertSee('Reset Password')
            ->assertSee('E-Mail Address')
            ->assertSee('Send Password Reset Link');
    }

    public function testRequiredFields(): void
    {
        $this->from('/password/reset')
            ->post('/password/email')
            ->assertStatus(302)
            ->assertSessionHasErrors(['email' => 'The email field is required.']);
    }

    public function testRequiredFieldsfollowRedirect(): void
    {
        $this->followingRedirects()
            ->from('/password/reset')
            ->post('/password/email')
            ->assertOk();
    }

    public function testInvalidEmail()
    {
        $this
            ->from('/password/reset')
            ->post('/password/email', [
                'email' => 'testgmail.com'
            ])
            ->assertStatus(302)
            ->assertSessionHasErrors(['email' => 'The email must be a valid email address.']);
    }

    public function testEmailDoesNotExist()
    {
        $this->followingRedirects()                         // bez redirect
            ->from('/password/reset')
            ->post('/password/email', [
                'email' => 'test@gmail.com'
            ])
            ->assertOk()
            //->assertSessionHasErrors(['email'=> 'We can\'t find a user with that e-mail address.'] );
            ->assertSeeText(e("We can't find a user with that e-mail address."));
    }

    public function testForgotPassword():void
    {
        NotificationAlias::fake();
        $user = factory(User::class)->create();
        $this->followingRedirects()
            ->from('/password/reset')
            ->post('/password/email', [
                'email' => $user->email,
            ])
        ->assertOk()
            ->assertSeeText('We have e-mailed your password reset link!');

        $this->assertDatabaseHas('password_resets',[
            'email'=> $user->email
        ]);


        NotificationAlias::assertSentTo([$user],ResetPassword::class);
    }

    /*public function testSendResetLink()
    {
        $user = factory(User::class)->create();
        $this->followingRedirects()
            ->from('/password/reset')
            ->post('/password/email', [
                'email' => $user->email,
            ])
            ->assertOk()
            ->assertSeeText('We have e-mailed your password reset link!');


        //Notification::assertSentTo($user, ResetPassword::class);

        Mail::fake();
        Mail::assertSent(ResetPassword::class);

    }*/



}
