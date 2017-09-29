<?php

namespace app\models;

use Yii;

/**
 * This is the model class for table "tables".
 *
 * @property integer $id
 * @property string $name
 * @property string $timestamp
 * @property string $json
 */
class JsonTable extends \yii\db\ActiveRecord
{
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'tables';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['name', 'json'], 'required'],
            [['timestamp'], 'safe'],
            [['name'], 'string', 'max' => 255],
            [['json'], 'string', 'max' => 5000],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'timestamp' => 'Timestamp',
            'json' => 'Json',
        ];
    }
}
