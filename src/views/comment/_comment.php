<?php

use yii\helpers\Html;

use ZakharovAndrew\news\Module;

?>
<div class="comment-child">
    <div class="comment-head">
        <div class="comment-avatar"><img src="<?= !$model->author->getAvatarUrl() ?
                Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                $model->author->getAvatarUrl()
            ?>" alt="Avatar"></div>
        <div class="comment-author">
            <?= $model->author->name?>
            <div class="comment-datetime"><?php date('d.m.Y H:i:s', strtotime($model->created_at ?? 'now')) ?></div>
        </div>
    </div>
    <div class="comment-content"><?= $model->content?></div>
    <?php if (\Yii::$app->user->identity->hasRole('admin')) {?>
    <div class="comment-actions"><?= Html::a(Module::t('Edit'), ['comment/update', 'id' => $model->id])?> <?= Html::a('Удалить', ['comment/delete', 'id' => $model->id])?></div>
    <?php } ?>
</div>