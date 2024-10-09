<?php

use yii\db\Migration;

class m240111_000117_create_reactions_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%reactions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string(255)->notNull(),
            'css_class' => $this->string(255)->notNull()
        ]);

        $this->insert('{{%reactions}}', ['id' => 1, 'name' => 'Like', 'css_class' => 'reaction_like']);
        $this->insert('{{%reactions}}', ['id' => 2, 'name' => 'Fire', 'css_class' => 'reaction_fire']);
        $this->insert('{{%reactions}}', ['id' => 3, 'name' => 'Dislike', 'css_class' => 'reaction_dislike']);
        $this->insert('{{%reactions}}', ['id' => 4, 'name' => 'Laught', 'css_class' => 'reaction_laught']);
    }

    public function down()
    {
        $this->dropTable('{{%reactions}}');
    }
}