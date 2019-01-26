<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "firm_bills".
 *
 * @property int $id
 * @property int $type
 * @property int $total_sum
 * @property string $created_at
 * @property string $updated_at
 */
class FirmBills extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'firm_bills';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type'], 'required'],
            [['type', 'total_sum'], 'integer'],
            [['created_at', 'updated_at'], 'safe'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Type',
            'total_sum' => 'Total Sum',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }
}
