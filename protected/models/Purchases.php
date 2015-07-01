<?php

/**
 * This is the model class for table "purchases".
 *
 * The followings are the available columns in table 'purchases':
 * @property integer $id
 * @property integer $users__id
 * @property integer $trip__id
 * @property string $name
 * @property double $price
 */
class Purchases extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'purchases';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users__id, trip__id, name, price', 'required'),
			array('users__id, trip__id', 'numerical', 'integerOnly'=>true),
			array('price', 'numerical'),
			array('name', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, users__id, trip__id, name, price', 'safe', 'on'=>'search'),
		);
	}

	/**
	 * @return array relational rules.
	 */
	public function relations()
	{
		// NOTE: you may need to adjust the relation name and the related
		// class name for the relations automatically generated below.
		return array(
			'user' => array(self::BELONGS_TO, 'Users', 'users__id'),
			'trip' => array(self::BELONGS_TO, 'Trip', 'trip__id'),
		);
	}

	/**
	 * @return array customized attribute labels (name=>label)
	 */
	public function attributeLabels()
	{
		return array(
			'id' => 'ID',
			'users__id' => 'Users',
			'trip__id' => 'Trip',
			'name' => 'Name',
			'price' => 'Price',
		);
	}

	/**
	 * Retrieves a list of models based on the current search/filter conditions.
	 *
	 * Typical usecase:
	 * - Initialize the model fields with values from filter form.
	 * - Execute this method to get CActiveDataProvider instance which will filter
	 * models according to data in model fields.
	 * - Pass data provider to CGridView, CListView or any similar widget.
	 *
	 * @return CActiveDataProvider the data provider that can return the models
	 * based on the search/filter conditions.
	 */
	public function search()
	{
		// @todo Please modify the following code to remove attributes that should not be searched.

		$criteria=new CDbCriteria;

		$criteria->compare('id',$this->id);
		$criteria->compare('users__id',$this->users__id);
		$criteria->compare('trip__id',$this->trip__id);
		$criteria->compare('name',$this->name,true);
		$criteria->compare('price',$this->price);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Purchases the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
