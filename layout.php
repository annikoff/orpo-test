<!DOCTYPE html>
<html xmlns:ng="http://angularjs.org" ng-app="secretApp">
<head>
    <meta charset="utf-8">
    <title>Secret Interface</title>
    <link href="http://netdna.bootstrapcdn.com/bootswatch/3.1.1/cerulean/bootstrap.min.css" rel="stylesheet" />  
    <link href="http://netdna.bootstrapcdn.com/font-awesome/4.1.0/css/font-awesome.min.css" rel="stylesheet" />
    <style>
        textarea.form-control{height: 300px;}
        .glyphicon{top: 3px; color: green;}
        button{margin-bottom: 1em;}
        .form-control{margin-bottom: 1em;}
        .nav > li{width: 100%; cursor: pointer;}
        .alert-danger{display: none;}
    </style>
</head>
<body ng-controller="SecretController" ng-init="getCalculations();setCondition(0);">
    <div class="wrapper">
    <div class="row-fluid"><div class="col-md-12">&nbsp;</div></div>    
    <div class="row-fluid">
        <div class="col-md-1"></div>
        <div class="col-md-10">
            <div class="alert alert-danger" ng-show="httpError">Ошибка при HTTP запросе</div>
        </div>
        <div class="col-md-1"></div>
    </div>
    <div class="row-fluid">
        <div class="col-md-1"></div>
        <div class="col-md-3">
            <div class="input-group">
                <div class="input-group-btn" ng-class="{open: condtionsIsOpen}">
                    <button class="btn btn-default dropdown-toggle" data-toggle="dropdown" ng-click='condtionsIsOpen=!condtionsIsOpen'>{{currentCondition.name}} <span class="caret"></span></button>
                    <ul class="dropdown-menu">
                        <li ng-repeat="(index, condition) in conditions" ng-click='setCondition(index)'><a>{{condition.name}}</a></li>
                    </ul>
                </div>
                <input type="text" class="form-control" ng-model="conditionValue" placeholder="Фильтр по кодам">
            </div>
            <ul class="nav nav-pills">
                <li ng-show="codeFilter(calculation, currentCondition.value, conditionValue)" ng-class="{active:isSelected(index)}" ng-repeat="(index, calculation) in calculations"><a ng-click="setCurrentCalculation(index)">{{calculation.name}}</a></li>
            </ul>
        </div>
        <div class="col-md-7">
            <div class="row-fluid">
                <div class="col-md-12">
                    <input ng-readonly="isHidden()" type="text" ng-model="currentCalculation.name" class="form-control" placeholder="Название" />
                </div>    
                <div class="col-md-12">
                    <textarea ng-readonly="isHidden()" ng-model="currentCalculation.text" class="form-control" placeholder="Секретный расчёт"></textarea>
                </div>
                <div class="col-md-12">
                <div class="panel panel-default">
                  <div class="panel-heading">Секретные коды</div>
                  <div class="panel-body">
                        <ul class="list-group" ng-show="isHidden()">
                            <li class="list-group-item" ng-repeat="code in currentCalculation.codes">{{code.code}}</li>
                        </ul>
                  </div>
                </div> 
                </div>        
                <div class="col-md-2">
                    <button type="button" class="btn btn-default btn-lg" ng-click="newCalculation()" ng-show="isHidden()">
                        <span class="glyphicon glyphicon-plus-sign"></span> Новый
                    </button>
                    <button type="button" class="btn btn-default btn-lg" ng-click="addCalculation()" ng-show="!isHidden()">
                        <span class="glyphicon glyphicon-save"></span> Сохранить
                    </button>
                </div>
            </div>
        </div>
    </div>
    </div>
    </div>
    <script src="https://code.angularjs.org/1.2.9/angular.min.js"></script>
    <script src="app.js"></script>
</body>
</html>
