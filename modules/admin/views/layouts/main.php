<?php

/* @var $this \yii\web\View */
/* @var $content string */

use yii\helpers\Url;
use yii\helpers\Html;
use app\components\inspinia\InspiniaAsset;
use app\modules\admin\models\UserSearch;
use app\models\User;
use app\models\Template;
use yii\bootstrap\Alert;
use app\models\Comment;
use app\models\Review;

$asset = $this->assetManager->getBundle(InspiniaAsset::className());

$userPendingCount = UserSearch::getPendingCount(User::ROLE_USER);
$webmasterPendingCount = UserSearch::getPendingCount(User::ROLE_WEBMASTER);
$templatesPendingCount = Template::getPendingCount();
$commentsNewCount = Comment::getNewCount();
$reviewsNewCount = Review::getNewCount();
?>

<?php $this->beginContent('@app/modules/admin/views/layouts/html.php'); ?>
    <div id="wrapper">

        <nav class="navbar-default navbar-static-side" role="navigation">
            <div class="sidebar-collapse">
                <ul class="nav" id="side-menu">
                    <li class="nav-header">
                        <div class="dropdown profile-element">
                            <span></span>
                            <a data-toggle="dropdown" class="dropdown-toggle"
                               href="<?= Url::home() ?>">
                            <span class="clear">
                                <span class="block m-t-xs">
                                    <strong class="font-bold"
                                            style="font-size: 18px;">
                                         ULTRON
                                    </strong>
                                </span>
                             </span>

                            </a>
                        </div>
                        <div class="logo-element">CP</div>
                    </li>
                    <li class="<?= $this->context->id === 'user' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['user/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Пользователи <?php if($userPendingCount > 0): ?><span class="label label-warning pull-right"><?= $userPendingCount ?></span><?php endif ?></span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'webmaster' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['webmaster/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Вебмастеры <?php if($webmasterPendingCount > 0): ?><span class="label label-warning pull-right"><?= $webmasterPendingCount ?></span><?php endif ?></span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'admin' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['admin/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Админы</span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'invoice' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['invoice/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Продажи</span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'income' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['income/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Выплаты</span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'payout' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['payout/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Архив выплат</span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'template' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['template/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">Товары <?php if($templatesPendingCount > 0): ?><span class="label label-warning pull-right"><?= $templatesPendingCount ?></span><?php endif ?></span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'comment' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['comment/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">
                                Комментарии
                                <?php
                                if($commentsNewCount > 0): ?>
                                    <span class="label label-warning pull-right"><?= $commentsNewCount ?></span>
                                <?php endif ?>
                            </span>
                        </a>
                    </li>
                    <li class="<?= $this->context->id === 'review' ? 'active' : '' ?>">
                        <a href="<?= Url::to(['review/index']) ?>">
                            <i class="fa fa-circle-o"></i>
                            <span class="nav-label">
                                Диалоги
                                <?php
                                if($reviewsNewCount > 0): ?>
                                    <span class="label label-warning pull-right"><?= $reviewsNewCount ?></span>
                                <?php endif ?>
                            </span>
                        </a>
                    </li>
                    <li>
                        <a href="#"><i class="fa fa-circle-o"></i> Ещё <span class="fa arrow"></span></a>
                        <ul class="nav nav-second-level collapse" style="height: 0px;">
                            <li class="<?= $this->context->id === 'news' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['news/index']) ?>">
                                    Новости
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'page' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['page/index']) ?>">
                                    Страницы
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'slider' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['slider/index']) ?>">
                                    Слайдер
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'slider' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['favorite-template/index']) ?>">
                                    Рекомендованное
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'banner' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['banner/index']) ?>">
                                    Баннер
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'service' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['service/index']) ?>">
                                    Доп. услуги
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'option' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['option/index']) ?>">
                                    Доп. комплектация
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'type' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['type/index']) ?>">
                                    Типы
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'category' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['category/index']) ?>">
                                    Категории
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'tag' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['tag/index']) ?>">
                                    Теги
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'hosting' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['hosting/index']) ?>">
                                    Хостинг
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'subscribe' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['subscribe/index']) ?>">
                                    Подписчики
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'snippet' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['snippet/index']) ?>">
                                    Сниппеты
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'paymaster' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['paymaster/index']) ?>">
                                    Paymaster
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'seller-request' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['seller-request/index']) ?>">
                                    Запросы от вебмастеров
                                </a>
                            </li>
                            <li class="<?= $this->context->id === 'meta' ? 'active' : '' ?>">
                                <a href="<?= Url::to(['meta/index']) ?>">
                                    Метатеги
                                </a>
                            </li>
                        </ul>
                    </li>
                </ul>
            </div>
        </nav>

        <div id="page-wrapper" class="gray-bg">
            <div class="row border-bottom">
                <nav class="navbar navbar-static-top" role="navigation"
                     style="margin-bottom: 0">
                    <div class="navbar-header">
                        <a class="navbar-minimalize minimalize-styl-2 btn btn-primary"
                           href="#"><i class="fa fa-bars"></i> </a>
                    </div>
                    <ul class="nav navbar-top-links navbar-right">
                        <li>
                            <a href="<?= Url::to(['default/logout']) ?>">
                                <i class="fa fa-sign-out"></i> Выход
                            </a>
                        </li>
                    </ul>

                </nav>
            </div>

            <?php if (isset($this->blocks['header'])): ?>
                <?= $this->blocks['header'] ?>
            <?php endif ?>
            <div class="alert-container">
                <?= Yii::$app->session->hasFlash('error') ? Alert::widget([
                    'body' => Yii::$app->session->getFlash('error'),
                    'options' => [
                        'class' => 'alert alert-warning alert-dismissible fade in'
                    ]
                ]) : '' ?>
            </div>
            <?= $content ?>
        </div>
    </div>
<?php $this->endContent(); ?>


<div class="modal fade" id="deleteModal" tabindex="-1" role="dialog">
    <div class="modal-dialog" role="document">
        <div class="modal-content">
            <? $form = \yii\widgets\ActiveForm::begin([
                'action' => Url::to([Yii::$app->controller->id . '/delete'])
            ]); ?>
            <div class="modal-header">
                <button type="button" class="close" data-dismiss="modal" aria-label="Close"><span aria-hidden="true">&times;</span></button>
                <h4 class="modal-title">Вы уверены, что хотите удалить этот элемент?</h4>
            </div>
            <div class="modal-body">
                <h5>Для удаления введите пароль</h5>

                <div class="">
                    <?= Html::input('password', 'Delete[password]', '', ['class' => 'form-control']) ?>
                </div>
                <?= Html::input('hidden', 'Delete[id]', '', ['class' => 'id-field']) ?>
            </div>
            <div class="modal-footer">
                <button type="button" class="btn btn-default" data-dismiss="modal">Отмена</button>
                <button type="submit" class="btn btn-primary">Удалить</button>
            </div>
            <? $form->end(); ?>
        </div><!-- /.modal-content -->
    </div><!-- /.modal-dialog -->
</div><!-- /.modal -->
