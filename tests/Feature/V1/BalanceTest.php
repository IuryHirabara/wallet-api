<?php

use App\Models\Account;
use Illuminate\Http\Response;

pest()->group('balance');

it('should return balance from account', function (
    string $accountId,
    int $statusCode,
    string $body,
    callable $callback
) {
    $callback();

    $response = $this->get(route('v1.balance.show', ['account_id' => $accountId]));

    $response->assertStatus($statusCode)->assertSee($body);
})->with('accounts');

dataset('accounts', [
    'non-existing account' => ['1234', Response::HTTP_NOT_FOUND, '0', function (): void {}],
    'existing account' => ['100', Response::HTTP_OK, '20', function (): void {
        Account::factory()->create([
            'id' => '100',
            'balance' => '20',
        ]);
    }],
]);
