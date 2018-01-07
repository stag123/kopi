<?php

use yii\helpers\Html;
use yii\widgets\DetailView;
use app\assets\ErrorAsset;
ErrorAsset::register($this);

/* @var $this yii\web\View */
/* @var $model app\models\Report */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Reports', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="report-view" style="background-color:#FFF; margin:0 auto; width: 600px;padding: 40px; border-radius: 5px">

    <h1><?= Html::encode($this->title) ?></h1>

    <p>
        <?= Html::a('Delete', ['delete', 'id' => $model->id], [
            'class' => 'btn btn-danger',
            'data' => [
                'confirm' => 'Are you sure you want to delete this item?',
                'method' => 'post',
            ],
        ]) ?>
    </p>

    <?php

    $details = json_decode($model->details);
    ?>
    Нападение<br/>
    <div class="army">
        <?php foreach (\app\components\village\build\unit\models\Unit::GetTypes() as $code) {?>
            <div class="unit <?= $code;?>"><?= $details->offStart->{$code};?> -&gt; <?= $details->off->{$code};?></div>
        <?php } ?>
    </div>

    Защита<br/>
    <div class="army">
        <?php foreach (\app\components\village\build\unit\models\Unit::GetTypes() as $code) {?>
            <div class="unit <?= $code;?>"><?= $details->defStart->{$code};?> -&gt; <?= $details->def->{$code};?></div>
        <?php } ?>
    </div>

    Добыча<br/>
    <div class="price">
        <div class="resource wood">
            <span class="count"><?= $details->resource->wood;?></span>
        </div>
        <div class="resource iron">
            <span class="count"><?= $details->resource->iron;?></span>
        </div>
        <div class="resource stone">
            <span class="count"><?= $details->resource->stone;?></span>
        </div>
        <div class="resource grain">
            <span class="count"><?= $details->resource->grain;?></span>
        </div>
    </div>


</div>
