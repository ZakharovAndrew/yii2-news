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
            [['name', 'css_class'], 'required'],
            [['name', 'css_class'], 'string', 'max' => 255],
        ];
    }
    
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => Module::t('Name'),
            'css_class' => 'CSS class',
        ];
    }
}