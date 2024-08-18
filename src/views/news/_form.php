<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */
/* @var $form yii\widgets\ActiveForm */

?>

<div class="news-form">

    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'content')->textarea(['rows' => 6])?>

    <?= $form->field($model, 'roles')->checkboxList(\yii\helpers\ArrayHelper::map($roles, 'id', 'name'))?>

    <div class="form-group">
        <?= Html::submitButton('Сохранить', ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>