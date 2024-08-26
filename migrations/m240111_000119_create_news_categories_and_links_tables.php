<?php

use yii\db\Migration;

class m240111_000119_create_news_categories_and_links_tables extends Migration
{
    public function up()
    {
        $this->createTable('news_categories', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull()->unique(),
            'url' => $this->string()->notNull()->unique(),
        ]);

        $this->createTable('news_category_links', [
            'news_id' => $this->integer()->notNull(),
            'category_id' => $this->integer()->notNull(),
            'PRIMARY KEY (news_id, category_id)',
        ]);

        $this->addForeignKey(
            'fk-news_category_links-news_id',
            'news_category_links',
            'news_id',
            'news',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_category_links-category_id',
            'news_category_links',
            'category_id',
            'news_categories',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-news_category_links-news_id', 'news_category_links');
        $this->dropForeignKey('fk-news_category_links-category_id', 'news_category_links');
        $this->dropTable('news_category_links');
        $this->dropTable('news_categories');
    }
}