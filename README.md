# Yii2 news

[![Latest Stable Version](https://poser.pugx.org/zakharov-andrew/yii2-news/v/stable)](https://packagist.org/packages/zakharov-andrew/yii2-news)
[![Total Downloads](https://poser.pugx.org/zakharov-andrew/yii2-news/downloads)](https://packagist.org/packages/zakharov-andrew/yii2-news)
[![License](https://poser.pugx.org/zakharov-andrew/yii2-news/license)](https://packagist.org/packages/zakharov-andrew/yii2-news)
[![Yii2](https://img.shields.io/badge/Powered_by-Yii_Framework-green.svg?style=flat)](http://www.yiiframework.com/)

The Yii2 News Module is a comprehensive extension designed to facilitate the creation, editing, and management of news content on your website. This versatile module is suitable for a wide range of news types, including blogs, press releases, announcements, and other forms of news publishing.

- Supports user comments
- Supports user actions
- Supports Bootstrap versions: 3, 4, 5
- Supports languages: English, Russian

## Installation

The preferred way to install this extension is through [composer](http://getcomposer.org/download/).

Either run

```
$ composer require zakharov-andrew/yii2-news
```
or add

```
"zakharov-andrew/yii2-news": "*"
```

to the ```require``` section of your ```composer.json``` file.

Subsequently, run

```
./yii migrate/up --migrationPath=@vendor/zakharov-andrew/yii2-news/migrations
```

in order to create the settings table in your database.

Or add to console config

```php
return [
    // ...
    'controllerMap' => [
        // ...
        'migrate' => [
            'class' => 'yii\console\controllers\MigrateController',
            'migrationPath' => [
                '@console/migrations', // Default migration folder
                '@vendor/zakharov-andrew/yii2-news/src/migrations'
            ]
        ]
        // ...
    ]
    // ...
];
```
## Usage

Add this to your main configuration's modules array

```php
    'modules' => [
        'news' => [
            'class' => 'ZakharovAndrew\news\Module',
            'bootstrapVersion' => 5, // if use bootstrap 5
            'showTitle' => true, // display H1 headings (default - true)
        ],
        // ...
    ],
```

## License

**yii2-news** it is available under a MIT License. Detailed information can be found in the `LICENSE.md`.
