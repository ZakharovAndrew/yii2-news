<?php

namespace ZakharovAndrew\news\models;

use yii\db\ActiveRecord;

/**
 * This is the model class for table "news_category_links".
 *
 * @property int $news_id
 * @property int $category_id
 */
class NewsCategoryLinks extends ActiveRecord
{
    /**
     * {@inheritdoc}
     */
    public static function tableName()
    {
        return 'news_category_links';
    }

    /**
     * {@inheritdoc}
     */
    public function rules()
    {
        return [
            [['news_id', 'category_id'], 'required'],
            [['news_id', 'category_id'], 'integer'],
            [['news_id', 'category_id'], 'unique', 'targetAttribute' => ['news_id', 'category_id'], 'message' => 'The combination of News ID and Category ID has already been taken.'],
        ];
    }

    /**
     * {@inheritdoc}
     */
    public function attributeLabels()
    {
        return [
            'news_id' => 'News ID',
            'category_id' => 'Category ID',
        ];
    }

    /**
     * Gets the related News model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getNews()
    {
        return $this->hasOne(News::className(), ['id' => 'news_id']);
    }

    /**
     * Gets the related Category model.
     *
     * @return \yii\db\ActiveQuery
     */
    public function getCategory()
    {
        return $this->hasOne(NewsCategory::className(), ['id' => 'category_id']);
    }
}
