<?php

use App\Models\Account;

pest()->group('reset');

it('should reset api', function () {
    $accountQty = 10;

    Account::factory()->count($accountQty)->create();
    expect(Account::count())->toBe($accountQty);

    $response = $this->post(route('v1.reset.index'));

    $response->assertOk()->assertSee('OK');
    expect(Account::count())->toBe(0);
});
