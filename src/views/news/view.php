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

$url_react = Url::to(['react']);
$url_comment_create = Url::to(['comment/create-ajax', 'news_id' => $model->id]);
$news_id = $model->id;

$script = <<< JS
   
$(document).on('click', '.reaction', function(e) {
    e.preventDefault();

    var newsId = $(this).data('news-id');
    var reactionId = $(this).data('reaction-id');
    
    $.ajax({
        url: '$url_react',
        type: 'POST',
        data: {
            news_id: newsId,
            reaction_id: reactionId
        },
        success: function(response) {
            // Обновляем количество реакций на странице
            if (response.success) {
                // Обновляем счетчик реакций
                // Например, если у вас есть элемент с классом reaction_count
                var countElement = $('a[data-news-id="' + newsId + '"][data-reaction-id="' + reactionId + '"]');
                countElement.text(response.new_count);
                countElement.toggleClass('reaction_selected', response.user_reacted);
            }
        },
        error: function() {
            alert('Ошибка при обработке запроса. Пожалуйста, попробуйте еще раз.');
        }
    });
});
        
$(document).on('click', '.reply-button', function(e) {
    e.preventDefault();
    var commentId = $(this).data('id');
        
    // Проверяем, существует ли уже форма ответа
    if ($('#reply-form-' + commentId).length === 0) {
        $(".reply-form").remove();
        var replyFormHtml = `
            <div class="reply-form comment-child" id="reply-form-\${commentId}">
                <textarea rows="2" placeholder="Оставьте ответ..." class="form-control reply-textarea"></textarea>
                <div class="form-group">
                    <button class="btn btn-primary submit-reply" data-comment-id="\${commentId}">Отправить</button>
                </div>
            </div>
        `;
        
        $("#comment-reply-form-"+commentId).append(replyFormHtml);
    } else {
        $('#reply-form-' + commentId).toggle();
    }
});

        
// Обработка отправки ответа на комментарий
$(document).on('click', '.submit-reply', function() {
    var commentId = $(this).data('comment-id');
    var content = $('#reply-form-' + commentId).find('.reply-textarea').val();
    var newsId = $news_id;

    $.ajax({
        url: '$url_comment_create',
        type: 'POST',
        data: {
            news_id: newsId,
            parent_id: commentId,
            content: content
        },
        success: function(response) {
            if (response.success) {
                // Добавить новый комментарий в разметку
                $('#reply-form-' + commentId).before(response.new_comment);
                $('#reply-form-' + commentId).remove(); // delete form
            } else {
                alert('Ошибка при добавлении комментария.');
            }
        },
        error: function() {
            alert('Ошибка при обработке запроса.');
        }
    });
});
JS;
$this->registerJs($script, yii\web\View::POS_READY);
?>
<style>

    body {
        background: #ebebeb;
    }
    .news-block li {
        font-size: 17px;
        margin: 0 0 10px;
    }
    .news-block li, .news-block p, .news-block h1 {
        font-family:Roboto;
    }
</style>

<div class="news-container">
    <div class="news-block">
        <h1><?= Html::encode($this->title)?></h1>

        <p><?= $model->content?></p>

        <?= $model->views?> просмотров

        <p><?= Html::a(Module::t('Edit'), ['update', 'id' => $model->id], ['class' => ''])?> | <?= Html::a(Module::t('Delete'), ['delete', 'id' => $model->id], ['class' => ''])?></p>

        <?php foreach ($reactions as $reaction) {
            $cnt = ZakharovAndrew\news\models\NewsReaction::find()->where([
                'news_id' => $model->id, 'reaction_id' => $reaction->id
            ])->count();
            $cnt_by_user = ZakharovAndrew\news\models\NewsReaction::find()->where([
                'news_id' => $model->id, 'reaction_id' => $reaction->id, 'user_id' => Yii::$app->user->id
            ])->count();?>
            <a href="#" class="reaction <?= $reaction->css_class . ($cnt_by_user > 0 ? ' reaction_selected' : '') ?>" 
                data-news-id="<?= $model->id ?>" data-reaction-id="<?= $reaction->id ?>" 
                title="<?= Html::encode($reaction->name) ?>">
                <?= $cnt ?>
            </a>
        <?php } ?>
    </div>

    <?php 
    $comments = $model->getComments()->where('parent_id is null')->orderBy('created_at DESC')->all();
    $cnt_comment = $model->getComments()->count();
    ?>
    <div class="comment-block" id="comments">
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
            <div class="comment" id="comment-<?= $comment->id ?>">
                <div class="comment-head">
                    <div class="comment-avatar"><img src="<?= !$comment->author->getAvatarUrl() ?
                                    Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                                    $comment->author->getAvatarUrl()
                                ?>" alt="Avatar"></div>
                    <div class="comment-author"><?= $comment->author->name ?><div class="comment-datetime"><?= date('d.m.Y H:i:s', strtotime($comment->created_at)) ?></div></div>
                </div>
                <div><?= $comment->content?></div>
                <div class="comment-actions">
                <?= Html::a(Module::t('Reply'), '#', ['class' => 'news-btn-comment reply-button', 'data-id' => $comment->id]) ?> 
                <?= Html::a('Редактировать', ['comment/update', 'id' => $comment->id])?> 
                <?= Html::a('Удалить', ['comment/delete', 'id' => $comment->id])?>
                </div>
                <div id="comment-reply-form-<?= $comment->id ?>"></div>
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

<script>

</script>