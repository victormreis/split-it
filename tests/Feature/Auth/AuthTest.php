<?php

use App\Models\User;
use Illuminate\Support\Facades\Hash;
use function Pest\Laravel\assertDatabaseHas;
use function PHPUnit\Framework\assertTrue;

test('Should register an user', function () {
    $user = [
        'name' => 'John Doe',
        'email' => 'j.doe@test.com',
        'password' => 'password'
    ];

    $response = $this->postJson(route('api.register'), $user);

    $response->assertStatus(201);

    assertDatabaseHas('users', [
        'name' => $user['name'],
        'email' => $user['email']
    ]);
});
test('Should reject invalid request input', function () {
    $input = [
        'name' => '',
        'email' => 'j.doetest.com',
        'password' => '@password1234567'
    ];

    $response = $this->postJson(route('api.register'), $input); ;
    $response->assertStatus(422);

});

test('Should have the password hashed', function () {
    $input = [
        'name' => 'John Doe',
        'email' => 'j.doe@test.com',
        'password' => '@password1234567'
    ];

    $this->postJson(route('api.register'), $input);

    $user = User::query()->where('email', $input["email"])->first();

    assertTrue(Hash::check($input['password'], $user->password));
});

test('Password shoul not be returnd when creating a user', function () {
    $input = [
        'name' => 'John Doe',
        'email' => 'j.doe@test.com',
        'password' => '@password1234567'
    ];

    $response = $this->postJson(route('api.register'), $input);


    expect($response->json())->not()->toHaveKey('password');

});
