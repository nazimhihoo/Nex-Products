<?php

return [
    [
        'key' => 'account',
        'name' => 'shop::app.layouts.my-account',
        'route' => 'shop.customers.account.profile.index',
        'icon' => '',
        'sort' => 1,
    ], [
        'key' => 'account.profile',
        'name' => 'shop::app.layouts.profile',
        'route' => 'shop.customers.account.profile.index',
        'icon' => 'icon-users',
        'sort' => 1,
    ], [
        'key' => 'account.address',
        'name' => 'shop::app.layouts.address',
        'route' => 'shop.customers.account.addresses.index',
        'icon' => 'icon-location',
        'sort' => 2,
    ], [
        'key' => 'account.orders',
        'name' => 'shop::app.layouts.orders',
        'route' => 'shop.customers.account.orders.index',
        'icon' => 'icon-orders',
        'sort' => 3,
    ], [
        'key' => 'account.reviews',
        'name' => 'shop::app.layouts.reviews',
        'route' => 'shop.customers.account.reviews.index',
        'icon' => 'icon-star',
        'sort' => 4,
    ],
];
