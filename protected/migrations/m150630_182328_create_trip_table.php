<?php

class m150630_182328_create_trip_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('trip', array(
            'id' => 'pk',
            'users__id' => 'int(11) NOT NULL',
			'departure' => 'string NOT NULL',
            'destination' => 'string NOT NULL',
			'date_start' => 'date NOT NULL',
			'date_end' => 'date DEFAULT NULL',
        ),'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		
		$this->createIndex('users__id', 'trip', 'users__id');
	}

	public function safeDown()
	{
		$this->dropTable('trip');
	}

}