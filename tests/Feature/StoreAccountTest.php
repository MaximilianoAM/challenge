<?php

namespace Tests\Feature;

use App\Models\Account;
use App\Models\User;
use Illuminate\Foundation\Testing\RefreshDatabase;
use Illuminate\Foundation\Testing\WithFaker;
use Tests\TestCase;

class StoreAccountTest extends TestCase
{
    use RefreshDatabase;

    /**
     * @return string[]
     */
    private function validPersonAccountData(): array
    {
        return [
            'type' => 'PERSON',
            'agency' => 20,
            'number' => 20,
            'digit' => 9,
            'cpf' => '893.013.610-94',
            'name' => 'Some name',
            'owner_user_id' => 1
        ];
    }

    /**
     * @return string[]
     */
    private function validCompanyAccountData(): array
    {
        return [
            'type' => 'COMPANY',
            'agency' => 20,
            'number' => 20,
            'digit' => 9,
            'cnpj' => '64.434.858/0001-47',
            'corporate_name' => 'Some corporate name',
            'trading_name' => 'Some trading name',
            'owner_user_id' => 1
        ];
    }

    private function validAccountData(): array
    {
        return rand(0,1)
            ? $this->validPersonAccountData()
            : $this->validCompanyAccountData();
    }

    public function testValid()
    {
        factory(User::class)->create();
        $response = $this->post('/accounts', $this->validAccountData());
        $response->assertStatus(201);
    }

    public function testInvalidWithoutOwnerUserId()
    {
        factory(User::class)->create();
        $validAccountData = $this->validAccountData();
        unset($validAccountData['owner_user_id']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutType()
    {
        factory(User::class)->create();
        $validAccountData = $this->validAccountData();
        unset($validAccountData['type']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutAgency()
    {
        factory(User::class)->create();
        $validAccountData = $this->validAccountData();
        unset($validAccountData['agency']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutNumber()
    {
        factory(User::class)->create();
        $validAccountData = $this->validAccountData();
        unset($validAccountData['agency']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutDigit()
    {
        factory(User::class)->create();
        $validAccountData = $this->validAccountData();
        unset($validAccountData['agency']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutName()
    {
        factory(User::class)->create();
        $validAccountData = $this->validPersonAccountData();
        unset($validAccountData['name']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutCpf()
    {
        factory(User::class)->create();
        $validAccountData = $this->validPersonAccountData();
        unset($validAccountData['cpf']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutTradingName()
    {
        factory(User::class)->create();
        $validAccountData = $this->validCompanyAccountData();
        unset($validAccountData['trading_name']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutCorporateName()
    {
        factory(User::class)->create();
        $validAccountData = $this->validCompanyAccountData();
        unset($validAccountData['corporate_name']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithoutCnpj()
    {
        factory(User::class)->create();
        $validAccountData = $this->validCompanyAccountData();
        unset($validAccountData['cnpj']);
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithInvalidType()
    {
        factory(User::class)->create();
        $validAccountData = $this->validAccountData();
        $validAccountData['type'] = 'SOME_TYPE';
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithInvalidCpf()
    {
        factory(User::class)->create();
        $validAccountData = $this->validPersonAccountData();
        $validAccountData['cpf'] = '321.456.987-89';
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testInvalidWithInvalidCnpj()
    {
        factory(User::class)->create();
        $validAccountData = $this->validCompanyAccountData();
        $validAccountData['cnpj'] = '321.456.987-89';
        $response = $this->post('/accounts', $validAccountData);

        $response->assertStatus(400);
    }

    public function testSameUserCantHaveMultipleAccountsOfTheSameType()
    {
        factory(User::class)->create();

        $validCompanyAccountData = $this->validCompanyAccountData();
        $response = $this->post('/accounts', $validCompanyAccountData);
        $response->assertStatus(201);

        $validPersonAccountData = $this->validPersonAccountData();
        $response = $this->post('/accounts', $validPersonAccountData);
        $response->assertStatus(201);

        $validCompanyAccountData['cnpj'] = '25.232.534/0001-74';
        $response = $this->post('/accounts', $validCompanyAccountData);
        $response->assertStatus(400);

        $validPersonAccountData['cpf'] = '718.273.780-93';
        $response = $this->post('/accounts', $validPersonAccountData);
        $response->assertStatus(400);
    }

}
