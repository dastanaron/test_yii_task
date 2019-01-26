<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "prize_delivery".
 *
 * @property int $id
 * @property int $user_id
 * @property int $prize_item_id
 * @property int $count
 * @property string $created_at
 * @property string $updated_at
 *
 * @property PrizeItems $prizeItem
 * @property Users $user
 */
class PrizeDelivery extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'prize_delivery';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id', 'prize_item_id', 'count'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
            [['prize_item_id'], 'exist', 'skipOnError' => true, 'targetClass' => PrizeItems::className(), 'targetAttribute' => ['prize_item_id' => 'id']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => Users::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'prize_item_id' => 'Prize Item ID',
            'count' => 'Count',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getPrizeItem()
    {
        return $this->hasOne(PrizeItems::className(), ['id' => 'prize_item_id']);
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(Users::className(), ['id' => 'user_id']);
    }
}
