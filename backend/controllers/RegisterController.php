<?php

namespace backend\controllers;

use Yii;
use common\models\Register;
use common\models\PaymentStatus;
use common\models\PaymentSlip;
use common\models\ResultSlip;
use common\models\PaperSubmission;
use backend\models\RegisterSearch;
use yii\web\Controller;
use yii\filters\VerbFilter;
use yii\filters\AccessControl;

/**
 * RegisterController implements the CRUD actions for Register model.
 */
class RegisterController extends Controller {

    public function behaviors() {
        return [
            'access' => [
                'class' => AccessControl::className(),
                'rules' => [
                    [
                        'allow' => true,
                        'roles' => ['@'],
                    ],
                ],
            ],
            'verbs' => [
                'class' => VerbFilter::className(),
                'actions' => [
                    'loadpaymentfile' => ['POST'],
                    'loadpaperfile' => ['POST'],
                ],
            ],
        ];
    }

    public function actionIndex() {
        $searchModel = new RegisterSearch();
        $params = Yii::$app->request->queryParams;
        $dataProvider = $searchModel->search($params);

        return $this->render('index', [
                    'searchModel' => $searchModel,
                    'params' => $params,
                    'dataProvider' => $dataProvider,
        ]);
    }

    public function actionApprovepaymentfile($id) {
        $model = $this->findModel($id);
        PaymentStatus::AddStatus($model->id, PaymentStatus::STATUS_PAID);
        $this->mailNotification($model);
        return $this->redirect(['view', 'id' => $id]);
    }

    public function actionRejectpaymentfile($id) {
        $model = $this->findModel($id);
        PaymentStatus::AddStatus($model->id, PaymentStatus::STATUS_CONFIRM_AGAIN);
        $this->mailNotification($model);
        return $this->redirect(['view', 'id' => $id]);
    }


    private function mailNotification($model) {
        Yii::$app->mailer->compose(
                        ['html' => 'updatePaymentStatus-html', 'text' => 'updatePaymentStatus-text'], ['register' => $model])
                ->setFrom([Yii::$app->params['adminEmail'] => '99StepRun'])
                ->setTo($model->email)
                ->setSubject('แจ้งเตือนสถานะการโอนเงิน | ' . $model->lastPaymentStatus->statusName)
                ->send();
    }

    public function actionExcel() {
        $searchModel = new RegisterSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams, false);
        if (Yii::$app->request->get('RegisterSearch') && $dataProvider->totalCount > 0) {
            return $this->render('_excel', [
                        'searchModel' => $searchModel,
                        'dataProvider' => $dataProvider,
            ]);
        } else {
            return $this->redirect(['index']);
        }
    }

    public function actionView($id) {
        $model = $this->findModel($id);
        if ($model->lastPaymentStatus->isWaitForCheckPayment) {
            PaymentStatus::AddStatus($model->id, PaymentStatus::STATUS_WAIT_FOR_APPROVE_PAYMENT);
        }
        return $this->render('view', [
                    'model' => $model,
        ]);
    }

    public function actionDelete($id) {
        $model = $this->findModel($id);
        $name = $model->fullname;
        $model->fullDelete();
        Yii::$app->session->setFlash('success', '<span class="fa fa-trash" aria-hidden="true"></span>&nbsp;&nbsp; ลบข้อมูล '.$name.' เรียบร้อย');
        return $this->redirect(['index']);
    }


    public function actionPending($id) {
        $model = $this->findModel($id);
        $name = $model->fullname;
        $model->pending();
        Yii::$app->session->setFlash('success', '<span class="fa fa-trash" aria-hidden="true"></span>&nbsp;&nbsp; ซ่อนข้อมูล '.$name.' เรียบร้อย');
        return $this->redirect(['index']);
    }

    public function actionLoadpaymentfile($id) {
        $model = $this->findModelPaymentSlip($id);
        $filepath = Yii::getAlias('@frontend') . '/web/' . $model->path;
        $ext = end((explode(".", $model->path)));
        if (file_exists($filepath)) {
            if ($ext == 'pdf') {
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Content-Type: application/pdf');
                header('Content-Disposition: inline; filename=' . str_replace('uploads/payment/', '', $model->path));
                header('Content-Length: ' . filesize($filepath));
                readfile("$filepath");
            } else {
                header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
                header('Content-Description: File Transfer');
                header('Content-Type: application/octet-stream');
                header('Content-Disposition: attachment; filename=' . str_replace('uploads/payment/', '', $model->path));
                header('Content-Length: ' . filesize($filepath));
                readfile("$filepath");
            }
        } else {
            echo "file not exist: " . $filepath;
        }
        exit;
    }

    public function actionUpdate($id) {
        $model = $this->findModel($id);

        if ($model->load(Yii::$app->request->post()) && $model->save()) {
            Yii::$app->session->setFlash('success', '<span class="fa fa-check" aria-hidden="true"></span>&nbsp;&nbsp; แก้ไขข้อมูลเรียบร้อย');
            return $this->redirect(['view', 'id' => $model->id]);
        } else {
            return $this->render('update', [
                        'model' => $model,
            ]);
        }
    }

    //TODO Fucntion for record result in backand (receive 2 variables [id,resut])
        public function actionRecresult($id) {
          $resultmodel = $this->findModelResultSlip($id);
          if ($resultmodel->load(Yii::$app->request->post()) && $resultmodel->save()) {
              Yii::$app->session->setFlash('success', '<span class="fa fa-check" aria-hidden="true"></span>&nbsp;&nbsp; บันทึกข้อมูลระยะการวิ่งเรียบร้อย');
              return $this->redirect(['view', 'id' => $resultmodel->register_id]);
          }
          return $this->render('recresult', [
                      'resultmodel' => $resultmodel,
          ]);
        }


    protected function findModel($id) {
        if (($model = Register::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPaymentSlip($id) {
        if (($model = PaymentSlip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelResultSlip($id) {
        if (($model = ResultSlip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

}
