<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\Comment */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="comment-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6])?>

    <div class="form-group">
        <?= Html::submitButton('Добавить комментарий', ['class' => 'btn btn-primary'])?>
    </div>

    <?php ActiveForm::end();?>

</div>