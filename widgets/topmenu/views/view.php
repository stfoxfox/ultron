<?php

/** @var $this \yii\web\View */
/** @var $types \app\models\Type[] */

use yii\helpers\Url;
use app\components\File;

$isAll = Yii::$app->controller->route == "template/index" && !Yii::$app->request->get('type');
$isSeller = Yii::$app->controller->route == "site/seller";

?>

<div class="top-menu-wrapper hidden-xs">
    <div class="container">
        <div class="inner relative">
            <nav class="top-menu">
                <ul>

                    <li>
                        <a href="<?= Url::to(['template/index']) ?>" class="<?= $isAll ? 'active' : '' ?>">
                            <img src="<?= Url::base() ?>/images/star-icon.svg"
                                 onerror="this.onerror=null; this.src='<?= Url::base() ?>/images/star-icon.png'"
                                 width="32"
                                 class="hidden-sm hidden-md"> <span>Все шаблоны</span>
                        </a>
                    </li>

                    <?php foreach ($types as $type): ?>
                        <?php $isCurrentType = (Yii::$app->request->get('type') == $type->alias) ?>
                        <li class="<?= $isCurrentType ? 'active' : '' ?>">
                            <a href="<?= Url::to(['template/index', 'type' => $type->alias]) ?>">
                                <img src="<?= File::src($type, 'picture', [32, 32]) ?>"
                                     onerror="this.onerror=null; this.src='<?= File::src($type, 'picture', [32, 32]) ?>'"
                                     width="32" class="hidden-sm hidden-md"> <span><?= $type->short_title ?></span>
                            </a>
                        </li>
                    <?php endforeach; ?>

                </ul>
            </nav>
            <?php if (Yii::$app->user->isGuest || !Yii::$app->user->identity->role === \app\models\User::ROLE_WEBMASTER): ?>
                <a href="<?= Url::to(['site/seller']) ?>" class="btn <?= $isSeller ? 'active' : '' ?>"><i class="fa fa-code" aria-hidden="true"></i>
                    Веб-мастеру</a>
            <?php endif; ?>
        </div>
    </div>
</div>

<div class="top-menu-wrapper-push hidden-xs"></div>