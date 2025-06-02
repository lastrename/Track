<?php

namespace app\models;

use app\traits\LoggableTrait;
use yii\behaviors\TimestampBehavior;
use yii\db\ActiveRecord;

/**
 * Track model
 *
 * @property int $id
 * @property string $track_number Unique track number
 * @property string $status Status of track (new, in_progress, completed, failed, canceled)
 * @property int $created_at Creation timestamp
 * @property int $updated_at Update timestamp
 */
class Track extends ActiveRecord
{
    use LoggableTrait;

    public static function getLoggableAttributes(): array
    {
        return ['track_number', 'status'];
    }

    const STATUS_NEW = 'new';
    const STATUS_IN_PROGRESS = 'in_progress';
    const STATUS_COMPLETED = 'completed';
    const STATUS_FAILED = 'failed';
    const STATUS_CANCELED= 'canceled';

    const STATUS_LIST = [
        self::STATUS_NEW => 'New',
        self::STATUS_IN_PROGRESS => 'In progress',
        self::STATUS_COMPLETED => 'Completed',
        self::STATUS_FAILED => 'Failed',
        self::STATUS_CANCELED => 'Canceled',
    ];

    /**
     * {@inheritdoc}
     */
    public function behaviors(): array
    {
        return [
            TimestampBehavior::class,
        ];
    }

    /**
     * {@inheritdoc}
     */
    public static function tableName(): string
    {
        return '{{%track}}';
    }

    /**
     * {@inheritdoc}
     */
    public function rules(): array
    {
        return [
            [['track_number', 'status'], 'required'],
            ['track_number', 'unique'],
            ['track_number', 'string'],
            ['status', 'in', 'range' => array_keys(self::STATUS_LIST)],
            [['created_at', 'updated_at'], 'integer'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels(): array
    {
        return [
            'id' => 'ID',
            'track_number' => 'Track Number',
            'status' => 'Status',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * Get status label
     * @return string
     */
    public function getStatusLabel(): string
    {
        return self::STATUS_LIST[$this->status] ?? $this->status;
    }

    /**
     * Check if track is completed
     * @return bool
     */
    public function isCompleted(): bool
    {
        return $this->status === self::STATUS_COMPLETED;
    }

    /**
     * {@inheritdoc}
     */
    public function afterSave($insert, $changedAttributes): void
    {
        parent::afterSave($insert, $changedAttributes);
        $this->logChanges();
    }
}
