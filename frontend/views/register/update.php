<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\DetailView;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;
use kartik\file\FileInput;
//use common\models\Register;

$this->registerJs("
$('#refresh-captcha').on('click', function(e){
    e.preventDefault();
    $('#my-captcha-image').yiiCaptcha('refresh');
});
");



$this->title = 'บันทึกที่อยู่';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-address">

    <h2><i class="far fa-envelope"></i> <?= Html::encode($this->title) ?></h2>
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
        <div class="row" >
            <div class="col-lg-12 col-md-12 col-sm-12">
              <?=         DetailView::widget([
                          'model' => $model,
                          'attributes' => [
                            [
                                'format' => 'html',
                                'label' => 'ชื่อ-สกุล',
                                'value' => $model->fullname
                            ],
                            'email',
                            'tel',
                          ],
                        ])
              ?>

            </div>
        </div>

        <div class="row">
            <div class="col-lg-8 col-md-8 col-sm-8">
                <?= $form->field($model, 'addr_1')->textInput(['autofocus' => true]) ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'addr_2')->textInput() ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'addr_3')->textInput() ?>
            </div>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'province')->textInput() ?>
            </div>
            <div class="col-lg-3 col-md-3 col-sm-3">
                <?= $form->field($model, 'zip')->widget(MaskedInput::className(), [
                   'mask' => '99999',
                ])->textInput() ?>
            </div>
        </div>

        <hr>
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12" style="padding-top: 13px;">
              <?= Html::activeHiddenInput($model, 'payment_type')?>
              <?= Html::activeHiddenInput($model, 'group_id')?>
              <?= Html::activeHiddenInput($model, 'ckagree',['value' => '1'])?>
              <?= Html::submitButton('<i class="fas fa-save"></i> บันทึก', ['value' => 'regis', 'name' => 'action', 'class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>

    </div>

</div>
