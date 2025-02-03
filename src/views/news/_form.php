<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ZakharovAndrew\news\Module;
use ZakharovAndrew\user\assets\UserAssets;

UserAssets::register($this);

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */
/* @var $form yii\widgets\ActiveForm */

$this->registerJsFile('https://cdn.ckeditor.com/ckeditor5/41.1.0/classic/ckeditor.js');
$script = <<< JS
        
ClassicEditor
    .create( document.querySelector( '#news-content' ) )
    .catch( error => {
        console.error( error );
    } );

JS;
$this->registerJs($script, yii\web\View::POS_READY);
//var_dump($model->roles); die();
?>
<style>
    #news-roles label {width:24%}
</style>

<div class="news-form">

    <div class="white-block">
    <?php $form = ActiveForm::begin();?>

    <?= $form->field($model, 'title')->textInput(['maxlength' => true])?>

    <?= $form->field($model, 'content')->textarea(['rows' => 10])?>
    
    <?= $form->field($model, 'categories')->checkboxList(\yii\helpers\ArrayHelper::map($categories, 'id', 'name')) ?>

    <?= $form->field($model, 'roles')->checkboxList($roles)?>
    </div>

    <div class="form-group">
        <?= Html::submitButton(Module::t('Save'), ['class' => 'btn btn-success'])?>
    </div>

    <?php ActiveForm::end();?>

</div>
