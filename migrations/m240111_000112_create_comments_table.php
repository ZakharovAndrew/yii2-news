<?php

use yii\db\Migration;

class m240111_000112_create_comments_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%comments}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'content' => $this->text()->notNull(),
            'created_at' => $this->integer()->notNull(),
            'updated_at' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-comments-news_id',
            '{{%comments}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-comments-news_id', '{{%comments}}');
        $this->dropTable('{{%comments}}');
    }
}