<?php

/**
 * Comments list view.
 *
 * @var \yii\web\View $this View
 */

use vova07\comments\Module;

?>

<div id="comments">
    <div id="comments-list" data-comment="list">
        <?= $this->render('_index_item', ['models' => $models, 'num'=>0]) ?>
    </div>
    <!--/ #comments-list -->

    <?php if (Yii::$app->user->can('createReviews')) : ?>
        <h3><?= Module::t('comments', 'FRONTEND_WIDGET_COMMENTS_FORM_TITLE') ?></h3>
        <div class="form_div">
            <?= $this->render('_create_form', ['model' => $reviewForm]); ?>
        </div>
        <div class="appeal_form_div" style="display: none">
            <?= $this->render('_appeal_form', ['model' => $appealForm]); ?>
        </div>
        <?php else:?>
        <div>Пожалуйста, <a href="<?=\yii\helpers\Url::to(['/login'])?>">авторизуйтесь</a>, чтобы оставлять комментарии</div>
    <?php endif; ?>
</div>