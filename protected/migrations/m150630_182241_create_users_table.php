<?php

class m150630_182241_create_users_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('users', array(
            'id' => 'pk',
            'username' => 'string NOT NULL',
            'email' => 'string NOT NULL',
			'password' => 'string NOT NULL',
			'first_name' => 'string NOT NULL',
			'last_name' => 'string NOT NULL',
        ),'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		
		$this->createIndex('username', 'users', 'username');
	}

	public function safeDown()
	{
		$this->dropTable('users');
	}
	
}