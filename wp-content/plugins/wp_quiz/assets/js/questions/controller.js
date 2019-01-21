/*
* Manage answers for question
* See View/Multichoicea/admin_add.ctp & admin_edit.ctp layout
*/
function QuestionAnswersController($scope, $routeParams, $http) {
    $scope.answers = [];
    $scope.weight  = 0;
	$scope.currentRadioIndex  = 0;

	var xsrf = $.param({action:'load_answers_by_question', 'question_id':$routeParams.questionId});
 	$http.post(
 			blogURL+"/wp-admin/admin-ajax.php", xsrf, { headers: { 'Content-Type': 'application/x-www-form-urlencoded; charset=UTF-8'} }
 		).success(function(data) {
	    //console.log(data);
        //res: [{"id":"1","text":"1","weight":"0"},{"id":"2","text":"2","weight":"1"},{"id":"3","text":"3","weight":"0"}]
	    $scope.answers = data;
        angular.forEach(data, function (c, i) {
            if(c.weight > 0){
                $scope.weight = i;
            }
        });
	});

    $scope.addAnswer = function() {
    	$scope.answers.push({text:$scope.answerText, weight:1});
    	$scope.answerText = '';
    };
    $scope.removeAnswer = function($index) {
    	$scope.answers.splice($index, 1);
    };

}
