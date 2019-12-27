<?php

use yii\helpers\Html;
use yii\helpers\Url;
use app\components\inspinia\Breadcrumbs;

/* @var $this yii\web\View */
/* @var $model app\models\Meta */

$this->title = 'Create Meta';
$this->params['breadcrumbs'][] = ['label' => 'Metas', 'url' => ['index']];
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
            <a href="<?= Url::to(['index']) ?>" class="btn btn-white">&larr;
                Вернуться назад</a>
            <a href="#" class="btn btn-primary"
               onclick="$('#meta-form').submit();return false">Сохранить</a>
        </div>
    </div>
</div>
<?php $this->endBlock() ?>

<div class="wrapper wrapper-content">
    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>
</div>
