<?php

use yii\helpers\Url;
use app\components\File;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $position \app\models\TemplateCartPosition */

?>

<div class="element relative">
    <a href="#" data-url="<?= Url::to(['user/cart/delete', 'id' => $position->id]) ?>" class="main-cart-delete-btn">
        <i class="material-icons">close</i></a>

    <div class="element-img">
        <a href="<?= Url::to(['template/view', 'id' => $position->getId()]) ?>"><img
                src="<?= File::src($position->getTemplate()->firstPicture, 'file_name', [370, 370]) ?>" alt=""/></a>
    </div>

    <div class="element-content">
        <div class="sub-element main">
            <a href="<?= Url::to(['template/view', 'id' => $position->getId()]) ?>" class="sub-element-title invert">
                <?= Html::encode($position->getTemplate()->title) ?>
            </a>
            <span class="sub-element-price">
                <?= $position->price ?> р.
            </span>
        </div>

        <div class="sub-element-description">
            <div class="article"><?= $position->getTemplate()->getDisplayArticle() ?></div>
            <div class="type"><?= $position->getTemplate()->type->title ?></div>
        </div>

        <?php foreach ($position->getServices() as $service): ?>
            <div class="sub-element extra">
                <span class="sub-element-title">
                    <em>
                        <?= Html::encode($service->title) ?>
                    </em>
                </span>
                <span class="sub-element-price">
                    <?= $service->price ?> р.
                </span>
            </div>
        <?php endforeach; ?>

        <?php foreach ($position->getOptions() as $option): ?>
            <div class="sub-element extra">
                <span class="sub-element-title"><em><?= Html::encode($option->title) ?></em></span> <span
                    class="sub-element-price"><?= $option->price ?> р.</span>
            </div>
        <?php endforeach; ?>

    </div>
</div>
