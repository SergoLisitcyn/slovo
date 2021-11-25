<?php

namespace common\models;

use Yii;
use yii\behaviors\TimestampBehavior;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

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
    public $mainfile;
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
            [['mainfile'], 'file'],
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
            'mainfile' => 'Изображение',
        ];
    }

    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $imageSquareFile = UploadedFile::getInstance($this, 'mainfile');
        if ($imageSquareFile) {
            $directory = Yii::getAlias('@frontend/web/uploads/images/reviews/main-image') . DIRECTORY_SEPARATOR;
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            $uid = date('YmdHs').Yii::$app->security->generateRandomString(6);
            $fileName = $uid . '-reviews_image.' . $imageSquareFile->extension;
            $filePath = $directory . $fileName;
            if ($imageSquareFile->saveAs($filePath)) {
                $path = '/uploads/images/reviews/main-image/' . $fileName;

                @unlink(Yii::getAlias('@frontend/web') . $this->mainfile);
                $this->setAttribute('image', $path);
                $this->save();
            }
        }
    }
}
