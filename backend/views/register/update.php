<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use common\models\Department;
use common\models\Group;
use common\models\Shirt;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;


$this->title = 'แก้ไขข้อมูลผู้ลงทะเบียน';
$this->params['breadcrumbs'][] = ['label' => 'จัดการข้อมูลผู้ลงทะเบียน', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => 'ข้อมูลผู้ลงทะเบียน : '.$model->fullname, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-create">

    <h2><span class="fa fa-bookmark"></span> <?= Html::encode($this->title) ?></h2>

    <div class="register-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="text-danger">
            <?=$form->errorSummary($model)?>
        </div>

        <div class="row">
            <div class="col-lg-4 col-md-5 col-sm-6">
<!--                 <?/*= $form->field($model, 'id_card')->widget(MaskedInput::className(), [
                    'mask' => '9-9999-99999-99-9',
                ])->textInput(['autofocus' => true]) */?> -->

                <?= $form->field($model, 'id_card')->textInput(['maxlength' => true,'autofocus' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-2 col-md-2 col-sm-3">
                <?= $form->field($model, 'title')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-4">
                <?= $form->field($model, 'firstname')->textInput(['maxlength' => true]) ?>
            </div>
            <div class="col-lg-5 col-md-5 col-sm-5">
                <?= $form->field($model, 'lastname')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
             <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'department_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Department::find()->all(), 'id','name'),
                    'language' => Yii::$app->language,
                    'options' => [
                        'placeholder' => 'กรุณาเลือก'
                    ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
                ]) ?>
            </div>
           <div class="col-lg-6 col-md-6 col-sm-6">

                <?= $form->field($model, 'gender_type')->widget(Select2::classname(), [
                   'data' => $model->ItemGenderType,
                    'language' => Yii::$app->language,
                   'options' => [
                        'placeholder' => 'เพศ'
                   ],
                    'pluginOptions' => [
                        'allowClear' => true
                    ],
               ]) ?>
            </div>
             <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'shirt_id')->widget(Select2::classname(), [
                    'data' => ArrayHelper::map(Shirt::find()->all(), 'id','shirtfull'),
                    'language' => Yii::$app->language,
                    'options' => [
                         'placeholder' => 'กรุณาเลือกขนาดเสื้อ'
                    ],
                    'pluginOptions' => [
                          'allowClear' => true
                        ],
                    ]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'email')->textInput() ?>
            </div>
            <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
            </div>
        </div>

        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <?= $form->field($model, 'addr_1')->textInput() ?>
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
            <div class="col-lg-6 col-md6 col-sm-6">
                <?= $form->field($model, 'province')->textInput() ?>
              </div>
              <div class="col-lg-6 col-md-6 col-sm-6">
                <?= $form->field($model, 'zip')->textInput() ?>
                <?= Html::activeHiddenInput($model, 'payment_type')?>
                <?= Html::activeHiddenInput($model, 'group_id')?>
                <?= Html::activeHiddenInput($model, 'ckagree',['value' => '1'])?>
            </div>
        </div>
        <?= Html::submitButton('<span class="fa fa-floopy-o"></span> บันทึก', ['value' => 'regis', 'name' => 'action', 'class' => 'btn btn-primary btn-lg btn-block']) ?>



        <?php ActiveForm::end(); ?>

    </div>

</div>
