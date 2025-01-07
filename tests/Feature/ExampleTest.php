<?php

it('returns a successful response', function (): void {
    $response = $this->get('/register');
    $response->assertStatus(200);
});
