<?php

use yii\helpers\Html;
use yii\bootstrap\Modal;
use yii\helpers\Url;
use yii\widgets\ActiveForm;
use common\models\ResultSlip;


    $form = ActiveForm::begin();
?>
    <div class="row">
      <div class="col-lg-3 col-md-3 col-sm-3">
          <?= Html::a(Html::img(str_replace('/backend', '',Url::base(true)).'/'.$resultmodel->path,['class' => 'img-rounded', 'style' => 'max-height: 600px;'])); ?>
          <span class="fa fa-calendar"></span> <?= Yii::$app->thaiFormatter->asDateTime($resultmodel->created_at, 'medium') ?>
          <?= $form->field($resultmodel, 'result')->textInput() ?>
          <?= Html::submitButton('<span class="fa fa-floopy-o"></span> บันทึก', ['value' => 'regis', 'name' => 'action', 'class' => 'btn btn-primary btn-lg btn-block']) ?>
      </div>
    </div>
<?php
    ActiveForm::end();




?>
