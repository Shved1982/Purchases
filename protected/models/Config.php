<?php

/**
 * This is the model class for table "config".
 *
 * The followings are the available columns in table 'config':
 * @property integer $id
 * @property string $alias
 * @property integer $is_done
 */
class Config extends CActiveRecord
{
	/**
	 * @return string the associated database table name
	 */
	public function tableName()
	{
		return 'config';
	}

	/**
	 * @return array validation rules for model attributes.
	 */
	public function rules()
	{
		// NOTE: you should only define rules for those attributes that
		// will receive user inputs.
		return array(
			array('alias', 'required'),
			array('is_done', 'numerical', 'integerOnly'=>true),
			array('alias', 'length', 'max'=>255),
			// The following rule is used by search().
			// @todo Please remove those attributes that should not be searched.
			array('id, alias, is_done', 'safe', 'on'=>'search'),
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
			'alias' => 'Alias',
			'is_done' => 'Is Done',
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
		$criteria->compare('alias',$this->alias,true);
		$criteria->compare('is_done',$this->is_done);

		return new CActiveDataProvider($this, array(
			'criteria'=>$criteria,
		));
	}

	/**
	 * Returns the static model of the specified AR class.
	 * Please note that you should have this exact method in all your CActiveRecord descendants!
	 * @param string $className active record class name.
	 * @return Config the static model class
	 */
	public static function model($className=__CLASS__)
	{
		return parent::model($className);
	}
	
	/**
	 * Поиск настройки по псевдониму
	 * @param string $alias псевдоним настройки
	 * @return Config экземпляр класса если настройка найде, FALSE - если настройки с таким псевдонимом не существует
	 */
	public function findByAlias($alias)
	{
		$criteria = new CDbCriteria();
		$criteria->condition = 'alias = :alias';
		$criteria->params = array(':alias' => $alias);
		
		$model = self::model()->find($criteria);
		
		if($model instanceof Config)
		{
			return $model;
		}
		else
		{
			return FALSE;
		}
	}
	
	/**
	 * Метод добавление строки в таблицу config
	 * @param string $alias псевдоним настройки
	 * @return boolen TRUE - настройка успешно добавлена
	 */
	public function insertData($alias)
	{
		$model = new Config();
		
		$model->alias = $alias;
		$model->is_done = (int)FALSE;
		
		if($model->validate())
		{
			$model->save();
		}
		
		return TRUE;
	}
}
