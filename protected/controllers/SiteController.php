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
				'date_start' => date("d.m.Y", strtotime($purchase->trip->date_start)),
				'date_end' => date("d.m.Y", strtotime($purchase->trip->date_end)),
				'name' => $purchase->name,
				'price' => $purchase->price,
			);
		}
		
		 echo  CJSON::encode($result);
    }  
	
	
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
	
	
	
	
	
	
	
	
	public function actionForm()
	{
	
		$result = $this->renderPartial('form',NULL, TRUE);
		
		 echo $result;
    } 

	public function actionView()
	{
	
		$result = $this->renderPartial('view',NULL, TRUE);
		
		 echo $result;
    } 	
	
	
	
	
	
	public function actiongetCustomer()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		$customerId = $params['data'];
		
		$customer = Customer::model()->findByPk($customerId);
		
		$result[] = array(
			'id' => $customer->id,
			'name' => $customer->name,
			'phone' => $customer->phone,
			'address' => $customer->address,
			);
		
		 echo  CJSON::encode($result);
    }  
	
	public function actiongetOrders()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		$customerId = $params['data']['id'];
		
		$criteria = new CDbCriteria();
		$criteria->condition = 'customer_id = :customer_id';
		$criteria->params = array('customer_id' => $customerId);
		
		$orders = Order::model()->findAll($criteria);
		
		$result = array();
		
		foreach($orders as $order)
		{	
			$date_paid = '';
			if($order->paid_at == NULL)
			{
				$date_paid = date("d.m.Y H:i:s", strtotime($order->paid_at));
			}
			$result[] = array(
				'id' => $order->id,
				'amount' => $order->amount,
				'posted_at' => date("d.m.Y H:i:s", strtotime($order->posted_at)),
				'paid_at' =>  $date_paid
				);
		}
		
		 echo  CJSON::encode($result);
    }  
	
	
	public function actionaddCustomer()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$error = TRUE;
		$errors = array();
		
		$customer = new Customer();
		$customer->name = $params['data']['name'];
		$customer->phone = $params['data']['phone'];
		$customer->address = $params['data']['address'];
		if($customer->validate())
		{
			$customer->save();
		}
		
		$errors['customer'] = $customer->getErrors();
		$errors['id'] = $customer->id;
		
		 echo CJSON::encode($errors);
    }
	
	public function actionupdateCustomer()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$error = TRUE;
		$errors = array();
		
		$customer = Customer::model()->findByPk($params['data']['id']);
		$customer->name = $params['data']['name'];
		$customer->phone = $params['data']['phone'];
		$customer->address = $params['data']['address'];
		if($customer->validate())
		{
			if(!$customer->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить клиента.');
			}
		}
		else
		{
			throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить клиента.');
		}
		
		$errors['customer'] = $customer->getErrors();
		
		 echo CJSON::encode($errors);
    }
	
	
	
	public function actioncreateOrder()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$error = TRUE;
		$errors = array();
		
		$order = new Order();
		$order->customer_id = $params['data']['customer_id'];
		$order->amount = $params['data']['amount'];
		$order->posted_at = date("Y-m-d H:i:s", strtotime($params['data']['posted_at']));
		$order->paid_at = date("Y-m-d H:i:s", strtotime($params['data']['paid_at']));
		if($order->validate())
		{
			if(!$order->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось создать заказ.');
			}
		}
		
		$date_paid = '';
		if(array_key_exists('paid_at', $params['data']))
		{
			$date_paid = date("d.m.Y H:i:s", strtotime($order->paid_at));
		}
		$result = array(
			'id' => $order->id,
			'amount' => $order->amount,
			'posted_at' => date("d.m.Y H:i:s", strtotime($order->posted_at)),
			'paid_at' =>  $date_paid
		);
		$errors['order'] = $order->getErrors();
		$errors['model'] = $result;
		
		 echo CJSON::encode($errors);
    }
	
	public function actionupdateOrder()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$error = TRUE;
		$errors = array();
		
		$order = Order::model()->findByPk($params['data']['id']);
		$order->customer_id = $params['data']['customer_id'];
		$order->amount = $params['data']['amount'];
		$order->posted_at = date("Y-m-d H:i:s", strtotime($params['data']['posted_at']));
		$order->paid_at = date("Y-m-d H:i:s", strtotime($params['data']['paid_at']));
		if($order->validate())
		{
			if(!$order->save())
			{
				throw new CHttpException('403', 'Ошибочный запрос, не удалось обновить заказ.');
			}
		}
		
		$errors['order'] = $order->getErrors();
		
		 echo CJSON::encode($errors);
    }
	
	public function actiondeleteOrder()
	{
		if(empty(Yii::app()->request->csrfToken))
		{
			throw new CHttpException('403', 'Ошибочный запрос, отказано в доступе.');
		}
		$params = CJSON::decode(file_get_contents('php://input'), true);
		
		$errors = array();
		$id = $params['data'];
		
		Order::model()->deleteByPk($id);
					
		 echo CJSON::encode($errors);
    }
	
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