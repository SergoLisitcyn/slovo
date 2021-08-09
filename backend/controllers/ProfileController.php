<?php

namespace backend\controllers;

use common\models\UserProfile;
use common\models\User;
use Yii;
use yii\data\ActiveDataProvider;
use yii\filters\AccessControl;
use yii\filters\VerbFilter;
use yii\web\Controller;
use yii\web\NotFoundHttpException;

/**
 * Class ProfileController
 * @package backend\controllers
 */
class ProfileController extends Controller
{
    public function behaviors()
    {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['admin','manager'],
                    ],
                    [
                        'allow' => false,
                        'roles' => ['client'],
                        'denyCallback' => function() { $this->redirect('/'); }
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'logout' => ['post'],
                ],
            ],
        ];
    }
    /**
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'empty';
        $user = Yii::$app->user->identity;
        $model = UserProfile::find()->where(['user_id' => $user->id])->one();

        if (is_null($model)) {
            $model = new UserProfile();
        }

        return $this->render('index',[
            'user' => $user,
            'model' => $model
        ]);
    }

    /**
     * @param $id
     * @return string
     * @throws NotFoundHttpException
     */
    public function actionView($id)
    {
        $model = UserProfile::findOne($id);
        if (!$model) {
            throw new NotFoundHttpException('This page doesn\'t exist');
        }
        $user = User::findIdentity($model->user_id);

        return $this->render('view',[
            'user' => $user,
            'model' => $model
        ]);
    }

    /**
     * @return string
     */
    public function actionList()
    {
        $dataProvider = new ActiveDataProvider([
            'query' => User::find()->with('profile')->where(['status' => User::STATUS_ACTIVE])->orderBy('username ASC'),
            'pagination' => [
                'pageSize' => 100,
            ],
        ]);

        return $this->render('profileList',[
            'dataProvider' => $dataProvider
        ]);
    }

    /**
     * @return bool
     */
    public function actionUpdate()
    {
        if (Yii::$app->request->isAjax) {
            $user = Yii::$app->user->identity;
            $model = UserProfile::find()->where(['user_id' => $user->id])->one();
            if (empty($model)) {
                $model = new UserProfile();
                $model->user_id = $user->id;
            }
            $model->load(Yii::$app->request->post());
            if($model->save()) {
                return true;
            }
            return false;
        }
    }

    /**
     *
     */
    public function actionUpload()
    {
        $user = Yii::$app->user->identity;
        $model = UserProfile::find()->where(['user_id' => $user->id])->one();

        if ($model) {
            $model->scenario = 'update';
        } else {
            $model = new UserProfile();
            $model->user_id = $user->id;
            $model->scenario = 'insert';
        }

        if ($model->load(Yii::$app->request->post())) {
            if($model->save()) $this->redirect(["/profile/index"]);
        }
    }

}
