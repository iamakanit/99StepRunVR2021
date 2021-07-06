<?php

/* @var $this \yii\web\View */
/* @var $content string */

use backend\assets\AppAsset;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use yii\helpers\Url;
use common\widgets\Alert;

AppAsset::register($this);
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <?= Html::csrfMetaTags() ?>

    <link rel="apple-touch-icon" sizes="57x57" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-57x57.png">
    <link rel="apple-touch-icon" sizes="60x60" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-60x60.png">
    <link rel="apple-touch-icon" sizes="72x72" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-72x72.png">
    <link rel="apple-touch-icon" sizes="76x76" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-76x76.png">
    <link rel="apple-touch-icon" sizes="114x114" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-114x114.png">
    <link rel="apple-touch-icon" sizes="120x120" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-120x120.png">
    <link rel="apple-touch-icon" sizes="144x144" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-144x144.png">
    <link rel="apple-touch-icon" sizes="152x152" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-152x152.png">
    <link rel="apple-touch-icon" sizes="180x180" href="<?= Yii::$app->request->baseUrl; ?>/icon/apple-icon-180x180.png">
    <link rel="icon" type="image/png" sizes="192x192"  href="<?= Yii::$app->request->baseUrl; ?>/icon/android-icon-192x192.png">
    <link rel="icon" type="image/png" sizes="32x32" href="<?= Yii::$app->request->baseUrl; ?>/icon/favicon-32x32.png">
    <link rel="icon" type="image/png" sizes="96x96" href="<?= Yii::$app->request->baseUrl; ?>/icon/favicon-96x96.png">
    <link rel="icon" type="image/png" sizes="16x16" href="<?= Yii::$app->request->baseUrl; ?>/icon/favicon-16x16.png">
    <link rel="manifest" href="<?= Yii::$app->request->baseUrl; ?>/icon/manifest.json">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= Yii::$app->request->baseUrl; ?>/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">

    <meta http-equiv="Expires" content="Mon,16 Feb 2020 00:00:00 ICT">
    <meta http-equiv="Cache-Control" content="no-cache" />
    <meta http-equiv="Pragma" content="no-cache">

    <title>PRC ALUMNI RUNNING CLUB Virtual Run 2021 : Backend </title>
    <?php $this->head() ?>
  </head>
  <body>
    <?php $this->beginBody() ?>
    <div class="wrap">
    <?php
    NavBar::begin([
      'brandLabel' => 'PRC ALUMNI RUNNING CLUB Virtual Run 2021 : Backend ',
      'brandUrl' => Yii::$app->homeUrl,
      'options' => [
        'class' => 'navbar navbar-default',
      ],
    ]);

    $menuItemsRight = [];

    if (Yii::$app->user->isGuest) {
      $menuItemsRight[] = ['label' => '<span class="fa fa-sign-in" aria-hidden="true"></span> '.Yii::t('app', 'Sign in'), 'url' => ['/site/login']];
    } else {
//        $menuItemsRight[] = ['label' => '<span class="fa fa-newspaper-o"></span> จัดการข่าว', 'url' => ['news/index']];
      $menuItemsRight[] = ['label' => '<span class="fa fa-cube"></span> จัดการรายการ', 'url' => ['group/index']];
      $menuItemsRight[] = ['label' => '<span class="fa fa-calendar"></span> จัดการกำหนดการ', 'url' => ['timeline/view']];
      $menuItemsRight[] = ['label' => '<span class="fa fa-users"></span> จัดการผู้ลงทะเบียน', 'url' => ['register/index']];
//        $menuItemsRight[] = ['label' => '<span class="fa fa-download"></span> จัดการเอกสาร', 'url' => ['document/index']];
      $menuItemsRight[] = ['label' => '<span class="fa fa-bank"></span> จัดการประเภท', 'url' => ['department/index']];
      $menuItemsRight[] = ['label' => '<span class="fa fa-bank"></span> จัดการขนาดเสื้อ', 'url' => ['shirt/index']];
//        $menuItemsRight[] = ['label' => '<span class="fa fa-cog"></span> ตั้งค่า', 'url' => ['sitesetting/setting']];
      $menuItemsRight[] = ['label' => '<span class="fa fa-sign-out" aria-hidden="true"></span> '.Yii::t('app', 'Sign out'), 'url' => ['site/logout'],'linkOptions' => ['data-method' => 'post']];
    }

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItemsRight,
		    'encodeLabels' => false,
      ]);

    NavBar::end();
    ?>

    <?= Breadcrumbs::widget([
            'links' => isset($this->params['breadcrumbs']) ? $this->params['breadcrumbs'] : [],
        ]) ?>
    <div class="container">
      <?= Alert::widget() ?>
      <?= $content ?>
    </div>
    <div class="footer-offset"></div>
    </div>

<footer>
    <div class="container">

        <div class="row">
            <div class="col-lg-10 col-lg-offset-1 text-center">
                <p class="">
                    Copyright &copy; <?= date('Y') ?> by 99 StepRun
                    &nbsp;
                    All Rights Reserved.
                </p>
            </div>
        </div>
    </div>
</footer>

<?php $this->endBody() ?>
</body>
</html>
<?php $this->endPage() ?>
