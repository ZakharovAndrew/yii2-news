<?php

use ZakharovAndrew\user\models\Roles;
use yii\helpers\Html;
use ZakharovAndrew\news\Module;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */
/* @var $form yii\widgets\ActiveForm */

$this->title = Module::t('Add News');
$this->params['breadcrumbs'][] = ['label' => Module::t('News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<div class="news-update">

    <?php if (Yii::$app->getModule('news')->showTitle) {?><h1><?= Html::encode($this->title) ?></h1><?php } ?>

    <?= $this->render('_form', [
        'model' => $model,
        'roles' => $roles,
        'categories' => $categories,
    ])?>

</div>