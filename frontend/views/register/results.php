<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use yii\captcha\Captcha;
use kartik\file\FileInput;

$this->registerJs("
$('#refresh-captcha').on('click', function(e){
    e.preventDefault();
    $('#my-captcha-image').yiiCaptcha('refresh');
});
");


$this->title = 'แจ้งผลการวิ่ง';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-create">
    <h2><span class="fa fa-credit-card"></span> <?= Html::encode($this->title) ?></h2>
    <div class="register-form">
        <?php $form = ActiveForm::begin(); ?>
        <div class="text-danger">
            <?=$form->errorSummary($model)?>
        </div>
        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'email')->textInput(['autofocus' => true]) ?>
                <?= $form->field($model, 'tel')->textInput() ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'file')->widget(FileInput::classname(), [
                        'pluginOptions' => [
                            'previewFileType' => 'any',
                            'showCaption' => false,
                            'showUpload' => false,
                            'showRemove' => false,
                            'browseClass' => 'btn btn-default btn-sm btn-browse',
                            'browseLabel' => ' อัพโหลดไฟล์',
                            'browseIcon' => '<i class="glyphicon glyphicon-picture"></i>',
                            'previewSettings' => [
                                'image' => ['class'=> 'img-responsive', 'style' => 'max-width: 1000px;']
                            ],
                            'layoutTemplates' => [
                                'footer' => '',
                            ],
                            'initialPreview' => [],
                        ]
                    ]) ?>
            </div>
        </div>
        <hr>
        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-5">
                <?= $form->field($modelVerify, 'verifyCode', [
                    'template' => '{label}&nbsp;&nbsp;'.Html::button('<span class="fa fa-refresh"></span>', ['id' => 'refresh-captcha','class' => 'btn btn-xs','data-toggle' => 'tooltip','data-placement'=>'right','title' => 'เปลี่ยนรหัสยืนยัน']).'{input}{hint}{error}'
                ])->widget(Captcha::className(), [
                    'imageOptions' => ['class' => 'img-responsive','id' => 'my-captcha-image'],
                    'template' => '<div class="row"><div class="col-lg-4 col-md-4 col-sm-4 col-xs-5">{image}</div><div class="col-lg-8 col-md-8 col-sm-8 col-xs-7">{input}</div></div>',
                ])->label('รหัสยืนยันการส่งผล') ?>
            </div>
            <div class="col-lg-7 col-md-7 col-sm-7" style="padding-top: 13px;">
                <?= Html::submitButton('<span class="fa fa-bookmark"></span> ส่งไฟล์รูปผลการวิ่ง', ['class' => 'btn btn-primary btn-lg btn-block']) ?>
            </div>
        </div>
        <?php ActiveForm::end(); ?>
    </div>
</div>
