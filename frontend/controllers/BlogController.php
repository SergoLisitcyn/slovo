<?php

namespace frontend\controllers;

use Yii;
use common\models\Blog;
use common\models\BlogSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * BlogController implements the CRUD actions for Blog model.
 */
class BlogController extends Controller
{
    /**
     * {@inheritdoc}
     */
    public function behaviors()
    {
        return [
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'delete' => ['POST'],
                ],
            ],
        ];
    }

    /**
     * Lists all Blog models.
     * @return mixed
     */
    public function actionIndex()
    {
        $blogs = Blog::find()
            ->where(['status'=> 1])
            ->orderBy(['sort' => SORT_DESC])
            ->all();

        return $this->render('index', [
            'blogs' => $blogs
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param string $url
     */
    public function actionView($url)
    {
        if(!$url) return $this->redirect('/');

        $model = Blog::find()->where(['status' => 1, 'url' => $url])->one();
        return $this->render('view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the Blog model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Blog the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Blog::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
