<?php

namespace app\models\user;

/**
 * This is the model class for table "template".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $title
 * @property string $demo_url
 * @property string $price
 * @property string $type_id
 * @property string $new_price
 * @property string $discount_date
 * @property string $discount_start_date
 * @property integer $is_free
 * @property string $description
 * @property string $rating
 * @property string $sales_count
 * @property string $features
 * @property string $version_history
 * @property string $created_at
 * @property string $label
 * @property string $moderate_status
 * @property string $is_deleted
 * @property string $alias
 * @property string $meta_keywords
 * @property string $meta_description
 * @property string $meta_title
 *

 */
class Template extends \app\models\Template
{

    /**
     * @inheritdoc
     */
    public function rules()
    {
        $rules = parent::rules();
        unset($rules['meta']);
        return $rules;
    }

}