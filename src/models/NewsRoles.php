<?php

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;
use ZakharovAndrew\news\models\News;
use ZakharovAndrew\user\models\Roles;
use ZakharovAndrew\news\Module;

class NewsRoles extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%news_roles}}';
    }

    public function rules()
    {
        return [
            [['news_id', 'role_id'], 'required'],
            [['news_id', 'role_id'], 'integer'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => Module::t('News'),
            'role_id' => Module::t('Role'),
        ];
    }

    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    public function getRole()
    {
        return $this->hasOne(Roles::className(), ['id' => 'role_id']);
    }
}