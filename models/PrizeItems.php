<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prize_items".
 *
 * @property int $id
 * @property string $name
 * @property int $count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PrizeDelivery[] $prizeDeliveries
 */
class PrizeItems extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prize_items';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name'], 'required'],
            [['count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['name'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizeDeliveries()
    {
        return $this->hasMany(PrizeDelivery::className(), ['prize_item_id' => 'id']);
    }
}
