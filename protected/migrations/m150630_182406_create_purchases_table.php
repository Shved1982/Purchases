<?php

class m150630_182406_create_purchases_table extends CDbMigration
{
	public function safeUp()
	{
		$this->createTable('purchases', array(
            'id' => 'pk',
            'users__id' => 'int(11) NOT NULL',
			'trip__id' => 'int(11) NOT NULL',
            'name' => 'string NOT NULL',
			'price' => 'float(10,2) NOT NULL',
        ),'ENGINE=InnoDB DEFAULT CHARSET=utf8');
		
		$this->createIndex('users__id', 'purchases', 'users__id');
		$this->createIndex('trip__id', 'purchases', 'trip__id');
	}

	public function safeDown()
	{
		$this->dropTable('purchases');
	}

}