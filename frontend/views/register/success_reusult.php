<?php

use yii\helpers\Html;

$this->registerJs("
setTimeout(function(){window.location.replace('" . Yii::$app->request->baseUrl . "/register/index');}, 10000);"
);

$this->title = 'แจ้งระยะการวิ่งเรียบร้อยแล้ว';
?>
<div class="container">

    <div class="jumbotron text-center" style="margin-top: 110px;">
        <div class="page-header">
            <h1>
                <span class="fa fa-bookmark"></span>
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <p class="text-primary"><strong></strong>เราจะการตรวจสอบไฟล์ระยะการวิ่ง และปรับปรุงข้อมูลระยะการวิ่งสะสมโดยเร็วที่สุด</strong></p>
    </div>

</div>
