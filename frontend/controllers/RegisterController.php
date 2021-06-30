<?php
namespace frontend\controllers;

use Yii;
use common\models\Register;
use common\models\VerifyForm;
use common\models\PaymentStatus;
use common\models\PaymentSlip;
use common\models\ResultSlip;
use common\models\Group;
use common\models\Shirt;
use common\models\Category;
use common\models\Code;
use frontend\models\RegisterSearch;
use frontend\models\CodeSearch;
use frontend\models\PaymentSlipForm;
use frontend\models\ResultSlipForm;
use frontend\models\AddressForm;
use yii\web\Controller;
use yii\web\NotFoundHttpException;
use yii\filters\VerbFilter;
use yii\web\Session;
use yii\helpers\ArrayHelper;
use yii\web\UploadedFile;

/**
 * RegisterController implements the CRUD actions for Register model.
 */
class RegisterController extends Controller {

  /**
   * @inheritdoc
   */
  public function behaviors() {
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
  public function actionIndex() {
    $searchModel = new RegisterSearch();
    $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

    return $this->render('index', [
                'searchModel' => $searchModel,
                'dataProvider' => $dataProvider,
    ]);
  }

    public function actionPrecreate() {
        $searchModel = new CodeSearch();
        $dataProvider = $searchModel->search(Yii::$app->request->queryParams);

        return $this->render('precreate', [
                    'searchModel' => $searchModel,
                    'dataProvider' => $dataProvider,
        ]);
    }

    /**
     * Displays a single Register model.
     * @param integer $id
     * @return mixed
     */
    public function actionView($id) {
        return $this->render('view', [
                    'model' => $this->findModel($id),
        ]);
    }

    /**
     * Creates a new Register model.
     * If creation is successful, the browser will be redirected to the 'view' page.
     * @return mixed
     */
    public function actionCreate($code=null) {
        if (!empty($group = Group::getRegisterGroup(false))) {
            if (!empty($group = Group::getRegisterGroup())) {
                $session = new Session;
                $model = new Register();
                $model->code_id = $code;
                $modelVerify = new VerifyForm();

                if ($model->load(Yii::$app->request->post()) && Yii::$app->request->post('action') == 'regis' && $model->validate()) {
                    if (in_array($model->group_id, ArrayHelper::getColumn($group, 'id'))) {
                        $session['model_active'] = true;
                        $session['modelRegis'] = $model;
                        return $this->render('summary', [
                                    'model' => $model,
                                    'modelVerify' => $modelVerify,
                        ]);
                    } else {
                        return $this->render('full', [
                                    'model' => $model,
                        ]);
                    }
                } elseif ($modelVerify->load(Yii::$app->request->post()) && $modelVerify->validate() && Yii::$app->request->post('action') == 'summary') {
                    $model = $session['modelRegis'];
                    $model->id_card = str_replace('-', '', $model->id_card);
                    $session['model_active'] = false;
                    $session->remove('modelRegis');
                    if (in_array($model->group_id, ArrayHelper::getColumn($group, 'id'))) {
                        if ($model->save()) {
                            $model->isPayBeforeStartWorkshop ? PaymentStatus::AddStatus($model->id,PaymentStatus::STATUS_PAY_BEFORE_START_WORKSHOP) : PaymentStatus::AddStatus($model->id);
                            return $this->render('success', [
                                        'model' => $model,
                            ]);
                        }
                    } else {
                        return $this->render('full', [
                                    'model' => $model,
                        ]);
                    }
                }
                if ($session['model_active'] == true) {
                    $model = $session['modelRegis'];
                    $session['model_active'] = false;
                    $session->remove('modelRegis');
                }
                return $this->render('create', [
                            'model' => $model,
                            'group' => $group,
                ]);
            } else {
                return $this->render('full');
            }
        } else {
            return $this->render('close');
        }
    }

    public function actionAddress()
    {
        //$session = new Session;
        $model = new AddressForm();


        if ($model->load(Yii::$app->request->post())) {
            if(($regis = Register::findByEmail($model->email,$model->tel)) !== null){

                 return $this->redirect(['update', 'id' => $regis->id]);
            }else{
                Yii::$app->session->setFlash('danger', '<span class="fa fa-close" aria-hidden="true"></span>&nbsp;&nbsp; ไม่พบข้อมูลผู้ลงทะเบียนในระบบ');
            }
        }
        return $this->render('address', [
                    'model' => $model,

        ]);
    }

    /**
     * Updates an existing Register model.
     * If update is successful, the browser will be redirected to the 'view' page.
     * @param integer $id
     * @return mixed
     */
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

    public function actionMailconfirm() {
        if (Yii::$app->request->isAjax) {
            $data = Yii::$app->request->post();
            $id = explode(":", $data['id']);
            $id = $id[0];
            $model = $this->findModel($id);
            $this->mailNotification($model);
            $json = Yii::$app->response->format = \yii\web\Response::FORMAT_JSON;
            return [
                'json' => $json,
                'status' => 'success'
            ];
        }
    }

    private function mailNotification($model) {
        Yii::$app->mailer->compose(
                        ['html' => 'registered-html', 'text' => 'registered-text'], ['register' => $model])
                ->setFrom([Yii::$app->params['adminEmail'] => '99 StepRun'])
                ->setTo($model->email)
                ->setSubject('PRC ALUMNI RUNNING CLUB Virtual Run 2021')
                ->send();
    }

    /**
     * Displays a single Register model.
     * @param integer $id
     * @return mixed
     */
    public function actionPayment()
    {
        $session = new Session;
        $model = new PaymentSlipForm();
        $modelVerify = new VerifyForm();

        if ($model->load(Yii::$app->request->post()) && $modelVerify->load(Yii::$app->request->post()) && $modelVerify->validate()) {
            $model->id_card = str_replace('-', '', $model->id_card);
            //if(($regis = Register::findByEmail($model->email,$model->id_card)) !== null){
              if(($regis = Register::findByEmail($model->email,$model->tel)) !== null){
                if (!$regis->lastPaymentStatus->isArrayFinishUpload) {
                    $inputFile = UploadedFile::getInstance($model, 'file');
                    if ($inputFile) {
                        $tmp = explode('.', $inputFile->name);
                        $ext = end($tmp);
                        Yii::$app->webTools->CreateDir('uploads/payment');
                        $path = 'uploads/payment/payment_' . time() . '.' . $ext;
                        if ($inputFile->saveAs(Yii::getAlias('@frontend') . '/web/' . $path)) {
                            $payment = new PaymentSlip();
                            $payment->register_id = $regis->id;
                            $payment->path = $path;
                            if ($payment->save()) {
                                PaymentStatus::AddStatus($regis->id,PaymentStatus::STATUS_WAIT_FOR_CHECK_PAYMENT);
                                return $this->render('success_payment', [
                                            'model' => $model,
                                            'payment' => $payment,
                                            'regis' => $regis,
                                ]);
                            }
                        }
                    }
                }else{
                    Yii::$app->session->setFlash('warning', '<span class="fa fa-warning" aria-hidden="true"></span>&nbsp;&nbsp; ท่านได้อัพโหลดหลักฐานไปแล้ว กรุณารอการตรวจสอบ');
                }
            }else{
                Yii::$app->session->setFlash('danger', '<span class="fa fa-close" aria-hidden="true"></span>&nbsp;&nbsp; ไม่พบข้อมูลผู้ลงทะเบียนในระบบ');
            }

        }
        return $this->render('payment', [
                    'model' => $model,
                    //'register' => !empty($register) ? $register : null,
                    'modelVerify' => $modelVerify,

        ]);
    }


    public function actionLoadpaymentfile($id)
    {
      $model = $this->findModelPaymentSlip($id);
      $filepath = Yii::getAlias('@frontend') . '/web/'.$model->path;
      $ext = end((explode(".", $model->path)));
      if (file_exists($filepath)) {
        if ($ext == 'pdf') {
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          header('Content-Type: application/pdf');
          header('Content-Disposition: inline; filename='.str_replace('uploads/payment/', '', $model->path));
          header('Content-Length: ' . filesize($filepath));
          readfile("$filepath");
        } else {
          header('Cache-Control: must-revalidate, post-check=0, pre-check=0');
          header('Content-Description: File Transfer');
          header('Content-Type: application/octet-stream');
          header('Content-Disposition: attachment; filename='.str_replace('uploads/payment/', '', $model->path));
          header('Content-Length: ' . filesize($filepath));
          readfile("$filepath");
          }
        } else {
          echo "file not exist: ".$filepath;
        }
      exit;
    }

    public function actionDeletepaymentfile($id)
    {
      $model = $this->findModelPaymentSlip($id);
      $register = $model->register;
      if($register->lastPaymentStatus->isWaitForCheckPayment){
        if (file_exists(Yii::getAlias('@frontend') . '/web/' . $model->path)) {
          @unlink(Yii::getAlias('@frontend') . '/web/' . $model->path);
        }
        if($model->delete()){
          $register->lastPaymentStatus->delete();
          Yii::$app->session->setFlash('success', '<span class="fa fa-check"></span> Deleted a payment slip, you can upload again now.');
        }
      }else{
        Yii::$app->session->setFlash('error', '<span class="fa fa-exclamation-circle"></span> Cannot delete this payment slip. Please, wait for approve or confirm again by Administrator.');
      }
      return $this->redirect(['view','id' => $register->id]);
    }

    /**
     * Deletes an existing Register model.
     * If deletion is successful, the browser will be redirected to the 'index' page.
     * @param integer $id
     * @return mixed
     */
    public function actionDelete($id) {
        $this->findModel($id)->delete();

        return $this->redirect(['index']);
    }

    public function actionClose()
    {
      return $this->render('close');
    }


    /**
     * Finds the Register model based on its primary key value.
     * If the model is not found, a 404 HTTP exception will be thrown.
     * @param integer $id
     * @return Register the loaded model
     * @throws NotFoundHttpException if the model cannot be found
     */
    protected function findModel($id) {
        if (($model = Register::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    protected function findModelPaymentSlip($id)
    {
        if (($model = PaymentSlip::findOne($id)) !== null) {
            return $model;
        } else {
            throw new NotFoundHttpException('The requested page does not exist.');
        }
    }

    /**
     * Displays a single Register model.
     * @param integer $id
     * @return mixed
     */
    public function actionResults()
    {
        $session = new Session;
        $model = new ResultSlipForm();
        $modelVerify = new VerifyForm();

        if ($model->load(Yii::$app->request->post()) && $modelVerify->load(Yii::$app->request->post()) && $modelVerify->validate()) {
            $model->id_card = str_replace('-', '', $model->id_card);
            //if(($regis = Register::findByEmail($model->email,$model->id_card)) !== null){
              if(($regis = Register::findByEmail($model->email,$model->tel)) !== null){
                Yii::$app->session->setFlash('danger', '<span class="fa fa-close" aria-hidden="true"></span>&nbsp;&nbsp; Ready to upload');

                    $inputFile = UploadedFile::getInstance($model, 'file');
                    if ($inputFile) {
                        $tmp = explode('.', $inputFile->name);
                        $ext = end($tmp);
                        Yii::$app->webTools->CreateDir('uploads/result');
                        $path = 'uploads/result/result_' . time() . '.' . $ext;
                        echo $path;
                         if ($inputFile->saveAs(Yii::getAlias('@frontend') . '/web/' . $path)) {
                            $result = new ResultSlip();
                            $result->register_id = $regis->id;
                            $result->path = $path;
                            if ($result->save()) {
                                //PaymentStatus::AddStatus($regis->id,PaymentStatus::STATUS_WAIT_FOR_CHECK_PAYMENT);
                                return $this->render('success_payment', [
                                            'model' => $model,
                                            'payment' => $result,
                                            'regis' => $regis,
                                ]);
                            }
                               }
                     }

            }else{
                Yii::$app->session->setFlash('danger', '<span class="fa fa-close" aria-hidden="true"></span>&nbsp;&nbsp; ไม่พบข้อมูลผู้ลงทะเบียนในระบบ');
            }

        }
        return $this->render('results', [
                    'model' => $model,
                    //'register' => !empty($register) ? $register : null,
                    'modelVerify' => $modelVerify,

        ]);
    }

}
