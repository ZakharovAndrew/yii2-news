<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/** @var yii\web\View $this */
/** @var ZakharovAndrew\news\models\NewsReaction $model */
/** @var yii\widgets\ActiveForm $form */
?>

<div class="news-reactions-form">

    <?php $form = ActiveForm::begin(); ?>

    <?= $form->field($model, 'news_id')->textInput() ?>

    <?= $form->field($model, 'user_id')->textInput() ?>

    <?= $form->field($model, 'reaction_id')->textInput() ?>

    <div class="form-group">
        <?= Html::submitButton('Save', ['class' => 'btn btn-success']) ?>
    </div>

    <?php ActiveForm::end(); ?>

</div>
