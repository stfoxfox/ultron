<?php
use app\widgets\review\Reviews;

echo Reviews::widget([
    'model' => $model,
    'jsOptions' => [
        'offset' => 80
    ]
]);