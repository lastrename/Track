<?php
namespace app\components;

use Yii;
use yii\db\ActiveRecord;

class ModelLogger
{
    /**
     * @param ActiveRecord $model
     */
    public static function logChanges(ActiveRecord $model): void
    {
        $oldAttributes = $model->getOldAttributes();
        $newAttributes = $model->attributes;

        foreach ($newAttributes as $name => $value) {
            if (isset($oldAttributes[$name]) && $oldAttributes[$name] != $value) {
                Yii::info(
                    "Атрибут '{$name}' изменен с '{$oldAttributes[$name]}' на '{$value}' в модели " . get_class($model),
                    'model'
                );
            }
        }
    }
}