<?php

test('unauthenticated users can\'t access products list page', function () {
    $this->get('/products')
        ->assertStatus(302)
        ->assertRedirect('/login');
});

test('unauthenticated users can\'t access products list page but more shorter')->get('/products')
    ->assertStatus(302)
    ->assertRedirect('/login');

