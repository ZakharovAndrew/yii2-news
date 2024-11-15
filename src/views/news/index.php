<?php

use yii\helpers\Html;
use yii\helpers\Url;
use yii\widgets\LinkPager;
use ZakharovAndrew\news\Module;
use ZakharovAndrew\news\assets\NewsAssets;
use ZakharovAndrew\user\assets\UserAssets;

/* @var $this yii\web\View */
/* @var $news ZakharovAndrew\news\models\News */
/* @var $pagination yii\data\Pagination */

$this->title = Module::t('News');
$this->params['breadcrumbs'][] = $this->title;

NewsAssets::register($this);
?>

<style>

    body {
        background: #ebebeb;
    }  
    .news-head {
        display: flex;
        gap: 10px;
        margin-bottom: 5px;
        margin: 11px 0 5px;
    }
    .news-avatar, .news-avatar img {
        width: 42px;
        height: 42px;
        border-radius: 50%;
        background: #ebebeb;
        overflow: hidden;
    }
    .news-block h2 {
        margin-bottom: 16px;
    }
    .news-block h2 a {
        font-size: 22px;
        line-height: 30px;
        text-decoration: none;
        color: #000;
    }
    .news-block h2 a:hover {
        color:blue;
    }
    .short-content-link {
        position: absolute;
        top: 0;
        left: 0;
        width: 100%;
        height: 100%;
    }
    .new-short-content {
        position: relative
    }
</style>

<?php if (Yii::$app->getModule('news')->showTitle) {?><h1><?= Html::encode($this->title) ?></h1><?php } ?>

<div class="news-container">
<?php if (Yii::$app->user->identity->hasRole('admin')) {?>
    <?= Html::a(Module::t('Add News'), ['create'], ['class' => 'btn btn-success'])?>
<?php } ?>
<?php foreach ($news as $model):?>
    <div class="news-block">
        <div class="news-head">
            <div class="news-avatar"><img src="<?= !$model->author->getAvatarUrl() ?
                            Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                            $model->author->getAvatarUrl()
                        ?>" alt="Avatar"></div>
            <div class="comment-author"><b><?= $model->author->name ?></b><div class="comment-datetime"><?php
            echo Yii::$app->formatter->asDate($model->created_at) ?></div></div>
        </div>
        <div class="new-short-content">
        <h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id])?></h2>
        <article  onclick=""><?= $model->getShortNews() ?></article>
        <?= Html::a('', ['view', 'id' => $model->id], ['class' => 'short-content-link'])?>
        </div>
        <div class="news-footer">
            <a href="<?= Url::to(['view', 'id' => $model->id])?>#comments" class="news-comments-count">
                <div class="news-comments"></div>
                <div class="news-comments-label"><?= $model->getComments()->count() ?></div>
            </a>
        </div>
    </div>
<?php endforeach;?>

<?= LinkPager::widget(['pagination' => $pagination])?>
</div>