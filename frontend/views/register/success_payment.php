<?php

use yii\helpers\Html;

$this->registerJs("
setTimeout(function(){window.location.replace('" . Yii::$app->request->baseUrl . "/register/index');}, 10000);"
);

$this->title = 'แจ้งหลักฐานการโอนเงินสำเร็จ';
?>
<div class="container">

    <div class="jumbotron text-center" style="margin-top: 110px;">
        <div class="page-header">
            <h1>
                <span class="fa fa-bookmark"></span>
                <?= Html::encode($this->title) ?>
            </h1>
        </div>
        <p class="text-primary"><strong></strong>เราจะการตรวจสอบหลักฐานการโอนเงิน และจะรีบแจ้งผลการตรวจสอบโดยเร็วที่สุด</strong></p>
<!--		
		<p>//= Html::a('เครือข่ายอุดมศึกษาภาคเหนือตอนบน','http://northnet.eqd.cmu.ac.th/',['target' => '_blank'])?> หรือทางเว็บไซต์ของ <?//= Html::a('สมาคมสหกิจศึกษาไทย','https://tace.sut.ac.th/tace/index.php',['target' => '_blank']) ?>
        </p>
-->
    </div>

</div>
