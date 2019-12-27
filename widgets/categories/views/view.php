<?php

use app\components\Url;
use yii\helpers\Html;

/** @var $this \yii\web\View */
/** @var $categories \app\models\Category[] */
/** @var $tags \app\models\Tag[] */

?>

<div class="aside">
    <nav class="aside-menu">
        <div class="aside-menu-title visible-xs visible-sm">
            <i class="material-icons">view_module</i> Категории шаблонов
        </div>
        <ul>
            <?php foreach ($categories as $i => $category): ?>
                <?php if (!$category->hasTemplates()) continue; ?>

            <?php $isCurrentCategory = (Yii::$app->request->get('category') == $category->alias) ?>
            <li class="<?= $i == 0 ? 'first' : ''; echo " "; echo $isCurrentCategory ? 'active-category' : ''; ?>">
                    <a href="<?= Url::current([
                        'index',
                        'category' => $category->alias,
                        'type' => Yii::$app->getRequest()->get('type'),
                        'tag' => null,
                        'id' => null
                    ]) ?>">
                        <?= Html::encode($category->title) ?>
                    </a>

                    <?php if ($category->children): ?>
                        <ul>
                            <?php foreach ($category->children as $k => $child): ?>
                                <?php if (!$child->hasTemplates()) continue; ?>

                                <li class="<?= $k == 0 ? 'first' : '' ?>">
                                    <a href="<?= Url::current(['index', 'category' => $child->alias, 'tag' => null, 'id' => null]) ?>">
                                        <?= Html::encode($child->title) ?>
                                    </a>
                                </li>
                            <?php endforeach; ?>
                        </ul>
                    <?php endif; ?>
                </li>
            <?php endforeach; ?>
        </ul>
    </nav>

    <?php if (count($tags) > 0): ?>
        <div class="aside-tags">
            <div class="title">Метки</div>
            <ul>
                <?php foreach ($tags as $tag): ?>
                    <?php $isCurrentTag = (Yii::$app->request->get('tag') == $tag->alias) ?>
                    <li>
                        <a href="<?= Url::current(['index', 'tag' => $tag->alias, 'id' => null]) ?>"
                            class="level4 <?= $isCurrentTag ? 'active-tag' : '' ?>">
                            #<?= $tag->title ?>
                        </a>
                    </li>
                <?php endforeach; ?>
            </ul>
        </div>
    <?php endif; ?>
</div>