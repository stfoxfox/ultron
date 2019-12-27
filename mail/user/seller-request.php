<?php

/** @var $user app\models\SellerRequest */

?>

<h2>Данные вебмастера</h2>

<table>
    <tr>
        <td><b>Имя:</b></td>
        <td><?= $user->name ?></td>
    </tr>
    <tr>
        <td><b>Емаил:</b></td>
        <td><?= $user->email ?></td>
    </tr>
    <tr>
        <td><b>Сообщение:</b></td>
        <td><?= $user->message ?></td>
    </tr>
    <tr>
        <td><b>Скайп:</b></td>
        <td><?= $user->skype ?></td>
    </tr>
</table>