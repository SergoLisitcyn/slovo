<?php

namespace frontend\controllers;

use Yii;
use common\models\SaleNews;
use common\models\SaleNewsSearch;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * SaleNewsController implements the CRUD actions for SaleNews model.
 */
class SaleNewsController extends Controller
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
     * Lists all SaleNews models.
     * @return mixed
     */
    public function actionIndex()
    {
        $searchModel = new SaleNewsSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('index', [
            'searchModel' => $searchModel,
            'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single SaleNews model.
     * @param integer $id
     * @return mixed
     * @throws NotFoundHttpException if the model cannot be found
     */
    public function actionView($id)
    {
        return $this->render('view', [
            'model' => $this->findModel($id),
        ]);
    }

    public function actionIndexNews()
    {
        $model = SaleNews::find()
            ->where(['status' => 1])
            ->andWhere(['type' => 0])
            ->all();
        return $this->render('index-news', [
            'model' => $model,
        ]);
    }

    public function actionIndexSales()
    {
        $model = SaleNews::find()
            ->where(['status' => 1])
            ->andWhere(['type' => 1])
            ->all();
        return $this->render('index-sales', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param string $url
     */
    public function actionSalesView($url)
    {
        if(!$url) return $this->redirect('/');

        $model = SaleNews::find()
            ->where(['status' => 1, 'url' => $url])
            ->one();
        return $this->render('sales-view', [
            'model' => $model,
        ]);
    }

    /**
     * Displays a single Blog model.
     * @param string $url
     */
    public function actionNewsView($url)
    {
        if(!$url) return $this->redirect('/');

        $model = SaleNews::find()
            ->where(['status' => 1, 'url' => $url])
            ->one();
        return $this->render('news-view', [
            'model' => $model,
        ]);
    }

    /**
     * Finds the SaleNews model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return SaleNews the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = SaleNews::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
