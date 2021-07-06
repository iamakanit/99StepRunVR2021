<?php

use yii\helpers\Html;
use common\models\Register;
use common\models\Group;

$this->title = 'PRC ALUMNI RUNNING CLUB Virtual Run 2021';
?>
<div class="site-error">
  <div class="jumbotron" style="margin-top: 20px;">
    <div class="text-center">
      <p>
        <?php foreach (Group::find()->all() as $key => $group): ?>
          <p style="font-size: 100%;">
           <center>
             <?= Html::img(Yii::$app->request->baseUrl.'/images/index.jpg',['class' => 'img-responsive','style' => 'max-width: 360px;']) ?>
           </center>
            <h2><?= $group->name ?></h2><br>
            <span class="text-info"><?= $group->description ?></span>
            <!-- <?php if(time() >= $group->start_regis):?>
              <br>
              <strong>(</strong> <span class="text-warning">ลงทะเบียนแล้ว</span>
              <?//= count($group->registers) ?> / <?= $group->max_amount ?> <strong>)</strong>
            <?php endif; ?> -->
        </p>
        <?php endforeach; ?>
        <br>

        <?= Html::a('ลงทะเบียนออนไลน์',['register/create'],['class' => 'btn btn-lg btn-success']) ?>
        <?php //= Html::a('แจ้งการโอนเงิน',['register/payment'],['class' => 'btn btn-lg btn-info']) ?>
        <hr />
        <p style="text-align:center"><br />
        <span style="font-size:20px">ทางผู้จัดงานต้องขออภัยในการปรับเปลี่ยนรูปแบบการจัดงาน และขอขอบคุณนักวิ่งทุกท่านมา ณ โอกาสนี้</span></p>

    </div>
  </div>
</div>
