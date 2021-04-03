<?php

return [
    'role_structure'       => [
        'super_administrator' => [
            'attributes'              => 'c,r,u,d',
            'balance'              => 'c,r,u,d',
            'bills'              => 'c,r,u,d',
            'comment'              => 'c,r,u,d',
            'coupon'              => 'c,r,u,d',
            'city'           => 'c,r,u,d',
            'category'             => 'c,r,u,d',
            'dashboard'         => 'c,r,u,d',
            'disapproves'              => 'c,r,u,d',
            'document'              => 'c,r,u,d',
            'gateway'             => 'c,r,u,d',
            'image'           => 'c,r,u,d',
            'message'              => 'c,r,u,d',
            'notification'              => 'c,r,u,d',
            'permissions'        => 'c,r,u,d',
            'place'              => 'c,r,u,d',
            'point'              => 'c,r,u,d',
            'question'              => 'c,r,u,d',
            'role'              => 'c,r,u,d',
            'setting'           => 'c,r,u,d',
            'takhfif'            => 'c,r,u,d',
            'tickets'            => 'c,r,u,d',
            'transaction'              => 'c,r,u,d',
            'violation'              => 'c,r,u,d',
            'users'             => 'c,r,u,d',
            'uploads'             => 'c,r,u,d',
        ],
        'moderator'           => [
            'users'   => 'c,r',
            'uploads'   => 'r,u',
            'tickets'   => 'c,r,u',
            'bills' => 'r,u',
        ],
        'user'                => [
            'comment' => 'c,r',
        ],
    ],
    'permission_structure' => [
        'cru_user' => [
            'comment' => 'c,r,u'
        ],
    ],
    'permissions_map'      => [
        'c' => 'create',
        'r' => 'read',
        'u' => 'update',
        'd' => 'delete',
    ]
];
