<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ZakharovAndrew\news\Module;

use ZakharovAndrew\user\assets\UserAssets;
use yii\helpers\Url;
UserAssets::register($this);

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
        text-decoration: none;
    }
    .comment-child {
        border-radius: 12px;
        margin-left: 26px;
        padding: 10px;
        position: relative
    }
    .comment .comment-child::before {
        content: "";
        display: block;
        border-left: 1px solid #e5e5e5;
        border-bottom: 1px solid #e5e5e5;
        border-radius: 0 0 0 10px;
        position: absolute;
        width: 16px;
        height: 31px;
        margin-left: -25px;
        margin-top: -10px;
    }
    .comment .comment-child::after {
        content: "";
        display: block;
        border-left: 1px solid #e5e5e5;
        height: 100%;
        width: 26px;
        margin-left: -25px;
        top: 0;
        position: absolute;
    }
    .comment .comment-child:last-child::after {
        display: none;
    }
    .comment-form textarea {
        background: #ebebeb
    }
    .comment-form .help-block {display:none !important;}
    .comment-head {display:flex;gap:10px;margin-bottom:5px;}
    .comment-avatar, .comment-avatar img{width:42px;height:42px;border-radius:50%;background:#ebebeb}
    .comment-author {
        font-size: 15px;
        line-height: 22px;
        display: grid;
        grid-template-columns: 1fr;
        grid-template-rows: repeat(2, auto);
        grid-gap: 0 10px;
        gap: 0 10px;
        align-items: center;
    }
    .comment-datetime {
        font-size:13px;
        color:#595959;
    }
    .comment-block {
        background: #fff;
        border-radius: 12px;
        padding:20px;
        margin-top:20px;
    }
    .comment-actions {
        display: flex;
        align-items: center;
        flex-wrap: wrap;
        margin: 7px 0;
    }
    .comment-actions a {
        margin-right: 16px;
        font-size:14px;
        text-decoration: none;
    }
    .comment-actions a:hover {
        text-decoration: underline;
    }
    .comment-content {
        font-size:17px;
    }
    body {
        background: #ebebeb;
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
<div class="comment-block">
    <div class="comments-count">Комментарии (<?=$cnt_comment?>):</div>

    <div class="comment-form">

        <?php $form = ActiveForm::begin(['action' => ['comment/create', 'news_id' => $model->id]]);?>

        <?= $form->field($modelComment, 'content')->textarea(['rows' => 3, 'placeholder' => "Комментарий..."])->label(false)?>

        <div class="form-group">
            <?= Html::submitButton('Добавить комментарий', ['class' => 'btn btn-primary'])?>
        </div>

        <?php ActiveForm::end();?>

    </div>

    <?php foreach ($comments as $comment):?>
        <div class="comment">
            <div class="comment-head">
                <div class="comment-avatar"><img src="<?= !$comment->author->getAvatarUrl() ?
                                Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                                $comment->author->getAvatarUrl()
                            ?>" alt="Avatar"></div>
                <div class="comment-author"><?= $comment->author->username?><div class="comment-datetime"><?= date('d.m.Y H:i:s', strtotime($comment->created_at)) ?></div></div>
            </div>
            <div><?= $comment->content?></div>
            <div class="comment-actions"><?= Html::a('Ответить', ['comment/create', 'news_id' => $model->id, 'parent_id' => $comment->id], ['class' => 'news-btn-comment'])?> <?= Html::a('Редактировать', ['comment/update', 'id' => $comment->id])?> <?= Html::a('Удалить', ['comment/delete', 'id' => $comment->id])?></div>
            <?php foreach ($comment->children as $child):?>
                <div class="comment-child">
                    <div class="comment-head">
                        <div class="comment-avatar"></div>
                        <div class="comment-author"><?= $child->author->username?><div class="comment-datetime"><?= date('d.m.Y H:i:s', strtotime($child->created_at)) ?></div></div>
                    </div>
                    <div class="comment-content"><?= $child->content?></div>
                    <div class="comment-actions"><?= Html::a('Редактировать', ['comment/update', 'id' => $child->id])?> <?= Html::a('Удалить', ['comment/delete', 'id' => $child->id])?></div>
                </div>
            <?php endforeach;?>

        </div>
    <?php endforeach;?>
</div>