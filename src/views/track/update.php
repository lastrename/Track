<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model app\models\Track */

$this->title = 'Update Track: ' . $model->track_number;
$this->params['breadcrumbs'][] = ['label' => 'Tracks', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->track_number, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="track-update">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
