<?php

use yii\db\Migration;

class m240111_000118_create_news_reactions_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%news_reactions}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'reaction_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-news_reactions-news_id',
            '{{%news_reactions}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_reactions-user_id',
            '{{%news_reactions}}',
            'user_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
        
        $this->addForeignKey(
            'fk-news_reactions-reaction_id',
            '{{%news_reactions}}',
            'reaction_id',
            '{{%reactions}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-news_reactions-user_id', '{{%news_reactions}}');
        $this->dropForeignKey('fk-news_reactions-news_id', '{{%news_reactions}}');
        $this->dropForeignKey('fk-news_reactions-reaction_id', '{{%news_reactions}}');
        $this->dropTable('{{%news_reactions}}');
    }
}