<?php

use yii\db\Migration;

class m240111_000120_add_column_pos_to_reactions_table extends Migration
{
    public function up()
    {
        $this->addColumn('{{%reactions}}', 'pos', $this->integer()->notNull());
        
    }

    public function down()
    {
        $this->dropColumn('{{%reactions}}', 'pos');
    }
}