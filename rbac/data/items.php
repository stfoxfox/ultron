<?php
return [
    'accessBackend' => [
        'type' => 2,
        'description' => 'Can access backend',
    ],
    'administrateRbac' => [
        'type' => 2,
        'description' => 'Can administrate all "RBAC" module',
        'children' => [
            'BViewRoles',
            'BCreateRoles',
            'BUpdateRoles',
            'BDeleteRoles',
            'BViewPermissions',
            'BCreatePermissions',
            'BUpdatePermissions',
            'BDeletePermissions',
            'BViewRules',
            'BCreateRules',
            'BUpdateRules',
            'BDeleteRules',
        ],
    ],
    'BViewRoles' => [
        'type' => 2,
        'description' => 'Can view roles list',
    ],
    'BCreateRoles' => [
        'type' => 2,
        'description' => 'Can create roles',
    ],
    'BUpdateRoles' => [
        'type' => 2,
        'description' => 'Can update roles',
    ],
    'BDeleteRoles' => [
        'type' => 2,
        'description' => 'Can delete roles',
    ],
    'BViewPermissions' => [
        'type' => 2,
        'description' => 'Can view permissions list',
    ],
    'BCreatePermissions' => [
        'type' => 2,
        'description' => 'Can create permissions',
    ],
    'BUpdatePermissions' => [
        'type' => 2,
        'description' => 'Can update permissions',
    ],
    'BDeletePermissions' => [
        'type' => 2,
        'description' => 'Can delete permissions',
    ],
    'BViewRules' => [
        'type' => 2,
        'description' => 'Can view rules list',
    ],
    'BCreateRules' => [
        'type' => 2,
        'description' => 'Can create rules',
    ],
    'BUpdateRules' => [
        'type' => 2,
        'description' => 'Can update rules',
    ],
    'BDeleteRules' => [
        'type' => 2,
        'description' => 'Can delete rules',
    ],
    'user' => [
        'type' => 1,
        'description' => 'User',
        'children' => [
            'viewReviews',
            'createReviews',
            'updateOwnReviews',
            'deleteOwnReviews',
        ],
    ],
    'admin' => [
        'type' => 1,
        'description' => 'Admin',
        'children' => [
            'user',
        ],
    ],
    'superadmin' => [
        'type' => 1,
        'description' => 'Super admin',
        'children' => [
            'admin',
            'accessBackend',
            'administrateRbac',
            'administrateReviews',
        ],
    ],
    'administrateReviews' => [
        'type' => 2,
        'description' => 'Can administrate all "Reviews" module',
        'children' => [
            'BViewReviewsModel',
            'BCreateReviewsModel',
            'BUpdateReviewsModel',
            'BDeleteReviewsModel',
            'BManageReviewsModule',
            'BViewReviews',
            'BUpdateReviews',
            'BDeleteReviews',
            'viewReviews',
            'createReviews',
            'updateReviews',
            'deleteReviews',
            'updateOwnReviews',
            'deleteOwnReviews',
        ],
    ],
    'BViewReviewsModel' => [
        'type' => 2,
        'description' => 'Can view backend reviews models list',
    ],
    'BCreateReviewsModel' => [
        'type' => 2,
        'description' => 'Can create backend reviews models',
    ],
    'BUpdateReviewsModel' => [
        'type' => 2,
        'description' => 'Can update backend reviews models',
    ],
    'BDeleteReviewsModel' => [
        'type' => 2,
        'description' => 'Can delete backend reviews models',
    ],
    'BManageReviewsModule' => [
        'type' => 2,
        'description' => 'Can enable or disable reviews for installed modules',
    ],
    'BViewReviews' => [
        'type' => 2,
        'description' => 'Can view backend reviews list',
    ],
    'BUpdateReviews' => [
        'type' => 2,
        'description' => 'Can update backend reviews',
    ],
    'BDeleteReviews' => [
        'type' => 2,
        'description' => 'Can delete backend reviews',
    ],
    'viewReviews' => [
        'type' => 2,
        'description' => 'Can view reviews',
    ],
    'createReviews' => [
        'type' => 2,
        'description' => 'Can create reviews',
    ],
    'updateReviews' => [
        'type' => 2,
        'description' => 'Can update reviews',
        'children' => [
            'updateOwnReviews',
        ],
    ],
    'deleteReviews' => [
        'type' => 2,
        'description' => 'Can delete reviews',
        'children' => [
            'deleteOwnReviews',
        ],
    ],
    'updateOwnReviews' => [
        'type' => 2,
        'description' => 'Can update own reviews',
        'ruleName' => 'author',
    ],
    'deleteOwnReviews' => [
        'type' => 2,
        'description' => 'Can delete own reviews',
        'ruleName' => 'author',
    ],
];
