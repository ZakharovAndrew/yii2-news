<?php

use yii\helpers\Html;
use yii\widgets\LinkPager;

/* @var $this yii\web\View */
/* @var $news ZakharovAndrew\news\models\News */
/* @var $pagination yii\data\Pagination */

$this->title = 'Новости';
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title)?></h1>

<?php foreach ($news as $model):?>
    <div class="news-item">
        <h2><?= Html::a($model->title, ['view', 'id' => $model->id])?></h2>
        <p><?= $model->content?></p>
    </div>
<?php endforeach;?>

<?= LinkPager::widget(['pagination' => $pagination])?>