<?php

namespace app\widgets\profileblock;

use app\models\Payout;
use app\models\Template;
use app\models\User;
use yii\base\Widget;

/**
 * Class ProfileBlock
 * @package app\widgets\profileblock
 */
class ProfileBlock extends Widget
{
    /**
     * @return string
     */
    public function run()
    {
        /** @var User $user */
        $user = User::findOne(\Yii::$app->user->id);
        if (!$user) {
            return null;
        }

        $availableSum = $user->getAvailableIncome();
        $blockedSum = $user->getHoldIncome();
        $templatesCount = Template::find()->where([
            'user_id' => $user->id,
            'status' => Template::STATUS_AVAILABLE,
            'is_deleted' => 0
        ])->count();

        return $this->render('view', compact('user', 'availableSum', 'blockedSum', 'templatesCount'));
    }
}