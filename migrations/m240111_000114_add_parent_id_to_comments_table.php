<?php

use yii\db\Migration;

class m240111_000114_add_parent_id_to_comments_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%comments}}', 'parent_id', $this->integer()->null());
        $this->addForeignKey(
            'fk-comments-parent_id',
            '{{%comments}}',
            'parent_id',
            '{{%comments}}',
            'id',
            'CASCADE'
        );
    }

    public function down()
    {
        $this->dropForeignKey('fk-comments-parent_id', '{{%comments}}');
        $this->dropColumn('{{%comments}}', 'parent_id');
    }
}