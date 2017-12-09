<?php

/* @var $this yii\web\View */
/* @var $form yii\bootstrap\ActiveForm */
/* @var $model app\models\LoginForm */

use yii\helpers\Html;
use yii\bootstrap\ActiveForm;
use app\assets\SiteAsset;

$this->title = 'Авторизация / Регистрация';
$this->params['breadcrumbs'][] = $this->title;

SiteAsset::register($this);
?>

<div class="site-login">
    <h1><?= Html::encode($this->title) ?></h1>

    <div id="uLogine11e68d2" data-ulogin="display=panel;fields=first_name,last_name;providers=vkontakte,odnoklassniki,mailru,facebook;hidden=other;redirect_uri=/"></div>


</div>
