<?php

use ZakharovAndrew\user\models\Roles;
use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="news-update">

    <h1><?= Html::encode($this->title)?></h1>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => Roles::find()->all(),
    ])?>

</div>