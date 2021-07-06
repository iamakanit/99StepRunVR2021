<?php
/* @var $this \yii\web\View */
/* @var $content string */
use yii\helpers\Html;
use yii\helpers\Url;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use frontend\assets\AppAsset;
use common\widgets\Alert;
use yii\widgets\Breadcrumbs;

AppAsset::register($this);
?>

<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
  <head>
    <?= Html::csrfMetaTags() ?>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta name="viewport" content="width=device-width, initial-scale=1, maximum-scale=1, user-scalable=no">
    <meta name="msapplication-TileColor" content="#ffffff">
    <meta name="msapplication-TileImage" content="<?= Yii::$app->request->baseUrl; ?>/icon/ms-icon-144x144.png">
    <meta name="theme-color" content="#ffffff">
    <meta http-equiv="Expires" content="Mon,16 Feb 2020 00:00:00 ICT">
    <meta http-equiv="Cache-Control" content="no-cache" >
    <meta http-equiv="Pragma" content="no-cache">
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
	   <!-- <meta name="google-site-verification" content="e4crLx5AKUKPpW5AZH66vUmr5cQk_SW4IiP02P5TTJA" /> -->
	  <script src="https://kit.fontawesome.com/6cf1de9a78.js"></script>

    <title>PRC ALUMNI RUNNING CLUB Virtual Run 2021</title>
    <?php $this->head() ?>
  </head>
  <body>
<?php $this->beginBody() ?>
  <header>
  <!-- <?//= Html::img(Yii::$app->request->baseUrl.'/images/coopday8th.jpg',['class' => 'img-responsive']) ?>
    <div class="container">
      <p style="font-size: 160%;"></p>
      <!-- <a href="https://www.99steprun.net/"> PRC Running club, The Prince Royal's College Alumni Association</a>
    </div>--->
  </header>
  <div class="wrap">
    <?php
    NavBar::begin([
      'brandLabel' => 'PRC ALUMNI RUNNING CLUB Virtual Run 2021',
      'brandUrl' => Yii::$app->homeUrl,
      'options' => [
        'class' => 'navbar navbar-default',
      ],
    ]);
    $menuItems = [
   //   ['label' => '<span class="fa fa-home"></span> หน้าแรก', 'url' => ['site/index']],
      ['label' => '<i class="fas fa-home"></i> หน้าแรก', 'url' => ['timeline/view']],
   	  ['label' => '<i class="fas fa-exclamation-circle"></i> กติกา', 'url' => ['site/rule']],
      ['label' => '<i class="fas fa-user-plus"></i> ลงทะเบียนออนไลน์', 'url' => ['register/create']],
      ['label' => '<span class="fa fa-credit-card"></span> แจ้งการโอนเงิน', 'url' => ['register/payment']],
      ['label' => '<i class="fas fa-running"></i> แจ้งผลการวิ่ง', 'url' => ['register/results']],
      ['label' => '<i class="fas fa-check-circle"></i> ตรวจสอบสถานะ/ระยะการวิ่งสะสม', 'url' => ['register/index']],
  //    ['label' => '<i class="fas fa-gift"></i> เสื้อและเหรียญที่ระลึก', 'url' => ['site/privileges']],
  //    ['label' => '<span class="fa fa-map"></span> เส้นทาง', 'url' => ['site/map']],
  //   ['label' => '<i class="far fa-envelope"></i> แจ้งที่อยู่', 'url' => ['register/address']],
  //  ['label' => '<span class="fa fa-newspaper-o"></span> ข่าวประชาสัมพันธ์', 'url' => ['news/index']],
  //  ['label' => '<span class="fa fa-user"></span> ลงทะเบียนออนไลน์', 'url' => ['site/']],
  //  ['label' => '<span class="fa fa-download"></span> Download เอกสาร', 'url' => ['document/index']],
  //  ['label' => '<span class="fa fa-user"></span> ลงทะเบียนออนไลน์ VIP', 'url' => ['vregister/create']],
  //  [],
      //['label' => '', 'url' => ['register/create']],
    ];

    echo Nav::widget([
        'options' => ['class' => 'navbar-nav navbar-right'],
        'items' => $menuItems,
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
    <div class="super-footer">
      <div class="container">
        <div class="row">
          <div class="col-lg-10 col-lg-offset-1 text-center">
            <p>
              <a href="https://m.me/99steprun">  &nbsp;<img src="../home/images/logo-24.png" width="20"> Contact us on Messenger &nbsp;https://m.me/99steprun</a><br />
              Copyright &copy; <?= date('Y') ?> 99StepRun&nbsp;All Rights Reserved.
              &nbsp;
            </p>
          </div>
        </div>
      </div>
    </div>
  </footer>

<?php $this->endBody() ?>
  </body>
</html>
<?php $this->endPage() ?>
