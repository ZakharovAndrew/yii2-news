<?php

use yii\helpers\Html;
use yii\widgets\ActiveForm;
use ZakharovAndrew\news\Module;

use ZakharovAndrew\user\assets\UserAssets;
use yii\helpers\Url;

UserAssets::register($this);

/* @var $this yii\web\View */
/* @var $comment ZakharovAndrew\news\models\Comment */
/* @var $form yii\widgets\ActiveForm */

?>

<?php foreach ($comments as $comment):?>
    <div class="comment" id="comment-<?= $comment->id ?>">
        <div class="comment-head">
            <div class="comment-avatar"><img src="<?= !$comment->author->getAvatarUrl() ?
                            Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                            $comment->author->getAvatarUrl()
                        ?>" alt="Avatar"></div>
            <div class="comment-author"><?= $comment->author->name ?><div class="comment-datetime"><?= $comment->getDatetime() ?></div></div>
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
                    <div class="comment-author"><?= $child->author->name?><div class="comment-datetime"><?= $child->getDatetime() ?></div></div>
                </div>
                <div class="comment-content"><?= $child->content?></div>
                <?php if (isset($is_admin)) {?>
                <div class="comment-actions"><?= Html::a(Module::t('Edit'), ['comment/update', 'id' => $child->id])?> <?= Html::a('Удалить', ['comment/delete', 'id' => $child->id])?></div>
                <?php } ?>
            </div>
        <?php endforeach;?>

    </div>
<?php endforeach;?>