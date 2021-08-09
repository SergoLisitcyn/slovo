<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;

/**
 * This is the model class for table "reviews".
 *
 * @property int $id
 * @property string $name
 * @property string|null $city
 * @property string $email
 * @property string $text
 * @property string|null $image
 * @property int $created_at
 * @property int $updated_at
 * @property int|null $status
 * @property int|null $sort
 */
class Reviews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'reviews';
    }

    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            TimestampBehavior::className(),
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'email', 'text'], 'required'],
            [['text'], 'string'],
            [['created_at', 'updated_at', 'status', 'sort'], 'integer'],
            [['name', 'city', 'email', 'image'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Имя',
            'city' => 'Город',
            'email' => 'Email',
            'text' => 'Сообщение',
            'image' => 'Изображение',
            'created_at' => 'Дата создания',
            'updated_at' => 'Updated At',
            'status' => 'Статус',
            'sort' => 'Сортировка',
        ];
    }
}
