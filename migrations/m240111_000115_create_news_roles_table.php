<?php

use yii\db\Migration;

class m240111_000115_create_news_roles_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%news_roles}}', [
            'id' => $this->primaryKey(),
            'news_id' => $this->integer()->notNull(),
            'role_id' => $this->integer()->notNull(),
        ]);

        $this->addForeignKey(
            'fk-news_roles-news_id',
            '{{%news_roles}}',
            'news_id',
            '{{%news}}',
            'id',
            'CASCADE'
        );

        $this->addForeignKey(
            'fk-news_roles-role_id',
            '{{%news_roles}}',
            'role_id',
            '{{%roles}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-news_roles-role_id', '{{%news_roles}}');
        $this->dropForeignKey('fk-news_roles-news_id', '{{%news_roles}}');
        $this->dropTable('{{%news_roles}}');
    }
}