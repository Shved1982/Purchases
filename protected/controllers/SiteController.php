<?php

class SiteController extends Controller
{
	/**
	 * Переменная которая указывает путь к шаблону
	 * $var string $layout
	 */
	public $layout = '//layouts/main';
	
	/**
	 * Контроллер (метод) генерации главной страницы
	 * ничего не возвращает
	 */
	public function actionIndex()
	{
		$alias = 'insert_into_bd';
		$config = Config::model()->findByAlias($alias);
		if(!($config instanceof Config))
		{
			Config::model()->insertData($alias);
			$this->insertFake($alias);
		}
		elseif(!(bool)$config->is_done)
		{
			$this->insertFake($alias);
		}

		$this->render('index');
	}
	
	/**
	 * Метод наполнения БД тестовыми данными
	 * $param $alias псевдоним настройки
	 * ничего не возвращает
	 */
	private function insertFake($alias)
	{
		for($i = 0; $i < 100; $i++)
		{
			//заполняем таблицу users
			$users = new Users();
			$users->username = test . $i;
			$users->email = 'test' . $i . '@test.com';
			$users->password = rand(1000,99999);
			$users->first_name = 'firstname' . $i;
			$users->last_name = 'lastname' . $i;
			if($users->validate())
			{
				$users->save();
			}
			
			//заполняем таблицу trip
			$trip = new Trip();
			$trip->users__id = rand(1,100);
			$trip->departure = 'city' . $i;
			$trip->destination = 'city' . $i;
			$trip->date_start = date('Y-m-d', strtotime(rand(2012,2015) . '-' . rand(1,12) . '-' . rand(1,28)));
			$trip->date_end = date('Y-m-d', strtotime(rand(2012,2015) . '-' . rand(1,12) . '-' . rand(1,28)));
			if($trip->validate())
			{
				$trip->save();
			}
			
			//заполняем таблицу purchases
			$purchase = new Purchases();
			$purchase->users__id = rand(1,100);
			$purchase->trip__id = rand(1,100);
			$purchase->name = 'purchase' . $i;
			$purchase->price = rand(1,10000);
			if($purchase->validate())
			{
				$purchase->save();
			}				
		}
		
		$config = Config::model()->findByAlias($alias);
		
		if(($config instanceof Config) && !(bool)$config->is_done)
		{
			$config->is_done = (int)TRUE;
			$config->save();
		}
	}
	
	/**
	 * Метод генерации контента главной страницы
	 * ничего не возвращает
	 */
	public function actionDefault()
	{
	
		$result = $this->renderPartial('default',NULL, TRUE);
		
		 echo $result;
    }  
	
	/**
	 * Метод выбирает список покупок в путешествиях
	 * возвращает массив JSON
	 */
	public function actiongetList()
	{
		$purchases = Purchases::model()->findAll();
		
		$result = array();
		foreach($purchases as $purchase)
		{
			$result[] = array(
				'id' => $purchase->id,
				'userfullname' => $purchase->user->getFullName(),
				'departure' => $purchase->trip->departure,
				'destination' => $purchase->trip->destination,
				'date_start' => date("Y-m-d", strtotime($purchase->trip->date_start)),
				'date_end' => date("Y-m-d", strtotime($purchase->trip->date_end)),
				'name' => $purchase->name,
				'price' => $purchase->price,
			);
		}
		
		 echo  CJSON::encode($result);
    }  
	
	/**
	 * Метод удаления покупки
	 * возвращает массив JSON с ошибками
	 */
	public function actiondeletePurchase()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$errors = array();
		$customerId = $params['data'];

		Purchases::model()->deleteByPk($customerId);
			
		 echo CJSON::encode($errors);
    }
	
	/**
	 * Метод обновления данных покупки и путешествия
	 * возвращает массив JSON с ошибками
	 */
	public function actionupdatePurchase()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$errors = array();
		
		$purchase = Purchases::model()->findByPk($params['data']['id']);
		$purchase->name = $params['data']['name'];
		$purchase->price = $params['data']['price'];
		
		$purchase->trip->departure = $params['data']['departure'];
		$purchase->trip->destination = $params['data']['destination'];
		
		if($purchase->validate())
		{
			if(!$purchase->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить purchase.');
			}
		}
		else
		{
			throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить purchase.');
		}
		
		if($purchase->trip->validate())
		{
			if(!$purchase->trip->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить trip.');
			}
		}
		else
		{
			throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить trip.');
		}
		
		$errors['customer'] = array_merge($purchase->getErrors(),$purchase->trip->getErrors());
		
		 echo CJSON::encode($errors);
    }
	
	/**
	 * Метод создания пользователя, путешествия, покупки
	 * возвращает массив JSON с ошибками
	 */
	public function actionaddPurchase()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$errors = array();
		
		$user = new Users();
		$user->username = $params['data']['userfullname'];
		$user->password = $params['data']['password'];
		$user->email = $params['data']['email'];
		$user->first_name = strpos($params['data']['userfullname'], ' ')===false ? $params['data']['userfullname']: substr($params['data']['userfullname'],0,strpos($params['data']['userfullname'], ' ') );
		$user->last_name = strpos($params['data']['userfullname'], ' ')===false ? $params['data']['userfullname']: substr($params['data']['userfullname'],strpos($params['data']['userfullname'], ' ') );
		
		if($user->validate())
		{
			if(!$user->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить user');
			}
		}
		else
		{
			throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить user');
		}
		
		$trip = new Trip();
		$trip->users__id = $user->id;
		$trip->departure = $params['data']['departure'];
		$trip->destination = $params['data']['destination'];
		$trip->date_start = date("Y-m-d", strtotime($params['data']['date_start']));
		$trip->date_end = date("Y-m-d", strtotime($params['data']['date_end']));
		
		if($trip->validate())
		{
			if(!$trip->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить trip');
			}
		}
		else
		{
			throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить trip');
		}
		
		$purchase = new Purchases();
		$purchase->users__id = $user->id;
		$purchase->trip__id = $trip->id;
		$purchase->name = $params['data']['name'];
		$purchase->price = $params['data']['price'];
		
		if($purchase->validate())
		{
			if(!$purchase->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить purchase');
			}
		}
		else
		{
			throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить purchase validate');
		}
		
		$errors['customer'] = array_merge($user->getErrors(),$trip->getErrors());
		
		 echo CJSON::encode($errors);
    }
	
	/**
	 * Метод генерации страниці с ошибкой
	 * ничего не возвращает
	 */
	public function actionError()
	{
		if($error=Yii::app()->errorHandler->error)
		{
			if(Yii::app()->request->isAjaxRequest)
				echo $error['message'];
			else
				$this->render('error', $error);
		}
	}
}