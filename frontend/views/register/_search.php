<?php

use yii\widgets\ActiveForm;
use yii\helpers\Html;
use common\models\Department;
use common\models\Group;
use common\models\PaymentStatus;
use yii\helpers\ArrayHelper;
use kartik\select2\Select2;

$this->registerJs("
$('a[data-toggle=\"tab\"]').on('show.bs.tab', function (e) {
    $('#registersearch-department_id').val('').trigger('change');
    $('#registersearch-group_id').val('').trigger('change');
    $('#registersearch-q').val('').trigger('change');
});
");
?>

<div class="register-search">
    <?php $form = ActiveForm::begin([
        'action' => ['index'],
        'method' => 'get',
    ]); ?>

    <div class="input-group">
        <?= Html::activeTextInput($model, 'q',['class'=>'form-control','placeholder'=> 'ค้นหาชื่อ หรือ นามสกุล','autofocus' => true]) ?>
        <span class="input-group-btn">
            <button class="btn btn-default" type="submit"><i class="glyphicon glyphicon-search"></i> ค้นหา</button>
        </span>
    </div>
    <?php ActiveForm::end(); ?>
</div>
