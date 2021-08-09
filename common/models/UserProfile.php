<?php

namespace common\models;

use kartik\popover\PopoverX;
use Yii;
use common\models\User;
use karpoff\icrop\CropImageUploadBehavior;
use yii\helpers\Url;

/**
 * This is the model class for table "user_profile".
 *
 * @property integer $id
 * @property integer $user_id
 * @property string $full_name
 * @property string $public_email
 * @property string $profession
 * @property string $about_me
 * @property string $avatar
 * @property string $avatar_cropped
 * @property string $avatar_crop

 *
 * @property User $user
 */
class UserProfile extends \yii\db\ActiveRecord
{
    const DEFAULT_AVATAR = '/admin/images/user-placeholder.jpg';

    public $defaultAvatar = '/admin/images/user-placeholder.jpg';
    /**
     * @inheritdoc
     */
    public static function tableName()
    {
        return 'user_profile';
    }

    /**
     * @inheritdoc
     */
    public function rules()
    {
        return [
            [['user_id'], 'required'],
            [['user_id'], 'integer'],
            [['about_me'], 'string'],
            [['full_name','public_email', 'profession','avatar_cropped','avatar_crop'], 'string', 'max' => 255],
            ['avatar', 'file', 'extensions' => 'jpeg, jpg, gif, png', 'on' => ['insert', 'update']],
            [['user_id'], 'exist', 'skipOnError' => true, 'targetClass' => User::className(), 'targetAttribute' => ['user_id' => 'id']],
        ];
    }

    /**
     * @inheritdoc
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'user_id' => 'User ID',
            'full_name' => 'Full Name',
            'public_email' => 'Public Email',
            'address' => 'Address',
            'profession' => 'Profession',
            'gender' => 'Gender',
            'birthday' => 'Birthday',
            'martial_status' => 'Martial Status',
            'about_me' => 'About Me',
            'avatar' => 'Avatar',
            'avatar_crop' => 'Avatar',
            'avatar_cropped' => 'Avatar',
        ];
    }

    /**
     * @inheritdoc
     */
    function behaviors()
    {
        return [
            [
                'class' => CropImageUploadBehavior::className(),
                'attribute' => 'avatar',
                'scenarios' => ['insert', 'update'],
                'path' => '@backend/web/images/avatars',
                'url' => '@web/images/avatars',
                'ratio' => 1,
                'crop_field' => 'avatar_crop',
                'cropped_field' => 'avatar_cropped',
            ],
        ];
    }

    /**
     * @return \yii\db\ActiveQuery
     */
    public function getUser()
    {
        return $this->hasOne(User::className(), ['id' => 'user_id']);
    }

    /**
     * Generates Html PopUp with user details
     *
     * @param $user
     * @return string
     */
    public static function generateUserPopUp($user)
    {
        $profile = isset($user->profile) ? $user->profile : false;
        $fullName = ucfirst($user->username);
        $profileUrl = "#!";
        //Get data from profile if isset
        if($profile) {
            $fullName = $profile->full_name;
            $profileUrl = Url::toRoute(["/profile/view","id" => $profile->id]);
        }

        // Popup content when click on operator name
        $profileContent = Yii::$app->controller->renderPartial('@backend/views/profile/_popupView',[
            'user' => $user ? $user : false,
            'model' => $profile ? $profile : false
        ]);

        $html = PopoverX::widget([
            'header' => 'Profile Card',
            'type' => PopoverX::TYPE_PRIMARY,
            'placement' => PopoverX::ALIGN_RIGHT,
            'size' => PopoverX::SIZE_MEDIUM,
            'footer' => '<a href="'.$profileUrl.'" class="mbtn mbtn-gray"><i class="fa fa-user"></i> Open Profile</a>',
            'content' => $profileContent,
            'toggleButton' => [
                'tag' => 'a',
                'label' => $fullName,
                'style' => 'cursor:pointer;border-bottom: 1px dashed;'
            ],
        ]);

        return $html;
    }

    /**
     * @return string
     */
    public function getAvatar()
    {
        if ($this->avatar_cropped) {
            if (is_file(\Yii::$app->basePath."/web/images/avatars/".$this->avatar_cropped)) {
                return "/admin/images/avatars/".$this->avatar_cropped;
            }
        }
        return $this->defaultAvatar;
    }

    /**
     * @return string
     */
    public function getUserName()
    {
        if ($this->full_name) {
            return $this->full_name;
        }

        return $this->user ? $this->user->username : "Not Set";
    }

    /**
     * @return string
     */
    public function getPosition()
    {
        return $this->profession ? $this->profession : 'Not Set';
    }
}
