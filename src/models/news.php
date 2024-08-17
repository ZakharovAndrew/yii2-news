<?php 

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;

class News extends ActiveRecord
{
    public static function tableName()
    {
        return 'news';
    }

    public function rules()
    {
        return [
            [['title', 'content'], 'equired'],
            [['title'], 'tring', 'ax' => 255],
            [['content'], 'tring'],
        ];
    }

    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'title' => 'Заголовок',
            'content' => 'Содержание',
            'created_at' => 'Создано',
            'updated_at' => 'Обновлено',
        ];
    }
    
    public function getComments()
    {
        return $this->hasMany(Comment::className(), ['news_id' => 'id']);
    }
    
    public function getRoles()
    {
        return $this->hasMany(ZakharovAndrew\user\models\Roles::className(), ['id' => 'role_id'])
            ->viaTable('{{%news_roles}}', ['news_id' => 'id']);
    }
}