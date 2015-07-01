<div class="main">
	<button class="btn btn-default" ng-click="showAdd()">Создать покупку</button>
	<hr>
	<div ng-show="editSuccess" style="color:green; font-weight: bold;">
		<h2>Покупка {{purch.name}} сохранена </h2>
	</div>
	<div ng-show="addSuccess" style="color:green; font-weight: bold;">
		<h2>Покупка {{addPurch.name}} сохранена </h2>
	</div>
	<div ng-show="editError" style="color:red; font-weight: bold;">
		<h2>Ошибка в покупке {{purch.name}}!!! </h2>
	</div>
	<div ng-show="addError" style="color:red; font-weight: bold;">
		<h2>Ошибка при создании покупки {{addPurch.name}}!!! </h2>
	</div>
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
				<th width="20%">
					<p class="input-group">
					<input type="text" class="form-control" readonly  datepicker-popup="dd.MM.yyyy" ng-model="start_start" is-open="openedStart" min-date="minDate" max-date="'2050-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Х" placeholder="<?=Yii::t('app', 'От')?>" />
					<span class="input-group-btn">
						<button ng-click="openStart($event)" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					 </p>
					 <p class="input-group">
					<input type="text" class="form-control" readonly datepicker-popup="dd.MM.yyyy" ng-model="start_end" is-open="openedStartNext" min-date="minDate" max-date="'2050-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Х" placeholder="<?=Yii::t('app', 'До')?>" />
					<span class="input-group-btn">
						<button ng-click="openStartNext($event)" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					 </p>
				</th>
				<th width="20%">
					<p class="input-group">
					<input type="text" class="form-control" readonly  datepicker-popup="dd.MM.yyyy" ng-model="end_start" is-open="openedEnd" min-date="minDate" max-date="'2050-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Х" placeholder="<?=Yii::t('app', 'От')?>" />
					<span class="input-group-btn">
						<button ng-click="openEnd($event)" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					 </p>
					 <p class="input-group">
					<input type="text" class="form-control" readonly datepicker-popup="dd.MM.yyyy" ng-model="end_end" is-open="openedEndNext" min-date="minDate" max-date="'2050-06-22'" datepicker-options="dateOptions" date-disabled="disabled(date, mode)" ng-required="true" close-text="Х" placeholder="<?=Yii::t('app', 'До')?>" />
					<span class="input-group-btn">
						<button ng-click="openEndNext($event)" class="btn btn-default" type="button"><i class="fa fa-calendar"></i></button>
					  </span>
					 </p>
				</th>
				<th><p class="input-group"><button ng-click="reset()" class="btn btn-default" type="button">Сбросить фильтр</button></p></th>
			</tr>
		</thead>
		<tbody>
			<tr ng-repeat="purchase in (filteredPots = (searchedPots = (purchases  | filter:search:strict | start:start_start:start_end | end:end_start:end_end) | pagination:watchPage:maxSizes)) ">
				<td>{{purchase.id}}</td>
				<td>{{purchase.userfullname}}</td>
				<td>{{purchase.name}}</td>
				<td>{{purchase.price}}</td>
				<td>{{purchase.departure}}</td>
				<td>{{purchase.destination}}</td>
				<td>{{purchase.date_start | date:'dd.MM.yyyy'}}</td>
				<td>{{purchase.date_end | date:'dd.MM.yyyy'}}</td>
				<td class="actions">
					<a href="" ng-click="edit(purchase)" title="<?=Yii::t('app', 'Редактировать')?>"><i class="fa fa-pencil fa-2x"></i></a>
					<a href="" ng-click="del(purchase)" title="<?=Yii::t('app', 'Удалить')?>"><i class="fa fa-trash fa-2x"></i></a>
				</td>
			</tr>
		</tbody>
		
	</table>
	<pagination boundary-links="true" total-items="searchedPots.length" items-per-page="maxSize" ng-model="currentPage" class="pagination-sm" previous-text="&lsaquo;" next-text="&rsaquo;" first-text="&laquo;" last-text="&raquo;"></pagination>
	</div>
	<hr>
	<div ng-show="editing">
	
		<h3>Редактирование покупки {{purch.name}}</h3>
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
		</thead>
		<tbody>
			<tr>
				<td>{{purch.id}}</td>
				<td>{{purch.userfullname}}</td>
				<td><input class="form-control" ng-model="purch.name"/></td>
				<td><input class="form-control" ng-model="purch.price"/></td>
				<td><input class="form-control" ng-model="purch.departure"/></td>
				<td><input class="form-control" ng-model="purch.destination"/></td>
				<td>{{purch.date_start}}</td>
				<td>{{purch.date_end}}</td>
				<td class="actions">
					<a href="" ng-click="save(purch)" title="<?=Yii::t('app', 'Сохранить')?>"><i class="fa fa-check fa-2x"></i></a>
					<a href="" ng-click="editing=false" title="<?=Yii::t('app', 'Отмена')?>"><i class="fa fa-ban fa-2x"></i></a>
				</td>
			</tr>
		</tbody>
		
		</table>
	</div>
	<div ng-show="adding">
	
		<h3>Создание покупки</h3>
		<table class="table table-hover">
		<thead>
			<tr class="text-uppercase">
				<th>ID</th>
				<th width="30%"><?=Yii::t('app','ФИ')?></th>
				<th><?=Yii::t('app','Пароль')?></th>
				<th><?=Yii::t('app','E-mail')?></th>
				<th><?=Yii::t('app','Название покупки')?></th>
				<th><?=Yii::t('app','Стоимость покупки')?></th>
				<th><?=Yii::t('app','Город вылета')?></th>
				<th><?=Yii::t('app','Город прибытия')?></th>
				<th><?=Yii::t('app','Дата вылета')?></th>
				<th><?=Yii::t('app','Дата возвращения')?></th>
			</tr>
		</thead>
		<tbody>
			<tr>
				<td></td>
				<td><input class="form-control" ng-model="addPurch.userfullname" /></td>
				<td><input type="password" class="form-control" ng-model="addPurch.password" /></td>
				<td><input class="form-control" ng-model="addPurch.email" /></td>
				<td><input class="form-control" ng-model="addPurch.name"/></td>
				<td><input class="form-control" ng-model="addPurch.price"/></td>
				<td><input class="form-control" ng-model="addPurch.departure"/></td>
				<td><input class="form-control" ng-model="addPurch.destination"/></td>
				<td><input class="form-control" ng-model="addPurch.date_start"/></td>
				<td><input class="form-control" ng-model="addPurch.date_end"/></td>
				<td class="actions">
					<a href="" ng-click="create(addPurch)" title="<?=Yii::t('app', 'Создать')?>"><i class="fa fa-check fa-2x"></i></a>
					<a href="" ng-click="adding=false" title="<?=Yii::t('app', 'Отмена')?>"><i class="fa fa-ban fa-2x"></i></a>
				</td>
			</tr>
		</tbody>
		
		</table>
	</div>
</div>

