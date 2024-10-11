<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;
use ZakharovAndrew\news\Module;
use ZakharovAndrew\news\assets\NewsAssets;

/* @var $this yii\web\View */
/* @var $news ZakharovAndrew\news\models\News */
/* @var $pagination yii\data\Pagination */

$this->title = Module::t('News');
$this->params['breadcrumbs'][] = $this->title;

NewsAssets::register($this);
?>

<?php if (Yii::$app->getModule('news')->showTitle) {?><h1><?= Html::encode($this->title) ?></h1><?php } ?>

<div class="news-container">
<?php foreach ($news as $model):?>
    <div class="news-block">
        <h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id])?></h2>
        <p><?= $model->content?></p>
    </div>
<?php endforeach;?>

<?= LinkPager::widget(['pagination' => $pagination])?>
</div>