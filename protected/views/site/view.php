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
	<div ng-controller="ViewController" class="col-md-6">
		<h3><?=Yii::t('app', 'Просмотр клиента')?></h3>
		<hr>
		<div ng-repeat="viewcustomer in viewcustomers" class="form-horizontal">
		<div class="form-group">
			<label class="col-sm-2 control-label"><?=Yii::t('app','ФИО')?></label >
			<div class="col-sm-10">
				<input type="text" class="form-control" ng-model="viewcustomer.name" name="name" disabled>
			</div>
		</div><bR>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?=Yii::t('app','Телефон')?></label >
			<div class="col-sm-10">
				<input type="text" class="form-control" ng-model="viewcustomer.phone" name="phone" disabled>
			</div>
		</div><bR>
		<div class="form-group">
			<label class="col-sm-2 control-label"><?=Yii::t('app','Адрес')?></label >
			<div class="col-sm-10">
				<input type="text" class="form-control" ng-model="viewcustomer.address" name="address" disabled >
			</div>
		</div><bR>
				
		<a href="/#/view" class="btn"><?=Yii::t('app', 'Назад')?></a>
		</div>
	</div>
	<div ng-hide="isEmpty" class="col-md-6">
		<div class="row">
			<div class="col-md-12">
				<h3><?=Yii::t('app','Список заказов')?></h3>
				<table class="table table-hover">
					<thead>
						<tr class="text-uppercase">
							<th>ID</th>
							<th><?=Yii::t('app','Дата заказа')?></th>
							<th><?=Yii::t('app','Сумма')?></th>
							<th><?=Yii::t('app','Дата оплаты')?></th>
						</tr>
						<tr class="text-uppercase">
							<th><?=Yii::t('app','фильтр')?></th>
							<th><input class="form-control" ng-model="searchOrder.posted_at"/></th>
							<th><input class="form-control" ng-model="searchOrder.amount"/></th>
							<th><input class="form-control" ng-model="searchOrder.paid_at"/></th>
						</tr>
					</thead>
					<tbody>
						<tr ng-repeat="order in orders | filter:searchOrder:strict">
							<td>{{order.id}}</td>
							<td>{{order.posted_at}}</td>
							<td>{{order.amount}}</td>
							<td>{{order.paid_at}}</td>
						</tr>
					</tbody>
				</table>
			
			</div>
		</div>
	</div>
</div>