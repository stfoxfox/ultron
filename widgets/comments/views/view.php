<?php

use yii\widgets\ListView;
use yii\widgets\Pjax;

/** @var \yii\data\ActiveDataProvider $dataProvider */
/** @var \app\models\Comment $comment */
/** @var \app\models\Template $template */

?>

<?php Pjax::begin(['id' => 'comments-list-pjax']) ?>

<div class="reviews">
    <?= ListView::widget([
        'dataProvider' => $dataProvider,
        'itemView' => '_itemView',
        'emptyText' => 'Здесь пока ещё нет комментариев. Стань первым!',
        'summary' => false,
    ]) ?>
</div>

<?php Pjax::end() ?>

<?php if (!$template->canComment()): ?>
    <div class="rev-form">
        <div class="push20"></div>
        <div class="row">
            <div class="col-sm-9 col-md-12">
                <div class="row">
                    <div class="col-sm-6">
                        <div class="title black upper bold">Оставить отзыв</div>
                    </div>
                </div>
            </div>
        </div>
    </div>

    <div class="push20"></div>

    <div class="reviews">
        <div class="reviews element">
            Отзыв можно оставить только после покупки шаблона.
        </div>
    </div>
<?php else: ?>
    <?= $this->render('_form', [
        'comment' => $comment,
        'template' => $template,
    ]); ?>
<?php endif ?>