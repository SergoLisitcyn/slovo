<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "blog".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 * @property string|null $content
 * @property string|null $text_preview
 * @property string|null $date
 * @property string|null $title
 * @property string|null $description
 * @property string|null $keywords
 * @property int|null $sort
 * @property int|null $status
 */
class Blog extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'blog';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['content','text_preview'], 'string'],
            [['date'], 'safe'],
            [['sort', 'status'], 'integer'],
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
