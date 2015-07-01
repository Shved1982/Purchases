<style>
.hidescreen {
     position: absolute;
	 z-index: 9998; 
	 width: 100%;
	 height: 900px;
	 background: #ffffff;
	 opacity: 0.7;
	 filter: alpha(opacity=70);
	 left:0;
	 top:0;
}
.load_page {
	 z-index: 9999;
	 position: absolute;
	 left: 50%;
	 top: 50%;
	 background: #ffffff;
	 border-radius: 3px;
	 width: auto;
}

li.ng-isolate-scope
{
 font-size: 16px;
}
.form-control.ng-dirty.ng-invalid
{
	background: #F490AB;
}
</style>
<div class="row">
	<div id="scrollArea" ng-controller="CreateController" class="col-md-6"> 

		<form name="placeForm" novalidate class="form-horizontal">
			<h3 ng-show="isNew"><?=Yii::t('app', 'Создание клиента')?></h3>
			<h3 ng-hide="isNew"><?=Yii::t('app', 'Редактирование клиента')?></h3>
			
			<hr>
		<div class="hidescreen" ng-show="saving"></div>
		<span class="load_page" ng-show="saving"><i class="fa fa-spinner fa-spin fa-5x"></i></span>
		<p class="bg-warning" style="padding: 15px;" ng-hide="success && isNew"><b><?=Yii::t('app','Поля помеченные *, обязательны для заполнения')?></b></p>
		<p class="bg-success" style="padding: 15px;" ng-show="success && isNew"><b><?=Yii::t('app','Клиент успешно создан, теперь можете перейти к добавлению заказов')?></b></p>
		<p class="bg-danger" style="padding: 15px;" ng-show="showErrors"><b><?=Yii::t('app','Произошла ошибка')?></b></p>
			
					<div class="form-group">
						<label class="col-sm-2 control-label"><?=Yii::t('app','ФИО*')?></label >
						<div class="col-sm-10">
							<input type="text" class="form-control" ng-model="customer.name" name="name" required  placeholder="<?=Yii::t('app', 'Введите ФИО')?>">
							<span class="text-danger" ng-show="placeForm.$dirty && placeForm.name.$error.required"><?=Yii::t('app', 'Это поле обязательно для заполнения')?></span>
						</div>
					</div><bR>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?=Yii::t('app','Телефон*')?></label >
						<div class="col-sm-10">
							<input type="text" class="form-control" ng-model="customer.phone" name="phone" pattern="^[0-9]{10,14}" required placeholder="<?=Yii::t('app', 'Введите телефон')?>">
							<span class="text-danger" ng-show="placeForm.$dirty && placeForm.phone.$error.required"><?=Yii::t('app', 'Это поле обязательно для заполнения')?></span>
							<span class="text-danger" ng-show="placeForm.$dirty && placeForm.phone.$error.pattern"><?=Yii::t('app', 'В поле "Телефон" допускаются только цифры, количество цифр не должно быть меньше 10 и больше 14')?></span>
						</div>
					</div><bR>
					<div class="form-group">
						<label class="col-sm-2 control-label"><?=Yii::t('app','Адрес*')?></label >
						<div class="col-sm-10">
							<input type="text" class="form-control" ng-model="customer.address" name="address" required  placeholder="<?=Yii::t('app', 'Введите адрес')?>">
							<span class="text-danger" ng-show="placeForm.$dirty && placeForm.address.$error.required"><?=Yii::t('app', 'Это поле обязательно для заполнения')?></span>
						</div>
					</div><bR>
					
					
		   <button ng-show="isNew" type="submit" ng-disabled="placeForm.$invalid || saving" ng-click="save()" class="btn btn-success">
				<span><?=Yii::t('app', 'Создать')?></span>
			</button>
			<button ng-hide="isNew" type="submit" ng-disabled="placeForm.$invalid || saving" ng-click="updateCustomer()" class="btn btn-success">
				<span ><?=Yii::t('app', 'Сохранить')?></span>
			</button>
		 
			<a href="/#/" class="btn"><?=Yii::t('app', 'Отмена')?></a>
		</form>
	</div>
	<div class="col-md-6">
		<div class="row">
			<div class="col-md-12" ng-hide="isEmpty">
				<h3><?=Yii::t('app','Список заказов')?></h3>
				<table class="table table-hover">
					<thead>
						<tr class="text-uppercase">
							<th>ID</th>
							<th><?=Yii::t('app','Дата заказа')?></th>
							<th><?=Yii::t('app','Сумма')?></th>
							<th><?=Yii::t('app','Дата оплаты')?></th>
							<th><?=Yii::t('app','Действия')?></th>
						</tr>
						<tr class="text-uppercase">
							<th><?=Yii::t('app','фильтр')?></th>
							<th><input class="form-control" ng-model="search.posted_at"/></th>
							<th><input class="form-control" ng-model="search.amount"/></th>
							<th><input class="form-control" ng-model="search.paid_at"/></th>
							<th></th>
						</tr>
					</thead>
					<tbody><? /*| pagination:watchPage:maxSizes*/?>
						<tr ng-repeat="(key, orderen) in orders track by key | filter:search:strict">
							<td>{{orderen.id}}</td>
							<td>{{orderen.posted_at | date:'dd.MM.yyyy HH:mm:ss'}}</td>
							<td>{{orderen.amount}}</td>
							<td>{{orderen.paid_at | date:'dd.MM.yyyy HH:mm:ss'}}</td>
							<td class="actions">
								<a href ng-click="update(orderen)" title="<?=Yii::t('app', 'Редактировать')?>"><i class="fa fa-pencil"></i></a>
								<a href ng-click="del(orderen)" title="<?=Yii::t('app', 'Удалить')?>"><i class="fa fa-trash"></i></a>
							</td>
						</tr>
					</tbody>
				</table>
			
			</div>

		</div>
	</div>
		
</div>
<div class="row">
	<div ng-show="success" class="col-md-6">
			<form name="orderForm" novalidate class="form-horizontal">
			<h3 ng-show="isNewOrder"><?=Yii::t('app', 'Создание заказа')?></h3>
			<h3 ng-hide="isNewOrder"><?=Yii::t('app', 'Редактирование заказа')?></h3>
			<hr>
			<div class="hidescreen" ng-show="saving"></div>
			<span class="load_page" ng-show="saving"><i class="fa fa-spinner fa-spin fa-5x"></i></span>
			<p class="bg-warning" style="padding: 15px;" ng-hide="successOrder"><b><?=Yii::t('app','Поля помеченные *, обязательны для заполнения')?></b></p>
			<p class="bg-success" style="padding: 15px;" ng-show="successOrder"><b><?=Yii::t('app','Заказ успешно создан')?></b></p>
			<p class="bg-danger" style="padding: 15px;" ng-show="showErrorsOrder"><b><?=Yii::t('app','Произошла ошибка')?></b></p>
				
						<div class="form-group">
							<label class="col-sm-2 control-label"><?=Yii::t('app','Дата создания*')?></label >
							<div class="col-sm-10">
								<p class="input-group">
								  <input type="text" class="form-control" datepicker-popup="dd.MM.yyyy HH:mm:ss" ng-model="order.posted_at" is-open="opened" min-date="minDate" max-date="'2050-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Close" placeholder="<?=Yii::t('app', 'Введите дату заказа')?>" />
								  <span class="input-group-btn">
									<button type="button" class="btn btn-default" ng-click="open($event)"><i class="glyphicon glyphicon-calendar"></i></button>
								  </span>
								</p>
							</div>
						</div><bR>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?=Yii::t('app','Сумма*')?></label >
							<div class="col-sm-10">
								<input type="text" class="form-control" ng-model="order.amount" name="amount" pattern="\-?\d+(\.\d{0,})?" required placeholder="<?=Yii::t('app', 'Введите сумму')?>">
								<span class="text-danger" ng-show="orderForm.$dirty && orderForm.amount.$error.required"><?=Yii::t('app', 'Это поле обязательно для заполнения')?></span>
								<span class="text-danger" ng-show="orderForm.$dirty && orderForm.amount.$error.pattern"><?=Yii::t('app', 'В поле "Сумма" допускаются только цифры с двумя знаками после запятой')?></span>
							</div>
						</div><bR>
						<div class="form-group">
							<label class="col-sm-2 control-label"><?=Yii::t('app','Дата оплаты*')?></label >
							<div class="col-sm-10">
								<p class="input-group">
								  <input type="text" class="form-control" datepicker-popup="{{format}}" ng-model="order.paid_at" is-open="openedNext" min-date="minDate" max-date="'2050-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="false" close-text="Close"placeholder="<?=Yii::t('app', 'Введите дату оплаты')?>"  />
								  <span class="input-group-btn">
									<button type="button" class="btn btn-default" ng-click="openNext($event)"><i class="glyphicon glyphicon-calendar"></i></button>
								  </span>
								</p>
							</div>
						</div><bR>
						
						
			   <button type="submit" ng-disabled="orderForm.$invalid || saving" ng-click="saveOrder()" class="btn btn-success">
					<span ng-show="isNewOrder"><?=Yii::t('app', 'Создать')?></span>
					<span ng-hide="isNewOrder"><?=Yii::t('app', 'Сохранить')?></span>
				</button>
			</form>
	</div>
</div>