<?php

use yii\helpers\Html;
use yii\grid\GridView;

$this->title = 'ตรวจสอบสถานะการลงทะเบียน / ระยะการวิ่งสะสม';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="register-index">
    <div class="page-header">
        <h2><i class="fas fa-check-circle"></i> <?= $this->title ?></h2>
    </div>
    <?= $this->render('_search', ['model' => $searchModel]); ?>
    <hr>
    <?php if(Yii::$app->request->get('RegisterSearch')):?>
        <div class="table-responsive">
        <?= GridView::widget([
            'dataProvider' => $dataProvider,
            'columns' => [
                [
                    'class' => 'yii\grid\SerialColumn',
                    'header' => 'No.',
                ],
                [
                    'attribute' => 'created_at',
                    'label' => 'วันเวลาที่ลงทะเบียน',
                    'format'=>'html',
                    'value'=>function($model){
                        return Yii::$app->thaiFormatter->asDateTime($model->created_at, 'short');
                    }
                ],
                [
                    'attribute' => 'title',
                    'label' => '',
                    'format'=>'html',
                    'value'=>function($model){
                        return $model->title;
                    }
                ],
                [
                    'attribute' => 'ntname',
                    'label' => 'ชื่อ-นามสกุล',
                    'format'=>'html',
                    'value'=>function($model){
                        return $model->ntname;
                    }
                ],
                [
                    //'label' => 'วิทยาลัย/มหาวิทยาลัย',
                    'label' => 'เพศ',
                    'attribute' => 'gender_type',
                    'format'=>'html',
                    'value'=>function($model){
                        return !empty($model->gender_type) ? $model->genderTypeName : '-';
                    }
                ],
                // [
                //      'label' => 'ประเภทการสมัคร',
                //      'attribute' => 'category_id',
                //      'format'=>'html',
                //      'value'=>function($model){
                //          return !empty($model->category_id) ? $model->category->name : '-';
                //     }
                //  ],
                [
                     'label' => 'ประเภท',
                     'attribute' => 'department_id',
                     'format'=>'html',
                     'value'=>function($model){
                         return !empty($model->department_id) ? $model->department->name : '-';
                    }
                 ],
                 [
                     'label' => 'ขนาดเสื้อ',
                     'attribute' => 'shirt_id',
                     'format'=>'html',
                     'value'=>function($model){
                         return !empty($model->shirt_id) ? $model->shirt->name : '-';
                     }
                 ],
                 [
                    'label' => 'สถานะการจ่ายเงิน',
                    'format'=>'html',
                    'value'=>function($model){
                      return '<p class="text-'.$model->lastPaymentStatus->bootstrapStatusColor.'">'.$model->lastPaymentStatus->statusNameAdmin.'&nbsp;&nbsp;'.(!$model->lastPaymentStatus->isArrayFinishUpload ? Html::a('แจ้งการโอนเงิน',['payment', 'pid'=>$model->id],['class' => 'btn btn-info btn-xs']) : '');
                    //  return '<p class="text-'.$model->lastPaymentStatus->bootstrapStatusColor.'">'.$model->lastPaymentStatus->statusNameAdmin.'&nbsp;&nbsp;'.(!$model->lastPaymentStatus->isArrayFinishUpload ? Html::a('แจ้งการโอนเงิน',['payment'],['class' => 'btn btn-info btn-xs']) : '');
                  }
                 ],
                 [
                    'label' => 'ระยะการวิ่งสะสม (กม.)',
                    'format'=>'html',
                    'value'=>function($model){
                      return !empty($model->sumResult) ? $model->sumResult : '-';
                  }
                 ],

            ],
        ]); ?>
        </div>
    <?php endif; ?>
</div>
