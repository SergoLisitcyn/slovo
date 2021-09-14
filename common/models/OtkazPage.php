<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "otkaz_page".
 *
 * @property int $id
 * @property string|null $title
 * @property string|null $text_top
 * @property string|null $text_bottom
 * @property string|null $title_seo
 * @property string|null $description
 * @property string|null $keywords
 */
class OtkazPage extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'otkaz_page';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['text_top', 'text_bottom'], 'string'],
            [['title', 'title_seo', 'description', 'keywords'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Title',
            'text_top' => 'Text Top',
            'text_bottom' => 'Text Bottom',
            'title_seo' => 'Title Seo',
            'description' => 'Description',
            'keywords' => 'Keywords',
        ];
    }
}
