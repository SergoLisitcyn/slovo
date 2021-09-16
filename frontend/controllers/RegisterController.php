<?php

namespace frontend\controllers;

use common\models\Calculator;
use common\models\OtkazPage;
use common\models\Partners;
use Yii;
use common\models\Register;
use yii\web\Controller;
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
     * @return string
     */
    public function actionIndex()
    {
        $this->layout = 'main-register';
        $settings = Calculator::findOne(1);
        $settingsRate = (isset($settings->rate) && !empty($settings->rate)) ? floatval($settings->rate) : 0.0019;
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

    public function actionSuccess()
    {
        $cookie = null;
        $dataUtm = Register::getUtm($cookie);

        $model = new Register();
        if ($model->load(Yii::$app->request->post())) {
            $post = Yii::$app->request->post();
            $yesterday = time() - 3600*24;
            $searchInn = Register::find()
                ->where(['tin' => $post['Register']['tin']])
                ->andWhere(['not',['link'=>null]])
                ->andWhere(['>', 'created_at', $yesterday])
                ->orderBy(['id' => SORT_DESC])
                ->one();

            if($searchInn) return $this->redirect($searchInn['link']);

            $dataSexNewDate = Register::getSex($model);
            $model->sex = $dataSexNewDate['sex'];
            $model->birthdate = $dataSexNewDate['newDate'];
            if ($model->save(false)) {
                $dataSig = [
                    "surname" => $model['surname'],
                    "name" => $model['name'],
                    "patronymic" => $model['patronymic'],
                    "sex" => $model['sex'],
                    "mobile" => $model['phone'],
                    "passport_id" => $model['tin'],
                    "birthdate" => $model['birthdate'],
                    "residence" => 'Астана',
                    "amount" => $model['amount'],
                    "term" => $model['term'],
                ];

                $signature = base64_encode(sha1(json_encode($dataSig) . $dataUtm['password'], true));
                $response = Register::getApiSlovoCheck($dataUtm['partnerId'],$dataSig,$signature);
                if(isset($response['error'])) return $this->redirect('register/credit');

                if($response['response'] == 'OK'){
                    $response = Register::getApiSlovoLink($dataUtm['partnerId'],$dataSig,$signature);
                    if(isset($response['error'])) if($response['error'] == 'Повторный запрос')  return $this->redirect('register/credit');

                    if(isset($response['link'])){
                        $model->link = $response['link'].'?=&'.$dataUtm['linkUtm'];
                        $model->save();

                        $query_str = parse_url($response['link'], PHP_URL_QUERY);
                        parse_str($query_str, $query_params);

                        $linkRedirect = $response['link'].'?=&'.$dataUtm['linkUtm'];
                        if(!empty($query_params)) $linkRedirect = $response['link'].'&'.$dataUtm['linkUtm'];

                        if($response['response'] == 'new person added'){
                            return $this->redirect($linkRedirect);
                        } elseif ($response['response'] == 'moved to broker'){
                            return $this->render('register/success', [
                                'model' => $model,
//                                'settings' => $settings,
                                'link' => $linkRedirect,
                            ]);
                        } else {
                            return $this->redirect('register/credit');
                        }
                    } else {
                        return $this->redirect('register/credit');
                    }
                } else {
                    return $this->redirect('register/credit');
                }
            } else {
                Yii::$app->session->setFlash(
                    'error',
                    'Ошибка.'
                );
            }
        }
    }

    public function actionCredit()
    {
        $this->layout = 'main-register';
        $partners = Partners::find()->where(['status' => 1])->orderBy(['sort' => SORT_ASC])->asArray()->all();
        $otkazPage = OtkazPage::findOne(1);

        return $this->render('credit', [
            'otkazPage' => $otkazPage,
            'partners' => $partners
        ]);
    }
}
