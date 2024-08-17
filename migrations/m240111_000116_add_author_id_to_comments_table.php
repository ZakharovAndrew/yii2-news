<?php

use yii\db\Migration;

class m240111_000116_add_author_id_to_comments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%comments}}', 'author_id', $this->integer()->notNull());
        $this->addForeignKey(
            'fk-comments-author_id',
            '{{%comments}}',
            'author_id',
            '{{%users}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-comments-author_id', '{{%comments}}');
        $this->dropColumn('{{%comments}}', 'author_id');
    }
}