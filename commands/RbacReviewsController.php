<?php

namespace app\commands;

use app\models\User;
use Yii;
use yii\console\Controller;
use yii\helpers\VarDumper;

/**
 * Reviews RBAC controller.
 */
class RbacReviewsController extends Controller
{
    /**
     * @inheritdoc
     */
    public $defaultAction = 'add';

    /**
     * @var array Main module permission array
     */
    public $mainPermission = [
        'name' => 'administrateReviews',
        'description' => 'Can administrate all "Reviews" module'
    ];

    /**
     * @var array Permission
     */
    public $backendPermissions = [
        'BViewReviewsModel' => [
            'description' => 'Can view backend reviews models list',
        ],
        'BCreateReviewsModel' => [
            'description' => 'Can create backend reviews models'
        ],
        'BUpdateReviewsModel' => [
            'description' => 'Can update backend reviews models'
        ],
        'BDeleteReviewsModel' => [
            'description' => 'Can delete backend reviews models'
        ],
        'BManageReviewsModule' => [
            'description' => 'Can enable or disable reviews for installed modules'
        ],
        'BViewReviews' => [
            'description' => 'Can view backend reviews list'
        ],
        'BUpdateReviews' => [
            'description' => 'Can update backend reviews'
        ],
        'BDeleteReviews' => [
            'description' => 'Can delete backend reviews'
        ],
        'viewReviews' => [
            'description' => 'Can view reviews'
        ],
        'createReviews' => [
            'description' => 'Can create reviews'
        ],
        'updateReviews' => [
            'description' => 'Can update reviews'
        ],
        'deleteReviews' => [
            'description' => 'Can delete reviews'
        ],
    ];

    public $permissions = [
        'viewReviews' => [
            'description' => 'Can view reviews'
        ],
        'createReviews' => [
            'description' => 'Can create reviews'
        ],
        'updateOwnReviews' => [
            'description' => 'Can update own reviews',
            'rule' => 'author'
        ],
        'deleteOwnReviews' => [
            'description' => 'Can delete own reviews',
            'rule' => 'author'
        ]
    ];
    /**
     * Add Reviews RBAC.
     */
    public function actionAdd()
    {
        $auth = Yii::$app->authManager;
        $superadmin = $auth->getRole('superadmin');
        $user = $auth->getRole('user');
        $mainPermission = $auth->createPermission($this->mainPermission['name']);
        if (isset($this->mainPermission['description'])) {
            $mainPermission->description = $this->mainPermission['description'];
        }
        if (isset($this->mainPermission['rule'])) {
            $mainPermission->ruleName = $this->mainPermission['rule'];
        }
        $auth->add($mainPermission);

        foreach ($this->backendPermissions as $name => $option) {
            $permission = $auth->createPermission($name);
            if (isset($option['description'])) {
                $permission->description = $option['description'];
            }
            if (isset($option['rule'])) {
                $permission->ruleName = $option['rule'];
            }
            $auth->add($permission);
            if(!$auth->hasChild($mainPermission, $permission))
                $auth->addChild($mainPermission, $permission);
        }

        foreach ($this->permissions as $name => $option) {
            $permission = $auth->createPermission($name);
            if (isset($option['description'])) {
                $permission->description = $option['description'];
            }
            if (isset($option['rule'])) {
                $permission->ruleName = $option['rule'];
            }
            $auth->add($permission);
            if(!$auth->hasChild($user, $permission))
                $auth->addChild($user, $permission);
            if(!$auth->hasChild($mainPermission, $permission))
                $auth->addChild($mainPermission, $permission);
        }

        if(!$auth->hasChild($superadmin, $mainPermission))
            $auth->addChild($superadmin, $mainPermission);

        $updateReviews = $auth->getPermission('updateReviews');
        $updateOwnReviews = $auth->getPermission('updateOwnReviews');
        $deleteReviews = $auth->getPermission('deleteReviews');
        $deleteOwnReviews = $auth->getPermission('deleteOwnReviews');

        if(!$auth->hasChild($updateReviews, $updateOwnReviews))
            $auth->addChild($updateReviews, $updateOwnReviews);
        if(!$auth->hasChild($deleteReviews, $deleteOwnReviews))
            $auth->addChild($deleteReviews, $deleteOwnReviews);

        $auth = Yii::$app->authManager;
        $role = $auth->getRole(User::ROLE_DEFAULT);
        foreach (User::find()->all() as $user){
            if(!$auth->getAssignment($role->name, $user->id))
                $auth->assign($role, $user->id);
            if($user->role == User::ROLE_ADMIN && !$auth->getAssignment($superadmin->name, $user->id))
                $auth->assign($superadmin, $user->id);
        }

        return static::EXIT_CODE_NORMAL;
    }

    /**
     * Remove Reviews RBAC.
     */
    public function actionRemove()
    {
        $auth = Yii::$app->authManager;

        $backendPermissions = array_keys($this->backendPermissions);
        foreach ($backendPermissions as $name => $option) {
            $permission = $auth->getPermission($name);
            if($permission)
                $auth->remove($permission);
        }

        $permissions = array_keys($this->permissions);

        foreach ($permissions as $name => $option) {
            $permission = $auth->getPermission($name);
            if($permission)
                $auth->remove($permission);
        }

        $mainPermission = $auth->getPermission($this->mainPermission['name']);
        if($mainPermission)
            $auth->remove($mainPermission);

        return static::EXIT_CODE_NORMAL;
    }
}
