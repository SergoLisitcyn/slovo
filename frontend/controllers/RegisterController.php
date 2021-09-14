<?php

namespace frontend\controllers;

use common\models\Calculator;
use Yii;
use common\models\Register;
use yii\data\ActiveDataProvider;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;

/**
 * RegisterController implements the CRUD actions for Register model.
 */
class RegisterController extends Controller
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
     * Lists all Register models.
     * @return mixed
     */
    public function actionIndex()
    {
//        var_dump($_POST);die;
        $this->layout = 'main-register';
        $settings = Calculator::findOne(1);
        $settingsRate = (isset($settings->rate) and !empty($settings->rate)) ? floatval($settings->rate) : 0.0019;
        $condition = [
            "id" => 1,
            "ruleViolationPercent" => 2.81,
            "amountMin" => intval($settings->min_amount),
            "amountMax" => intval($settings->amount),
            "termMin" => intval($settings->min_term),
            "termMax" => intval($settings->term),
            "rate" => $settingsRate,
            "amountStep" => intval($settings->amount_step),
            "termStep" => intval($settings->term_step),
            "product" => 1
        ];
        $conditions[] = $condition;

        return $this->render('index', [
            'conditions' => $conditions,
            'settingsRate' => $settingsRate
        ]);
    }


    /**
     * Finds the Register model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Register the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id)
    {
        if (($model = Register::findOne($id)) !== null) {
            return $model;
        }

        throw new NotFoundHttpException('The requested page does not exist.');
    }
}
