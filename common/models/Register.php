<?php

namespace common\models;

use Yii;

/**
 * This is the model class for table "register".
 *
 * @property int $id
 * @property string $name
 * @property string $surname
 * @property string|null $patronymic
 * @property int $sex
 * @property string $phone
 * @property string $birthdate
 * @property string $tin
 * @property string $term
 * @property string|null $link
 * @property int $created_at
 * @property int $updated_at
 */
class Register extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'register';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'surname', 'sex', 'phone', 'birthdate', 'tin', 'term', 'created_at', 'updated_at'], 'required'],
            [['sex', 'created_at', 'updated_at'], 'integer'],
            [['name', 'surname', 'patronymic', 'phone', 'birthdate', 'tin', 'term', 'link'], 'string', 'max' => 255],
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
            'surname' => 'Surname',
            'patronymic' => 'Patronymic',
            'sex' => 'Sex',
            'phone' => 'Phone',
            'birthdate' => 'Birthdate',
            'tin' => 'Tin',
            'term' => 'Term',
            'link' => 'Link',
            'created_at' => 'Created At',
            'updated_at' => 'Updated At',
        ];
    }

    public static function getSex($model)
    {
        $year = substr($model['tin'], 0,2);
        $month = substr($model['tin'], 2,2);
        $day = substr($model['tin'], 4,2);
        $data = [];
        $sex = $model['tin']{6};
        $data['sex'] = '2';
        if($sex == 1 || $sex == 3 || $sex == 5) $data['sex'] = '1';

        if($sex == 3 || $sex == 4){
            $data['newDate'] = '19'.$year.'-'.$month.'-'.$day;
        } elseif($sex == 5 || $sex == 6) {
            $data['newDate'] = '20'.$year.'-'.$month.'-'.$day;
        } else {
            $data['newDate'] = '18'.$year.'-'.$month.'-'.$day;
        }

        return $data;
    }

    public static function getApiSlovoCheck($partnerId,$dataSig,$signature)
    {
        $data = [
            "partner" => $partnerId,
            "data" => $dataSig,
            "signature" => $signature,
            "method" => 'check',
        ];

        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => json_encode( $data ),
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            ],
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
        ];

        $context  = stream_context_create( $options );
        $result = file_get_contents( 'https://mfo-crm.4slovo.kz/requestAPI.php', false, $context );
        return json_decode( $result, true );
    }

    public static function getApiSlovoLink($partnerId,$dataSig,$signature)
    {
        $dataLink = [
            "partner" => $partnerId,
            "data" => $dataSig,
            "signature" => $signature,
        ];
        $options = [
            'http' => [
                'method'  => 'POST',
                'content' => json_encode( $dataLink ),
                'header'=>  "Content-Type: application/json\r\n" .
                    "Accept: application/json\r\n"
            ],
            "ssl"=>[
                "verify_peer"=>false,
                "verify_peer_name"=>false,
            ],
        ];

        $context  = stream_context_create( $options );
        $result = @file_get_contents( 'https://mfo-crm.4slovo.kz/requestAPI.php', false, $context );
        return json_decode( $result, true );
    }
}
