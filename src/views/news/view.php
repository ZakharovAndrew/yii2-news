<?php

use yii\helpers\Html;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => 'Новости', 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>

<h1><?= Html::encode($this->title)?></h1>

<p><?= $model->content?></p>

<h2>Комментарии:</h2>

<?php foreach ($model->comments as $comment):?>
    <div class="comment">
        <p><?= $comment->content?></p>
        <p><?= Html::a('Редактировать', ['comment/update', 'id' => $comment->id])?> | <?= Html::a('Удалить', ['comment/delete', 'id' => $comment->id])?></p>
        <h3>Ответы:</h3>
        <?php foreach ($comment->children as $child):?>
            <div class="comment-child">
                <p><?= $child->content?></p>
                <p><?= Html::a('Редактировать', ['comment/update', 'id' => $child->id])?> | <?= Html::a('Удалить', ['comment/delete', 'id' => $child->id])?></p>
            </div>
        <?php endforeach;?>
        <?= Html::a('Ответить', ['comment/create', 'news_id' => $model->id, 'parent_id' => $comment->id], ['class' => 'btn btn-primary'])?>
    </div>
<?php endforeach;?>

<?= Html::a('Добавить комментарий', ['comment/create', 'news_id' => $model->id], ['class' => 'btn btn-primary'])?>