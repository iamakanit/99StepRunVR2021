<?php
namespace frontend\controllers;

use Yii;
use yii\web\Controller;
use common\models\Register;



/**
 * Site controller
 */
class SiteController extends Controller
{

    public function actions()
    {
        return [
            'error' => [
                'class' => 'yii\web\ErrorAction',
            ],
            'captcha' => [
                'class' => 'yii\captcha\CaptchaAction',
                'fixedVerifyCode' => YII_ENV_TEST ? 'testme' : null,
            ],
        ];
    }

    public function actionIndex()
    {
        return $this->render('index');
    }

    public function actionMap()
    {
        return $this->render('map');
    }

    public function actionPrivileges()
    {
        return $this->render('privileges');
    }

    public function actionRule()
    {
        return $this->render('rule');
    }

    public function actionPrereg()
    {
        return $this->render('prereg');
    }

    public function actionPrecreate()
    {
        return $this->render('precreate');
    }

    public function actionVcreate()
    {
        return $this->render('vcreate');
    }



    public function actionGetallregis() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $json = Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'json' => $json,
                'amount' => Register::find()->count(),
            ];
        }
    }
}
