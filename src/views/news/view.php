<?php

use yii\helpers\Html;
use ZakharovAndrew\news\Module;

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>
    .comments-count {
        font-size: 20px;
        line-height: 28px;
        font-weight: bold;
    }
    .news-btn-comment {
        font-size: 15px;
        line-height: 22px;
        color: #595959;
        margin-right: 16px;
        cursor: pointer;
        white-space: nowrap;
    }
    .comment-child {
        border: 1px solid #ebebeb;
        border-radius: 12px;
        margin-left: 10px; 
    }
</style>

<h1><?= Html::encode($this->title)?></h1>

<p><?= $model->content?></p>

<?= $model->views?> просмотров

<p><?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => ''])?> | <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => ''])?></p>

<?php foreach ($reactions as $reaction):?>
    <?= Html::a($reaction->name, ['react', 'news_id' => $model->id, 'reaction_id' => $reaction->id], ['class' => 'btn btn-primary'])?>
<?php endforeach;?>

<?php 
$comments = $model->getComments()->where('parent_id is null')->orderBy('created_at DESC')->all();
$cnt_comment = $model->getComments()->count();
?>
<div class="comments-count">Комментарии (<?=$cnt_comment?>):</div>
<?php foreach ($comments as $comment):?>
    <div class="comment">
        <p><?= $comment->content?></p>
        <p>Автор: <?= $comment->author->username?></p>
        <p><?= Html::a('Ответить', ['comment/create', 'news_id' => $model->id, 'parent_id' => $comment->id], ['class' => 'news-btn-comment'])?> | <?= Html::a('Редактировать', ['comment/update', 'id' => $comment->id])?> | <?= Html::a('Удалить', ['comment/delete', 'id' => $comment->id])?></p>
        <h3>Ответы:</h3>
        <?php foreach ($comment->children as $child):?>
            <div class="comment-child">
                <p><?= $child->content?></p>
                <p>Автор: <?= $child->author->username?></p>
                <p><?= Html::a('Редактировать', ['comment/update', 'id' => $child->id])?> | <?= Html::a('Удалить', ['comment/delete', 'id' => $child->id])?></p>
            </div>
        <?php endforeach;?>
        
    </div>
<?php endforeach;?>

<?= Html::a('Добавить комментарий', ['comment/create', 'news_id' => $model->id], ['class' => 'btn btn-primary'])?>