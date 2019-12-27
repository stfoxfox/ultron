<?php

use yii\helpers\Url;
use yii\helpers\Html;
use app\components\inspinia\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\Payout */
/* @var $user app\models\User */

$this->title = 'Создать выплату';
$this->params['pageHeader'] = $this->title;
$this->params['breadcrumbs'][] = ['label' => 'Выплаты', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;

?>

<?php $this->beginBlock('header') ?>
<div class="row wrapper border-bottom white-bg page-heading">
    <div class="col-lg-8">
        <h2><?= Html::encode($this->title) ?></h2>
        <?= Breadcrumbs::widget(['links' => $this->params['breadcrumbs']]) ?>
    </div>
    <div class="col-lg-4">
        <div class="title-action">
            <a href="#" class="btn btn-primary"
               onclick="$('#page-form').submit();return false">Сохранить</a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="wrapper wrapper-content">
    <?= $this->render('_form', [
        'model' => $model,
        'user' => $user,
    ]) ?>
</div>
