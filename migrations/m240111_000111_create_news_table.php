<?php

use yii\db\Migration;

class m240111_000111_create_news_table extends Migration
{
    public function up()
    {
        $this->createTable('news', [
            'id' => $this->primaryKey(),
            'title' => $this->string()->notNull(),
            'content' => $this->text()->notNull(),
            'user_id' => $this->integer()->notNull(),
            'created_at' => $this->timestamp()->defaultValue( new \yii\db\Expression('CURRENT_TIMESTAMP') ),
            'updated_at' => $this->timestamp()->null(),
        ]);
    }

    public function down()
    {
        $this->dropTable('news');
    }
}