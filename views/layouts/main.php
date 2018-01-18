<?php

/* @var $this \app\components\BaseView */
/* @var $content string */
/* @var array $initials */

use app\widgets\Alert;
use yii\helpers\Html;
use yii\bootstrap\Nav;
use yii\bootstrap\NavBar;
use yii\widgets\Breadcrumbs;
use app\assets\AppAsset;
use yii\helpers\Url;
?>
<?php $this->beginPage() ?>
<!DOCTYPE html>
<html lang="<?= Yii::$app->language ?>">
<head>
    <meta charset="<?= Yii::$app->charset ?>">
    <meta http-equiv="X-UA-Compatible" content="IE=edge">
    <meta name="viewport" content="width=device-width, initial-scale=1">
    <?= Html::csrfMetaTags() ?>
    <title><?= Html::encode($this->title) ?></title>
    <script>
        window.initials = <?= $this->params['initials'];?>;
    </script>
    <?php $this->head() ?>
</head>
<body>
<?php $this->beginBody() ?>

<div class="wrap">

    <?php if ($this->currentUser) {?>
    <div class="menu">
        <a href="<?=Url::to(['/map/index', 'x' => $this->currentUser->getVillage()->map->x, 'y' => $this->currentUser->getVillage()->map->y]);?>" class="menu-item map">
            Карта
        </a>
        <a href="<?=Url::to(['/village/view', 'id' => $this->currentUser->getVillage()->id]);?>" class="menu-item village">
            Деревня
        </a>
        <a href="<?=Url::to(['/report/index']);?>" class="menu-item report">
            Отчеты
        </a>
        <a href="<?=Url::to(['/message/index']);?>" class="menu-item message">
            Сообщения
        </a>
        <?php /*<a href="<?=Url::to(['/user/index']);?>" class="menu-item profile">
            Профиль
        </a>*/?>
        <a href="<?=Url::to(['/site/logout']);?>" class="menu-item exit">
            Выход
        </a>
    </div>
        <?php } /*
    NavBar::begin([
        'options' => [
            'class' => '',
        ],
    ]);

    $items = [
        ['label' => Yii::$app->user->isGuest ? 'Главная' : 'Карта', 'url' => Url::to(['/site/index'])]/*,
        ['label' => 'Об игре', 'url' => ['/site/about']],
        ['label' => 'Сообщить об ошибке', 'url' => ['/site/contact']]*/
        /*];



       if (!Yii::$app->user->isGuest) {
           $items[] = (
               '<li>'
               . Html::beginForm(['/site/logout'], 'post')
               . Html::submitButton(
                   'Logout (' . Yii::$app->user->identity->username . ')',
                   ['class' => 'btn btn-link logout']
               )
               . Html::endForm()
               . '</li>'
           );
       }
       echo Nav::widget([
           'options' => ['class' => 'navbar-nav navbar-left'],
           'items' => $items
       ]);
       NavBar::end();*/
    ?>

    <div class="container">
        <?= Alert::widget() ?>
        <?= $content ?>
    </div>
</div>

<footer class="footer">
    <div class="container">
    </div>
</footer>

<?php $this->endBody() ?>
<script async type="text/javascript" src="//ulogin.ru/js/ulogin.js"></script>
</body>
</html>
<?php $this->endPage() ?>
