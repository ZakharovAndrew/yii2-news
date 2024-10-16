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
</style>

<?php if (Yii::$app->getModule('news')->showTitle) {?><h1><?= Html::encode($this->title) ?></h1><?php } ?>

<div class="news-container">
<?php foreach ($news as $model):?>
    <div class="news-block">
        <div class="news-head">
            <a href="<?= Url::to(['/user/user/profile', 'id' => $model->author->id])?>" class="news-avatar"><img src="<?= !$model->author->getAvatarUrl() ?
                            Yii::$app->assetManager->getAssetUrl(UserAssets::register($this), 'images/default-avatar.png') :
                            $model->author->getAvatarUrl()
                        ?>" alt="Avatar"></a>
            <div class="comment-author"><b><?= $model->author->name ?></b><div class="comment-datetime"><?php
            echo Yii::$app->formatter->asDate($model->created_at) ?></div></div>
        </div>
        <h2><?= Html::a(Html::encode($model->title), ['view', 'id' => $model->id])?></h2>
        <p><?= $model->getShortNews() ?></p>
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