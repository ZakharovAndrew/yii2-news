<?php 

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;

class NewsReaction extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%news_reactions}}';
    }

    public function rules()
    {
        return [
            [['news_id', 'user_id', 'reaction_id'], 'required'],
            [['news_id', 'user_id', 'reaction_id'], 'integer'],
        ];
    }

    public function getReactionName()
    {
        return $this->hasOne(Reaction::className(), ['id' => 'reaction_id']);
    }
}