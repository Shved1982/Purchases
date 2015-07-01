<div class="main">
	<div>
	<table class="table table-hover">
		<thead>
			<tr class="text-uppercase">
				<th>ID</th>
				<th><?=Yii::t('app','ФИ')?></th>
				<th><?=Yii::t('app','Название покупки')?></th>
				<th><?=Yii::t('app','Стоимость покупки')?></th>
				<th><?=Yii::t('app','Город вылета')?></th>
				<th><?=Yii::t('app','Город прибытия')?></th>
				<th><?=Yii::t('app','Дата вылета')?></th>
				<th><?=Yii::t('app','Дата возвращения')?></th>
			</tr>
			<tr class="text-uppercase">
				<th><?=Yii::t('app','фильтр')?></th>
				<th><input class="form-control" ng-model="search.userfullname"/></th>
				<th><input class="form-control" ng-model="search.name"/></th>
				<th><input class="form-control" ng-model="search.price"/></th>
				<th><input class="form-control" ng-model="search.departure"/></th>
				<th><input class="form-control" ng-model="search.destination"/></th>
				<th><input class="form-control" ng-model="search.date_start"/></th>
				<th><input class="form-control" ng-model="search.date_end"/></th>
				<th></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="purchase in purchases  | filter:search:strict | pagination:watchPage:maxSizes ">
				<td>{{purchase.id}}</td>
				<td>{{purchase.userfullname}}</td>
				<td>{{purchase.name}}</td>
				<td>{{purchase.price}}</td>
				<td>{{purchase.departure}}</td>
				<td>{{purchase.destination}}</td>
				<td>{{purchase.date_start}}</td>
				<td>{{purchase.date_end}}</td>
				<td class="actions">
					<a href="#/view/id/{{purchase.id}}" title="<?=Yii::t('app', 'Просмотр')?>"><i class="fa fa-eye fa-2x"></i></a>
					<a href="#/update/id/{{purchase.id}}" title="<?=Yii::t('app', 'Редактировать')?>"><i class="fa fa-pencil fa-2x"></i></a>
					<a href="#/view" ng-click="del(purchase)" title="<?=Yii::t('app', 'Удалить')?>"><i class="fa fa-trash fa-2x"></i></a>
				</td>
			</tr>
		</tbody>
		
	</table>
	<pagination boundary-links="true" total-items="totalItems" items-per-page="maxSize" ng-model="currentPage" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></pagination>
</div>
</div>

