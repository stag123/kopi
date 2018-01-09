<?php

use yii\helpers\Html;
use yii\grid\GridView;
use app\models\Message;
use app\assets\ErrorAsset;
use yii\helpers\Url;
ErrorAsset::register($this);
/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Сообщения';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="message-index" style="background-color:#FFF; margin:0 auto; width: 600px;padding: 40px; border-radius: 5px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [
            'created_at',
            'userFrom.username',
            'userTo.username',
            [
                'attribute' => 'title',
                'value' => function (Message $data) {
                    return ($data->status == 0 ? '(не прочитано)': '') . Html::a(Html::encode($data->title), Url::to(['view', 'id' => $data->id]));
                },
                'format' => 'raw',
            ],
        ],
    ]); ?>
</div>
