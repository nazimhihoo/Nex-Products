<?php

return [
    [
        'label' => 'Dashboard',
        'icon' => 'icon-dashboard',
        'route' => 'admin.dashboard.index',
        'active' => ['admin.dashboard.*'],
        'children' => [],
    ],
    [
        'label' => 'Orders',
        'icon' => 'icon-sales',
        'route' => 'admin.sales.orders.index',
        'active' => [
            'admin.sales.orders.*',
            'admin.sales.invoices.*',
            'admin.sales.shipments.*',
            'admin.sales.refunds.*',
            'admin.sales.transactions.*',
        ],
        'children' => [],
    ],
    [
        'label' => 'Customers',
        'icon' => 'icon-customer-2',
        'route' => 'admin.customers.customers.index',
        'active' => [
            'admin.customers.customers.index',
            'admin.customers.customers.view',
            'admin.customers.customers.edit',
            'admin.customers.customers.update',
            'admin.customers.customers.delete',
            'admin.customers.customers.addresses.*',
        ],
        'children' => [],
    ],
    [
        'label' => 'Users',
        'icon' => 'icon-settings',
        'route' => 'admin.settings.users.index',
        'active' => [
            'admin.settings.users.*',
            'admin.settings.roles.*',
        ],
        'children' => [],
    ],
    [
        'label' => 'Brands',
        'icon' => 'icon-product',
        'route' => 'admin.brands.index',
        'active' => ['admin.brands.*'],
        'children' => [],
    ],
    [
        'label' => 'Products',
        'icon' => 'icon-product',
        'route' => 'admin.catalog.products.index',
        'active' => [
            'admin.catalog.products.*',
            'admin.catalog.attributes.*',
            'admin.catalog.families.*',
        ],
        'children' => [
            [
                'label' => 'Products',
                'route' => 'admin.catalog.products.index',
                'active' => ['admin.catalog.products.*'],
            ],
            [
                'label' => 'Attributes',
                'route' => 'admin.catalog.attributes.index',
                'active' => ['admin.catalog.attributes.*'],
            ],
            [
                'label' => 'Families',
                'route' => 'admin.catalog.families.index',
                'active' => ['admin.catalog.families.*'],
            ],
        ],
    ],
    [
        'label' => 'Categories',
        'icon' => 'icon-product',
        'route' => 'admin.catalog.categories.index',
        'active' => ['admin.catalog.categories.*'],
        'children' => [],
    ],
    [
        'label' => 'Reviews',
        'icon' => 'icon-customer-2',
        'route' => 'admin.customers.customers.review.index',
        'active' => ['admin.customers.customers.review.*'],
        'children' => [],
    ],
    [
        'label' => 'Banners',
        'icon' => 'icon-cms',
        'route' => 'admin.banners.index',
        'active' => [
            'admin.banners.*',
            'admin.settings.themes.edit',
            'admin.settings.themes.update',
        ],
        'children' => [],
    ],
    [
        'label' => 'Promotions',
        'icon' => 'icon-promotion',
        'route' => 'admin.marketing.promotions.catalog_rules.index',
        'active' => [
            'admin.marketing.promotions.catalog_rules.*',
            'admin.marketing.promotions.cart_rules.*',
        ],
        'children' => [
            [
                'label' => 'Catalog Rules',
                'route' => 'admin.marketing.promotions.catalog_rules.index',
                'active' => ['admin.marketing.promotions.catalog_rules.*'],
            ],
            [
                'label' => 'Cart Rules',
                'route' => 'admin.marketing.promotions.cart_rules.index',
                'active' => ['admin.marketing.promotions.cart_rules.*'],
            ],
        ],
    ],
    [
        'label' => 'Settings',
        'icon' => 'icon-configuration',
        'route' => 'admin.configuration.index',
        'active' => [
            'admin.configuration.*',
            'admin.settings.channels.*',
            'admin.settings.locales.*',
            'admin.settings.currencies.*',
            'admin.settings.exchange_rates.*',
            'admin.settings.inventory_sources.*',
            'admin.settings.taxes.*',
        ],
        'children' => [
            [
                'label' => 'Site Settings',
                'route' => 'admin.configuration.index',
                'active' => ['admin.configuration.*'],
            ],
            [
                'label' => 'Channels',
                'route' => 'admin.settings.channels.index',
                'active' => ['admin.settings.channels.*'],
            ],
            [
                'label' => 'Inventory',
                'route' => 'admin.settings.inventory_sources.index',
                'active' => ['admin.settings.inventory_sources.*'],
            ],
            [
                'label' => 'Taxes',
                'route' => 'admin.settings.taxes.categories.index',
                'active' => ['admin.settings.taxes.*'],
            ],
            [
                'label' => 'Locales',
                'route' => 'admin.settings.locales.index',
                'active' => ['admin.settings.locales.*'],
            ],
            [
                'label' => 'Currencies',
                'route' => 'admin.settings.currencies.index',
                'active' => [
                    'admin.settings.currencies.*',
                    'admin.settings.exchange_rates.*',
                ],
            ],
        ],
    ],
    [
        'label' => 'Analytics',
        'icon' => 'icon-dashboard',
        'route' => 'admin.analytics.index',
        'active' => [
            'admin.analytics.*',
            'admin.reporting.sales.*',
            'admin.reporting.products.*',
            'admin.reporting.customers.*',
        ],
        'children' => [
            [
                'label' => 'Overview',
                'route' => 'admin.analytics.index',
                'active' => ['admin.analytics.*'],
            ],
            [
                'label' => 'Sales',
                'route' => 'admin.reporting.sales.index',
                'active' => ['admin.reporting.sales.*'],
            ],
            [
                'label' => 'Products',
                'route' => 'admin.reporting.products.index',
                'active' => ['admin.reporting.products.*'],
            ],
            [
                'label' => 'Customers',
                'route' => 'admin.reporting.customers.index',
                'active' => ['admin.reporting.customers.*'],
            ],
        ],
    ],
];
