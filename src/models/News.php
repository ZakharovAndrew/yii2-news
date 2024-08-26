<?php 

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;
use ZakharovAndrew\news\Module;
use ZakharovAndrew\user\models\Roles;
use ZakharovAndrew\news\models\Comment;
use ZakharovAndrew\news\models\NewsReaction;
use ZakharovAndrew\news\models\NewsCategory;

class News extends ActiveRecord
{
    public static function tableName()
    {
        return 'news';
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'required'],
            [['user_id'], 'integer'],
            [['title'], 'string', 'max' => 255],
            [['content'], 'string'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => Module::t('Title'),
            'content' => Module::t('Content'),
            'views' => 'Просмотры',
            'created_at' => Module::t('Created'),
            'updated_at' => 'Обновлено',
            'roles' => 'Роли',
        ];
    }
    
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['news_id' => 'id']);
    }
    
    public function getRoles()
    {
        return $this->hasMany(Roles::className(), ['id' => 'role_id'])
            ->viaTable('{{%news_roles}}', ['news_id' => 'id']);
    }
    
    public function getReactions()
    {
        return $this->hasMany(NewsReaction::className(), ['news_id' => 'id']);
    }
    
    public function saveRoles($roles)
    {
        NewsRoles::deleteAll(['news_id' => $this->id]);
    }
    
    public function getCategories()
    {
        return $this->hasMany(NewsCategory::className(), ['id' => 'category_id'])
            ->viaTable('{{%news_category_links}}', ['news_id' => 'id']);
    }
    
    public function saveCategories($categories)
    {
        NewsCategoryLinks::deleteAll(['news_id' => $this->id]);

        foreach ($categories as $category) {
            $link = new NewsCategoryLinks();
            $link->news_id = $this->id;
            $link->category_id = $category;
            $link->save();
        }
    }
}