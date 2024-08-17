<?php 

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;

class Reaction extends ActiveRecord
{
    public static function tableName()
    {
        return '{{%reactions}}';
    }

    public function rules()
    {
        return [
            [['name'], 'required'],
            [['name'], 'string'],
        ];
    }
}