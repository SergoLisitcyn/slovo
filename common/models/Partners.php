<?php

namespace common\models;

use Yii;
use yii\helpers\FileHelper;
use yii\web\UploadedFile;

/**
 * This is the model class for table "partners".
 *
 * @property int $id
 * @property string|null $image
 * @property string|null $advantages
 * @property string $srok
 * @property string $stavka
 * @property string $summa
 * @property string $link
 * @property int|null $best_deal
 * @property string|null $gesv
 * @property int|null $sort
 * @property int|null $status
 */
class Partners extends \yii\db\ActiveRecord
{
    public $image_file;
    public function afterSave($insert, $changedAttributes)
    {
        parent::afterSave($insert, $changedAttributes);

        $imageSquareFile = UploadedFile::getInstance($this, 'image_file');

        if ($imageSquareFile) {
            $directory = Yii::getAlias('@frontend/web/uploads/partners') . DIRECTORY_SEPARATOR;
            if (!is_dir($directory)) {
                FileHelper::createDirectory($directory);
            }

            $uid = date('YmdHs').Yii::$app->security->generateRandomString(6);
            $fileName = $uid . '.' . $imageSquareFile->extension;
            $filePath = $directory . $fileName;
            if ($imageSquareFile->saveAs($filePath)) {
                $path = '/uploads/partners/' . $fileName;

                @unlink(Yii::getAlias('@frontend/web') . $this->image);
                $this->setAttribute('image', $path);
                $this->save();
            }
        }
    }
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'partners';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['srok', 'stavka', 'summa', 'link'], 'required'],
            [['best_deal', 'sort', 'status'], 'integer'],
            [['image', 'advantages', 'srok', 'stavka', 'summa', 'link', 'gesv'], 'string', 'max' => 255],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'image' => 'Изображение',
            'image_file' => 'Логотип',
            'advantages' => 'Преимущества',
            'srok' => 'Срок',
            'stavka' => 'Ставка',
            'summa' => 'Сумма',
            'link' => 'Партнерская ссылка',
            'sort' => 'Сортировка',
            'status' => 'Статус',
            'best_deal' => 'Лучшее предложение',
            'gesv' => 'ГЭСВ',
        ];
    }
}
