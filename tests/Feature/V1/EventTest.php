<?php

use App\Models\Account;
use Illuminate\Testing\TestResponse;

pest()->group('event');

it('should deposit', function (
    string $accountId,
    int $amount,
    int $expectedBalance,
    callable $callback
) {
    $callback();

    $response = $this->postJson(route('v1.event.store'), [
        'type' => 'deposit',
        'destination' => $accountId,
        'amount' => $amount,
    ]);

    $response->assertCreated()->assertJsonPath(
        'destination.balance',
        $expectedBalance
    );
})->with('deposit');

it('should withdraw', function (
    string $accountId,
    int $amount,
    int $expectedBalance,
    callable $createOrNotAnAccount,
    callable $assertResponse,
) {
    $createOrNotAnAccount();

    $response = $this->postJson(route('v1.event.store', [
        'type' => 'withdraw',
        'origin' => $accountId,
        'amount' => $amount,
    ]));

    $assertResponse($response, $expectedBalance);
})->with('withdraw');

it('should transfer', function (
    string $fromAccount,
    string $toAccount,
    int $amount,
    callable $createOrNotAccounts,
    callable $assertResponse
) {
    $createOrNotAccounts();

    $response = $this->postJson(route('v1.event.store'), [
        'type' => 'transfer',
        'origin' => $fromAccount,
        'destination' => $toAccount,
        'amount' => $amount,
    ]);

    $assertResponse($response);
})->with('transfer');

dataset('deposit', [
    'creating an account' => ['100', 10, 10, function () {}],
    'with existing account' => ['100', 10, 20, function () {
        Account::factory()->create(['id' => '100', 'balance' => 10]);
    }],
]);

dataset('withdraw', [
    'non-existing account' => [
        '200',
        10,
        0,
        function () {},
        function (TestResponse $response, int $expectedBalance) {
            $response->assertNotFound()->assertSee('0');
        }
    ],
    'existing account' => [
        '100',
        5,
        15,
        function () {
            Account::factory()->create(['id' => '100', 'balance' => 20]);
        },
        function (TestResponse $response, int $expectedBalance) {
            $response->assertCreated()->assertJsonPath(
                'origin.balance',
                $expectedBalance
            );
        }
    ],
]);

dataset('transfer', [
    'existing account' => [
        '100',
        '300',
        15,
        function () {
            Account::factory()->createMany([
                ['id' => '100', 'balance' => 15],
                ['id' => '300', 'balance' => 0]
            ]);
        },
        function (TestResponse $response) {
            $response->assertCreated()
                ->assertJsonPath('origin.balance', 0)
                ->assertJsonPath('destination.balance', 15);
        }
    ],
    'non-existing account' => [
        '100',
        '300',
        15,
        function () {},
        function (TestResponse $response) {
            $response->assertNotFound()->assertSee('0');
        }
    ]
]);
