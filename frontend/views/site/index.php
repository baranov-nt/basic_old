<?php
use common\widgets\SlideReveal\SlideRevealWidget;
use himiklab\ipgeobase\IpGeoBase;
/* @var $this yii\web\View */
/* @var $user \common\models\User */

$this->title = Yii::$app->name;
$user = Yii::$app->user->identity;
?>
<div class="container">
    <div class="site-index">
    </div>
<?php
//function getIP(){
    if (!empty($_SERVER['HTTP_CLIENT_IP'])){
        $ip=$_SERVER['HTTP_CLIENT_IP'];
    } elseif (!empty($_SERVER['HTTP_X_FORWARDED_FOR'])){
        $ip=$_SERVER['HTTP_X_FORWARDED_FOR'];
    } else {
        $ip=$_SERVER['REMOTE_ADDR'];
    }
    //return $ip;
//}
/*d($ip);
$modelIpGeoBase = new IpGeoBase();
$modelIpGeoBase->updateDB();
d(Yii::$app->ipgeobase->getLocation($ip));*/
/*$Info = \Yii::createObject([
    'class' => \rmrevin\yii\geoip\HostInfo::className(),
    'host' => '109.198.112.66', // some host or ip
]);*/

// check available
//$Info->isAvailable();

// obtaining all data
/*$Info = $Info->getData();
$rrr = $Info->getContinentCode();*/
//d($Info->getContinentCode());

//Along with free DB
/*$location = Yii::$app->geoip->lookupLocation();
d($location);
$countryCode = Yii::$app->geoip->lookupCountryCode();
$countryName = Yii::$app->geoip->lookupCountryName();*/

//Required Paid DB
/*$org = Yii::$app->geoip->lookupOrg();
$regionCode = Yii::$app->geoip->lookupRegion();

$location->countryCode;
$location->countryCode3;
$location->countryName;
$location->region;
$location->regionName;
$location->city;
$location->postalCode;
$location->latitude;
$location->longitude;
$location->areaCode;
$location->dmaCode;
$location->timeZone;
$location->continentCode;*/
/*if (isset($user)) {
    Yii::$app->formatter->timeZone = 'Europe/London';
    */?><!--
    <?/*= Yii::$app->formatter->asDatetime($user->created_at, 'long'); */?>
    <br>
    <?php /*Yii::$app->formatter->timeZone = 'Asia/Yekaterinburg'; */?>
    --><?/*= Yii::$app->formatter->asDatetime($user->created_at, 'long');
}*/
?>
<?php
//phpinfo();
/*echo SlideRevealWidget::widget([
    'header' => Yii::t('app', 'Chat room'),
    'idButton' => 'chatButton',
    'idBlock' => 'chatBlock',
    'classButton' => 'handle-right',
    'iconButton' => 'fa fa-comment-o fa-2x',
    'width' => '30%',
    'push' => false,
    'overlay' => false,
    'position' => 'right',
    'autoEscape' => false,
]);*/
?>
    <?php
    //phpinfo();
    /*echo SlideRevealWidget::widget([
        'header' => Yii::t('app', 'Chat room'),
        'idButton' => 'chatButton',
        'idBlock' => 'chatBlock',
        'classButton' => 'handle-right',
        'iconButton' => 'fa fa-comment-o fa-2x',
        'width' => '30%',
        'push' => false,
        'overlay' => false,
        'position' => 'right',
        'autoEscape' => false,
    ]);*/
    ?>
</div>

