<?php

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;
use ZakharovAndrew\news\models\News;
use ZakharovAndrew\news\models\Comment;
use ZakharovAndrew\user\models\User;

class Comment extends ActiveRecord
{
    public static function tableName()
    {
        return 'comments';
    }

    public function rules()
    {
        return [
            [['news_id', 'content'], 'required'],
            [['news_id', 'parent_id'], 'integer'],
            [['content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'news_id' => 'Новость',
            'content' => 'Содержание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }

    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }
    
    public function getAuthor()
    {
        return $this->hasOne(User::className(), ['id' => 'author_id']);
    }
    
    public function getParent()
    {
        return $this->hasOne(static::className(), ['id' => 'parent_id']);
    }

    public function getChildren()
    {
        return $this->hasMany(static::className(), ['parent_id' => 'id']);
    }
    
    public function getDatetime($format = 'd.m.Y H:i:s')
    {
        return date($format, strtotime($this->created_at));
    }
}