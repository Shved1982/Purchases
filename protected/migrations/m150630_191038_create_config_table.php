<?php

class m150630_191038_create_config_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('config', array(
            'id' => 'pk',
            'alias' => 'string NOT NULL',
			'is_done' => 'INT(11) NOT NULL DEFAULT 0',
        ),'ENGINE=InnoDB DEFAULT CHARSET=utf8');
	}

	public function safeDown()
	{	
		$this->dropTable('config');
	}

}