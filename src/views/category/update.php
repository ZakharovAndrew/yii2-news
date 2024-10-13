<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ZakharovAndrew\news\models\NewsCategory $model */

$this->title = 'Update News Categories: ' . $model->name;
$this->params['breadcrumbs'][] = ['label' => 'News Categories', 'url' => ['index']];
$this->params['breadcrumbs'][] = ['label' => $model->name, 'url' => ['view', 'id' => $model->id]];
$this->params['breadcrumbs'][] = 'Update';
?>
<div class="news-categories-update">

    <?php if (Yii::$app->getModule('news')->showTitle) {?><h1><?= Html::encode($this->title) ?></h1><?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
