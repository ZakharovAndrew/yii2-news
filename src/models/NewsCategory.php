<?php

namespace ZakharovAndrew\news\models;

use Yii;

/**
 * This is the model class for table "news_categories".
 *
 * @property int $id
 * @property string $name
 * @property string $url
 *
 * @property News[] $news
 * @property NewsCategoryLinks[] $newsCategoryLinks
 */
class NewsCategory extends \yii\db\ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_categories';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['name', 'url'], 'required'],
            [['name', 'url'], 'string', 'max' => 255],
            [['name'], 'unique'],
            [['url'], 'unique'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'id' => 'ID',
            'name' => 'Name',
            'url' => 'Url',
        ];
    }

    /**
     * Gets query for [[News]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasMany(News::class, ['id' => 'news_id'])->viaTable('news_category_links', ['category_id' => 'id']);
    }

    /**
     * Gets query for [[NewsCategoryLinks]].
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNewsCategoryLinks()
    {
        return $this->hasMany(NewsCategoryLinks::class, ['category_id' => 'id']);
    }
}
