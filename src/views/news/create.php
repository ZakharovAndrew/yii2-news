<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */
/* @var $roles ZakharovAndrew\user\models\Role */

$this->title = 'Добавить новость';
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title)?></h1>

<?php $form = ActiveForm::begin();?>

<?= $form->field($model, 'title')->textInput(['maxlength' => true])?>

<?= $form->field($model, 'content')->textarea(['rows' => 6])?>

<?= Html::label('Роли')?>
<?= Html::checkboxList('roles', [], ArrayHelper::map($roles, 'id', 'name'))?>

<div class="form-group">
    <?= Html::submitButton('Добавить новость', ['class' => 'btn btn-primary'])?>
</div>

<?php ActiveForm::end();?>