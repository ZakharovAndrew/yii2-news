<?php

/**
 * Yii2 News
 * *************
 *  
 * @link https://github.com/ZakharovAndrew/yii2-news/
 * @copyright Copyright (c) 2024 Zakharov Andrew
 */
 
namespace ZakharovAndrew\news;

use Yii;

/**
 * User module
 */
class Module extends \yii\base\Module
{    
    /**
     * @var string Module version
     */
    protected $version = "0.0.4";

    /**
     * @var string Alias for module
     */
    public $alias = "@news";
    
    /**
     * @var string version Bootstrap
     */
    public $bootstrapVersion = '';
 
    public $useTranslite = false;
    
    /**
     * @var string show H1
     */
    public $showTitle = true;
    
    /**
     *
     * @var string source language for translation 
     */
    public $sourceLanguage = 'en-US';
    
    /**
     * @inheritdoc
     */
    public $controllerNamespace = 'ZakharovAndrew\news\controllers';


    /**
     * {@inheritdoc}
     * @throws \yii\base\InvalidConfigException
     */
    public function init()
    {
        parent::init();
        
        self::registerTranslations();
    }
    
    /**
     * Registers the translation files
     */
    protected static function registerTranslations()
    {
        if (isset(Yii::$app->i18n->translations['extension/yii2-news/*'])) {
            return;
        }
        
        Yii::$app->i18n->translations['extension/yii2-news/*'] = [
            'class' => 'yii\i18n\PhpMessageSource',
            'sourceLanguage' => 'en-US',
            'basePath' => '@vendor/zakharov-andrew/yii2-news/src/messages',
            'on missingTranslation' => ['app\components\TranslationEventHandler', 'handleMissingTranslation'],
            'fileMap' => [
                'extension/yii2-news/news' => 'news.php',
            ],
        ];
    }

    /**
     * Translates a message. This is just a wrapper of Yii::t
     *
     * @see Yii::t
     *
     * @param $category
     * @param $message
     * @param array $params
     * @param null $language
     * @return string
     */
    public static function t($message, $params = [], $language = null)
    {
        static::registerTranslations();
        
        $category = 'news';
        return Yii::t('extension/yii2-news/' . $category, $message, $params, $language);
    }
    
}
