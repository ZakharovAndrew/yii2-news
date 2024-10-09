<?php

use yii\helpers\Html;

/** @var yii\web\View $this */
/** @var ZakharovAndrew\news\models\NewsReaction $model */

$this->title = 'Create News Reaction';
$this->params['breadcrumbs'][] = ['label' => 'News Reactions', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<div class="news-reactions-create">

    <h1><?= Html::encode($this->title) ?></h1>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
