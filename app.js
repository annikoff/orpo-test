(function () {

    angular.module("secretApp", [])
    .controller("SecretController", function($scope, $http) {

        $scope.httpError = false;
        $scope.calculations = [];
        $scope.currentCalculation = {};
        $scope.conditions = [
            {name: "Без условия", value: ""},
            {name: "Код =", value: "eq"},
            {name: "Код >", value: "gt"},
            {name: "Код <", value: "lt"},
        ];
        $scope.currentCondition = '';
        $scope.condtionsIsOpen = false;
        $scope.conditionValue = '';

        $scope.codeFilter = function(item, contidion, search) {
            if (contidion == "") {
                return true;
            }
            for (var i = 0; i < item.codes.length; i++) {
                switch (contidion) {
                    case "eq":
                        if (parseInt(item.codes[i].code) == search) {
                            return true;
                        }
                    break;
                    case "gt":
                        if (parseInt(item.codes[i].code) > search) {
                            return true;
                        }
                    break;
                    case "lt":
                        if (parseInt(item.codes[i].code) < search) {
                            return true;
                        }
                    break;
                }
            }
            return false;
        }

        $scope.setCondition = function(index) {
            $scope.currentCondition = $scope.conditions[index];
            $scope.condtionsIsOpen = false;
        }

        $scope.getCalculations = function() {

            var responsePromise =  $http.get("index.php?action=getCalculations");

            responsePromise.success(function(data, status) {
                $scope.calculations = data;
            });
            responsePromise.error(function(data, status) {
                $scope.httpError = true;
            });
        }

        $scope.setCurrentCalculation = function(index) {
            $scope.currentCalculation = $scope.calculations[index];
            $scope.currentCalculation.index = index;
        }

        $scope.addCalculation = function() {

            var data = {
                'name': $scope.currentCalculation.name,
                'text': $scope.currentCalculation.text
            }
            var responsePromise =  $http.post("index.php?action=addCalculation", data);

            responsePromise.success(function(data, status) {
                $scope.calculations.push(data);
                $scope.setCurrentCalculation($scope.calculations.length-1);
            });
            responsePromise.error(function(data, status) {
                $scope.httpError = true;
            });
        }

        $scope.isSelected = function(index) {
            return index == $scope.currentCalculation.index;
        }

        $scope.isHidden = function() {
            return $scope.currentCalculation.id > 0;
        }

        $scope.newCalculation = function() {
            $scope.currentCalculation = {};
        }

    });

}());
