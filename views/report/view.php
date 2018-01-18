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
            <div class="unit <?= $code;?>"><?= isset($details->offStart->{$code}) ? $details->offStart->{$code} : '0';?> -&gt; <?= $details->off->{$code};?></div>
        <?php } ?>
    </div>

    Защита<br/>
    <div class="army">
        <?php foreach (\app\components\village\build\unit\models\Unit::GetTypes() as $code) {?>
            <div class="unit <?= $code;?>"><?= isset($details->defStart->{$code}) ? $details->defStart->{$code} : '0';?> -&gt; <?= $details->def->{$code};?></div>
        <?php } ?>
    </div>
    <?php if ($res = $details->resource) {?>
    Добыча<br/>
    <div class="price">
        <div class="resource wood">
            <span class="count"><?= isset($res->wood) ? floor($res->wood) : '0';?></span>
        </div>
        <div class="resource iron">
            <span class="count"><?= isset($res->iron) ? floor($res->iron): '0';?></span>
        </div>
        <div class="resource stone">
            <span class="count"><?= isset($res->stone) ? floor($res->stone): '0';?></span>
        </div>
        <div class="resource grain">
            <span class="count"><?= isset($res->grain) ? floor($res->grain): '0';?></span>
        </div>
    </div>
    <?php } ?>

    <?php if (isset($details->buildStart)) { ?>
    Разрушения<br/>
    <div><?= $details->buildStart->build->name;?> ( <?= $details->buildStart->level;?> ) -&gt;  <?php if (isset($details->build)) {?> <?= $details->build->build->name;?> ( <?= $details->build->level;?> )<?php } else { ?>Здание разрушено<?php } ?></div>
    <?php } ?>

</div>
