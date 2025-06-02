<?php

namespace app\traits;

use Yii;
use app\models\ModelLog;
use yii\db\Exception;

trait LoggableTrait
{
    /**
     * @return array
     */
    public static function getLoggableAttributes(): array
    {
        return [];
    }

    /**
     * @return void
     * @throws Exception
     */
    public function logChanges(): void
    {
        $attributesToLog = static::getLoggableAttributes();

        if (empty($attributesToLog)) {
            return;
        }

        foreach ($attributesToLog as $attribute) {
            if ($this->isAttributeChanged($attribute)) {
                $old = $this->getOldAttribute($attribute);
                $new = $this->$attribute;

                // Записываем в базу
                ModelLog::create([
                    'model_name' => static::class,
                    'model_id' => $this->primaryKey,
                    'attribute' => $attribute,
                    'old_value' => (string)$old,
                    'new_value' => (string)$new,
                ]);
            }
        }
    }
}