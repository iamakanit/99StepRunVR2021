<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use yii\widgets\MaskedInput;
use common\models\Department;
use common\models\Shirt;
use common\models\Code;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

/*$this->registerJs('
    $("#agree-chk").change(function(){
        var btn=$("#submitbt");
        if($(this).is(":checked")){
            btn.removeAttr("disabled");
            btn.removeClass("disabled");
        }else{
            btn.attr("disabled",true);
            btn.addClass("disabled");
        }
        });
    ');*/
$this->title = 'ลงทะเบียนออนไลน์';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-create">

    <div class="page-header">
        <h2><span class="fa fa-bookmark"></span> <?= Html::encode($this->title) ?></h2>
    </div>

    <div class="register-form">

        <?php $form = ActiveForm::begin(); ?>

        <div class="text-danger">
            <?=$form->errorSummary($model)?>
        </div>

        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6">
                <?= $form->field($model, 'group_id')->dropDownList(ArrayHelper::map($group, 'id','name')) ?>
            </div>
        </div>
<!-- Row 0 -->


      <div class="row">
          <div class="col-lg-6 col-md-6 col-sm-6">
            <?= $form->field($model, 'code_id')->textInput(['readonly' => true])  ?>
         </div>
      </div>

        <div class="row">
            <div class="col-lg-5 col-md-5 col-sm-6">
                <?= $form->field($model, 'id_card')->textInput(['maxlength' => true,'autofocus' => true]) ?>
            </div>
        </div>
<!-- Row 1 -->
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
<!-- Row 2 -->
<div class="row">
    <div class="col-lg-6 col-md-6 col-sm-6">
        <?= $form->field($model, 'email')->textInput() ?>
    </div>
   <div class="col-lg-6 col-md-6 col-sm-6">
    <?= $form->field($model, 'tel')->textInput(['maxlength' => true]) ?>
  </div>
</div>
<!-- Row 3 -->


<!-- Row 4 -->
<div class="row">
    <div class="col-lg-3 col-md-3 col-sm-3">

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
    <div class="col-lg-9 col-md-9 col-sm-9">
    <?= $form->field($model, 'department_id')->widget(Select2::classname(), [
       'data' => ArrayHelper::map(Department::find()->all(), 'id','name'),
       'language' => Yii::$app->language,
       'options' => [
            'placeholder' => 'กรุณาเลือกประเภท - รุ่นอายุ'
       ],
       'pluginOptions' => [
             'allowClear' => true
           ],
     ]) ?>
</div>
</div>

<!-- Row 5 -->
<div class="row">
   <div class="col-lg-6 col-md-6 col-sm-6">
       <?= $form->field($model, 'shirt_id')->widget(Select2::classname(), [
           'data' => ArrayHelper::map(shirt::find()->all(), 'id','shirtfull'),
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
<!-- Row 6 -->
        <div class="row">
            <div class="col-lg-12 col-md-12 col-sm-12">
                <div class="panel panel-default">
                    <div class="panel-footer">
                    <p>
                        <center><strong> <span class="fas fa-exclamation-triangle"></span> ข้อตกลงร่วมกัน (Release and statement) </strong> <span class="fas fa-exclamation-triangle"></span> <br><br>
                            &emsp;&emsp;&emsp;&emsp;  ข้าพเจ้ารับรองว่า ข้อมูลที่สมัครร่วมกิจกรรมในครั้งนี้เป็นความจริงทุกประการ ซึ่งข้าพเจ้ามีร่างกายสมบูรณ์พร้อมที่จะเข้าร่วมกิจกรรมอย่างเต็มใจ และข้าพเจ้าได้ศึกษาและยินยอมปฏิบัติตามกฎกติกาต่าง ๆ ทุกประการ โดยไม่เรียกร้องค่าเสียหายใด ๆ หากเกิดอันตรายหรือบาดเจ็บ ทั้งก่อน ระหว่าง และหลังการแข่งขัน นอกจากนี้ ข้าพเจ้ายินยอมให้คณะผู้จัดงานถ่ายภาพหรือวิดีโอ เพื่อบันทึกการจัดกิจกรรม และถือเป็นลิขสิทธิ์ของคณะผู้จัดงานในครั้งนี้ <br>
                            &emsp;&emsp;&emsp;&emsp; I certify that I am medically fit to complete and fully understand that I enter at my own risk and organizers will be no way be held responsibility for any injuries, illness or loss or as a result of the event. <br><br>
                            <!-- <?//= Html::checkbox('agree', false, ['id' => 'agree-chk']) ?> -->
                            <?= $form->field($model,'ckagree')->checkbox(); ?>
                        </center>
                    </p>
                    </div>
                </div>
            </div>
        </div>
         <div class="row">
            <!--<div class="col-lg-12 col-md-12 col-sm-12">
              <div class="panel panel-default">
                <div class="panel-body">
                  <p>
                      <span class="fa fa-credit-card"></span>

                      <?//= Html::activeHiddenInput($model, 'department_id',['value' => '2'])?>


                      <strong> ค่าลงทะเบียนท่านละ 1,000 บาท</strong>
                  </p>
                  <p>
                      &emsp;&emsp;<strong>โอนเงินผ่านบัญชี</strong> แล้วแจ้งโอนในหน้า<?= Html::a('แจ้งการโอนเงิน',['register/payment'],['target' => '_blank']) ?>
                      โดยกรอกอีเมลที่ใช้ลงทะเบียน และยืนยันรหัสประจำตัวบัตรประชาชนที่ใช้ลงทะเบียน พร้อมด้วยอัพโหลดไฟล์เอกสาร
                      หรือรูปภาพหลักฐานการโอนเงิน จากนั้นกรอกรหัสยืนยันแจ้งการโอนเงินให้ถูกต้อง แล้วคลิกที่ <strong>แจ้งการโอนเงิน</strong>
                      หลังจากนั้นเราจะทำการตรวจสอบหลักฐานการโอนที่ส่งมา และแจ้งผลการตรวจสอบกลับไปยัง<strong>อีเมล</strong>
                  </p>
                  <p class="lead text-info" style="margin-left: 20px;margin-bottom: 2px;">
                      ข้อมูลการโอนเงิน
                  </p>
                  <div class="pull-left" style="margin-left: 20px;">
                    <?= Html::img(Yii::$app->request->baseUrl.'/images/scb-logo-desktop.svg',['class' => 'img-responsive','style' => 'max-width: 240px;']) ?>
                  </div>
                  <p class="pull-left" style="margin-left: 5px;">
                    <strong>ธนาคารไทยพาณิชย์</strong> สาขาศรีนครพิงค์ เชียงใหม่
                    <br>
                    <strong>ประเภทบัญชี</strong> ออมทรัพย์
                    <br>
                    <strong>เลขที่บัญชี</strong> 549 2532 817
                    <br>
                    <strong>ชื่อบัญชี</strong> นายปิติกุล นิจจุฬา
                  </p>
                  <div class="clearfix"></div>
                </div>
              </div>
            </div> -->
        </div>
       <!--  <?//= Html::submitButton('ต่อไป <span class="fa fa-caret-right"></span>', ['value' => 'regis', 'name' => 'action', 'class' => 'btn btn-primary btn-lg btn-block disabled','id' => 'submitbt', 'disabled' => 'disabled']) ?> -->
            <!-- <?//= Html::activeHiddenInput($model, 'payment_type',['value' => '10'])?> -->

            <!-- <?//= Html::activeHiddenInput($model, 'code_id',['value' => $code])?> -->
            <?= Html::submitButton('ต่อไป <span class="fa fa-caret-right"></span>', ['value' => 'regis', 'name' => 'action', 'class' => 'btn btn-primary btn-lg btn-block']) ?>

        <?php ActiveForm::end(); ?>
        <br>
    </div>

</div>
