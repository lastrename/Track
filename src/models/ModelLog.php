<?php

namespace app\models;

use yii\db\ActiveRecord;
use yii\db\Exception;

class ModelLog extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%model_log}}';
    }

    /**
     * @param $data
     * @return bool
     * @throws Exception
     */
    public static function create($data): bool
    {
        $modelChange = new self();
        $modelChange->attributes = $data;
        return $modelChange->save();
    }
}
