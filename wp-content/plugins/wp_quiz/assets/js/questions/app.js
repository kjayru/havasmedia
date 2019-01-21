// var baseURL = document.getElementById('pluginUrl').value;
// var blogURL = document.getElementById('ajaxUrl').value;
var app = angular.module('question_answers', [], function($routeProvider, $locationProvider) {

  $routeProvider.when('/question_answers/:questionId', {
    templateUrl: baseURL+'/assets/js/questions-template/question_answers.html',
    controller: QuestionAnswersController //neu khai bao o day thi khong khai bao  ng-controller="ManageLessonGalleryController" trong view nua
  });
});