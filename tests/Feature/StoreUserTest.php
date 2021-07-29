<?php

namespace Tests\Feature;

use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreUserTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return string[]
     */
    private function validUserData(): array
    {
        return [
            'name' => 'German Bahringer',
            'cpf' => '603.343.700-43',
            'phone_number' => '1-606-972-7277 x9649',
            'email' => 'test.case@email.net',
            'password' => 'password'
        ];
    }

    public function testValid()
    {
        $response = $this->post('/users', $this->validUserData());
        $response->assertStatus(201);
    }

    public function testInvalidWithoutName()
    {
        $validUserdata = $this->validUserData();
        unset($validUserdata['name']);
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithoutCpf()
    {
        $validUserdata = $this->validUserData();
        unset($validUserdata['cpf']);
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithoutEmail()
    {
        $validUserdata = $this->validUserData();
        unset($validUserdata['email']);
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithoutPassword()
    {
        $validUserdata = $this->validUserData();
        unset($validUserdata['password']);
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithoutPhoneNumber()
    {
        $validUserdata = $this->validUserData();
        unset($validUserdata['phone_number']);
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithInvalidCpf()
    {
        $validUserdata = $this->validUserData();
        $validUserdata['cpf'] = '123.123.123-12';
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithInvalidEmail()
    {
        $validUserdata = $this->validUserData();
        $validUserdata['email'] = '.awd.123@.awd';
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithTakenCpf()
    {
        $validUserdata = $this->validUserData();
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(201);

        $validUserdata = $this->validUserData();
        $validUserdata['email'] = 'some.other@email.com';
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }

    public function testInvalidWithTakenEmail()
    {
        $validUserdata = $this->validUserData();
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(201);

        $validUserdata = $this->validUserData();
        $validUserdata['cpf'] = '906.658.790-32';
        $response = $this->post('/users', $validUserdata);
        $response->assertStatus(400);
    }
}
