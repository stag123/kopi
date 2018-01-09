<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\grid\GridView;
use \app\models\Report;
use app\assets\ErrorAsset;
ErrorAsset::register($this);

/* @var $this yii\web\View */
/* @var $dataProvider yii\data\ActiveDataProvider */

$this->title = 'Отчеты';
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-index" style="background-color:#FFF; margin:0 auto; width: 600px;padding: 40px; border-radius: 5px">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= GridView::widget([
        'dataProvider' => $dataProvider,
        'columns' => [

            [
                'attribute' => 'title',
                'value' => function (Report $data) {
                    return ($data->status == 0 ? '<b>': '') . Html::a(Html::encode($data->title), Url::to(['view', 'id' => $data->id])) . ($data->status == 0 ? '</b>': '');
                },
                'format' => 'raw',
            ],
         //   'id',
         //   'type',
          //  'user_id',
           // 'village_id',
           // 'title',
            // 'details:ntext',
             'created_at',
            // 'updated_at',

        ],
    ]); ?>
</div>
