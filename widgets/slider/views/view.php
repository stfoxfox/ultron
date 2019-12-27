<?php

use app\components\File;

?>

<div class="top-slider-wrapper white">
    <div class="top-slider">
        <?php foreach ($models as $i => $model): ?>
            <?= $model->snippet; ?>
        <?php endforeach; ?>
    </div>
</div>