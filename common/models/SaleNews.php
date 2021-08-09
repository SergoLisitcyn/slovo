<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "sale_news".
 *
 * @property int $id
 * @property int|null $type
 * @property string $name
 * @property string $url
 * @property string|null $text_preview
 * @property string|null $content
 * @property string|null $date
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @property int|null $sort
 * @property int|null $status
 */
class SaleNews extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'sale_news';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['type', 'sort', 'status'], 'integer'],
            [['name', 'url'], 'required'],
            [['text_preview', 'content'], 'string'],
            [['date'], 'safe'],
            [['name', 'url', 'title', 'description', 'keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'type' => 'Тип',
            'name' => 'Название',
            'url' => 'Url',
            'content' => 'Контент',
            'date' => 'Дата',
            'text_preview' => 'Короткое описание',
            'title' => 'Title',
            'description' => 'Description',
            'keywords' => 'Keywords',
            'sort' => 'Сортировка',
            'status' => 'Статус',
        ];
    }
}
