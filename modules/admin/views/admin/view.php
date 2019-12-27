<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\components\inspinia\Breadcrumbs;
use yii\widgets\DetailView;

/* @var $this yii\web\View */
/* @var $model app\models\User */

$this->title = 'Просмотр админа';
$this->params['pageHeader'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Админы', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-6">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    </div>
    <div class="col-lg-6">
        <div class="title-action">
            <a href="<?= Url::to(['index']) ?>" class="btn btn-white">&larr;
                Вернуться назад</a>
            <a href="<?= Url::to(['update', 'id' => $model->id]) ?>" class="btn btn-info">Редактировать</a>
            <a href="#" class="btn btn-danger"
               onclick="return confirm('Вы действительно хотите безвозвратно удалить этого пользователя?');">Удалить</a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="wrapper wrapper-content">
    <div class="row">
        <div class="col-lg-12">
            <div class="tabs-container">
                <ul class="nav nav-tabs">
                    <li class="active"><a data-toggle="tab" href="#tab-1" aria-expanded="true">Общие сведения</a></li>
                </ul>
                <div class="tab-content">
                    <div id="tab-1" class="tab-pane active">
                        <div class="panel-body">
                            <?= DetailView::widget([
                                'model' => $model,
                                'attributes' => [
                                    'id',
                                    'username',
                                    'email:email',
                                    'created_at:date',
                                    'displayStatus',
                                ],
                            ]) ?>
                        </div>
                    </div>
                </div>
            </div>
        </div>
    </div>
</div>
