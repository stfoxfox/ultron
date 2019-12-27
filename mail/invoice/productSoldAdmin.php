<?php

/** @var $invoice app\models\Invoice */

$templates = $invoice->invoiceTemplates;
$i = 1;
?>

Покупатель:
<a href="<?= Yii::$app->urlManager->createAbsoluteUrl([
    'admin/user/view',
    'id' => $invoice->user->id
]) ?>">
    <?= $invoice->user->username?>
</a>

<h2>Куплены следующие товары:</h2>

<table border="1" cellspacing="0"  cellpadding="15">
    <thead>
        <tr>
            <th>#</th>
            <th>Наименование шаблона</th>
            <th>Автор</th>
            <th>Цена</th>
        </tr>
    </thead>
    <tbody>
        <? foreach ($templates as $template): ?>
            <tr>
                <td><?= $i ?></td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl([
                        'template/view',
                        'id' => $template->template_id
                    ]) ?>">
                        <?= $template->template->title ?>
                    </a>
                </td>
                <td>
                    <a href="<?= Yii::$app->urlManager->createAbsoluteUrl([
                        'admin/webmaster/view',
                        'id' => $template->template->user_id
                    ]) ?>">
                        <?= $template->template->user->username?>
                    </a>
                </td>
                <td><?= $template->template->getActualPrice() ?> руб.</td>
            </tr>
            <? if ($template->invoiceOptions): ?>
                <tr>
                    <th colspan="4">Дополнительные опции к этому товару:</th>
                </tr>
                <? foreach ($template->invoiceOptions as $option): ?>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <?= $option->option->title ?>
                        </td>
                        <td>
                            <?= $option->option->price ?>
                        </td>
                    </tr>
                <? endforeach ?>
            <? endif ?>
            <? if ($template->invoiceServices): ?>
                <tr>
                    <th colspan="4">Дополнительные услуги к этому товару:</th>
                </tr>
                <? foreach ($template->invoiceServices as $service): ?>
                    <tr>
                        <td></td>
                        <td colspan="2">
                            <?= $service->service->title ?>
                        </td>
                        <td>
                            <?= $service->service->price ?> руб.
                        </td>
                    </tr>
                <? endforeach ?>
            <? endif ?>
            <? $i++ ?>
        <? endforeach ?>
    </tbody>
</table>