<?php

use yii\helpers\Html;

/** @var $template \app\models\Template */
/** @var $orderForm \app\models\OrderForm */

?>

<div class="element open">
    <div class="title upper bold f11">Дополнительные услуги</div>
    <div class="scrollpane-block-wrapper">
        <ul class="scrollpane-block">
            <?php foreach ($services as $i => $model): ?>
                <li>
                    <div class="customcheck">
                        <input type="checkbox" name="CartForm[services][]"
                               id="extra_service_<?= $i ?>" value="<?= $model->id ?>">

                        <label for="extra_service_<?= $i ?>">
                            <i class="material-icons no-checked-icon">check_box_outline_blank</i>
                            <i class="material-icons checked-icon">check_box</i>
                            <?= \yii\helpers\Html::encode($model->title) ?>
                        </label>

                        <i class="material-icons help-icon">help</i>
                        <div class="hide">
                            <?= \yii\helpers\Html::encode($model->description) ?>
                        </div>
                    </div>
                    <div class="extra-element-price"
                         data-price="<?= $model->price ?>"><?= $model->price ?> р.
                    </div>
                </li>
            <?php endforeach; ?>
        </ul>
    </div>
</div>