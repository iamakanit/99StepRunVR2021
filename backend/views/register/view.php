<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use yii\bootstrap\Modal;
use yii\helpers\Url;


$this->registerJs("
$('.modal-pic').click(function(){
    $('#modalContent').html('<h3 class=\"text-center\"><span class=\"fa fa-spinner\"></span> Loading...</h3>');
    $('#modal').find('#modalHeader').html('<span class=\"fa fa-picture-o\"></span> Image');
    $('#modal').modal('show').find('#modalContent').html('<img src=\"'+$(this).attr('value')+'\" class=\"center-block\" style=\"max-height: 850px;\">');
    return false;
});

$.fn.modal.Constructor.prototype.enforceFocus = $.noop;
$('.modal-create').click(function(){
    $('#modalContent').html('<h3 class=\"text-center\"><span class=\"fa fa-spinner\"></span> Loading...</h3>');
    $('#modal').find('#modalHeader').html($(this).html());
    $('#modal').modal('show').find('#modalContent').load($(this).attr('value'));
    return false;
});

$('#modal').on('hidden.bs.modal', function (e) {
    $('#modalContent').html('');
});
");

$this->title = $model->fullname;
$this->params['breadcrumbs'][] = ['label' => 'ผู้ลงทะเบียน', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-view">

  <div class="page-header" style="margin-bottom: 0px">
      <h2>
          <span class="fa fa-user" aria-hidden="true"></span> <?= $this->title ?>
      </h2>
  </div>

    <div class="row">
      <div class="col-lg-6 col-md-6">
        <h3>
          <span class="fa fa-info-circle"></span>
          ข้อมูลผู้ลงทะเบียน
          &nbsp;
          <?= Html::a('<span class="fa fa-edit" aria-hidden="true"></span> แก้ไข',['update','id' => $model->id],['class' => 'btn btn-warning btn-xs']) ?>
        </h3>
        <div class="table-responsive">
          <?= DetailView::widget([
            'model' => $model,
            'attributes' => [
                [
                    'format' => 'html',
                    'label' => 'ชื่องาน',
                    'value' => !empty($model->group_id) ? $model->group->name : '-'
                ],
                [
                    'format' => 'html',
                    'attribute' => 'id_card',
                    'value' => $model->id_card
                ],
                [
                    'format' => 'html',
                    'label' => 'ชื่อ-สกุล',
                    'value' => $model->fullname
                ],
                [
                    'format' => 'html',
                    'attribute' => 'gender_type',
                    'value' => !empty($model->gender_type) ? $model->genderTypeName : '-'
                ],
                'email:email',
                'tel',
                [
                    'format' => 'html',
                    'label' => 'ที่อยู่',
                    'value' => $model->fulladdress
                ],
                // [
                //     'format' => 'html',
                //     'attribute' => 'category_id',
                //     'value' => !empty($model->category_id) ? $model->category->name : '-'
                // ],
                // [
                //     'format' => 'html',
                //     'attribute' => 'alumni_id',
                //     'value' => !empty($model->alumni_id) ? $model->alumni->name : '-'
                // ],
                [
                    'format' => 'html',
                    'attribute' => 'department_id',
                    'value' => !empty($model->department_id) ? $model->department->name : '-'
                ],
                [
                    'format' => 'html',
                    'attribute' => 'shirt_id',
                    'value' => !empty($model->shirt_id) ? $model->shirt->name  : '-'
                ],
                [
                    'format' => 'html',
                    'label' => 'วันเวลาที่ลงทะเบียน',
                    'value' => Yii::$app->thaiFormatter->asDateTime($model->created_at, 'medium')
                ],

                //'position',
                // [
                //     'format' => 'html',
                //     'attribute' => 'payment_type',
                //     'value' => !empty($model->payment_type) ? $model->paymentTypeName : '-'
                // ],
            ],
        ]) ?>
        </div>
        <div class="pull-right">
          <?= Html::a('<span class="fa fa-trash" aria-hidden="true"></span> ซ่อนผู้ลงทะเบียน',['pending','id' => $model->id],[
            'class' => 'btn btn-danger btn-xs',
            'data' => [
                'confirm' => 'โปรดยืนยันการ ซ่อนข้อมูลผู้ลงทะเบียนชื่อ '.$model->fullname.' โดยผู้ลงทะเบียนจะไม่เห็นข้อมูลการลงทะเบียน',
                'method' => 'post',
            ],
        ]) ?>
          <?= Html::a('<span class="fa fa-trash" aria-hidden="true"></span> ยกเลิกการทะเบียน',['delete','id' => $model->id],[
            'class' => 'btn btn-danger btn-xs',
            'data' => [
                'confirm' => 'โปรดยืนยันการลบข้อมูลผู้ลงทะเบียนชื่อ '.$model->fullname.' โดยข้อมูลการลงทะเบียนจะถูกลบทั้งหมด?',
                'method' => 'post',
            ],
        ]) ?>
        </div>
      </div>
      <div class="col-lg-6 col-md-6">
        <h3>
          <span class="fa fa-credit-card"></span>
          สถานะการจ่ายเงิน
        </h3>
        <div class="panel panel-default">
          <div class="panel-body" style="padding-bottom: 5px;">
            <?php if($model->isMoneyTransfer): ?>
              <?php foreach ($model->paymentStatuses as $key => $paymentStatus): ?>
                <?php echo $key+1; if ($key+1 == count($model->paymentStatuses) && $model->lastPaymentStatus->isArrayFinishUpload ): ?>
                  <?php // if (in_array(end((explode(".", $model->lastPaymentSlip->path))), ['png', 'jpg', 'gif', 'bmp', 'jpeg', 'PNG', 'JPG', 'GIF', 'BMP'])): ?>
           		  <?php $ext = explode(".",$model->lastPaymentSlip->path); if(in_array(end($ext),['png', 'jpg', 'gif', 'bmp', 'jpeg', 'PNG', 'JPG', 'GIF', 'BMP'])): ?>
                    <p class="bg-info text-info lead" style="padding: 10px 30px; margin-bottom: 3px;">
                      <?= Html::a(Html::img(str_replace('/backend', '',Url::base(true)).'/'.$model->lastPaymentSlip->path,['class' => 'img-rounded', 'style' => 'max-height: 80px;']),'',['class' => 'modal-pic','value' => str_replace('/backend', '',Url::base(true)).'/'.$model->lastPaymentSlip->path]) ?>

                    </p>
                  <?php else: ?>
                    <p class="bg-info text-info lead" style="padding: 5px 30px; margin-bottom: 3px;">
                      <?= Html::a('<span class="fa fa-file"></span> ไฟล์รูปภาพหลักฐานการโอนเงิน', ['loadpaymentfile', 'id' => $model->lastPaymentSlip->id], [
                        'target' => '_blank',
                        'title' => 'Payment Slip File',
                        'data' => [
                          'method' => 'post',
                        ],
                        ]) ?>
                    </p>
                  <?php endif; ?>
                <?php endif; ?>
                <p class="<?= $key+1 == count($model->paymentStatuses) ? 'lead text-'.$model->lastPaymentStatus->bootstrapStatusColor : 'text-muted'?>" style="padding-left: 20px;">
                  <?= $key+1 == count($model->paymentStatuses) ? '<span class="fa fa-circle"></span>' : '<span class="fa fa-minus"></span>' ?>
                  <?= $paymentStatus->statusNameAdmin ?>
                  <small class="text-muted" <?= $key+1 == count($model->paymentStatuses) ? 'style="font-size: 60%;"' : '' ?>>
                    <span class="fa fa-calendar"></span>
                    <?= Yii::$app->thaiFormatter->asDateTime($paymentStatus->created_at, 'medium') ?>
                  </small>
                </p>
              <?php endforeach; ?>
              <?php if ($model->lastPaymentStatus->isPaid): ?>
                <h2 class="text-success bg-success text-center" style="padding: 10px;">
                  <span class="fa fa-check"></span>
                  การชำระค่าสมัครสมบูรณ์
                </h2>
              <?php elseif ($model->lastPaymentStatus->isArrayFinishUpload): ?>
                <div class="text-center" style="margin: 10px 0px;">
                  <?= Html::a('<span class="fa fa-check"></span> หลักฐานการโอนถูกต้อง', ['approvepaymentfile', 'id' => $model->id], [
                    'class' => 'btn btn-success btn-lg',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Approve a payment slip to paid',
                    'data' => [
                      'confirm' => 'โปรดยืนยันการตรวจสอบการโอนเงิน?',
                      'method' => 'post',
                    ],
                    ]) ?>
                  <?= Html::a('<span class="fa fa-times"></span> หลักฐานการโอนไม่ถูกต้อง', ['rejectpaymentfile', 'id' => $model->id], [
                    'class' => 'btn btn-danger btn-lg',
                    'data-toggle' => 'tooltip',
                    'data-placement' => 'bottom',
                    'title' => 'Reject a payment slip to confirm payment slip again',
                    'data' => [
                      'confirm' => 'โปรดยืนยันการปฏิเสธการโอนเงิน?',
                      'method' => 'post',
                    ],
                    ]) ?>
                </div>
              <?php endif; ?>
            <?php else: ?>
              <h3 class="text-info bg-info text-center" style="padding: 10px;">
                <span class="fa fa-inbox"></span>
                ลงทะเบียนด้วยรหัส F การลงทะเบียนสมบูรณ์
              </h3>
            <?php endif; ?>
          </div>
        </div>


      </div>
    </div>
    <div class="col-lg-12 col-md-12">
      <h3>
        <span class="fa fa-credit-card"></span>
        ผลการวิ่ง
      </h3>


       <?php foreach ($model->resultSlips as $key => $ResultSlips):?>
         <?php //echo $ResultSlips->path; ?>
            <p class="bg-info text-info lead" style="padding: 10px 30px; margin-bottom: 3px;">
              <?= Html::a(Html::img(str_replace('/backend', '',Url::base(true)).'/'.$ResultSlips->path,['class' => 'img-rounded', 'style' => 'max-height: 80px;']),'',['class' => 'modal-pic','value' => str_replace('/backend', '',Url::base(true)).'/'.$ResultSlips->path]) ?>
            </p>
                  <span class="fa fa-calendar"></span>
            <?= Yii::$app->thaiFormatter->asDateTime($ResultSlips->created_at, 'medium') ?>
          </small>
        </p>
      <?php endforeach; ?>
    </div>

    <?php
        Modal::begin([
            'header' => '<h4 id="modalHeader" class="text-primary" style="margin-top: 0px; margin-bottom: 0px;"></h4>',
            'id' => 'modal',
            'size' => 'modal-lg'
        ]);
    ?>
    <div id="modalContent"></div>
    <?php Modal::end(); ?>

</div>
