<?php

use app\widgets\topmenu\TopMenu;
use app\widgets\profileblock\ProfileBlock;

/** @var $invoice \app\models\Invoice */
/** @var $this \yii\web\View */

?>

<div class="title-h2">Заказ <?= $invoice->getDisplayNumber() ?></div>
