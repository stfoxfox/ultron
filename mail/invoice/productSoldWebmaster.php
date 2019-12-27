<?php
/**
 * Created by PhpStorm.
 * User: Ziyodulloxon
 * Date: 24.11.2017
 * Time: 10:53
 *
 * @var $template app\models\Template
 * @var $invoice app\models\Invoice
 *
 */

?>

<table border="1" cellspacing="0">
    <tr>
        <td>Номер заказа:</td>
        <td>#<?= $invoice->getDisplayNumber() ?></td>
    </tr>
    <tr>
        <td>Дата:</td>
        <td><?= date('Y-m-d h:i:s', time()) ?></td>
    </tr>
    <tr>
        <td>Артикул:</td>
        <td>#<?= $template->getDisplayArticle() ?></td>
    </tr>
    <tr>
        <td>Название шаблона:</td>
        <td>
            <a href="<?= Yii::$app->urlManager->createAbsoluteUrl(['template/view', 'id' => $template->id]) ?>">
                <?= \yii\helpers\Html::encode($template->title) ?>
            </a>
        </td>
    </tr>
    <tr>
        <td>Цена:</td>
        <td><?= $template->getActualPrice() ?></td>
    </tr>
    <tr>
        <td>Партнерский процент:</td>
        <td><?= $template->user->payoutPercent ?>%</td>
    </tr>
</table>


