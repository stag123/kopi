<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\ErrorAsset;
ErrorAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Message */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Messages', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-view" style="background-color:#FFF; margin:0 auto; width: 600px;padding: 40px; border-radius: 5px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= DetailView::widget([
        'model' => $model,
        'attributes' => [
            'userTo.username',
            'text:ntext',
            'created_at'
        ],
    ]) ?>

</div>
