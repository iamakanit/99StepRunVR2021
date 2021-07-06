<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;
use kartik\file\FileInput;
use common\models\Register;

$this->registerJs("
$('#refresh-captcha').on('click', function(e){
    e.preventDefault();
    $('#my-captcha-image').yiiCaptcha('refresh');
});
");



$this->title = 'ยืนยันตัวตนเพื่อบันทึกข้อมูลที่อยู่';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-address">
<!--    <h2><i class="far fa-envelope"></i> <?= Html::encode($this->title) ?></h2> -->
    <!-- <div class="panel panel-default">
        <div class="panel-body">

        </div>
    </div> -->

    <div class="register-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="text-danger">
            <?=$form->errorSummary($model)?>
        </div>

<?php

?>
<!---
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?//= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?//= $form->field($model, 'tel')->widget(MaskedInput::className(), [
                   'mask' => '9999999999',
                ])->textInput() ?>

            </div>
        </div>


        <hr>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6" style="padding-top: 13px;">

                <?//= Html::submitButton('<i class="fas fa-user-check"></i> ตรวจสอบ', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>
        </div>
        <?php //ActiveForm::end(); ?>

    </div>

-->
</div>


