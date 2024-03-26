<?php

return [
    [
        'name' => 'Dashboard',
        'route' => 'admin.index',
        'icon' => 'fas fa-fw fa-tachometer-alt',
    ],
    [
        'name' => 'Người dùng',
        'route' => 'admin.user.index',
        'icon' => 'fas fa-fw fa-users',
    ],
    [
        'name' => 'Danh mục',
        'route' => 'admin.category.index',
        'icon' => 'fas fa-fw fa-list',
    ],
    [
        'name' => 'Nhà sản xuất',
        'route' => 'admin.brand.index',
        'icon' => 'fas fa-fw fa-building',
    ],
    [
        'name' => 'Sản phẩm',
        'route' => 'admin.product.index',
        'icon' => 'fas fa-fw fa-box',
        'children' => [
            [
                'name' => 'Danh sách',
                'route' => 'admin.product.index',
            ],
            [
                'name' => 'Kích thước',
                'route' => 'admin.size.index',
            ],
        ],
    ],
    [
        'name' => 'Đơn hàng',
        'route' => 'admin.order.index',
        'icon' => 'fas fa-fw fa-shopping-cart',
    ],
    [
        'name' => 'Mã giảm giá',
        'route' => 'admin.discount.index',
        'icon' => 'fas fa-fw fa-percent',
    ],
];
