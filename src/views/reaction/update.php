<?php

use yii\helpers\Html;
use ZakharovAndrew\news\Module;

/** @var yii\web\View $this */
/** @var ZakharovAndrew\news\models\NewsReaction $model */

$this->title = Module::t('Update Reaction') . ': ' . $model->id;
$this->params['breadcrumbs'][] = ['label' => Module::t('News Reactions'), 'url' => ['index']];
$this->params['breadcrumbs'][] = Module::t('Update');
?>
<div class="news-reactions-update">

    <?php if (Yii::$app->getModule('news')->showTitle) {?><h1><?= Html::encode($this->title) ?></h1><?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
    ]) ?>

</div>
