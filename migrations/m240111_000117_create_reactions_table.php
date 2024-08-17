<?php

use yii\db\Migration;

class m240111_000117_create_reactions_table extends Migration
{
    public function up()
    {
        $this->createTable('{{%reactions}}', [
            'id' => $this->primaryKey(),
            'name' => $this->string()->notNull(),
        ]);

        $this->insert('{{%reactions}}', ['id' => 1, 'name' => 'Палец вверх']);
        $this->insert('{{%reactions}}', ['id' => 2, 'name' => 'Палец вниз']);
        $this->insert('{{%reactions}}', ['id' => 3, 'name' => 'Огонь']);
        $this->insert('{{%reactions}}', ['id' => 4, 'name' => 'Слеза']);
    }

    public function down()
    {
        $this->dropTable('{{%reactions}}');
    }
}