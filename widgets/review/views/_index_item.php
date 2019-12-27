<?php

/**
 * Comments item view.
 *
 * @var \yii\web\View $this View
 * @var \app\models\Review[] $models Comments models
 * @var integer $num Номер вложенности комментария
 */

use vova07\comments\Module;
use yii\helpers\Url;

?>
<?php if ($models !== null) : ?>
    <?php foreach ($models as $comment) : ?>

        <div class="media" data-comment="parent" data-comment-id="<?= $comment->id ?>">
            <?php $avatar = $comment->author->picture ? \app\components\File::src($comment->author, 'picture', [50, 50]) : Yii::$app->assetManager->publish('@vova07/themes/site/assets/images/blog/avatar3.png')[1]; ?>
            <div class="pull-left">
                <img src="<?= $avatar ?>" class="avatar img-circle width-50"
                     alt="<?= $comment->author->username ?>"/>
            </div>
            <div class="media-body">
                <div class="well" data-comment="append">
                    <div>
                        <small># <?=$comment->id?></small>
                    </div>
                    <div class="media-heading">
                        <strong><?= $comment->author->username ?>
                            <?php if($comment->isUserTemplateAuthor()): ?>
                                <span class="template-author"> [Автор]</span>
                            <?php endif;?>
                        </strong>&nbsp;
                        <small><?= Yii::$app->formatter->asDatetime($comment->created_at, 'dd MMM, yyyy H:m') ?></small>
                        <?php if ($comment->parent_id) { ?>
                            &nbsp;
                            <a href="#comment-<?= $comment->parent_id ?>" data-comment="ancor"
                               data-comment-parent="<?= $comment->parent_id ?>"><i class="icon-arrow-up"></i></a>
                        <?php } ?>
                        <?php if ($comment->isActive) { ?>
                            <div class="pull-right" data-comment="tools">
                                <?php if (Yii::$app->user->can('updateReviews') || Yii::$app->user->can('updateOwnReviews', ['model' => $comment])) { ?>
                                    &nbsp;
                                    <a href="#" data-comment="update" data-comment-id="<?= $comment->id ?>"
                                       data-comment-url="<?= Url::to([
                                           '/review/update',
                                           'id' => $comment->id
                                       ]) ?>">
                                        <i class="icon-pencil"></i> <?= Module::t('comments', 'FRONTEND_WIDGET_COMMENTS_UPDATE') ?>
                                    </a>
                                <?php } ?>
                                <?php if (Yii::$app->user->can('deleteReviews') || Yii::$app->user->can('deleteOwnReviews', ['model' => $comment])) { ?>
                                    &nbsp;
                                    <a href="#" data-comment="delete" data-comment-id="<?= $comment->id ?>"
                                       data-comment-url="<?= Url::to([
                                           '/review/delete',
                                           'id' => $comment->id
                                       ]) ?>"
                                       data-comment-confirm="<?= Module::t('comments', 'FRONTEND_WIDGET_COMMENTS_DELETE_CONFIRMATION') ?>">
                                        <i class="icon-trash"></i> <?= Module::t('comments', 'FRONTEND_WIDGET_COMMENTS_DELETE') ?>
                                    </a>
                                <?php } ?>
                                <?php
                                if (Yii::$app->user->can('createReviews')) { ?>
                                    <div class="pull-right">
                                        <a href="#"
                                           data-comment="appeal"
                                           data-comment-id="<?= $comment->id ?>"
                                           data-comment-url="<?= Url::to([
                                               '/review/appeal',
                                               'id' => $comment->id
                                           ]) ?>"
                                        >
                                            <i class="icon-ambulance"></i> Пожаловаться
                                        </a>
                                    </div>
                                <?php } ?>
                            </div>
                        <?php } ?>
                    </div>
                    <?php if ($comment->isDeleted) { ?>
                        <?= Module::t('comments', 'FRONTEND_WIDGET_COMMENTS_DELETED_COMMENT_TEXT') ?>
                    <?php } else { ?>
                        <div class="content" data-comment="content"><?= $comment->content ?></div>
                        <div class="content-reply"></div>
                        <?php
                        if (Yii::$app->user->can('createReviews')) { ?>
                            <div class="pull-right" data-comment="tools">
                                <a href="#" data-comment="reply" data-comment-id="<?= $comment->id ?>"
                                   data-comment-url="<?= Url::to([
                                       '/review/reply',
                                       'id' => $comment->id
                                   ]) ?>">
                                    <i class="icon-repeat"></i> Ответить
                                </a>
                            </div>
                            <div style="clear: both"></div>
                        <?php } ?>
                    <?php } ?>
                </div>
                <?php if ($comment->children && $num < 4) { ?>
                    <?= $this->render('_index_item', ['models' => $comment->children, 'num' => $num + 1]) ?>
                <?php } ?>
            </div>
            <?php if ($comment->children && $num >= 4) { ?>
                <?= $this->render('_index_item', ['models' => $comment->children, 'num' => $num + 1]) ?>
            <?php } ?>
        </div>
    <?php endforeach; ?>
<?php endif; ?>