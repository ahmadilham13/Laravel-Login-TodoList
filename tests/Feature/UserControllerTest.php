<?php

namespace Tests\Feature;

use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class UserControllerTest extends TestCase
{
    public function testLoginPage()
    {
        $this->get('/login')
            ->assertSeeText(('Login'));
    }
    public function testLoginPageWithMember()
    {
        $this->withSession([
            "user" => "ilham"
        ])->get('/login')
        ->assertRedirect('/');
    }
    public function testloginSuccess()
    {
        $this->post('/login', [
            "user" => "ilham",
            "password" => "12345"
        ])->assertRedirect('/')
        ->assertSessionHas("user", "ilham");
    }
    public function testLoginForUserAlreadyLogin()
    {
        $this->withSession([
            "user" => "ilham"
        ])->post("/login", [
            "user"=> "ilham",
            "password" => "12345"
        ])
        ->assertRedirect('/');
    }
    public function testLoginValidationError()
    {
        $this->post('login', [])
            ->assertSeeText('Username or Password is Required');
    }
    public function testLoginFailed()
    {
        $this->post('/login', [
            "user" => "wrong",
            "password" => "wrong"
        ])->assertSeeText('Username or Password Wrong');
    }
    public function testLogout()
    {
        $this->withSession([
            "user" => 'ilham'
        ])->post("/logout")
        ->assertRedirect("/")
        ->assertSessionMissing("user");
    }
    public function testLogoutGuest()
    {
        $this->post('/logout')
            ->assertRedirect("/");
    }
}
