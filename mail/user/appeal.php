<?php
/** @@var \app\models\User $author*/
/** @var \app\models\Review $review*/
/** @var string $link*/
?>
<div>
    <div>Внимание жалоба к комментарию!</div>
    <div>Автор жалобы: <?=$author->username?></div>
    <div>id комментария: <?=$review->id?></div>
    <div>Текст сообщения: <?=$appeal?></div>
    <div>Ссылка на страницу комментариев: <?=$link?></div>
    <div></div>
</div>