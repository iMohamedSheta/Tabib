<?php

use App\Attributes\UsedIn;

it('can create a UsedIn attribute with places', function () {
    $attribute = new UsedIn('place1', 'place2');

    expect($attribute->places)->toBe(['place1', 'place2']);
});

it('can create a UsedIn attribute with no places', function () {
    $attribute = new UsedIn();

    expect($attribute->places)->toBeEmpty();
});
