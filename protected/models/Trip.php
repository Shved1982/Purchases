<?php

/**
 * This is the model class for table "trip".
 *
 * The followings are the available columns in table 'trip':
 * @property integer $id
 * @property integer $users__id
 * @property string $departure
 * @property string $destination
 * @property string $date_start
 * @property string $date_end
 */
class Trip extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'trip';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('users__id, departure, destination, date_start', 'required'),
			array('users__id', 'numerical', 'integerOnly'=>true),
			array('departure, destination', 'length', 'max'=>255),
			array('date_end', 'safe'),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, users__id, departure, destination, date_start, date_end', 'safe', 'on'=>'search'),
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
			'departure' => 'Departure',
			'destination' => 'Destination',
			'date_start' => 'Date Start',
			'date_end' => 'Date End',
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
		$criteria->compare('departure',$this->departure,true);
		$criteria->compare('destination',$this->destination,true);
		$criteria->compare('date_start',$this->date_start,true);
		$criteria->compare('date_end',$this->date_end,true);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Trip the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
}
