<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ZakharovAndrew\news\Module;

use ZakharovAndrew\user\assets\UserAssets;
use ZakharovAndrew\news\assets\NewsAssets;
use yii\helpers\Url;

UserAssets::register($this);
NewsAssets::register($this);

/* @var $this yii\web\View */
/* @var $model ZakharovAndrew\news\models\News */

$this->title = $model->title;
$this->params['breadcrumbs'][] = ['label' => Module::t('News'), 'url' => ['index']];
$this->params['breadcrumbs'][] = $this->title;
?>
<style>

    body {
        background: #ebebeb;
    }    
</style>

<div class="news-container">
    <div class="news-block">
        <h1><?= Html::encode($this->title)?></h1>

        <p><?= $model->content?></p>

        <?= $model->views?> просмотров

        <p><?= Html::a('Редактировать', ['update', 'id' => $model->id], ['class' => ''])?> | <?= Html::a('Удалить', ['delete', 'id' => $model->id], ['class' => ''])?></p>

        <?php foreach ($reactions as $reaction) {
            $cnt = ZakharovAndrew\news\models\NewsReaction::find()->where([
                'news_id' => $model->id, 'reaction_id' => $reaction->id
            ])->count();
            $cnt_by_user = ZakharovAndrew\news\models\NewsReaction::find()->where([
                'news_id' => $model->id, 'reaction_id' => $reaction->id, 'user_id' => Yii::$app->user->id
            ])->count();
            echo Html::a($cnt, ['react', 'news_id' => $model->id, 'reaction_id' => $reaction->id], ['class' => 'reaction '.$reaction->css_class . ($cnt_by_user > 0 ? ' reaction_selected' : ''), 'title' => $reaction->name]);
        } ?>
    </div>

    <?php 
    $comments = $model->getComments()->where('parent_id is null')->orderBy('created_at DESC')->all();
    $cnt_comment = $model->getComments()->count();
    ?>
    <div class="comment-block">
        <div class="comments-count"><?= Module::t('Comments') ?> (<?=$cnt_comment?>):</div>

        <div class="comment-form">

            <?php $form = ActiveForm::begin(['action' => ['comment/create', 'news_id' => $model->id]]);?>

            <?= $form->field($modelComment, 'content')->textarea(['rows' => 3, 'placeholder' => Module::t('Comments')."..."])->label(false)?>

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
                    <div class="comment-author"><?= $comment->author->name ?><div class="comment-datetime"><?= date('d.m.Y H:i:s', strtotime($comment->created_at)) ?></div></div>
                </div>
                <div><?= $comment->content?></div>
                <div class="comment-actions"><?= Html::a(Module::t('Reply'), ['comment/create', 'news_id' => $model->id, 'parent_id' => $comment->id], ['class' => 'news-btn-comment'])?> <?= Html::a('Редактировать', ['comment/update', 'id' => $comment->id])?> <?= Html::a('Удалить', ['comment/delete', 'id' => $comment->id])?></div>
                <?php foreach ($comment->children as $child):?>
                    <div class="comment-child">
                        <div class="comment-head">
                            <div class="comment-avatar"><img src="<?= !$child->author->getAvatarUrl() ?
                                    Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                                    $child->author->getAvatarUrl()
                                ?>" alt="Avatar"></div>
                            <div class="comment-author"><?= $child->author->name?><div class="comment-datetime"><?= date('d.m.Y H:i:s', strtotime($child->created_at)) ?></div></div>
                        </div>
                        <div class="comment-content"><?= $child->content?></div>
                        <div class="comment-actions"><?= Html::a(Module::t('Edit'), ['comment/update', 'id' => $child->id])?> <?= Html::a('Удалить', ['comment/delete', 'id' => $child->id])?></div>
                    </div>
                <?php endforeach;?>

            </div>
        <?php endforeach;?>
    </div>
    
</div>